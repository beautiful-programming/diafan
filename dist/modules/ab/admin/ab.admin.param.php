<?php
/**
 * Редактирование дополнительных характеристик объявлений
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
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
 * Ab_admin_param
 */
class Ab_admin_param extends Frame_admin
{
    /**
     * @var string таблица в базе данных
     */
    public $table = 'ab_param';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'name' => array(
				'type' => 'text',
				'name' => 'Название',
				'help' => 'Имя дополнительной характеристики объявления, доступно для заполнения при редактировании товара.',
				'multilang' => true,
			),
			'type' => array(
				'type' => 'select',
				'name' => 'Тип',
				'select' => array(
					'text' => 'строка',
					'numtext' => 'число',
					'date' => 'дата',
					'datetime' => 'дата и время',
					'textarea' => 'текстовое поле',
					'checkbox' => 'галочка',
					'select' => 'выпадающий список',
					'multiple' => 'список с выбором нескольких значений',
					'editor' => 'поле с визуальным редактором',
					'email' => 'электронный ящик',
					'phone' => 'телефон',
					'title' => 'заголовок группы характеристик',
					'attachments' => 'файлы',
					'images' => 'изображения',
				),
			),
			'max_count_attachments' => array(
				'type' => 'none',
				'name' => 'Максимальное количество добавляемых файлов',
				'help' => 'Количество добавляемых файлов. Если значение равно нулю, то форма добавления файлов не выводится. Параметр выводится, если тип характеристики задан как «файлы».',
				'no_save' => true,
			),
			'attachment_extensions' => array(
				'type' => 'none',
				'name' => 'Доступные типы файлов (через запятую)',
				'help' => 'Параметр выводится, если тип характеристики задан как «файлы».',
				'no_save' => true,
			),
			'recognize_image' => array(
				'type' => 'none',
				'name' => 'Распознавать изображения',
				'help' => 'Позволяет прикрепленные файлы в формате JPEG, GIF, PNG отображать как изображения. Параметр выводится, если тип характеристики задан как «файлы».',
				'no_save' => true,
			),
			'attach_big' => array(
				'type' => 'none',
				'name' => 'Размер для большого изображения',
				'help' => 'Размер изображения, отображаемый в пользовательской части сайта при увеличении изображения предпросмотра. Параметр выводится, если тип характеристики задан как «файлы» и отмечена опция «Распознавать изображения».',
				'no_save' => true,
			),
			'attach_medium' => array(
				'type' => 'none',
				'name' => 'Размер для маленького изображения',
				'help' => 'Размер изображения предпросмотра. Параметр выводится, если тип характеристики задан как «файлы» и отмечена опция «Распознавать изображения».',
				'no_save' => true,
			),
			'attach_use_animation' => array(
				'type' => 'none',
				'name' => 'Использовать анимацию при увеличении изображений',
				'help' => 'Параметр добавляет JavaScript код, позволяющий включить анимацию при увеличении изображений. Параметр выводится, если отмечена опция «Распознавать изображения». Параметр выводится, если тип характеристики задан как «файлы» и отмечена опция «Распознавать изображения».',
				'no_save' => true,
			),
			'upload_max_filesize' => array(
				'type' => 'none',
				'name' => 'Максимальный размер загружаемых файлов',
				'help' => 'Параметр показывает максимально допустимый размер загружаемых файлов, установленный в настройках хостинга. Параметр выводится, если тип характеристики задан как «файлы».',
				'no_save' => true,
			),
			'images_variations' => array(
				'type' => 'none',
				'name' => 'Генерировать размеры изображений',
				'help' => 'Размеры изображений, заданные в модуле «Изображения». Параметр выводится, если тип характеристики задан как «изображение».',
				'no_save' => true,
			),
			'param_select' => array(
				'type' => 'function',
				'name' => 'Значения, псевдоссылка',
				'help' => 'Поле появляется для характеристик с типом «галочка», «выпадающий список» и «список с выбором нескольких значений».',
			),
			'required' => array(
				'type' => 'checkbox',
				'name' => 'Обязательно для заполнения из пользовательской части',
			),
			'measure_unit' => array(
				'type' => 'text',
				'name' => 'Единица измерения',
				'help' => 'Параметр выводится, если тип характеристики задан как «число».',
				'multilang' => true,
			),
			'page' => array(
				'type' => 'checkbox',
				'name' => 'Отдельная страница для значений',
				'help' => 'Поле появляется для характеристик с типом «выпадающий список» и «список с выбором нескольких значений». Если опция отмечена, то на сайте появляется страница с объявлениями, объединенными одной характеристикой. Например, город: Краснодар. Странице можно задать ЧПУ, для этого рядом с полем «Значение» выводится дополнительное поля «Псевдоссылка».',
			),
			'site_id' => array(
				'type' => 'none',
				'name' => 'Раздел сайта',
				'help' => 'Раздел сайта, к которому применяется характеристика.',
				'no_save' => true,
			),
			'category' => array(
				'type' => 'function',
				'name' => 'Категория',
				'help' => 'Категории объявлений, для которых действует данный параметр. Если не указана ни одна категория, то характеристика считается общей.',
			),
			'hr1' => 'hr',
			'search' => array(
				'type' => 'checkbox',
				'name' => 'Использовать в форме поиска',
				'help' => 'Позволяет отображать характеристику в форме поиска, выводимой тегом show_search.',
			),
			'list' => array(
				'type' => 'checkbox',
				'name' => 'Показывать в списке',
				'help' => 'Позволяет выводить значение характеристики для объявлений в списке объявлений на сайте.',
			),
			'block' => array(
				'type' => 'checkbox',
				'name' => 'Показывать в блоке объявлений',
				'help' => 'Позволяет выводить значение характеристики для объявлений в блоке объявлений, выводимом тегом show_block.',
			),
			'id_page' => array(
				'type' => 'checkbox',
				'name' => 'Показывать на странице объявления',
				'help' => 'Если отмечено, данная характеристика будет отображаться на странице объявления.',
				'default' => true,
			),
			'display_in_sort' => array(
				'type' => 'checkbox',
				'name' => 'Отображать параметры в блоке для сортировки объявлений',
				'help' => 'Позволяет выводить характеристику в виде ссылки для сортировки объявлений по значению характеристики.',
			),
			'hr2' => 'hr',
			'text' => array(
				'type' => 'textarea',
				'name' => 'Описание характеристики',
				'multilang' => true,
			),
			'sort' => array(
				'type' => 'function',
				'name' => 'Сортировка: установить перед',
				'help' => 'Редактирование порядка следования характеристики в списке',
			),
		),
	);

	/**
	 * @var array поля в списка элементов
	 */
	public $variables_list = array (
		'checkbox' => '',
		'sort' => array(
			'name' => 'Сортировка',
			'type' => 'numtext',
			'sql' => true,
			'fast_edit' => true,
		),
		'name' => array(
			'name' => 'Название'
		),
		'type' => array(
			'name' => 'Тип',
			'type' => 'select',
			'sql' => true,
			'no_important' => true,
		),
		'actions' => array(
			'trash' => true,
		),
	);

	/**
	 * @var array поля для фильтра
	 */
	public $variables_filter = array (
		'cat_id' => array(
			'type' => 'select',
		),
	);

	/**
	 * @var array дополнительные групповые операции
	 */
	public $group_action = array(
		"param_category_rel" => array('name' => "Применить к категории", 'module' => 'ab'),
		"param_category_unrel" => array('name' => "Открепить от категории", 'module' => 'ab')
	);

	/**
	 * Подготавливает конфигурацию модуля
	 * @return void
	 */
	public function prepare_config()
	{
		if (! $this->diafan->configmodules("cat", "ab", $this->diafan->_route->site))
		{
			$this->diafan->variable_unset("cat_id");
		}
		else
		{
			$cats = DB::query_fetch_all(
				"SELECT id, [name], parent_id, site_id FROM {ab_category} WHERE trash='0'"
				.($this->diafan->_route->site ? " AND site_id='".$this->diafan->_route->site."'" : "")
				." ORDER BY sort ASC LIMIT 100"
			);
			if(count($cats))
			{
				$this->diafan->not_empty_categories = true;
			}
			if(count($cats) == 100)
			{
				$this->diafan->categories = array();
			}
			else
			{
				$this->diafan->categories = $cats;
			}
		}
	}

	/**
	 * Выводит ссылку на добавление
	 * @return void
	 */
	public function show_add()
	{
        $this->diafan->addnew_init('Добавить характеристику');
	}

    /**
     * Выводит список дополнительных характеристик товара
     * @return void
     */
    public function show()
    {
        $this->diafan->list_row();
    }

	/**
	 * Выводит категории характеристики в списке
	 *
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_parent($row, $var)
	{
		if(! isset($this->cache["prepare"]["parent_cats"]))
		{
			$this->cache["prepare"]["parent_cats"] = DB::query_fetch_key_array(
				"SELECT s.[name], c.element_id, s.id FROM {ab_param_category_rel} as c"
				." INNER JOIN {ab_category} as s ON s.id=c.cat_id"
				." WHERE element_id IN (%s)",
				implode(",", $this->diafan->rows_id),
				"element_id"
			);
		}
		$cats = array();
		if(! empty($this->cache["prepare"]["parent_cats"][$row["id"]]))
		{
			foreach($this->cache["prepare"]["parent_cats"][$row["id"]] as $cat)
			{
				$cats[] = '<a href="'.BASE_PATH_HREF.'ab/category/edit'.$cat["id"].'/">'.$cat["name"].'</a>';
			}
		}
		if ( ! $cats)
		{
			$cats[] = $this->diafan->_('Общие');
		}
		$title = '';
		if(count($cats) > 3)
		{
			$title = ' title="'.implode(', ', $cats).'"';
			$cats = array_slice($cats, 0, 3);
			$cats[] = '...';
		}
		return '<div class="categories"'.$title.'>'.implode(', ', $cats).'</div>';
	}

	/**
	 * Поиск по полю "Категория"
	 *
	 * @param array $row информация о текущем поле
	 * @return mixed
	 */
	public function save_filter_variable_cat_id($row)
	{
		$cat_id = $this->diafan->_route->cat;
		if (! $cat_id)
		{
			return;
		}
		$this->diafan->join .= " INNER JOIN {ab_param_category_rel} AS c ON e.id=c.element_id AND (c.cat_id='".$cat_id."' OR c.cat_id=0)";
		return $cat_id;
	}

	/**
	 * Выводит фильтры для панели групповых  операций
	 *
	 * @param string $value последнее выбранное значение в списке групповых операций
	 * @return string
	 */
	public function group_action_panel_filter($value)
	{
		$dop = '';

		if (count($this->diafan->categories))
		{
			$dop .= '<div class="action-popup dop_param_category_rel dop_param_category_unrel'.($value != 'param_category_rel' && $value != 'param_category_unrel' ? ' hide' : '').'">';
			$cats = array();
			$count = 0;
			foreach ($this->diafan->categories as $row)
			{
				$cats[$row["parent_id"]][] = $row;
				$count++;
			}

			if ($count > 0)
			{
				$dop .= '<select name="cat_id">';
				$dop .= $this->diafan->get_options($cats, $cats[0], array($this->diafan->_route->cat)).'</select>';
			}
			$dop .= '</div>';
		}

		return $dop;
	}

	/**
	 * Редактирование поля "Параметры"
	 * @return void
	 */
	public function edit_variable_param_select()
	{
		$value = array();
		if ( ! $this->diafan->is_new && in_array($this->diafan->values("type"), array('select', 'multiple', 'checkbox')))
		{
			$rows_select = DB::query_fetch_all("SELECT [name], value, id, sort FROM {ab_param_select} WHERE param_id=%d ORDER BY sort ASC", $this->diafan->id);
			foreach ($rows_select as $row_select)
			{
				if ($this->diafan->values("type") == 'checkbox')
				{
					$value[$row_select["value"]] = $row_select["name"];
				}
				else
				{
					$row_select["rewrite"] = DB::query_result("SELECT rewrite FROM {rewrite} WHERE module_name='ab' AND element_type='param' AND element_id=%d LIMIT 1", $row_select["id"]);
					$value[] = $row_select;
				}
			}
		}
		echo '<div class="unit" id="param">
			<div class="infofield">'.$this->diafan->variable_name().'</div>
			<div class="param_container">
				<a href="javascript:void(0)" class="param_sort_name">'.$this->diafan->_('Сортировать по алфавиту').'</a>';

		$fields = false;
		$param_textarea = '';
		if (in_array($this->diafan->values("type"), array('select', 'multiple')))
		{
			foreach ($value as $row)
			{
				echo '
				<div class="param">
					<input type="hidden" name="param_id[]" value="'.$row["id"].'">
					<input type="text" name="paramv[]" size="30" value="'.str_replace('"', '&quot;', $row["name"]).'" title="ID: '.$row["id"].'">
					<input type="text" name="param_rewrite[]" value="'.$row["rewrite"].'">
					<span class="param_actions">
						<a href="javascript:void(0)" action="delete_param" class="delete"  confirm="'.$this->diafan->_('Вы действительно хотите удалить запись?').'"><i class="fa fa-close" title="'.$this->diafan->_('Удалить').'"></i></a>
						<a href="javascript:void(0)" action="up_param" title="'.$this->diafan->_('Выше').'">↑</a>
						<a href="javascript:void(0)" action="down_param" title="'.$this->diafan->_('Ниже').'">↓</a>
					</span>
				</div>';
				$fields = true;
				$param_textarea .= str_replace(array('<', '>'), array('&lt;', '&gt;'), $row["name"].';'.$row["rewrite"])."\n" ;
			}
		}
		if (! $fields)
		{
			echo '
			<div class="param">
				<input type="hidden" name="param_id[]" value="">
				<input type="text" name="paramv[]" size="30" value="">
				<input type="text" name="param_rewrite[]" value="">
				<span class="param_actions">
					<a href="javascript:void(0)" action="delete_param" class="delete"  confirm="'.$this->diafan->_('Вы действительно хотите удалить запись?').'">
						<i class="fa fa-close" title="'.$this->diafan->_('Удалить').'"></i>
					</a>
					<a href="javascript:void(0)" action="up_param" title="'.$this->diafan->_('Выше').'">↑</a>
					<a href="javascript:void(0)" action="down_param" title="'.$this->diafan->_('Ниже').'">↓</a>
				</span>
			</div>';
		}
		echo '
				<a href="javascript:void(0)" class="param_plus" title="'.$this->diafan->_('Добавить').'"><i class="fa fa-plus-square"></i> '.$this->diafan->_('Добавить').'</a>
			</div>

			<div class="infobox">
				<input type="checkbox" value="1" name="param_textarea_check" id="input_param_textarea_check">
				<label for="input_param_textarea_check">'.$this->diafan->_('Быстрое редактирование').'</label>
				'.$this->diafan->help('Нажмите, чтобы использовать текстовый список для редактирвания характеристик. Каждое значение характеристики с новой строки, псевдоадрес через ; Например, красный;red зеленый;green').'
			</div>
			<div class="param_textarea">
				<textarea name="param_textarea" cols="49" rows="10">'.$param_textarea.'</textarea>
			</div>
		</div>
		<div class="unit" id="param_check">
			<div class="infofield">'.$this->diafan->variable_name().'</div>
			'.$this->diafan->_('да').' <input type="text" name="paramk_check1" value="'
			.(! empty($value[1]) && $this->diafan->values("type") == 'checkbox' ? str_replace('"', '&quot;', $value[1]) : '')
			.'">
			&nbsp;&nbsp;
			'.$this->diafan->_('нет').' <input type="text" name="paramk_check0" value="'
			.(! empty($value[0]) && $this->diafan->values("type") == 'checkbox' ? str_replace('"', '&quot;', $value[0]) : '')
			.'">
		</div>';
		Custom::inc('modules/attachments/admin/attachments.admin.inc.php');
		$attachment = new Attachments_admin_inc($this->diafan);
		$attachment->edit_config_param($this->diafan->values("config"));

		Custom::inc('modules/images/admin/images.admin.inc.php');
		$images = new Images_admin_inc($this->diafan);
		$images->edit_config_param($this->diafan->values("config"));
	}

	/**
	 * Редактирование поля "Раздел сайта"
	 *
	 * @return void
	 */
	public function edit_variable_site_id(){}

	/**
	 * Редактирование поля "Категория"
	 *
	 * @return void
	 */
	public function edit_variable_category()
	{
		echo '<div class="unit" id="name">
				↑ <a href="http'.(IS_HTTPS ? "s" : '').'://www.diafan.ru/dokument/full-manual/modules/ads/#KHarakteristiki" target="_blank">'.$this->diafan->_('О типах характеристик').'</a>
		</div>
		<h2></h2>';

		$value = $this->diafan->values('site_id');
		if ($this->diafan->is_new)
		{
			$value = $this->diafan->_route->site;
		}
		$sites = DB::query_fetch_all("SELECT id, [name] FROM {site} WHERE trash='0' AND module_name='%s' ORDER BY sort ASC, id DESC", $this->diafan->_admin->module);

		echo '
		<div class="unit" id="site_id">
			<div class="infofield">'.$this->diafan->variable_name('site_id').$this->diafan->help('site_id').'</div>
			<select name="site_id">
			<option value="0">'.$this->diafan->_('Все').'</option>';
			echo $this->diafan->get_options(array(0 => $sites), $sites, array($value)).'
			</select>
		</div>';

		if(! $this->diafan->configmodules("cat", "ab", 0))
		{
			return;
		}

		$rows = DB::query_fetch_all("SELECT id, [name], parent_id, site_id FROM {ab_category} WHERE trash='0' ORDER BY sort ASC LIMIT 1000");
		foreach ($rows as $row)
		{
			$cats[$row["site_id"]][$row["parent_id"]][] = $row;
		}

		$values = array();
		if ( ! $this->diafan->is_new)
		{
			$values = DB::query_fetch_value("SELECT cat_id FROM {ab_param_category_rel} WHERE element_id=%d AND cat_id>0", $this->diafan->id, "cat_id");
		}
		elseif($this->diafan->_route->cat)
		{
			$values[] = $this->diafan->_route->cat;
		}
		if(count($rows) == 1000)
		{
			foreach($values as $value)
			{
				echo '<input type="hidden" name="cat_ids[]" value="'.$value.'">';
			}
			return;
		}

		echo '
		<div class="unit">
			<div class="infofield">'.$this->diafan->_('Категория').$this->diafan->help().'</div>';

		echo ' <select name="cat_ids[]" multiple="multiple" size="11">
		<option value="all"'.(empty($values) ? ' selected' : '').'>'.$this->diafan->_('Все').'</option>';
		foreach ($sites as $site)
		{
			if(! empty($cats[$site["id"]]))
			{
				if(count($sites) > 1)
				{
					echo '<optgroup label="'.$site["name"].'" data-site_id="'.$site["id"].'">';
				}
				echo $this->diafan->get_options($cats[$site["id"]], $cats[$site["id"]][0], $values);
				if(count($sites) > 1)
				{
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';

		echo '
		</div>';
	}

	/**
	 * Сохранение поля "Параметры"
	 * @return void
	 */
	public function save_variable_param_select()
	{
		switch ($_POST["type"])
		{
			case "select":
			case "multiple":
				if(! empty($_POST["param_textarea_check"]))
				{
					$values = DB::query_fetch_value("SELECT id FROM {ab_param_select} WHERE param_id=%d", $this->diafan->id, "id");
					$strings = explode("\n", $_POST["param_textarea"]);
					$sort = 1;
					foreach ($strings as $i => $string)
					{
						$data = explode(";", trim($string));
						$data[0] = trim($data[0]);
						if(empty($data[0]) && $data[0] !== "0")
						{
							continue;
						}
						$id = (! empty($values[$i]) ? $values[$i] : '');
						if($id)
						{
							DB::query("UPDATE {ab_param_select} SET [name]='%h', sort=%d WHERE id=%d", $data[0], $sort, $id);
						}
						else
						{
							$id = DB::query("INSERT INTO {ab_param_select} (param_id, [name], sort) VALUES (%d, '%h', %d)", $this->diafan->id, $data[0], $sort);
						}
						if(empty($data[1]))
						{
							$data[1] = '';
						}
						else
						{
							$data[1] = trim($data[1]);
						}
						if($data[1])
						{
							$rewrite = DB::query_fetch_array("SELECT id, rewrite FROM {rewrite} WHERE module_name='ab' AND element_type='param' AND element_id=%d LIMIT 1", $id);
							if ( ! empty($rewrite["id"]))
							{

								if ($rewrite["rewrite"] != $data[1])
								{
									DB::query("UPDATE {rewrite} SET rewrite='%h' WHERE element_type='param' AND element_id=%d", $data[1], $id);
								}
							}
							else
							{
								DB::query("INSERT INTO {rewrite} (module_name, element_type,  element_id, rewrite) VALUES ('ab', 'param', %d, '%h')", $id, $data[1]);
							}
						}
						else
						{
							$this->diafan->_route->delete($id, 'ab', 'param');
						}
						$sort++;
						$ids[] = $id;
					}
				}
				else
				{
					$ids = array();
					if(! empty($_POST["paramv"]))
					{
						$sort = 1;
						foreach ($_POST["paramv"] as $key => $value)
						{
							$value = trim($value);
							if (! $value && $value !== "0")
								continue;

							$id = 0;
							if ( ! empty($_POST["param_id"][$key]))
							{
								$id = $_POST["param_id"][$key];
							}
							if ($id)
							{
								DB::query("UPDATE {ab_param_select} SET [name]='%h', sort=%d WHERE id=%d", $value, $sort, $id);
							}
							else
							{
								$id = DB::query("INSERT INTO {ab_param_select} (param_id, [name], sort) VALUES (%d, '%h', %d)", $this->diafan->id, $value, $sort);
							}
							$sort++;
							$_POST["param_rewrite"][$key] = ! empty($_POST["param_rewrite"][$key]) ? trim($_POST["param_rewrite"][$key]) : '';

							if ($_POST["param_rewrite"][$key])
							{
								$rewrite = DB::query_fetch_array("SELECT id, rewrite FROM {rewrite} WHERE module_name='ab' AND element_type='param' AND element_id=%d LIMIT 1", $id);
								if ( ! empty($rewrite["id"]))
								{

									if ($rewrite["rewrite"] != trim($_POST["param_rewrite"][$key]))
									{
										DB::query("UPDATE {rewrite} SET rewrite='%h' WHERE element_type='param' AND element_id=%d", trim($_POST["param_rewrite"][$key]), $id);
									}
								}
								else
								{
									DB::query("INSERT INTO {rewrite} (module_name, element_type, element_id, rewrite) VALUES ('ab', 'param', %d, '%h')", $id, trim($_POST["param_rewrite"][$key]));
								}
							}
							else
							{
								$this->diafan->_route->delete($id, 'ab', 'param');
							}
							$ids[] = $id;
						}
					}
				}

				if (! empty($ids))
				{
					$del_ids = DB::query_fetch_value("SELECT id FROM {ab_param_select} WHERE param_id=%d AND id NOT IN (%s)", $this->diafan->id, implode(",", $ids), "id");
					if($del_ids)
					{
						DB::query("DELETE FROM {ab_param_select} WHERE id IN (%s)", implode(",", $del_ids));
						DB::query("DELETE FROM {ab_param_element} WHERE param_id=%d AND value".$this->diafan->_languages->site." IN (%s)", $this->diafan->id, implode(",", $del_ids));
						$this->diafan->_route->delete($del_ids, 'ab', 'param');
					}
				}

				break;
			case "checkbox":

				if ($this->diafan->values("type") == "checkbox" && ($_POST["paramk_check1"] || $_POST["paramk_check0"]))
				{
					$rows = DB::query_fetch_all("SELECT id, value FROM {ab_param_select} WHERE param_id=%d", $this->diafan->id);
					foreach ($rows as $row)
					{
						if ($row["value"] == 1)
						{
							DB::query("UPDATE {ab_param_select} SET [name]='%h' WHERE id=%d", $_POST["paramk_check1"], $row["id"]);
							$check1 = true;
						}
						elseif ($row["value"] == 0)
						{
							DB::query("UPDATE {ab_param_select} SET [name]='%h' WHERE id=%d", $_POST["paramk_check0"], $row["id"]);
							$check0 = true;
						}
					}
					DB::query("DELETE FROM {ab_param_select} WHERE param_id=%d AND value NOT IN (0,1)", $this->diafan->id);
				}
				else
				{
					DB::query("DELETE FROM {ab_param_select} WHERE param_id=%d", $this->diafan->id);
				}
				if (empty($check0) && $_POST["paramk_check0"])
				{
					DB::query("INSERT INTO {ab_param_select} (param_id, value, [name]) VALUES (%d, 0, '%h')", $this->diafan->id, $_POST["paramk_check0"]);
				}
				if (empty($check1) && $_POST["paramk_check1"])
				{
					DB::query("INSERT INTO {ab_param_select} (param_id, value, [name]) VALUES (%d, 1, '%h')", $this->diafan->id, $_POST["paramk_check1"]);
				}

				break;

			default:
				DB::query("DELETE FROM {ab_param_select} WHERE param_id=%d", $this->diafan->id);
		}

		Custom::inc('modules/attachments/admin/attachments.admin.inc.php');
		$attachment = new Attachments_admin_inc($this->diafan);
		$attachment->save_config_param();

		Custom::inc('modules/images/admin/images.admin.inc.php');
		$images = new Images_admin_inc($this->diafan);
		$images->save_config_param();
	}

	/**
	 * Сохранение поля "Отдельная страница для значений"
	 *
	 * @return void
	 */
	public function save_variable_page()
	{
		$this->diafan->set_query("page='%d'");
		$this->diafan->set_value(($_POST["type"] == 'multiple' || $_POST["type"] == 'select') && ! empty($_POST["page"]) ? 1 : 0);
	}

	/**
	 * Сохранение поля "Категория"
	 *
	 * @return void
	 */
	public function save_variable_category()
	{
		$site_id = $this->diafan->filter($_POST, "integer", "site_id");

		$this->diafan->set_query("site_id=%d");
		$this->diafan->set_value($site_id);

		DB::query("DELETE FROM {ab_param_category_rel} WHERE element_id=%d", $this->diafan->id);
		if(! empty($_POST["cat_ids"]) && in_array("all", $_POST["cat_ids"]))
		{
			$_POST["cat_ids"] = array();
		}
		$cat_ids = array();
		if(! empty($_POST["cat_ids"]))
		{
			foreach ($_POST["cat_ids"] as $cat_id)
			{
				$cat_id = $this->diafan->filter($cat_id, "integer");
				$cat_ids[] = $cat_id;
			}
		}
		if($site_id && $cat_ids)
		{
			$cat_ids = DB::query_fetch_value("SELECT id FROM {ab_category} WHERE trash='0' AND site_id=%d AND id IN (%s)", $site_id, implode(",", $cat_ids), "id");
		}
		if($cat_ids)
		{
			foreach ($cat_ids as $cat_id)
			{
				DB::query("INSERT INTO {ab_param_category_rel} (element_id, cat_id) VALUES(%d, %d)", $this->diafan->id, $cat_id);
			}
		}
		else
		{
			DB::query("INSERT INTO {ab_param_category_rel} (element_id) VALUES(%d)", $this->diafan->id);
		}
	}

	/**
	 * Сохранение поля "Обязательно для заполнения"
	 * @return void
	 */
	public function save_variable_required()
	{
		$this->diafan->set_query("required='%d'");
		if(! empty($_POST["required"]) && $_POST["type"] == "title")
		{
			$this->diafan->set_value(0);
		}
		else
		{
			$this->diafan->set_value(! empty($_POST["required"]) ? 1 : 0);
		}
	}
}
