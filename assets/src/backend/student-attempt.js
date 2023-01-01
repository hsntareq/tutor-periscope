import ajaxRequest from "../frontend/ajax";

/**
 * Student attempt script
 *
 * Attempt assignment field add dom manipulation will be managed from here.
 *
 * @since v1.0.0
 */
const {__} = wp.i18n;

window.document.addEventListener('DOMContentLoaded', async function() {
    //on change attempt value store in DB
    const assignAttempt = document.querySelectorAll('.tp-assigned-attempt');
    assignAttempt.forEach((attempt) => {
        attempt.onchange = async (e) => {
            const target = e.currentTarget;
            const tds = target.closest('tr').querySelectorAll('td');
            const remainingTd = tds[tds.length-1];

            const formData = new FormData();
            formData.set('attempt', target.value);
            formData.set('user_email', target.dataset.email);
            formData.set('course_id', target.dataset.courseId);
            formData.set('nonce', tp_data.nonce);
            formData.set('action', 'tutor_periscope_update_attempt');
            const response = await ajaxRequest(formData);
            const {data, success} = response;

            if (!success) {
                if (data) {
                    tutor_toast(
                        __('Failed', 'tutor-periscope'),
                        __(data, 'tutor-periscope'),
                        'error',
                    );
                } else {
                    tutor_toast(
                        __('Failed', 'tutor-periscope'),
                        __("Attempt assign failed, please try again!", 'tutor-periscope'),
                        'error',
                    );
                }
            } else {
                remainingTd.innerHTML = data.remaining;
                tutor_toast(
                    __('Success', 'tutor-periscope'),
                    __("Attempt has been assigned successfully!", 'tutor-periscope'),
                    'success',
                );
            }
        }
    });
});