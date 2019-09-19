'use strict';

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
                }
            ],
            form: {
                name: {
                    label: 'Имя',
                    type: 'text',
                    name: 'name',
                    placeholder: 'Иванов Иван Иванович',
                },
                phone: {
                    label: 'Телефон',
                    type: 'tel',
                    name: 'phone',
                    placeholder: '89000000000'
                }
            }
        },
        quiz = $('.main-quiz');

    if (quiz) {
        const box = $(quiz).find('.main-quiz__box');
        let html = '';

        for (let [key, value] of Object.entries(data.questions)) {
            html += `<fieldset class="main-quiz-form-question${(+key === 0 ? ' main-quiz-form-question--active' : '')}" data-number-question="${+key + 1}">
<div class="main-quiz-form-question__wrapper"><legend class=" main-quiz-form-question__title" data-question-title="${value.title}">Какой язык хотите учить?</legend>
`;
            let arr = value.answers;
            arr.forEach(function (answer, index, arr) {
                if (index === 0) {
                    html += '<div class="main-quiz-form-question__radios">';
                }
                let currentID = makeID(8);
                html += `<div class="main-quiz-form-radio">
<input type="radio" name="question-${index + 1}" class="main-quiz-form-radio__item" id="question-1-${currentID}" value="${answer}">
<label for="question-1-${currentID}" class="main-quiz-form-radio__label">${answer}</label></div>`;
            });
            html += '<button class="c-btn main-quiz-form-radio__btn">Следующий вопрос</button></div></fieldset>';
        }

        $(box).append(html);
    }
}

$(document).ready(() => {
    initMainQuiz()
        .then(resolve => {
            console.log(resolve);
        });
    $('.main-quiz-form').on('click', '.main-quiz-form-radio__btn', function (e) {
        e.preventDefault();
        const parentQuestion = $(this).closest('.main-quiz-form-question');

        if ($('input:radio', parentQuestion).is(':checked')) {
            const parentQuiz = $(parentQuestion).closest('.main-quiz'),
                dots = $(parentQuiz).find('main-quiz-dots'),
                numberTab = $(parentQuestion).attr('data-number-question'),
                newNumberTab = +numberTab + 1;

            $('.main-quiz-dots-list__item[data-number-dot="' + numberTab + '"]', dots).addClass('main-quiz-dots-list__item--completed').removeClass('main-quiz-dots-list__item--active');
            $('.main-quiz-dots-list__item[data-number-dot="' + newNumberTab + '"]', dots).addClass('main-quiz-dots-list__item--active');
            $(parentQuestion).addClass('main-quiz-form-question--completed').removeClass('main-quiz-form-question--active');
            $('.main-quiz-form-question[data-number-question="' + newNumberTab + '"]', parentQuiz).addClass('main-quiz-form-question--active');
        } else {
            const allLabels = $(parentQuestion).find('label');
            $(allLabels).each(function (index) {
                const item = $(this);
                setTimeout(function () {
                    item.addClass('main-quiz-form-radio__label--error');
                    setTimeout(function () {
                        item.removeClass('main-quiz-form-radio__label--error');
                    }, 200 * ((index + 1) / 2));
                }, 100 * ((index + 1) / 2));
            });
        }
    });
});
