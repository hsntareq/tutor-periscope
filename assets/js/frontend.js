/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/frontend/ajax.js":
/*!*************************************!*\
  !*** ./assets/src/frontend/ajax.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ajaxRequest)
/* harmony export */ });
/**
 * Ajax request for global use
 *
 * @param {*} formData | form data for post request
 * @returns json response on success or false
 */
async function ajaxRequest(formData, jsonResponse = true) {
  const loader = `<div id="tutor-periscope-loader-wrapper">
        <div class="tutor-periscope-loading">
        </div>
    </div>`;
  document.body.insertAdjacentHTML('beforeend', loader);
  const post = await fetch(tp_data.url, {
    method: 'POST',
    body: formData
  });
  document.getElementById('tutor-periscope-loader-wrapper').remove();

  if (post.ok) {
    if (jsonResponse) {
      return await post.json();
    } else {
      return await post.text();
    }
  } else {
    return false;
  }
}

/***/ }),

/***/ "./assets/src/frontend/attempt-details.js":
/*!************************************************!*\
  !*** ./assets/src/frontend/attempt-details.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ajax */ "./assets/src/frontend/ajax.js");

const {
  __
} = wp.i18n;
/**
 * get attempt details
 *
 * @since v1.0.0
 */

document.addEventListener('DOMContentLoaded', async function () {
  const attemptDetails = document.querySelectorAll('.tutor-periscope-attempt-details');
  attemptDetails.forEach(attemptDetail => {
    attemptDetail.onclick = async e => {
      const attemptId = e.target.dataset.id;
      const formData = new FormData();
      formData.set('attempt_id', attemptId);
      formData.set("nonce", tp_data.nonce);
      formData.set("action", "tutor_periscope_attempt_details");

      try {
        const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData, false);

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
    };
  });
  /**
   * Allow to download certificate, save meta data against a student id
   *
   * @since v1.0.0
   */

  const pendingTable = document.querySelector('.tutor-periscope-pending-approval-list');

  if (pendingTable) {
    pendingTable.onclick = async e => {
      const target = e.target;
      const currentTarget = e.currentTarget;

      if (target.tagName === 'I') {
        target.closest('a').click();
      }

      if (target.tagName === 'A' && target.classList.contains('tutor-status-pending-approval')) {
        let certificate_no = prompt("Certificate Number (unique & >= 5 Character)");

        if (certificate_no.length >= 5) {
          const studentId = target.dataset.userId;
          const courseId = target.dataset.courseId;
          const formData = new FormData();
          formData.set('certificate_no', certificate_no);
          formData.set('course_id', courseId);
          formData.set('student_id', studentId);
          formData.set("nonce", tp_data.nonce);
          formData.set("action", "tutor_periscope_allow_to_download_certificate");
          const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

          if (response.success) {
            if (target.classList.contains('tutor-status-pending-approval')) {
              target.classList.remove('tutor-status-pending-approval');
              target.classList.add('tutor-status-approved-context');
            }

            tutor_toast('Success', __('Certificate Download Approval Success!', 'tutor-periscope'), 'success');
          } else {
            tutor_toast('Failed', __('Certificate Download Approval Failed!', 'tutor-periscope'), 'error');
          }
        } else {
          alert(__('Invalid certificate no', 'tutor-periscope'));
        }
      }
    };
  }
});

/***/ }),

/***/ "./assets/src/frontend/course-evaluation.js":
/*!**************************************************!*\
  !*** ./assets/src/frontend/course-evaluation.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ajax */ "./assets/src/frontend/ajax.js");
/**
 * Student course evaluation
 *
 * @since v1.0.0
 */

const {
  __
} = wp.i18n;
document.addEventListener("DOMContentLoaded", function () {
  // show evaluation popup
  if (tp_data.should_show_evaluation_form) {
    const modal = `
        <div id="fuck-u" class="tutor-modal tutor-modal-scrollable tutor-lesson-modal-wrap tutor-is-active">
            <div class='tutor-modal-window'>
                <div class="tutor-modal-content">
                    <div class="tutor-modal-header">
                        <div class="tutor-modal-title">
                            <h3>${__('Please evaluate the course', 'tutor-periscope')}</h3>
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
    console.log(modal);
    document.body.insertAdjacentHTML("beforeend", modal);
  }

  const reviewForm = document.getElementById("tutor-periscope-evaluation-form");
  const submitButton = document.querySelector(".tutor-periscope-evaluation-submit-button.tutor-button");

  if (submitButton) {
    submitButton.onclick = async event => {
      event.preventDefault();
      const formData = new FormData(reviewForm);
      formData.set('tutor_course_id', tp_data.tutor_course_id);
      formData.set("nonce", tp_data.nonce);
      formData.set("action", "tutor_periscope_evaluation");
      submitButton.innerHTML = `${__('Please wait...')}`;

      try {
        const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

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

/***/ }),

/***/ "./assets/src/frontend/linear.js":
/*!***************************************!*\
  !*** ./assets/src/frontend/linear.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ajax */ "./assets/src/frontend/ajax.js");

const {
  __
} = wp.i18n;
/**
 * Check previous lesson complete status and if not completed previous lesson
 * then restrict user to start next lesson or quiz
 *
 * @since v1.0.0
 */

document.addEventListener('DOMContentLoaded', async function () {
  //disable sidebar lesson link
  const linearPath = tp_data.linear_path; // linear path active.

  if (linearPath) {
    const lessonList = document.querySelectorAll('.tutor-single-lesson-items:not(.active)');
    lessonList.forEach(lesson => {
      if (lesson.querySelector('.tutor-done')) {} else {
        lesson.style.background = '#dddddd';
        const a = lesson.querySelector('a');

        if (a != null || a != undefined) {
          a.setAttribute('class', '');
          a.style.cursor = 'not-allowed';
          const lessonTitle = a.querySelector('.lesson_title');
          const playTime = a.querySelector('.tutor-play-duration');
          const quizTime = a.querySelector('.quiz-time-limit');

          if (lessonTitle) {
            lessonTitle.style.color = '#a4a9b9';
          }

          if (playTime) {
            playTime.style.color = '#a4a9b9';
          }

          if (quizTime) {
            quizTime.style.color = '#a4a9b9';
          }

          a.onclick = e => {
            e.preventDefault();
          };
        }
      }
    });
  }
  /**
   * Disable next lesson navigation link if current lesson not completed
   * show alert message to complete current lesson.
   */


  let dynamicDocument = document.getElementById('tutor-single-entry-content');

  if (dynamicDocument) {
    dynamicDocument.onclick = async e => {
      if (e.target.classList.contains('tutor-next-link')) {
        e.preventDefault(); //class name with next lesson id: tutor-next-link-4507

        const linkWithId = e.target.classList[1]; //extract id

        const nextLessonId = linkWithId.split('-')[3]; //make ajax request to check if current lesson or quiz is completed

        const formData = new FormData();
        formData.set('next_lesson_id', nextLessonId);
        formData.set('nonce', tp_data.nonce);
        formData.set('action', 'tutor_periscope_is_done_current_lesson');
        const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

        if (response.success && response.data.done) {
          window.location.href = e.target.href;
        }

        if (response.success && !response.data.done) {
          alert(__('Please complete current lesson/quiz first to go the next content.', 'tutor-periscope'));
        }
      }
    };
  }

  const lessonSidebar = document.getElementById('tutor-lesson-sidebar-tab-content');

  if (lessonSidebar && linearPath) {
    const hasActiveContent = document.querySelector('.tutor-single-lesson-items.active'); //check if user in on any course material like lesson, quiz etc

    if (hasActiveContent) {
      const currentContent = hasActiveContent.querySelector('a');
      let contentId = 0;

      if (currentContent.hasAttribute('data-lesson-id')) {
        contentId = Number(currentContent.getAttribute('data-lesson-id'));
      }

      if (currentContent.hasAttribute('data-quiz-id')) {
        contentId = Number(currentContent.getAttribute('data-quiz-id'));
      }

      checkPreviousContentStatus(contentId);
    }
  }
  /**
   * On click course content check if user completed previous content
   */


  if (lessonSidebar && linearPath) {
    lessonSidebar.onclick = e => {
      const target = e.target;
      let clickedTag = target;

      if (clickedTag.tagName !== 'A') {
        clickedTag = target.closest('a');
      }

      if (clickedTag) {
        if (clickedTag.hasAttribute('data-lesson-id')) {
          checkPreviousContentStatus(Number(clickedTag.getAttribute('data-lesson-id')));
        }

        if (clickedTag.hasAttribute('data-quiz-id')) {
          checkPreviousContentStatus(Number(clickedTag.getAttribute('data-quiz-id')));
        }
      }
    };
  } //disable view attempt if fail


  const fails = document.querySelectorAll('.result-fail');

  if (fails.length) {
    fails.forEach(item => {
      if (item) {
        const tr = item.closest('tr');

        if (tr) {
          const viewAttempt = tr.querySelector('td:last-child a');

          if (viewAttempt) {
            viewAttempt.removeAttribute('href');
            viewAttempt.style.color = '#bdbfc7';
          }
        }
      }
    });
  }
});

async function checkPreviousContentStatus(contentId) {
  if (contentId > 0) {
    //check if user complete previous course content
    const formData = new FormData();
    formData.set('content-id', contentId);
    formData.set('action', 'tutor_periscope_previous_content_status');
    formData.set('nonce', tp_data.nonce);
    const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

    if (response.success) {} else {
      if (response.data.url) {
        tutor_toast(__('Fail', 'tutor-periscope'), __('Please complete previous lesson first!', 'tutor-periscope'), 'error');
        window.location.href = response.data.url;
      } else {
        tutor_toast(__('Fail', 'tutor-periscope'), __('Previous content status check failed!', 'tutor-periscope'), 'error');
      }
    }
  }
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************************!*\
  !*** ./assets/src/frontend/frontend.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _course_evaluation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./course-evaluation */ "./assets/src/frontend/course-evaluation.js");
/* harmony import */ var _linear__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./linear */ "./assets/src/frontend/linear.js");
/* harmony import */ var _attempt_details__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./attempt-details */ "./assets/src/frontend/attempt-details.js");


 //import "./video-management";
})();

/******/ })()
;
//# sourceMappingURL=frontend.js.map