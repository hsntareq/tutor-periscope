/**
 * Hide lesson complete button
 *
 * Hide start quiz button
 */
document.addEventListener('DOMContentLoaded', function() {

    //hide lesson complete button
    const tutorLessonCompleteBtn = document.querySelector('.tutor-topbar-complete-btn');
    if (tutorLessonCompleteBtn) {
        tutorLessonCompleteBtn.remove();
    }

    //hide start quiz button if student out of attempt
    if (!tp_data.has_quiz_attempt) {
        const startQuizButton = document.querySelectorAll('button[name=start_quiz_btn]');
        startQuizButton.forEach((button) => {
            button.remove();
        });
    }

    const quizDetails = document.querySelectorAll('td[data-th=Result]');
    quizDetails.forEach((item) => {
        if (item.querySelector('.label-danger')) {
            item.nextSibling.nextSibling.innerHTML = '';
        }
    });
});