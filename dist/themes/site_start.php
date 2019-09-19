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
<!--        <meta name="viewport" content="width=1280">-->

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
                    <div class="learning-benefits-list-item__icon" style="background-image: url(<insert name="
                         custom
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
            <div class="main-quiz-box">
                <h1 class="main-quiz__title">Подбор курса за 5 минут</h1>
                <div class="main-quiz-box__wrapper">
                    <form id="formForMainQuiz" class="main-quiz-form">

                    </form>
                    <div class="main-quiz-end">
                        <div class="main-quiz-end-links">
                            <ul class="main-quiz-end-links-list">

                            </ul>
                            <button class="c-btn main-quiz-end-links__more-details">Подробнее</button>
                        </div>
                        <div class="main-quiz-end-details">
                            <insert name="show_form" module="feedback" id="153" template="main_quiz">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <articles class="courses">
<div class="courses__wrapper">
    <h1 class="courses__title">Курсы иностранных языков</h1>
    <div class="courses-block">
        <div class="courses-block-left-nav">
            <ul class="courses-block-left-nav-list">
                <li class="courses-block-left-nav-list__item courses-block-left-nav-list__item--active" data-course-nav-left="1">Английский</li>
                <li class="courses-block-left-nav-list__item" data-course-nav-left="2">Испанский</li>
                <li class="courses-block-left-nav-list__item" data-course-nav-left="3">Итальянский</li>
                <li class="courses-block-left-nav-list__item" data-course-nav-left="4">Китайский</li>
                <li class="courses-block-left-nav-list__item" data-course-nav-left="5">Французский</li>
                <li class="courses-block-left-nav-list__item" data-course-nav-left="6">Русский для иностранцев</li>
                <li class="courses-block-left-nav-list__item" data-course-nav-left="7">Немецкий</li>
            </ul>
        </div>
        <div class="courses-block-main">
            <div class="courses-block-main-top-nav">
                <ul class="courses-block-main-top-nav-list">
                    <li class="courses-block-main-top-nav-list__item courses-block-main-top-nav-list__item--active" data-course-nav-top="1">Взрослым</li>
                    <li class="courses-block-main-top-nav-list__item" data-course-nav-top="2">Детям</li>
                    <li class="courses-block-main-top-nav-list__item" data-course-nav-top="3">Учителям</li>
                    <li class="courses-block-main-top-nav-list__item" data-course-nav-top="4">Корпоративное обучение</li>
                    <li class="courses-block-main-top-nav-list__item" data-course-nav-top="5">Переводы</li>
                </ul>
            </div>
            <div class="courses-block-main-content">
                <ul class="courses-block-main-content-items">
                    <li class="courses-block-main-content-items-one courses-block-main-content-items-one--active" data-course-left="1" data-course-top="1">
                        <div class="courses-block-main-content-items-one-info">
                        <p class="courses-block-main-content-items-one-info__description">Интересный факт - обучение языкам во взрослом возрасте гораздо легче, ведь у вас уже есть навык обучения в целом. Наши преподаватели научат вас думать на английском и свободно общаться с носителями языка как в путешествиях так и на работе.</p>
                        <span class="courses-block-main-content-items-one-info__secondary">В рамках обучения есть несколько направлений:</span>
                        <ul class="courses-block-main-content-items-one-info-list">
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-comment courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-one-info-list-item__link">Общий разговорный курс</a></li>
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-running courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-one-info-list-item__link">Экспресс-курсы</a></li>
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-handshake courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-one-info-list-item__link">Деловой курс</a></li>
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-comments courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-one-info-list-item__link">Разговорный клуб</a></li>
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-hiking courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-one-info-list-item__link">Курс для путешествий</a></li>
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-users courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-one-info-list-item__link">Языковое погружение</a></li>
                            <li class="courses-block-main-content-items-one-info-list-item"><i class="fas fa-user-graduate courses-block-main-content-items-one-info-list-item__icon"></i><a href="#" class="c-link c-link--primary courses-block-main-content-items-info-one-list-item__link">Международные экзамены</a></li>
                        </ul>
                            <button class="c-btn courses-block-main-content-items-one-info__btn">Подобрать курс</button>
                            <div class="courses-block-main-content-items-one__image" style="background-image: url(<insert name="
                                 custom
                            " path="custom/img/info/courses/4_1.png" absolute="true">)"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
    </articles>
</main>
    <insert name="show_js">
        <script src="https://kit.fontawesome.com/3c2825fddc.js"></script>
        <script type="text/javascript"
                asyncsrc='<insert name=" custom" path="js/main.js" absolute="true" compress="js">'
                charset="UTF-8"></script>
        <script type="text/javascript"
                asyncsrc='<insert name=" custom" path="custom/js/custom.js" absolute="true" compress="js">'
                charset="UTF-8"></script>
