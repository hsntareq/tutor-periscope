(()=>{var o={6100:()=>{document.addEventListener("DOMContentLoaded",function(){const t=document.querySelector(".tutor-topbar-complete-btn");if(t&&t.remove(),!tp_data.has_quiz_attempt){const o=document.querySelectorAll("button[name=start_quiz_btn]");o.forEach(t=>{t.remove()})}const e=document.querySelectorAll("td[data-th=Result]");e.forEach(t=>{t.querySelector(".label-danger")&&(t.nextSibling.nextSibling.innerHTML="")})})}},a={};function c(t){var e=a[t];if(void 0!==e)return e.exports;e=a[t]={exports:{}};return o[t](e,e.exports,c),e.exports}(()=>{"use strict";async function n(t,e=!0){document.body.insertAdjacentHTML("beforeend",`<div id="tutor-periscope-loader-wrapper">
        <div class="tutor-periscope-loading">
        </div>
    </div>`);const o=await fetch(tp_data.url,{method:"POST",body:t});return document.getElementById("tutor-periscope-loader-wrapper").remove(),!!o.ok&&(e?o.json():o.text())}const r=wp.i18n["__"],s=(document.addEventListener("DOMContentLoaded",async function(){if(tp_data.should_show_evaluation_form){const e=new FormData;e.set("course_id",tp_data.tutor_course_id),e.set("action","tp_evaluation_form"),e.set("nonce",tp_data.nonce);var t=await n(e);t.success&&(t=`
                <div class="tutor-modal tutor-modal-scrollable tutor-lesson-modal-wrap tutor-is-active">
                <div class='tutor-modal-window'>
                    ${t.data.template}
                </div>
                </div>
            `,document.body.insertAdjacentHTML("beforeend",t))}const o=document.getElementById("tutor-periscope-evaluation-form"),a=document.querySelector(".tutor-periscope-evaluation-submit-button.tutor-btn");a&&(a.onclick=async t=>{t.preventDefault();const e=new FormData(o);e.set("course_id",tp_data.tutor_course_id),e.set("nonce",tp_data.nonce),e.set("action","tutor_periscope_evaluation"),a.innerHTML=""+r("Please wait...");try{(await n(e)).success?(a.innerHTML=""+r("Thank you for evaluating"),window.location.reload()):alert(r("Evaluate submission failed","tutor-periscope"))}catch(t){alert(t)}})}),wp.i18n)["__"];document.addEventListener("DOMContentLoaded",async function(){const t=document.querySelectorAll(".tutor-periscope-attempt-details"),e=(t.forEach(t=>{t.onclick=async t=>{t=t.target.dataset.id;const e=new FormData;e.set("attempt_id",t),e.set("nonce",tp_data.nonce),e.set("action","tutor_periscope_attempt_details");try{var o=await n(e,!1);if(o){const a=document.getElementById("tutor-periscope-attempt-details-wrap"),r=(a&&(a.innerHTML=o),document.querySelector(".tutor-periscope-attempt-modal"));r&&r.classList.add("show")}else alert(s("Something went wrong, please try again.","tutor-periscope"))}catch(t){alert(t)}}}),document.querySelector(".tutor-periscope-pending-approval-list"));e&&(e.onclick=async t=>{const e=t.target;t.currentTarget;if("I"===e.tagName&&e.closest("a").click(),"A"===e.tagName&&e.classList.contains("tutor-status-pending-approval")){t=prompt("Certificate Number (unique & >= 5 Character)");if(5<=t.length){var o=e.dataset.userId,a=e.dataset.courseId;const r=new FormData;r.set("certificate_no",t),r.set("course_id",a),r.set("student_id",o),r.set("nonce",tp_data.nonce),r.set("action","tutor_periscope_allow_to_download_certificate"),(await n(r)).success?(e.classList.contains("tutor-status-pending-approval")&&(e.classList.remove("tutor-status-pending-approval"),e.classList.add("tutor-status-approved-context")),tutor_toast("Success",s("Certificate Download Approval Success!","tutor-periscope"),"success")):tutor_toast("Failed",s("Certificate Download Approval Failed!","tutor-periscope"),"error")}else alert(s("Invalid certificate no","tutor-periscope"))}})});c(6100)})()})();