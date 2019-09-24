'use strict';

import WOW from 'wow.js';

const makeID = (length) => {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
        charactersLength = characters.length;

    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
};


async function initMainQuiz() {
    const data = {
            questions: [
                {
                    title: 'Какой язык хотите учить?',
                    answers: ["Английский", "Испанский", "Французский", "Немецкий", "Русский", "Китайский", "Итальянский"]
                },
                {title: 'Заглушка', answers: ["Заглушка 1", "Заглушка 2", "Заглушка 3", "Заглушка 4", "Заглушка 5"]},
                {title: 'Заглушка', answers: ["Заглушка 1", "Заглушка 2", "Заглушка 3", "Заглушка 4", "Заглушка 5"]},
                {title: 'Заглушка', answers: ["Заглушка 1", "Заглушка 2", "Заглушка 3", "Заглушка 4", "Заглушка 5"]},
                {title: 'Заглушка', answers: ["Заглушка 1", "Заглушка 2", "Заглушка 3", "Заглушка 4", "Заглушка 5"]},
                {title: 'Заглушка', answers: ["Заглушка 1", "Заглушка 2", "Заглушка 3", "Заглушка 4", "Заглушка 5"]},
            ],
            end: {
                courses: []
            }
        },
        quiz = $('.main-quiz');

    if (quiz.length) {
        const box = $(quiz).find('.main-quiz-form'),
            wrapper = $(quiz).find('.main-quiz__wrapper');
        let html = '',
            htmlDot = '<div class="main-quiz-dots"><ul class="main-quiz-dots-list">',
            htmlForm = '',
            questionsArr = data.questions;

        questionsArr.forEach(function (value, key, questionsArr) {
            htmlDot += `<li class="main-quiz-dots-list__item${(+key === 0 ? ' main-quiz-dots-list__item--active' : '')}" data-number-dot="${+key + 1}">${+key + 1}</li>`;
            html += `<fieldset class="main-quiz-form-question${(+key === 0 ? ' main-quiz-form-question--active' : '')}" data-number-question="${+key + 1}">
<div class="main-quiz-form-question__wrapper"><legend class=" main-quiz-form-question__title" data-question-title="${value.title}">${value.title}</legend>`;
            let arr = value.answers;
            arr.forEach(function (answer, index, arr) {
                if (index === 0) {
                    html += '<div class="main-quiz-form-question__radios">';
                }
                let currentID = makeID(8);
                html += `<div class="main-quiz-form-radio">
<input type="radio" name="question-${key + 1}" class="main-quiz-form-radio__item" id="question-1-${currentID}" value="${answer}">
<label for="question-1-${currentID}" class="main-quiz-form-radio__label">${answer}</label></div>`;
            });
            html += '</div><button class="c-btn main-quiz-form-question__btn">Следующий вопрос</button></div></fieldset>';
        });

        htmlDot += `<li class="main-quiz-dots-list__item" data-number-dot="${+questionsArr.length + 1}">${+questionsArr.length + 1}</li></ul></div>`;
        $(box).append(html);
        $(wrapper).append(htmlDot);
    }

    $(quiz).on('click', '.main-quiz-form-question__btn', function (e) {
        e.preventDefault();
        const parentQuestion = $(this).closest('.main-quiz-form-question');

        if ($('input:radio', parentQuestion).is(':checked')) {
            const parentQuiz = $(parentQuestion).closest('.main-quiz'),
                dots = $(parentQuiz).find('.main-quiz-dots'),
                numberTab = $(parentQuestion).attr('data-number-question'),
                newNumberTab = +numberTab + 1,
                nextQuestion = $('.main-quiz-form-question[data-number-question="' + newNumberTab + '"]', parentQuiz);

            if (nextQuestion.length) {
                $('.main-quiz-dots-list__item[data-number-dot="' + numberTab + '"]', dots).addClass('main-quiz-dots-list__item--completed').removeClass('main-quiz-dots-list__item--active');
                $('.main-quiz-dots-list__item[data-number-dot="' + newNumberTab + '"]', dots).addClass('main-quiz-dots-list__item--active');
                $(parentQuestion).addClass('main-quiz-form-question--completed').removeClass('main-quiz-form-question--active');
                $(nextQuestion).addClass('main-quiz-form-question--active');
            } else {
                const quizForm = $('.main-quiz-form', parentQuiz),
                    endSlide = $('.main-quiz-end', parentQuiz),
                    linksList = $('.main-quiz-end-links-list', endSlide),
                    links = getCoursesLinks();
                let htmlCourses = '';

                links.forEach(function (value, key, links) {
                    htmlCourses += `<li class="main-quiz-end-links-list__item"><a class="c-link" href="#">${value}</a></li>`;
                });

                $(linksList).append(htmlCourses);
                $('.main-quiz-dots-list__item[data-number-dot="' + numberTab + '"]', dots).addClass('main-quiz-dots-list__item--completed').removeClass('main-quiz-dots-list__item--active');
                $('.main-quiz-dots-list__item[data-number-dot="' + newNumberTab + '"]', dots).addClass('main-quiz-dots-list__item--active');
                $(parentQuestion).addClass('main-quiz-form-question--completed').removeClass('main-quiz-form-question--active');
                $(quizForm).addClass('main-quiz-form--completed')
            }
        } else {
            const allLabels = $(parentQuestion).find('label');
            $(allLabels).each(function (index) {
                const item = $(this);
                setTimeout(function () {
                    item.addClass('main-quiz-form-radio__label--error');
                }, 175 * index);
                setTimeout(function () {
                    item.removeClass('main-quiz-form-radio__label--error');
                }, 175 * (index + 1));
            });
        }

    }).on('click', '.main-quiz-end-links__more-details', function () {
        const parent = $(this).closest('.main-quiz-end');
        $(parent).find('.main-quiz-end-links').addClass('main-quiz-end-links--hidden');
    });
}

function scrollToElement(el = $('body')) {
    $(el).scrollTop($(el).offset().top);
}

async function initEventsCoursesBlock() {
    const coursesBlock = $('.courses');

    if (coursesBlock.length) {
        $(coursesBlock).on('click', '.courses-block-left-nav-list__item', function () {
            const thisActiveNumber = $(this).attr('data-course-nav-left'),
                topActiveNumber = $('.courses-block-main-top-nav-list__item--active', coursesBlock).attr('data-course-nav-top'),
                activeLeftNav = $('.courses-block-left-nav-list__item--active', coursesBlock),
                activeContent = $('.courses-block-main-content-items-one--active', coursesBlock),
                newActiveContent = $('.courses-block-main-content-items-one[data-course-left="' + thisActiveNumber + '"][data-course-top="' + topActiveNumber + '"]', coursesBlock);

            $(this).addClass('courses-block-left-nav-list__item--active');
            $(activeLeftNav).removeClass('courses-block-left-nav-list__item--active');
            $(activeContent).removeClass('courses-block-main-content-items-one--active');
            $(newActiveContent).addClass('courses-block-main-content-items-one--active');
            scrollToElement(coursesBlock);
        }).on('click', '.courses-block-main-top-nav-list__item', function () {
            const thisActiveNumber = $(this).attr('data-course-nav-top'),
                leftActiveNumber = $('.courses-block-left-nav-list__item--active', coursesBlock).attr('data-course-nav-left'),
                activeTopNav = $('.courses-block-main-top-nav-list__item--active', coursesBlock),
                activeContent = $('.courses-block-main-content-items-one--active', coursesBlock),
                newActiveContent = $('.courses-block-main-content-items-one[data-course-top="' + thisActiveNumber + '"][data-course-left="' + leftActiveNumber + '"]', coursesBlock);

            $(this).addClass('courses-block-main-top-nav-list__item--active');
            $(activeTopNav).removeClass('courses-block-main-top-nav-list__item--active');
            $(activeContent).removeClass('courses-block-main-content-items-one--active');
            $(newActiveContent).addClass('courses-block-main-content-items-one--active');
            scrollToElement(coursesBlock);
        }).on('click', '#coursesLeftNavBtnLeft', function () {
            const thisActiveNav = $('.courses-block-left-nav-list__item--active', coursesBlock).attr('data-course-nav-left'),
                topActiveNumber = $('.courses-block-main-top-nav-list__item--active', coursesBlock).attr('data-course-nav-top'),
                activeContent = $('.courses-block-main-content-items-one--active', coursesBlock),
                maxNavItems = $('.courses-block-left-nav-list__item', coursesBlock).length;

            let newActiveNav = 0;

            ((+thisActiveNav - 1) === 0 ? newActiveNav = maxNavItems : newActiveNav = (+thisActiveNav - 1));

            const newActiveContent = $('.courses-block-main-content-items-one[data-course-left="' + newActiveNav + '"][data-course-top="' + topActiveNumber + '"]', coursesBlock);

            $('.courses-block-left-nav-list__item--active', coursesBlock).removeClass('courses-block-left-nav-list__item--active');
            $('.courses-block-left-nav-list__item[data-course-nav-left="' + newActiveNav + '"]', coursesBlock).addClass('courses-block-left-nav-list__item--active');
            $(activeContent).removeClass('courses-block-main-content-items-one--active');
            $(newActiveContent).addClass('courses-block-main-content-items-one--active');
        }).on('click', '#coursesLeftNavBtnRight', function () {
            const thisActiveNav = $('.courses-block-left-nav-list__item--active', coursesBlock).attr('data-course-nav-left'),
                topActiveNumber = $('.courses-block-main-top-nav-list__item--active', coursesBlock).attr('data-course-nav-top'),
                activeContent = $('.courses-block-main-content-items-one--active', coursesBlock),
                maxNavItems = $('.courses-block-left-nav-list__item', coursesBlock).length;

            let newActiveNav = 0;

            ((+thisActiveNav + 1) > maxNavItems ? newActiveNav = 1 : newActiveNav = (+thisActiveNav + 1));


            const newActiveContent = $('.courses-block-main-content-items-one[data-course-left="' + newActiveNav + '"][data-course-top="' + topActiveNumber + '"]', coursesBlock);

            $('.courses-block-left-nav-list__item--active', coursesBlock).removeClass('courses-block-left-nav-list__item--active');
            $('.courses-block-left-nav-list__item[data-course-nav-left="' + newActiveNav + '"]', coursesBlock).addClass('courses-block-left-nav-list__item--active');
            $(activeContent).removeClass('courses-block-main-content-items-one--active');
            $(newActiveContent).addClass('courses-block-main-content-items-one--active');
        });
    }
}


const getCoursesLinks = () => {
    return [
        'Курс «Деловой английский»',
        'Курс «Деловой английский»',
        'Курс «Деловой английский»',
    ]
};

$(document).ready(() => {
    const wow = new WOW(
        {
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true
        }
    );
    wow.init();
    initMainQuiz().catch(error => {
        throw new Error('mainQuiz not load');
    });
    initEventsCoursesBlock().catch(error => {
        throw new Error('coursesBlock error');
    });
    $('body').on('click', '#mobileMenuOpen', function () {
        const menu = $('.top-line-menu__wrapper');

        if (menu.length) {
            $(menu).addClass('top-line-menu__wrapper--open');
            $('body').addClass('no-scroll');
        }
    }).on('click', '#mobileMenuClose', function () {
        const menu = $('.top-line-menu__wrapper');

        if (menu.length) {
            $(menu).removeClass('top-line-menu__wrapper--open');
            $('body').removeClass('no-scroll');
        }
    });

});


