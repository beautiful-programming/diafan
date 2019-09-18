<?php
/**
 * Каркас для обработки API-запросов модуля
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__;
	while(! file_exists($path.'/includes/404.php'))
	{
		$parent = dirname($path);
		if($parent == $path) exit;
		$path = $parent;
	}
	include $path.'/includes/404.php';
}

abstract class Api extends Diafan
{
	/**
   * @var integer версия API
   */
	const API_VERSION = 1;

	/**
   * @var string success
   */
	const SUCCESS = "success";

	/**
   * @var string error
   */
	const ERROR = "error";

	/**
	 * @var string полученный электронный ключ при обращении
	 */
	public $token;

	/**
	 * @var integer номер текущего электронного ключа
	 */
	public $token_id = 0;

	/**
	 * @var integer номер текущего пользователя
	 */
	public $user_id = 0;

	/**
	 * @var string имя текущего метора
	 */
	public $method;

	/**
	 * @var array массив переменных в URI
	 */
	public $variables = array();

	/**
	 * @var array полученный после обработки данных результат
	 */
	public $result;

	/**
	 * @var array массив ошибок
	 */
	public $errors = array(
		"error" => "ошибка",
		"method_unknown" => "Метод запроса не определен.",
		"access_denied" => "Доступ запрещен.",
		"only_https" => "Необходимо использовать протокол HTTPS.",
	);

	/**
	 * @var boolean отдавать ответ только запросам AJAX
	 */
	public $ajax = false;

	/**
	 * @var boolean при недопустимых запросах отдавать 404
	 */
	public $page_404 = false;

	/**
	 * @var boolean ответ API только по протоколу HTTPS
	 */
	public $only_https = true;

	/**
	 * Подключает модель
	 *
	 * @return object|null
	 */
	public function __get($name)
	{
		if($name == 'model' || $name == 'inc')
		{
			$module = $this->diafan->current_module;
			if(! isset($this->cache[$name.'_'.$module]))
			{
				if(Custom::exists('modules/'.$module.'/'.$module.'.'.$name.'.php'))
				{
					Custom::inc('modules/'.$module.'/'.$module.'.'.$name.'.php');
					$class = ucfirst($module).'_'.$name;
					$this->cache[$name.'_'.$module] = new $class($this->diafan, $module);
				}
			}
			return $this->cache[$name.'_'.$module];
		}
		return NULL;
	}

	/**
	 * Конструктор класса
	 *
	 * @return void
	 */
	public function __construct(&$diafan)
	{
		parent::__construct($diafan);
	}

	/**
	 * Определяет свойства класса
	 *
	 * @return void
	 */
	public function prepare()
	{
		$this->errors();
		$this->auth();
	}

	/**
	 * Определение ошибок
	 *
	 * @return void
	 */
	public function errors(){}

	/**
	 * Авторизация или получение токена
	 *
	 * @param integer $user_id номер пользователя
	 * @return string
	 */
	public function auth($user_id = false)
	{
		if($user_id)
		{
			if(! $u_id = DB::query_result("SELECT id FROM {users} WHERE trash='0' AND id=%d LIMIT 1", $user_id))
			{
				return false;
			}
			DB::query("DELETE FROM {users_token} WHERE user_id=%d AND element_type='api'", $u_id);
			if($u_id == $this->user_id)
			{
				$this->clear();
			}
			$token = $this->token();
			$time = time();
			$date_start = $time;
			$date_finish = $date_start + (180 * 24 * 60 * 60); // 180 дней
			$token_id = DB::query("INSERT INTO {users_token} (user_id, token, element_type, created, date_start, date_finish) VALUES (%d, '%h', '%h', %d, %d, %d)", $u_id, $token, 'api', $time, $date_start, $date_finish);
			if(! $token = DB::query_result("SELECT token FROM {users_token} WHERE id=%d LIMIT 1", $token_id))
			{
				return false;
			}
			$this->user_id = $u_id;
			$this->token_id = $token_id;
			return $this->token = $token;
		}

		if($this->is_auth())
		{
			return false;
		}
		$this->clear();
		$headers = $this->get_request_headers();
		if(! $headers || ! is_array($headers))
		{
			return false;
		}
		foreach($headers as $key => $value)
		{
			if(strtolower($key) != 'authorization' || substr($value, 0, 6) != 'OAuth ')
			{
				continue;
			}
			$this->token = $this->diafan->filter(substr($value, 6), "string");
			break;
		}
		if(! $this->token)
		{
			$this->clear();
			return false;
		}
		$time = time();
		if(! $row = DB::query_fetch_array("SELECT u.id, u.role_id, t.token, t.id AS token_id FROM {users} AS u"
			." INNER JOIN {users_token} AS t ON u.id = t.user_id"
			." WHERE u.act='1' AND u.trash='0' AND u.created<=%d"
			." AND t.created<=%d AND t.date_start<=%d AND (t.date_finish=0 OR t.date_finish>=%d)"
			." AND t.token<>'' AND t.token='%h'"
			." AND t.element_type='api'"
			." GROUP BY u.id ORDER by t.id DESC, t.created DESC, u.created DESC"
			." LIMIT 1", $time, $time, $time, $time, $this->token))
		{
			$this->clear();
			return false;
		}
		$this->user_id = $row["id"];
		$this->token_id = $row["token_id"];
		return $this->token = $row["token"];
	}

	/**
	 * Проверяет авторизацию текущего пользователя
	 *
	 * @return boolean
	 */
	public function is_auth()
	{
		if(! $this->token || ! $this->token_id || ! $this->user_id)
		{
			return false;
		}
		return true;
	}

	/**
	 * Сброс авторизации
	 *
	 * @return void
	 */
	private function clear()
	{
		$this->token = null;
		$this->user_id = 0;
		$this->token_id = 0;
	}

	/**
	 * Отдает уникальный электронный ключ
	 *
	 * @return mixed(string|object)
	 */
	private function token()
	{
		$token = md5($this->diafan->uid(true));
		if(DB::query_result("SELECT id FROM {users_token} WHERE element_type='api' AND token='%h' LIMIT 1", $token))
		{
			$token = $this->token();
		}
		return $token;
	}

	/**
	 * Отзывает электронный ключ у текущего пользователя
	 *
	 * @return boolean
	 */
	public function revoke()
	{
		if(! $this->is_auth() || ! $this->user_id)
		{
			return false;
		}
		DB::query("DELETE FROM {users_token} WHERE user_id=%d AND element_type='api'", $this->user_id);
		$this->clear();
		return true;
	}

	/**
	 * Возвращает данные о текущем электронном ключе
	 *
	 * @return array
	 */
	public function token_info()
	{
		$headers = $this->get_request_headers();
		if(! $headers || ! is_array($headers))
		{
			return false;
		}
		foreach($headers as $key => $value)
		{
			if(strtolower($key) != 'authorization' || substr($value, 0, 6) != 'OAuth ')
			{
				continue;
			}
			$this->token = $this->diafan->filter(substr($value, 6), "string");
			break;
		}
		if(! $this->token)
		{
			return false;
		}
		$time = time();
		if(! $row = DB::query_fetch_array("SELECT"
			." u.id AS user_id, u.role_id AS user_role_id, u.act AS user_act, u.trash AS user_trash, u.created AS user_created"
			.", t.token, t.id AS token_id, t.created AS token_created, t.date_start AS token_date_start, t.date_finish AS token_date_finish"
			." FROM {users} AS u"
			." INNER JOIN {users_token} AS t ON u.id = t.user_id"
			." WHERE t.token<>'' AND t.token='%h' AND t.element_type='api'"
			." GROUP BY u.id ORDER by t.id DESC, t.created DESC, u.created DESC"
			." LIMIT 1", $this->token))
		{
			return false;
		}
		$row["date"] = $time;
		return $row;
	}

	/**
	 * Является ли запрос AJAX
	 *
	 * @return boolean
	 */
	private function is_ajax()
	{
		if(! empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest'
			// для IE
			|| ! empty($_POST["action"]))
		{
			return true;
		}
		return false;
	}

	/**
	 * Отправляет ответ
	 *
	 * @return void
	 */
	public function end()
	{
		if($this->only_https && ! IS_HTTPS)
		{
			$this->result = array();
			$this->set_error("only_https");
		}
		$this->result = $this->result ?: array();
		$params = array("errors", "result");
		$s = false;
		if(is_array($this->result))
		{
			foreach ($params as $v)
			{
				if (! empty($this->result[$v]))
				{
					$s = true;
					break;
				}
			}
		}
		if($s && (! $this->ajax || $this->is_ajax()))
		{
			if(! isset($this->result["result"]) || is_bool($this->result["result"]))
			{
				if(isset($this->result["result"]) && ! $this->result["result"] && empty($this->result["errors"]))
				{
					$this->set_error("error");
				}
				$this->result["result"] = array();
			}
			if(! is_array($this->result["result"]))
			{
				$this->result["result"] = array($this->result["result"]);
			}
			if(! empty($this->result["errors"]))
			{
				if(! empty($this->result["result"]["errors"]))
				{
					$this->result["result"]["errors"] = array_merge($this->result["result"]["errors"], $this->result["errors"]);
				}
				else $this->result["result"]["errors"] = $this->result["errors"];
				unset($this->result["errors"]);
			}
			if(! isset($this->result["result"]["v"]))
			{
				$this->result["result"]["v"] = self::API_VERSION;
			}
			if(! isset($this->result["result"]["method"]) && $this->method)
			{
				$this->result["result"]["method"] = $this->method;
			}
			if(! isset($this->result["result"]["request"]))
			{
				if(! isset($this->result["result"]["errors"])) $this->result["result"]["request"] = self::SUCCESS;
				else $this->result["result"]["request"] = self::ERROR;
			}
			$this->result = $this->result["result"];
			echo $this->to_json($this->result);
			exit;
		}
		if(! $this->page_404)
		{
			$this->set_error("error");
			if(! empty($this->result["errors"])) $this->result["result"] = $this->result["errors"];
			else $this->result["result"] = array(
				"v" => self::API_VERSION,
				"method" => $this->method ?: "unknown",
				"request" => self::ERROR,
				"errors" => array("error" => "error"),
			);
			$this->result = $this->result["result"];
			echo $this->to_json($this->result);
			exit;
		}
		include(ABSOLUTE_PATH.Custom::path('includes/404.php'));
		exit;
	}

	/**
	 * Запоминает найденную ошибку
	 *
	 * @return void
	 */
	public function set_error($key, $value = false)
	{
		if(! $value && isset($this->errors[$key]))
		{
			$value = $this->errors[$key];
		}
		if($value)
		{
			$this->result["errors"][$key] = $this->diafan->_($value, false);
		}
		else $this->result["errors"][$key] = $key;
	}

	/**
	 * Проверяет сформирован ли ответ
	 *
	 * @return boolean
	 */
	public function result()
	{
		if(is_array($this->result) && (! empty($this->result["result"]) || ! empty($this->result["errors"])))
		{
			return true;
		}
		return false;
	}

	/**
	 * Преобразует массив в формат JSON
	 *
	 * @param array $data исходный массив
	 * @return string
	 */
	private function to_json($data)
	{
		header('Content-Type: application/json; charset=utf-8');
		$php_version_min = 50400; // PHP 5.4
		if (PHP_VERSION_ID < $php_version_min)
		{
			// TO_DO: кириллица в ответе JSON - JSON_UNESCAPED_UNICODE
			$json = preg_replace_callback(
				"/\\\\u([a-f0-9]{4})/",
				function($matches) {
					return iconv('UCS-4LE','UTF-8',pack('V', hexdec('U' . $matches[0])));
				},
				json_encode($data)
			);
			$json = str_replace('&', '&amp;', $json);
			$json = str_replace(array('<', '>'), array('&lt;', '&gt;'), $json);
		}
		else $json = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		return $json;
	}

	/**
	 *  Получает список всех заголовков HTTP-запроса
	 *
	 * @return array
	 */
	private function get_request_headers()
	{
		if(isset($this->cache["headers"]))
		{
			return $this->cache["headers"];
		}
		if(function_exists('apache_request_headers'))
		{
			$this->cache["headers"] = apache_request_headers();
			return $this->cache["headers"];
		}
		$headers = array();
    foreach($_SERVER as $key => $value)
		{
        if(substr($key, 0, 5) == 'HTTP_')
				{
					$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
					$headers[$header] = $value;
        }
				elseif(substr($key, 0, 14) == 'REDIRECT_HTTP_')
				{
					$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 14)))));
					$headers[$header] = $value;
        }
    }
    $this->cache["headers"] = $headers;
		return $this->cache["headers"];
	}
}

/**
 * Api_exception
 *
 * Исключение для обработки API-запросов
 */
class Api_exception extends Exception{}
