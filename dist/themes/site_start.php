<?php
/**
 * Шаблон стартовой страницы сайта
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (!defined("DIAFAN")) {
    $path = __FILE__;
    while (!file_exists($path . '/includes/404.php')) {
        $parent = dirname($path);
        if ($parent == $path) exit;
        $path = $parent;
    }
    include $path . '/includes/404.php';
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

    <!-- шаблонный тег show_head выводит часть HTML-шапки сайта. Описан в файле themes/functions/show_head.php. -->
    <insert name="show_head">
        <meta name="viewport" content="width=1280">

        <link rel="shortcut icon" href="<insert name=" path
        ">favicon.ico" type="image/x-icon">
        <!-- шаблонный тег show_css подключает CSS-файлы. Описан в файле themes/functions/show_css.php. -->
        <insert name="show_css" files="style.css">

            </head>

<body>
<header class="main-header">
    <div class="top-line">
        <div class="top-line__wrapper">
            <insert name="show_block" module="menu" id="1" template="top_line">
                <div class="top-line__other">
                    <div class="top-line-sign-in">
                        <a href="#" title="Войти в личный кабинет"
                           class="c-link top-line-sign-in__link"><span>Личный кабинет</span></a>
                    </div>
                    <insert name="show_search" module="search" template="top" ajax="true">
                </div>
        </div>
    </div>
    <div class="main-header__wrapper">
        <div class="main-header-site">
            <span class="main-header-site__name"><insert name="show_href" alt="Лингвистический клуб"></span>
        </div>
        <div class="main-header__other">
            <div class="main-header-info">
                <div class="main-header-info-links">
                    <a href="#" class="c-link c-link--primary main-header-info-links__item" title="Попробовать">Пробное
                        занятие</a>
                    <a href="#" class="c-link c-link--primary main-header-info-links__item" title="Пройти">On-line
                        тест</a>
                </div>
                <div class="main-header-info-social">
                    <insert name="show_block" module="site" id="6">
                </div>
                <div class="main-header-info-phones">
                    <div class="main-header-info-phones-item">
                        <insert name="show_block" module="site" id="1">
                    </div>
                    <div class="main-header-info-phones-item">
                        <insert name="show_block" module="site" id="5">
                    </div>
                </div>
            </div>
            <div class="main-header-controls">
                <insert name="show_block" module="menu" id="3" template="additional">
                    <a href="#" class="c-btn main-header-controls__btn c-btn--small">Подобрать курс за 5 минут</a>
            </div>
        </div>
    </div>
</header>
<main class="main-content">
    <article class="main-slider">
        <insert name="show_block" module="bs" count="3" cat_id="1" template="slider" defer="emergence">
    </article>
    <section class="advantages">
        <div class="advantages__wrapper">
            <h1 class="advantages__title">Лингвистический клуб<br>иностранных языков в Самаре</h1>
            <ul class="advantages-list">
                <li class="advantages-list-item">
                    <h2 class="advantages-list-item__title">
                        <span class="advantages-list-item__secondary-text">Опыт более</span>
                        <span class="advantages-list-item__primary-text">13 лет</span>
                    </h2>
                </li>
                <li class="advantages-list-item">
                    <h2 class="advantages-list-item__title">
                        <span class="advantages-list-item__secondary-text">Обучение</span>
                        <span class="advantages-list-item__primary-text">7 языкам</span>
                    </h2>
                </li>
                <li class="advantages-list-item">
                    <h2 class="advantages-list-item__title">
                        <span class="advantages-list-item__secondary-text">Переводы с/на</span>
                        <span class="advantages-list-item__primary-text">30 языков</span>
                    </h2>
                </li>
            </ul>
        </div>
    </section>
    <section class="learning-benefits">
        <div class="learning-benefits__wrapper">
            <h1 class="learning-benefits__title">Быстрое и комфортное изучение языка</h1>
            <ul class="learning-benefits-list">
                <li class="learning-benefits-list-item">
                    <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name=" custom
                    " path="custom/img/info/benifits/talk.svg" absolute="true">)">
        </div>
        <span class="learning-benefits-list-item__description">Сделаем всё, чтобы <b>вы заговорили как можно раньше</b></span>
        </li>
        <li class="learning-benefits-list-item">
            <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name=" custom
            " path="custom/img/info/benifits/medal.svg" absolute="true">)">
            </div>
            <span class="learning-benefits-list-item__description">Постоянный контроль качества курсов, <b>даем гарантию что вы освоите 100%</b> материала</span>
        </li>
        <li class="learning-benefits-list-item">
            <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name=" custom
            " path="custom/img/info/benifits/rating.svg" absolute="true">)">
            </div>
            <span class="learning-benefits-list-item__description"><b>Мотивирующая дружелюбная</b> атмосфера на занятиях</span>
        </li>
        <li class="learning-benefits-list-item">
            <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name=" custom
            " path="custom/img/info/benifits/worldwide.svg" absolute="true">)">
            </div>
            <span class="learning-benefits-list-item__description">Работаем по <b>международным стандартам CEFR</b></span>
        </li>
        <li class="learning-benefits-list-item">
            <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name=" custom
            " path="custom/img/info/benifits/cup.svg" absolute="true">)">
            </div>
            <span class="learning-benefits-list-item__description"><b>Платиновый партнер</b> международным издательства «Макмиллан»</span>
        </li>
        <li class="learning-benefits-list-item">
            <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name=" custom
            " path="custom/img/info/benifits/startup.svg" absolute="true">)">
            </div>
            <span class="learning-benefits-list-item__description"><b>Собственный методический отдел</b> для преподавателей. Учим тех, кто учит других</span>
        </li>
        </ul>
        </div>
    </section>
        <article class="main-quiz">
            <div class="main-quiz__wrapper">
                <div class="main-quiz-dots">
                    <ul class="main-quiz-dots-list">
                        <li class="main-quiz-dots-list__item main-quiz-dots-list__item--active" data-number-dot="1">1</li>
                        <li class="main-quiz-dots-list__item" data-number-dot="2">2</li>
                        <li class="main-quiz-dots-list__item" data-number-dot="3">3</li>
                        <li class="main-quiz-dots-list__item" data-number-dot="4">4</li>
                        <li class="main-quiz-dots-list__item" data-number-dot="5">5</li>
                        <li class="main-quiz-dots-list__item" data-number-dot="6">6</li>
                        <li class="main-quiz-dots-list__item" data-number-dot="7">7</li>
                    </ul>
                </div>
                <div class="main-quiz__box">
                    <h1 class="main-quiz__title">Подбор курса за 5 минут</h1>
                    <form id="formForMainQuiz" class="main-quiz-form">

                    </form>
                </div>
            </div>
        </article>
</main>
<div id="top-line">
    <div class="wrapper">
        <div class="top-phone">
            <insert name="show_block" module="site" id="1">
        </div>
        <!-- шаблонный тег вывода блока ссылок на разные языковые версии сайта. Вид формы редактируется в файле modules/languages/views/languages.view.show_block.php. -->

        <div class="top-line-right">
            <!-- шаблонный тег вывода количества отложенных товаров. Вид формы редактируется в файле modules/wishlist/views/wishlist.view.show_block.php. -->
            <insert name="show_block" module="wishlist">

                <!-- шаблонный тег вывода формы корзины. Вид формы редактируется в файле modules/cart/views/cart.view.show_block.php. -->
                <insert name="show_block" module="cart">
        </div>
    </div>
</div>
<div id="top-menuline">
    <div class="wrapper">
        <div id="logo">
            <!-- шаблонный тег вывода "умной ссылки", которая не ссылается сама на себя. Если это не требуется, можно заменить на классические <a href="/">Название сайта</a>  -->
            <insert name="show_href" img="img/logo_LANG.png" alt="title" width="220" height="80">
        </div>
        <!-- шаблонный тег вывода первого меню (параметр id=1). Настраивается в файле modules/menu/views/menu.view.show_block_topmenu.php
        Документация тега http://www.diafan.ru/dokument/full-manual/templates-functions/#show_block_menu -->

        <!-- шаблонный тег вывода формы поиска. Вид формы редактируется в файле modules/search/views/search.view.show_search.php. -->
    </div>
</div>
<!-- шаблонный тег вывода баннеров. Блок выводит баннеры слайдера. Вид блока редактируется в файле modules/bs/views/bs.view.show_block_slider.php-->

<div class="wrapper content">
    <div id="left-col">
        <div class="block">
            <h3>
                <insert value="Продукция">
            </h3>
            <!-- шаблонный тег вывода меню каталога (параметр id=2). Настраивается в файле modules/menu/views/menu.view.show_block_leftmenu.php
            Документация тега http://www.diafan.ru/dokument/full-manual/templates-functions/#show_block_menu -->
            <insert name="show_block" module="menu" id="2" template="leftmenu">
        </div>
        <!-- шаблонный тег вывода формы поиска по товарам. Вид формы редактируется в файле modules/shop/views/shop.view.show_search.php. -->
        <insert name="show_search" module="shop" cat_id="current" ajax="true" defer="emergence"
                defer_title="Поиск по товарам">
            <!-- шаблонный тег вывода формы входа и регистрации пользователей. Вид формы редактируется в файле modules/registration/views/registration.view.show_login.php. -->
            <insert name="show_login" module="registration" defer="emergence" defer_title="Профиль">

                <!-- шаблонный тег вывода блока некоторых товаров из магазина. Вид блока товаров редактируется в файле modules/shop/views/shop.view.show_block.php. -->
                <insert name="show_block" module="shop" count="1" images="1" sort="rand" template="left"
                        defer="emergence" defer_title="Товары">

                    <!-- шаблонный тег вывода блока с голосованиями. Вид блока редактируется в файле modules/votes/views/votes.view.show_block.php. -->
                    <insert name="show_block" module="votes" sort="rand" defer="emergence"
                            defer_title="Опрос сайта">
    </div>
    <div id="right-col">
        <!-- шаблонный тег вывода блока новостей. Вид блока файлов редактируется в файле modules/news/views/news.view.show_block.php. -->
        <insert name="show_block" module="news" count="2" images="1" defer="emergence" defer_title="Новости">
            <!-- шаблонный тег вывода блока статей. Вид блока статей редактируется в файле modules/clauses/views/clauses.view.show_block.php. -->
            <insert name="show_block" module="clauses" count="1" images="1" defer="emergence" defer_title="Статьи">
                <!-- шаблонный тег вывода блока последних комментариев на сайте сайта. Вид блока редактируется в файле modules/comments/views/comments.view.show_block.php -->
                <insert name="show_block" module="comments" defer="emergence" defer_title="Последние комментарии">
                    <!-- шаблонный тег вывода блока некоторых изображений из фотогалереи. Вид блока фотографий редактируется в файле modules/photo/views/photo.view.show_block.php. -->
                    <insert name="show_block" module="photo" sort="rand" count="1" cat_id="1" defer="emergence"
                            defer_title="Фотографии">
                        <!-- шаблонный тег вывода блока некоторых позиций из файлового архива. Вид блока файлов редактируется в файле modules/files/views/files.view.show_block.php. -->
                        <insert name="show_block" module="files" count="2" images="1" defer="emergence"
                                defer_title="Файловый архив">
    </div>
    <!--/right-col -->
    <div id="center-col">

        <!-- шаблонный тег вывода навигации "Хлебные крошки"-->
        <insert name="show_breadcrumb">

            <!-- шаблонный тег вывода основного контента сайта -->
            <insert name="show_body">

                <!-- шаблонный тег вывода блока некоторых товаров из магазина. Вид блока товаров редактируется в файле modules/shop/views/shop.view.show_block.php. -->
                <insert name="show_block" module="shop" count="3" images="1" sort="rand" defer="emergence"
                        defer_title="Интернет-магазин">

                    <!-- шаблонный тег вывода блока вопросов и ответов сайта. Вид блока редактируется в файле modules/faq/views/faq.view.show_block.php. -->
                    <insert name="show_block" module="faq" count="2" often="0" defer="emergence"
                            defer_title="Вопрос-Ответ">
                        <!-- шаблонный тег вывода блока последних сообщений на форуме. Вид блока файлов редактируется в файле modules/forum/views/forum.view.show_block_messages.php. -->
                        <insert name="show_block_messages" module="forum" count="3" cat_id="all" defer="emergence"
                                defer_title="Последние сообщения на форуме">
    </div>
    <div class="clear">&nbsp;</div>
    <div class="bs_center">
        <!-- шаблонный тег вывода баннеров. Блок выводит все баннеры. Вид блока редактируется в файле modules/bs/views/bs.view.show_block.php-->
        <insert name="show_block" module="bs" count="1" cat_id="2" defer="emergence">
    </div>
</div>
<!-- шаблонный тег вывода формы для подписчиков. Вид блока редактируется в файле modules/subscription/views/subscription.view.form.php.  -->
<insert name="show_form" module="subscription" defer="emergence" defer_title="Подписаться на рассылку">
    <div id="footer">
        <div class="wrapper">
            <div class="contacts">
                <h3>
                    <insert value="Контакты">
                </h3>
                <insert name="show_block" module="site" id="2">
            </div>

            <!-- шаблонный тег вывода кнопок социальных сетей. Правится в файле themes/functions/show_social_links_main.php -->
            <insert name="show_social_links_main">

                <div class="footer-menu">
                    <h3>
                        <insert value="О магазине">
                    </h3>
                    <!-- шаблонный тег вывода первого меню (параметр id=1). Настраивается в файле modules/menu/views/menu.view.show_menu.php, так как параметр template не был передан. Тогда в оформлении используются параметры tag
                    Документация тега http://www.diafan.ru/dokument/full-manual/templates-functions/#show_block_menu -->
                    <insert name="show_block" module="menu"
                            id="1"
                            count_level="1"
                            tag_level_start_1="[ul]"
                            tag_start_1="[li]"
                            tag_end_1="[/li]"
                            tag_level_end_1="[/ul]"
                            tag_level_start_2=""
                            tag_start_2="[li class='podmenu']"
                            tag_end_2="[/li]"
                            tag_level_end_2=""
                    >
                </div>
                <div class="copyright">
                    <h3>&copy;
                        <insert name="show_year"> Demosite.ru
                    </h3>
                    <!-- шаблонный тег подключает файл-блок -->
                    <insert name="show_include" file="diafan">
                        <div class="notes">
				<span class="note mistakes">
					<i class="fa fa-warning"></i>
                    <!-- шаблонный тег ошибка на сайте -->
					<insert name="show_block" module="mistakes">
				</span>
                            <span class="note sitemap">
					<i class="fa fa-link"></i>
                                <!-- шаблонный тег show_href выведет ссылку на карту сайта <a href="/map/"><img src="/img/map.png"></a>, на странице карты сайта тег выведет активную иконку -->
					<insert name="show_href" rewrite="map" alt="Карта сайта">
				</span>
                            <span class="note siteinfo">
					<i class="fa fa-signal"></i>
                                <!-- шаблонный тег вывода количества пользователей on-line. Вид блока редактируется в файле modules/users/views/users.view.show_block.php. -->
					<insert name="show_block" module="users">
				</span>
                        </div>
                </div>
        </div>
    </div>
    <!--/footer -->

    <!-- шаблонный тег подключает on-line консультант -->

    <!-- шаблонный тег show_js подключает JS-файлы. Описан в файле themes/functions/show_js.php. -->
    <insert name="show_js">

        <script type="text/javascript" asyncsrc='<insert name=" custom" path="js/main.js" absolute="true" compress="js">' charset="UTF-8"></script>
        <script type="text/javascript" asyncsrc='<insert name=" custom" path="custom/js/custom.min.js" absolute="true" compress="js">' charset="UTF-8"></script>
