import ajaxRequest from "./ajax";
const {__} = wp.i18n;
/**
 * Check previous lesson complete status and not completed previous lesson
 * then restrict user to start next lesson or quiz
 *
 * @since v1.0.0
 */
document.addEventListener('DOMContentLoaded', async function() {

    //disable sidebar lesson link
    const lessonList = document.querySelectorAll('.tutor-single-lesson-items:not(.active)');
    lessonList.forEach((lesson) => {
        if ( lesson.querySelector('.tutor-done')) {

        } else {
            lesson.style.background = '#dddddd';
            const a = lesson.querySelector('a');
            if (a != null || a != undefined) {
                a.setAttribute('class', '');
                a.style.cursor = 'not-allowed';
                const lessonTitle = a.querySelector('.lesson_title');
                const playTime = a.querySelector('.tutor-play-duration');
                const quizTime = a.querySelector('.quiz-time-limit')
                if ( lessonTitle ) {
                    lessonTitle.style.color = '#a4a9b9';
                }
                if ( playTime ) {
                    playTime.style.color = '#a4a9b9';
                }
                if ( quizTime ) {
                    quizTime.style.color = '#a4a9b9';
                }
                a.onclick = (e) => {
                    e.preventDefault();
                }
            }
        }
    });

    // disable next lesson go link
    let dynamicDocument = document.getElementById('tutor-single-entry-content');
    if (dynamicDocument) {
        dynamicDocument.onclick = (e) => {
           if (e.target.classList.contains('tutor-next-link')) {
            e.preventDefault();
            console.log(e.target.classList);
           }
        } 
    }

    const lessonSidebar = document.getElementById('tutor-lesson-sidebar-tab-content');
    if (lessonSidebar) {
        const hasActiveContent = document.querySelector('.tutor-single-lesson-items.active');
        //check if user in on any course material like lesson, quiz etc
        if(hasActiveContent) {
            const currentContent = hasActiveContent.querySelector('a');
            let contentId = 0;
            if (currentContent.hasAttribute('data-lesson-id')) {
                contentId = Number(currentContent.getAttribute('data-lesson-id'));
            }
            if (currentContent.hasAttribute('data-quiz-id')) {
                contentId = Number(currentContent.getAttribute('data-quiz-id'));
            }
            checkPreviousContentStatus(contentId);
        }
    }
    /**
     * On click course content check if user completed previous content
     */
    if (lessonSidebar) {
        lessonSidebar.onclick = (e) => {
            const target = e.target;
            let clickedTag = target;
            if (clickedTag.tagName !== 'A') {
                clickedTag = target.closest('a');
            }
            if (clickedTag.hasAttribute('data-lesson-id')) {

                checkPreviousContentStatus(Number(clickedTag.getAttribute('data-lesson-id')));
            }
            if (clickedTag.hasAttribute('data-quiz-id')) {
                checkPreviousContentStatus(Number(clickedTag.getAttribute('data-quiz-id')));
            }
        }
    }
});

async function checkPreviousContentStatus(contentId) {
    if (contentId > 0) {
        //check if user complete previous course content
        const formData = new FormData();
        formData.set('content-id', contentId);
        formData.set('action', 'tutor_periscope_previous_content_status');
        formData.set('nonce', tp_data.nonce);
        const response = await ajaxRequest(formData);
        if (response.success) {
        } else {
            if(response.data.url) {
                tutor_toast(
                    __('Fail', 'tutor-periscope'),
                    __('Please complete previous lesson first!', 'tutor-periscope'),
                    'error',
                );
                window.location.href = response.data.url
            } else {
                tutor_toast(
                    __('Fail', 'tutor-periscope'),
                    __('Previous content status check failed!', 'tutor-periscope'),
                    'error',
                );
            }
        }

    }
}