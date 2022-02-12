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
async function ajaxRequest(formData) {
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
    return await post.json();
  } else {
    return false;
  }
}

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
        <div class="tutor-modal-wrap tutor-quiz-builder-modal-wrap show">
        <div class="tutor-modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h1>${__('Please evaluate the course', 'tutor-periscope')}</h1>
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
 * Check previous lesson complete status and not completed previous lesson
 * then restrict user to start next lesson or quiz
 *
 * @since v1.0.0
 */

document.addEventListener('DOMContentLoaded', async function () {
  //disable sidebar lesson link
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
  /**
   * Disable next lesson navigation link is current lesson not completed
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

  if (lessonSidebar) {
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


  if (lessonSidebar) {
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

 //import "./video-management";
})();

/******/ })()
;
//# sourceMappingURL=frontend.js.map