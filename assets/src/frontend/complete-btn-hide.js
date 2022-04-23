/**
 * Hide lesson complete button
 */
document.addEventListener('DOMContentLoaded', function() {
    const tutorLessonCompleteBtn = document.querySelector('.tutor-topbar-complete-btn');
    if (tutorLessonCompleteBtn) {
        tutorLessonCompleteBtn.remove();
    }
});