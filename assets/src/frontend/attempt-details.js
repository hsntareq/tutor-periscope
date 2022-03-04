import ajaxRequest from "./ajax";
const {__} = wp.i18n;
/**
 * get attempt details
 *
 * @since v1.0.0
 */
document.addEventListener('DOMContentLoaded', async function() {
    const attemptDetails = document.querySelectorAll('.tutor-periscope-attempt-details');
    attemptDetails.forEach((attemptDetail) => {
        attemptDetail.onclick = async (e) => {
            const attemptId = e.target.dataset.id;
            const formData = new FormData();
            formData.set('attempt_id', attemptId)
            formData.set("nonce", tp_data.nonce);
            formData.set("action", "tutor_periscope_attempt_details");
           
            try {
              const response = await ajaxRequest(formData, false);
              if (response) {
                    const modalContainer = document.getElementById('tutor-periscope-attempt-details-wrap');
                    if (modalContainer) {
                        modalContainer.innerHTML = response;
                    }
                    const modal = document.querySelector('.tutor-periscope-attempt-modal');
                    if (modal) {
                        modal.classList.add('show');
                    }
              } else {
                alert(__('Something went wrong, please try again.', 'tutor-periscope'));
              }
            } catch (error) {
              alert(error);
            }
        }
    });

    /**
     * Allow to download certificate, save meta data against a student id
     *
     * @since v1.0.0
     */
    const allowToDownload = document.querySelectorAll('.tutor-periscope-allow-download-cert:not(.disabled)');
    if (allowToDownload.length) {
      allowToDownload.forEach((item) => {
        item.onclick = async (e) => {
          if (confirm(__('Are you sure, want to approve? This action can not be revert!'))) {
            const target = e.target;
            const currentTarget = e.currentTarget;
            const studentId = currentTarget.dataset.userId;
            const courseId = currentTarget.dataset.courseId;
            const formData = new FormData();
            formData.set('course_id', courseId)
            formData.set('student_id', studentId)
            formData.set("nonce", tp_data.nonce);
            formData.set("action", "tutor_periscope_allow_to_download_certificate");
    
            const response = await ajaxRequest( formData );
            if (response.success) {
              const tr = target.closest('tr');
              if (tr) {
                tr.querySelector('.tutor-quiz-attempt-review-wrap span').setAttribute('class', 'result-pass');
                currentTarget.classList.add('disabled');
              }
            } else {
              alert(__('Download approval failed, please try again!', 'tutor-periscope'));
            }
          }
        }
      });
    }

});