import ajaxRequest from "./ajax";
/**
 * Video interaction hook. Tract user's interaction with video.
 * On video pause and end trigger wp hook to store info.
 *
 * @since v1.0.0
 */
const { __ } = wp.i18n;
document.addEventListener('DOMContentLoaded', function () {
    const lessonSidebar = document.getElementById('tutor-lesson-sidebar-tab-content');
    const progressClasses = document.getElementsByClassName('plyr__progress__container');
    const progressBar = progressClasses[0];
    if (progressBar) {
        // progressBar.remove();
    }
    //var video = document.getElementById('tutorPlayer');
    manageVideoAction();

    if (lessonSidebar) {
        lessonSidebar.onclick = (e) => {
            const target = e.target;
            let clickedTag = target;
            if (clickedTag.tagName !== 'A') {
                clickedTag = target.closest('a');
            }
            if (clickedTag.hasAttribute('data-lesson-id')) {
                //wait for content loading, after ready then reload page. so that video event can work
                setTimeout(() => {
                    window.location.reload();
                }, 2000)

            }
        }
    }

    /**
     * Hook up video event. For ex: on video pause, end.
     * And do required operation
     */
    function manageVideoAction() {
        // var video = document.getElementById('tutorPlayer');
        var videos = document.querySelectorAll('.tutor-video-player');

        videos.forEach((video) => {
            if (video) {
                // if has pause time then start from there
                var supposedCurrentTime = tp_data.has_lesson_time ? Number(tp_data.has_lesson_time) : 0;

                video.addEventListener('timeupdate', function () {
                    if (!video.seeking) {
                        supposedCurrentTime = video.currentTime;
                    }

                });
                // prevent user from seeking
                video.addEventListener('seeking', function () {

                    // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
                    var delta = video.currentTime - supposedCurrentTime;
                    // delta = Math.abs(delta); // disable seeking previous content if you want
                    if (delta > 0.01) {
                        video.currentTime = supposedCurrentTime;
                    }
                });
                video.addEventListener('ended', function () {
                    // reset state in order to allow for rewind
                    supposedCurrentTime = 0;
                    tractVideoProgress();
                });

                video.addEventListener('pause', function () {
                    tractVideoProgress(video.currentTime);
                });
            }

        })



    }

    /**
     * Tract user's video progress. Store video pause time to resume from there.
     * If video end then mark lesson as complete.
     *
     * @param currentTime, false means video ended other wise
     * video time position.
     */
    async function tractVideoProgress(currentTime = false) {
        //check if it is lesson
        const lesson = document.querySelector('.tutor-single-lesson-items.active a[data-lesson-id]');
        if (lesson) {
            const lessonId = lesson.getAttribute('data-lesson-id');
            //setup form data
            const formData = new FormData();
            formData.set('action', currentTime ? 'tutor_periscope_store_video_time' : 'tutor_periscope_mark_lesson_complete');
            if (currentTime) {
                //time in sec
                formData.set('time', currentTime);
            }
            formData.set('lesson_id', lessonId);
            formData.set('nonce', tp_data.nonce);

            //make ajax request
            const response = await ajaxRequest(formData);
            //if response false
            if (!response) {
                alert(__('Lesson activity tracking failed', 'tutor-periscope'));
            }
        }
    }

});