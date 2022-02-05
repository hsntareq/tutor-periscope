document.addEventListener('DOMContentLoaded', function(){
    const lessonSidebar = document.getElementById('tutor-lesson-sidebar-tab-content');
    const progressClasses = document.getElementsByClassName('plyr__progress__container');
    const progressBar = progressClasses[0];
    if (progressBar) {
        progressBar.remove();
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
                setTimeout(()=> {
                    window.location.reload();
                },2000)
                //manageVideoAction();
                var video = document.getElementById('tutorPlayer');
                console.log(video);
            }
        }
    }
    function manageVideoAction() {
        var video = document.getElementById('tutorPlayer');
        
        if (video) {
            var supposedCurrentTime = 0;
            video.addEventListener('timeupdate', function() {
                if (!video.seeking) {
                    supposedCurrentTime = video.currentTime;
                }
            });
            // prevent user from seeking
            video.addEventListener('seeking', function() {
                // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
                var delta = video.currentTime - supposedCurrentTime;
                // delta = Math.abs(delta); // disable seeking previous content if you want
                if (delta > 0.01) {
                    video.currentTime = supposedCurrentTime;
                }
            });
            video.addEventListener('ended', function() {
            // reset state in order to allow for rewind
            //supposedCurrentTime = 0;
                //console.log(video.currentTime);
                tractVideoProgress();
            });
        
            video.addEventListener('pause', function(){
                tractVideoProgress();
                console.log(video.currentTime);
            });
        }
    }

    function tractVideoProgress() {
        const lesson = document.querySelector('.tutor-single-lesson-items.active a[data-lesson-id]');
        if (lesson) {
            const lessonId = lesson.getAttribute('data-lesson-id');
            console.log(lessonId);
        }
    }

});