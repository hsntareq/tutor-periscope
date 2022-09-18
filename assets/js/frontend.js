/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/frontend/ajax.js":
/*!*************************************!*\
  !*** ./assets/src/frontend/ajax.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
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
document.addEventListener("DOMContentLoaded", async function () {
  // show evaluation popup.
  if (tp_data.should_show_evaluation_form) {
    const formData = new FormData();
    formData.set("course_id", tp_data.tutor_course_id);
    formData.set("action", "tp_evaluation_form");
    formData.set('nonce', tp_data.nonce);
    const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

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

  if (submitButton) {
    submitButton.onclick = async event => {
      event.preventDefault();
      const formData = new FormData(reviewForm);
      formData.set("course_id", tp_data.tutor_course_id);
      formData.set("nonce", tp_data.nonce);
      formData.set("action", "tutor_periscope_evaluation");
      submitButton.innerHTML = `${__("Please wait...")}`;

      try {
        const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

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

/***/ }),

/***/ "./assets/src/frontend/hide-tutor-elements.js":
/*!****************************************************!*\
  !*** ./assets/src/frontend/hide-tutor-elements.js ***!
  \****************************************************/
/***/ (() => {

/**
 * Hide lesson complete button
 *
 * Hide start quiz button
 */
document.addEventListener('DOMContentLoaded', function () {
  //hide lesson complete button
  const tutorLessonCompleteBtn = document.querySelector('.tutor-topbar-complete-btn');

  if (tutorLessonCompleteBtn) {
    tutorLessonCompleteBtn.remove();
  } //hide start quiz button if student out of attempt


  if (!tp_data.has_quiz_attempt) {
    const startQuizButton = document.querySelectorAll('button[name=start_quiz_btn]');
    startQuizButton.forEach(button => {
      button.remove();
    });
  }

  const quizDetails = document.querySelectorAll('td[data-th=Result]');
  quizDetails.forEach(item => {
    if (item.querySelector('.label-danger')) {
      item.nextSibling.nextSibling.innerHTML = '';
    }
  });
});

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*****************************************!*\
  !*** ./assets/src/frontend/frontend.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _course_evaluation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./course-evaluation */ "./assets/src/frontend/course-evaluation.js");
/* harmony import */ var _attempt_details__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./attempt-details */ "./assets/src/frontend/attempt-details.js");
/* harmony import */ var _hide_tutor_elements__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./hide-tutor-elements */ "./assets/src/frontend/hide-tutor-elements.js");
/* harmony import */ var _hide_tutor_elements__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_hide_tutor_elements__WEBPACK_IMPORTED_MODULE_2__);
 //import "./linear";

 //import "./video-management";


})();

/******/ })()
;
//# sourceMappingURL=frontend.js.map