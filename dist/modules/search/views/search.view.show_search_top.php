<?php
/**
 * Шаблон формы поиска по сайту, template=top
 *
 * Шаблонный тег <insert name="show_search" module="search" template="top"
 * [button="надпись на кнопке"]>:
 * форма поиска по сайту
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (!defined('DIAFAN')) {
    $path = __FILE__;
    while (!file_exists($path . '/includes/404.php')) {
        $parent = dirname($path);
        if ($parent == $path) exit;
        $path = $parent;
    }
    include $path . '/includes/404.php';
}

echo '
<div class="top-line-search">
	<form action="' . $result["action"] . '" class="js_search_form top-line-search-form' . ($result["ajax"] ? ' ajax" method="post"' : '" method="get"') . ' id="search">
	<div class="top-line-search-form__box">
	<input type="hidden" name="module" value="search">
	<input id="textbox" class="top-line-search-form__input" pattern="\S+.*" required type="text" name="searchword">
		<button type="submit" class="top-line-search-form__submit"><svg viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.8852 17.8271L13.6007 13.5659C16.6027 10.5453 16.6942 5.69649 13.8083 2.56482C10.9223 -0.566858 6.0822 -0.871004 2.82691 1.87476C-0.428383 4.62053 -0.944612 9.44262 1.65567 12.8153C4.25596 16.1879 9.05075 16.9152 12.5342 14.4654L16.9022 18.8333C17.1762 19.0887 17.6032 19.0812 17.8681 18.8163C18.133 18.5514 18.1405 18.1244 17.8852 17.8503V17.8271ZM1.51246 8.00164C1.51246 4.41643 4.41884 1.51005 8.00404 1.51005C11.5892 1.51005 14.4956 4.41643 14.4956 8.00164C14.4956 11.5868 11.5892 14.4932 8.00404 14.4932C4.41884 14.4932 1.51246 11.5868 1.51246 8.00164Z" fill="#dadada"/>
</svg></button>
		<div class="top-line-search-form__icon">
		<svg viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.8852 17.8271L13.6007 13.5659C16.6027 10.5453 16.6942 5.69649 13.8083 2.56482C10.9223 -0.566858 6.0822 -0.871004 2.82691 1.87476C-0.428383 4.62053 -0.944612 9.44262 1.65567 12.8153C4.25596 16.1879 9.05075 16.9152 12.5342 14.4654L16.9022 18.8333C17.1762 19.0887 17.6032 19.0812 17.8681 18.8163C18.133 18.5514 18.1405 18.1244 17.8852 17.8503V17.8271ZM1.51246 8.00164C1.51246 4.41643 4.41884 1.51005 8.00404 1.51005C11.5892 1.51005 14.4956 4.41643 14.4956 8.00164C14.4956 11.5868 11.5892 14.4932 8.00404 14.4932C4.41884 14.4932 1.51246 11.5868 1.51246 8.00164Z" fill="#dadada"/>
</svg>
<span>Поиск по сайту</span>
</div>
	</div>
	</form>';
if ($result["ajax"]) {
    echo '<div class="js_search_result search_result top-line-search__result"></div>';
}
echo '</div>';