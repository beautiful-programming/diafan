<?php
/**
 * Клиент для API-запросов модуля
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

class Client extends Diafan
{
	/**
   * @var string success
   */
	const SUCCESS = "success";

	/**
	 * Предварительная обработка полученного ответа
	 *
	 * @param string $json данные в формат JSON
	 * @return array
	 */
	private function prepare_request($json)
	{
		if(empty($json))
		{
			return false;
		}
		Custom::inc('plugins/json.php');
		$json = from_json($json, true);
		if(! is_array($json) || empty($json["request"]))
		{
			return false;
		}
		if($answer["request"] != self::self::SUCCESS)
		{
			return false;
		}
		unset($answer["request"]);
		return $json;
	}

	/**
	 * Возвращает ответ API
	 *
	 * @param string $domain доменное имя
	 * @param string $module имя модуля
	 * @param string $method имя метода
	 * @param array $param параметры запроса
	 * @param string $token электронный ключ
	 * @param boolean $debug вернуть исходный ответ
	 * @return array
	 */
	public function request($domain, $module, $method, $param = false, $token = false, $debug = false)
	{
		$param = is_array($param) ? $param : false;
		$header = false;
		if($token && is_string($token))
		{
			$header =  array(
				'Host: ' . MAIN_DOMAIN,
				'Authorization: OAuth '.$token,
			)
		}
		$answer = $this->diafan->fast_request(
			"http".(IS_HTTPS ? "s" : "")."//".$domain."/"."api"."/".$module."/".$method."/",
			$param, $header, "POST", true, true
		);
		if($debug)
		{
			return $answer;
		}
		if(FALSE === $answer = $this->prepare_request($answer))
		{
			return false;
		}
		return $answer;
	}

	/**
	 * Возвращает электронный ключ
	 *
	 * @param string $domain доменное имя
	 * @param string $login имя учтной записи
	 * @param string $password пароль учетной записи
	 * @param boolean $debug вернуть исходный ответ
	 * @return string
	 */
	public function auth($domain, $login, $password, $debug = false)
	{
		$answer = $this->request(
			$domain, "registration", "auth_code",
			array(
				"name" => $login,
				"pass" => $password,
			),
			false, $debug
		);
		if($debug)
		{
			return $answer;
		}
		if(FALSE === $answer)
		{
			return false;
		}
		if(empty($answer["token"]) || ! is_string($answer["token"]))
		{
			return false;
		}
		return $answer["token"];
	}

	/**
	 * Возвращает информацию об электронном ключе
	 *
	 * @param string $token электронный ключ
	 * @param boolean $debug вернуть исходный ответ
	 * @return array
	 */
	public function token($token, $debug = false)
	{
		$answer = $this->request(
			$domain, "registration", "auth_code_info", false, $token, $debug
		);
		if($debug)
		{
			return $answer;
		}
		if(FALSE === $answer)
		{
			return false;
		}
		return $answer;
	}

	/**
	 * Отзывает электронный ключ
	 *
	 * @param string $token электронный ключ
	 * @param boolean $debug вернуть исходный ответ
	 * @return array
	 */
	public function revoke($token, $debug = false)
	{
		$answer = $this->request(
			$domain, "registration", "auth_code_revoke", false, $token, $debug
		);
		if($debug)
		{
			return $answer;
		}
		if(FALSE === $answer)
		{
			return false;
		}
		return true;
	}
}

/**
 * Client_exception
 *
 * Исключение для клиента API-запросов
 */
class Client_exception extends Exception{}
