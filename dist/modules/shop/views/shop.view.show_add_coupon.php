<?php
/**
 * Шаблон формы активации купона
 * 
 * Шаблонный тег <insert name="show_add_coupon" module="shop" [template="шаблон"]>:
 * форма активации купона
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

echo '<div class="coupon-d section-d__coupon"><div class="coupon-d__inside">';
if($result["coupon"])
{
    echo '<div class="coupon-d__inside">'.$this->diafan->_('Вы активировали купон.').'</div>';
}
else
{
    echo '<form method="post" action="" class="js_shop_form ajax">
    <input type="hidden" name="action" value="add_coupon">
    <input type="hidden" name="form_tag" value="'.$result["form_tag"].'">
    <input type="hidden" name="module" value="shop">
    <div class="coupon-d__inside">
    <div class="heading-d coupon-d__heading">'.$this->diafan->_('Код купона на скидку').'</div>
    <div class="field-d field-d_text coupon-d__field">
    <input type="text" name="coupon" placeholder="'.$this->diafan->_('Введите код', false).'">
    </div>
    <button class="button-d button-d_narrow coupon-d__button" type="submit"><span class="button-d__name">'.$this->diafan->_('Активировать', false).'</span></button>
    </div>
    <div class="errors error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>
    </form>';
}
echo '</div></div>';