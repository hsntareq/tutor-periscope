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
    const pendingTable = document.querySelector('.tutor-periscope-pending-approval-list');
    if (pendingTable) {
      pendingTable.onclick = async (e) => {
        const target = e.target;
        const currentTarget = e.currentTarget;
        console.log(target.tagName)
        if (target.tagName === 'I') {
          target.closest('a').click();
        }
        if (target.tagName === 'A' && target.classList.contains('tutor-status-pending-approval')) {
          const studentId = target.dataset.userId;
          const courseId = target.dataset.courseId;
          const formData = new FormData();
          formData.set('course_id', courseId)
          formData.set('user_id', studentId)
          formData.set("nonce", tp_data.nonce);
          formData.set("action", "tutor_periscope_allow_to_download_certificate");
  
          const response = await ajaxRequest( formData );
          if (response.success) {
            if (target.classList.contains('tutor-status-pending-approval')) {
              target.classList.remove('tutor-status-pending-approval');
              target.classList.add('tutor-status-approved-context');
            }
            tutor_toast('Success', __('Certificate Download Approval Success!', 'tutor-periscope'), 'success');
          } else {
            tutor_toast('Failed', __('Certificate Download Approval Failed!', 'tutor-periscope'), 'error');
          }
        }
      }
    }

});