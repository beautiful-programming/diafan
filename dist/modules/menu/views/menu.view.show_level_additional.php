<?php
/**
 * Шаблон вывода первого уровня меню, вызывается из функции show_block в начале файла, оформленного шаблоном
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

if (empty($result["rows"][$result["parent_id"]]))
{
	return true;
}

// начало уровня меню
foreach ($result["rows"][$result["parent_id"]] as $row)
{
	if (!$result["rows"][$result["parent_id"]][0] != $row)
	{
		// разделитель пунктов меню
	}

	if ($row["active"])
	{
		// начало пункта меню для текущей страницы
		echo '<li class="main-header-controls-nav-list-item main-header-controls-nav-list-item--active">';
	}
	elseif ($row["active_child"])
	{
		// начало пункта меню для активного дочернего пункта
		echo '<li class="main-header-controls-nav-list-item main-header-controls-nav-list-item--active-child">';
	}
	elseif ($row["children"])
	{
		// начало пункта меню для элемента -родителя
		echo ' <li class="main-header-controls-nav-list-item main-header-controls-nav-list-item--parent">';
	}
	else
	{
		// начало любого другого пункта меню
		echo '<li class="main-header-controls-nav-list-item">';
	}

	if (
		// на текущей странице нет ссылки, если не включена настройка "Текущий пункт как ссылка"
		(!$row["active"] || $result["current_link"])

		// включен пункт "Не отображать ссылку на элемент, если он имеет дочерние пункты"
		&& (!$result["hide_parent_link"] || empty($result["rows"][$row["id"]]))
	)
	{
		if ($row["othurl"])
		{
			echo '<a class="main-header-controls-nav-list-item__link" href="'.$row["othurl"].'"'.$row["attributes"].'>';
		}
		else
		{
			echo '<a class="main-header-controls-nav-list-item__link" href="'.BASE_PATH_HREF.$row["link"].'"'.$row["attributes"].'>';
		}
	}

	//вывод изображения
	if (! empty($row["img"]))
	{
		echo '<img src="'.$row["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
		.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
	}

	// название пункта меню
	if (! empty($row["name"]) && ((!$row["active"] || $result["current_link"])

            // включен пункт "Не отображать ссылку на элемент, если он имеет дочерние пункты"
            && (!$result["hide_parent_link"] || empty($result["rows"][$row["id"]]))))
	{
        echo $row["name"];
	} else {
        echo '<span class="main-header-controls-nav-list-item__non-link">' . $row["name"] . '</span>';
    }
	
	if (
		// на текущей странице нет ссылки, если не включена настройка "Текущий пункт как ссылка"
		(!$row["active"] || $result["current_link"])

		// включен пункт "Не отображать ссылку на элемент, если он имеет дочерние пункты"
		&& (!$result["hide_parent_link"] || empty($result["rows"][$row["id"]]))
	)
	{
		echo '</a>';
	}

	// описание пункта меню
	if (! empty($row["text"]))
	{
		echo $row["text"];
	}

	if ($result["show_all_level"] || $row["active_child"] || $row["active"])
	{
		// вывод вложенного уровня меню
		$menu_data = $result;
		$menu_data["parent_id"] = $row["id"];
		$menu_data["level"]++;

		if (empty($result['attributes']['count_level']) || $result['attributes']['count_level'] >= $menu_data["level"])
			echo $this->get('show_level_additional_2', 'menu', $menu_data);  //ниже функция, которая выводит в цикле пункты второго уровня вложенности.
	}
}
// окончание уровня меню