/**
 * Student course evaluation
 *
 * @since v1.0.0
 */
import ajaxRequest from './ajax';
document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.querySelector('.tutor-write-review-form form');
    const submitButton = document.querySelector('.tutor_submit_review_btn.tutor-button')
    if (submitButton) {
        submitButton.onclick = async (event) => {
            event.preventDefault();
            const formData = new FormData(reviewForm);
            formData.set('nonce', tp_data.nonce);
            formData.set('action', 'tutor_periscope_evaluation');
            try {
                const response = await ajaxRequest(formData);
                if (response.success) {
                    console.log(response.data);
                    console.log('course evaluation failed');
                } else {
                    console.log(response);
                }
            } catch (error) {
                alert(error);
            }
        };
    }
});
