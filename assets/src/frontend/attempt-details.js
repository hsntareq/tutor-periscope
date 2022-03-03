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
});