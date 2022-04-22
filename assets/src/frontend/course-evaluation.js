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
        <div id="fuck-u" class="tutor-modal tutor-modal-scrollable tutor-lesson-modal-wrap tutor-is-active">
            <div class='tutor-modal-window'>
                <div class="tutor-modal-content">
                    <div class="tutor-modal-header">
                        <div class="tutor-modal-title">
                            <h3>${__( 'Please evaluate the course', 'tutor-periscope' )}</h3>
                        </div>
                        <button data-tutor-modal-close="" class="tutor-iconic-btn tutor-modal-close">
                            <span class="tutor-icon-times" area-hidden="true"></span>
                        </button>
                    </div>
                    <div class="tutor-modal-body modal-container" style="padding:20px;">
                        <div class="tutor-periscope-student-course-evaluation-wrapper">
                            <form id="tutor-periscope-evaluation-form">
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('1. Were the course learning objectives met?', 'tutor-periscope')}
                                    </label>
                                    <select name="objectives_met" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('2. Did course content match course description?', 'tutor-periscope')}
                                    </label>
                                    <select name="content_matched" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('3. Was current evidence provided to substantiate material presented? ', 'tutor-periscope')}
                                    </label>
                                    <select name="material_presented" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('4. Were the instructors effective and knowledgeable?', 'tutor-periscope')}
                                    </label>
                                    <select name="instructors_effective" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('5. Was the virtual learning platform supportive to learning? ', 'tutor-periscope')}
                                    </label>
                                    <select name="supportive_learning" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('6. Overall, the course was valuable.', 'tutor-periscope')}
                                    </label>
                                    <select name="was_valuable" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>

                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('7. Would you recommend this course to a colleague?', 'tutor-periscope')}
                                    </label>
                                    <select name="recommend" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('8. Were personal experience and observation the primary source of information? ', 'tutor-periscope')}
                                    </label>
                                    <select name="information" id="" class="tutor-form-control">
                                        <option value="agree">${__('Strongly Agree', 'tutor-periscope')}</option>
                                        <option value="agree">${__('Agree', 'tutor-periscope')}</option>
                                        <option value="disagree">${__('Disagree', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Neutral', 'tutor-periscope')}</option>
                                        <option value="neutral">${__('Strongly Disagree', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('9. Was a commercial product promoted? If yes, did you feel that the product promotion was the sole purpose of the course? ', 'tutor-periscope')}
                                    </label>
                                    <select name="product_promoted" id="" class="tutor-form-control">
                                        <option value="No">${__('No', 'tutor-periscope')}</option>
                                        <option value="Yes">${__('Yes', 'tutor-periscope')}</option>
                                        <option value="">${__('', 'tutor-periscope')}</option>
                                    </select>
                                </div>
                                <div class="tutor-form-group mb-3 clearfix">
                                    <label class="d-inline-block">
                                        ${__('10. What topic(s) would you like more training in? Share any additional comments or questions.', 'tutor-periscope')}
                                    </label>
                                    <textarea name="comments"></textarea>
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
        </div>
        <style>.nice-select{float:right;}</style>
      `;
    console.log(modal)
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
            submitButton.innerHTML = `${__('Thank you for evaluating')}`;
            window.location.reload();
        } else {
          alert(__('Evaluate submission failed', 'tutor-periscope'));
        }
      } catch (error) {
        alert(error);
      }
    };
  }
});
