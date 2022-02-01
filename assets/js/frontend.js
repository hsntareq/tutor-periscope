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

document.addEventListener('DOMContentLoaded', function () {
  const reviewForm = document.querySelector('.tutor-write-review-form form');
  const submitButton = document.querySelector('.tutor_submit_review_btn.tutor-button');

  if (submitButton) {
    submitButton.onclick = async event => {
      event.preventDefault();
      const formData = new FormData(reviewForm);
      formData.set('nonce', tp_data.nonce);
      formData.set('action', 'tutor_periscope_evaluation');

      try {
        const response = await (0,_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])(formData);

        if (response.success) {} else {
          console.log(response);
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

      if (clickedTag.hasAttribute('data-lesson-id')) {
        checkPreviousContentStatus(Number(clickedTag.getAttribute('data-lesson-id')));
      }

      if (clickedTag.hasAttribute('data-quiz-id')) {
        checkPreviousContentStatus(Number(clickedTag.getAttribute('data-quiz-id')));
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


})();

/******/ })()
;
//# sourceMappingURL=frontend.js.map