/**
 * Student course evaluation
 *
 * @since v1.0.0
 */
import ajaxRequest from "./ajax";
const { __ } = wp.i18n;
document.addEventListener("DOMContentLoaded", async function () {
    // show evaluation popup.
    if (tp_data.should_show_evaluation_form) {
        const formData = new FormData();
        formData.set("course_id", tp_data.tutor_course_id);
        formData.set("action", "tp_evaluation_form");
        formData.set('nonce', tp_data.nonce);
        const response = await ajaxRequest(formData);
        if (response.success) {
            const html = `
                <div class="tutor-modal tutor-modal-scrollable tutor-lesson-modal-wrap tutor-is-active">
                <div class='tutor-modal-window'>
                    ${response.data.template}
                </div>
                </div>
            `;
            document.body.insertAdjacentHTML("beforeend", html);
        }
    }

    const reviewForm = document.getElementById("tutor-periscope-evaluation-form");
    const submitButton = document.querySelector(".tutor-periscope-evaluation-submit-button.tutor-button");
console.log(submitButton);
    if (submitButton) {
        submitButton.onclick = async (event) => {
            event.preventDefault();
            const formData = new FormData(reviewForm);
            formData.set("course_id", tp_data.tutor_course_id);
            formData.set("nonce", tp_data.nonce);
            formData.set("action", "tutor_periscope_evaluation");
            submitButton.innerHTML = `${__("Please wait...")}`;
            try {
                const response = await ajaxRequest(formData);
                if (response.success) {
                    submitButton.innerHTML = `${__("Thank you for evaluating")}`;
                    window.location.reload();
                } else {
                    alert(__("Evaluate submission failed", "tutor-periscope"));
                }
            } catch (error) {
                alert(error);
            }
        };
    }
});
