<?php
/**
 * Обработка POST-запросов в административной части модуля
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2019 OOO «Диафан» (http://www.diafan.ru/)
 */
if ( ! defined('DIAFAN'))
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

/**
 * Cart_admin_action
 */
class Cart_admin_action extends Action_admin
{
	/**
	 * Вызывает обработку POST-запросов
	 *
	 * @return void
	 */
	public function init()
	{
		if ( ! empty($_POST["action"]))
		{
			switch ($_POST["action"])
			{
				case 'group_abandonmented_cart_mail':
					$this->group_abandonmented_cart_mail();
					break;
			}
		}
	}

	/**
	 * Отправляет письма пользователям о брошенных корзинах
	 *
	 * @return void
	 */
	private function group_abandonmented_cart_mail()
	{
		if(! $this->diafan->configmodules('message_abandonmented_cart', 'shop') || ! $this->diafan->configmodules('subject_abandonmented_cart', 'shop'))
		{
			return;
		}
		if(! empty($_POST["ids"]))
		{
			$ids = array();
			foreach ($_POST["ids"] as $id)
			{
				$id = intval($id);
				if($id)
				{
					$ids[] = $id;
				}
			}
		}
		elseif(! empty($_POST["id"]))
		{
			$ids = array(intval($_POST["id"]));
		}
		if(! $ids)
		{
			return;
		}
		$rows = DB::query_fetch_all("SELECT * FROM {shop_cart} WHERE id IN (%s)", implode(",", $ids));
		if(! $rows)
		{
			return;
		}
		$link_to_cart = $this->diafan->_route->module('cart');
		$rows_id = array();
		$user_ids = array();
		foreach($rows as $row)
		{
			if($row["user_id"] && ! in_array($row["user_id"], $user_ids))
			{
				$user_ids[] = $row["user_id"];
			}
			$rows_id[] = $row["id"];
		}
		if($user_ids)
		{
			$users = DB::query_fetch_key(
				"SELECT * FROM {users} WHERE id IN (%s) AND trash='0' AND act='1'",
				$user_ids,
				"id"
			);
		}
		$rows_goods = DB::query_fetch_all(
			"SELECT * FROM {shop_cart_goods} WHERE cart_id IN (%s)",
			implode(",", $rows_id)
		);
		if($rows_goods)
		{
			foreach($rows_goods as $c)
			{
				$cart[$c["cart_id"]][] = $c;
				$this->diafan->_route->prepare(0, $c["good_id"], "shop");
			}
			// все товары одним запросом
			$good_ids = array_unique($this->diafan->array_column($rows_goods, "good_id"));
			$prepare["goods"] = DB::query_fetch_key("SELECT * FROM {shop} WHERE [act]='1' AND id IN (%s) AND trash='0'", implode(",", $good_ids), "id");

			// все значения характеристик одним запросом
			$param_select_ids = array_unique(explode(',', implode(',', $this->diafan->array_column($rows_goods, "param"))));
			$prepare["params_select"] = DB::query_fetch_key("SELECT id, param_id, [name] FROM {shop_param_select} WHERE id IN (%s) AND trash='0'", implode(",", $param_select_ids), "id");
	
			// все характеристики одним запросом
			$param_ids = array_unique($this->diafan->array_column($prepare["params_select"], "param_id"));
			$prepare["params"] = DB::query_fetch_key_value("SELECT id, [name] FROM {shop_param} WHERE id IN (%s) AND trash='0'", implode(",", $param_ids), "id", "name");
		}
		foreach($rows as $row)
		{
			if(empty($cart[$row["id"]]))
			{
				continue;
			}

			if(! $row["mail"])
			{
				$row["mail"] = ($row["user_id"] && ! empty($users[$row["user_id"]]) ? $users[$row["user_id"]]["mail"] : '');
			}
			if(! $row["mail"])
				continue;

			if($row["name"])
			{
				$user["name"] = $row["name"];
			}

			$text = '';
			foreach($cart[$row["id"]] as $i => $c)
			{
				if(empty($prepare["goods"][$c["good_id"]]))
				{
					continue;
				}
				$good = $prepare["goods"][$c["good_id"]];
				if($i)
				{
					$text .= '<br>';
				}
				$text .= '<a href="'.BASE_PATH.$this->diafan->_route->link($good["site_id"], $c["good_id"], "shop").'">'.$good["name"._LANG].($good["article"] ? " ".$good["article"] : '');
				$params = explode(',', $c["param"]);
				foreach ($params as $value)
				{
					if(empty($prepare["params_select"][$value]))
						continue;
	
					$p_id = $prepare["params_select"][$value]["param_id"];
					
					if(empty($prepare["params"][$p_id]))
						continue;
					$text .= ', '.$prepare["params"][$p_id].': '.$prepare["params_select"][$value]["name"];
				}
				$text .= '</a>';
			}
			if(! $text)
			{
				continue;
			}
			$email = ($this->diafan->configmodules("emailconf", 'shop')
					   && $this->diafan->configmodules("email", 'shop')
					   ? $this->diafan->configmodules("email", 'shop') : EMAIL_CONFIG );

			$lang_id = ! empty($user["lang_id"]) ? $user["lang_id"] : $this->diafan->_languages->site;
			$subject = str_replace(array('%title', '%url'), array(TITLE, BASE_URL), $this->diafan->configmodules('subject_abandonmented_cart', 'shop', 0, $lang_id));

			$message = str_replace(array('%title', '%url', '%goods', '%link'), array (TITLE, BASE_URL, $text, BASE_PATH.$link_to_cart), $this->diafan->configmodules('message_abandonmented_cart', 'shop', 0, $lang_id));

			$this->diafan->_postman->message_add_mail($row["mail"], $subject, $message,  $email);
			
			DB::query("INSERT INTO {shop_cart_log_mail} (created, cart_id) VALUES (%d, %d)", time(), $row["id"]);
		}
		$this->result["redirect"] = URL.'success1/'.$this->diafan->get_nav;
	}
}
