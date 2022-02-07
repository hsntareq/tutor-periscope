/**
 * Student course evaluation
 *
 * @since v1.0.0
 */
import ajaxRequest from "./ajax";
const {__} = wp.i18n;
document.addEventListener("DOMContentLoaded", function () {
  // show evaluation popup
  if (tp_data.should_show_evaluation_form) {
    const modal = `
        <div class="tutor-modal-wrap tutor-quiz-builder-modal-wrap show">
        <div class="tutor-modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h1>${__( 'Please evaluate the course', 'tutor-periscope' )}</h1>
                </div>
                <div class="modal-close-wrap">
                    <a href="javascript:;" class="modal-close-btn"><i class="tutor-icon-line-cross"></i> </a>
                </div>
            </div>
            <div class="modal-container" style="padding:20px;">
                <div class="tutor-periscope-student-course-evaluation-wrapper">
                    <form id="tutor-periscope-evaluation-form">
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Course content matched the session description', 'tutor-periscope')}
                            </label>
                            <select name="content_matched" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('The learning outcome were met', 'tutor-periscope')}
                            </label>
                            <select name="outcome_met" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Current evidence was cited for specific content', 'tutor-periscope')}
                            </label>
                            <select name="specific_content" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Instructional activities added value to my learning experience', 'tutor-periscope')}
                            </label>
                            <select name="added_value" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Course content was effectively delivered', 'tutor-periscope')}
                            </label>
                            <select name="effectively_delivered" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Overall course was valuable', 'tutor-periscope')}
                            </label>
                            <select name="was_valuable" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Promotion of a product or service was not present', 'tutor-periscope')}
                            </label>
                            <select name="promotion_present" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('The environment was supportive of my learning experience', 'tutor-periscope')}
                            </label>
                            <select name="supportive_environment" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('Numbers of hours it took to complete- ONLY online for online courses', 'tutor-periscope')}
                            </label>
                            <select name="number_of_hours" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <label class="d-inline-block">
                                ${__('How will you apply this in your practice', 'tutor-periscope')}
                            </label>
                            <select name="apply_in_practice" id="" class="tutor-form-control">
                                <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                            </select>
                        </div>
                        <div class="tutor-form-group mb-3 clearfix">
                            <button class="tutor-periscope-evaluation-submit-button tutor-button">
                                ${__('Submit', 'tutor-periscope')}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
        <style>.nice-select{float:right;}</style>
      `;
    document.body.insertAdjacentHTML("beforeend", modal);
  }

  const reviewForm = document.getElementById("tutor-periscope-evaluation-form");
  const submitButton = document.querySelector(".tutor-periscope-evaluation-submit-button.tutor-button");
  if (submitButton) {
    submitButton.onclick = async (event) => {
      event.preventDefault();
      const formData = new FormData(reviewForm);
      formData.set('tutor_course_id', tp_data.tutor_course_id)
      formData.set("nonce", tp_data.nonce);
      formData.set("action", "tutor_periscope_evaluation");
      submitButton.innerHTML = `${__('Please wait...')}`;
      try {
        const response = await ajaxRequest(formData);
        if (response.success) {
            submitButton.innerHTML = `${__('Thank for evaluating')}`;
            window.location.reload();
        } else {
          console.log(response);
        }
      } catch (error) {
        alert(error);
      }
    };
  }
});
