<?php
/**
 * Редактирование модуля
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

/**
 * Account_admin
 */
class Account_admin extends Frame_admin
{
  /**
	 * @var string таблица в базе данных
	 */
	public $table = 'account';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
  );

  /**
	 * @var array поля в списка элементов
	 */
	public $variables_list = array (
  );

  /**
	 * @var array настройки модуля
	 */
	public $config = array (
	);

	/**
	 * Выводит список статей
	 * @return void
	 */
	public function show()
	{
		// $this->diafan->list_row();
	}
}
