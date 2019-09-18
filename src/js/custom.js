'use strict';

$(document).ready(() => {
    $('.main-quiz-form').on('click', '.main-quiz-form__btn', function (e) {
        e.preventDefault();
        const parentQuestion = $(this).closest('.main-quiz-form-question');

        if ($('input:radio', parentQuestion).is(':checked')) {
            const numberTab = $(parentQuestion).attr('data-number-question'),
                newNumberTab = +numberTab + 1;
            $(parentQuestion).addClass('main-quiz-form-question--completed').removeClass('main-quiz-form-question--active');
            $('.main-quiz-form-question[data-number-question="' + newNumberTab + '"]').addClass('main-quiz-form-question--active');
        } else {
            const allLabels = $(parentQuestion).find('label');
            $(allLabels).each(function(index) {
                const item = $(this);
                setTimeout(function () {
                    item.addClass('main-quiz-form-radio__label--error');
                    setTimeout(function () {
                        item.removeClass('main-quiz-form-radio__label--error');
                    }, 200 * ((index + 1) /2 ));
                }, 100 * ((index + 1) / 2));
            });
        }
    });
});
