/**
 * Append/remove form fields
 *
 * @since v2.0.0
 */
import ajaxRequest from "../frontend/ajax";

const {__} = wp.i18n;

/**
 * Add field anywhere needed
 *
 * @since v2.0.0
 *
 * @param field   html field to add
 * @param appendAbleElement  selector where it should append.
 * CSS Selector like: '.class #id' or html tag that is valid.
 *
 * @return void
 */
export default function addDynamicField(field, appendAbleElement) {
    document.querySelector(appendAbleElement)
    .insertAdjacentHTML('beforeend', field);
}

/**
 * A global remove-able function to remove field from
 * anywhere. Just use class tp-remove-able, it will remove the closest div
 * of having class tp-remove-able-wrapper
 *
 * If field should make ajax request before removing element then add
 * attr like: data-tp-ajax={action: 'abc'}
 *
 * So data-tp-ajax should contain valid object as value.
 *
 * Note: for dynamically added element it will not work.
 * In that we can just removeElement function and pass
 * HTML element like below:
 *
 * const a = document.querySelector('.b);
 * removeElement(a);
 *
 * @return void
 */
const removeAbles = document.querySelectorAll('.tp-remove-able');
removeAbles.forEach((elem) => {
    elem.onclick = async (event) => {
        event.preventDefault();
        // if has data attr make ajax request
        removeElement();
    }
});

export async function removeElement(elem) {
    if ('undefined' !== elem && elem.hasAttribute('data-tp-ajax')) {
console.log(typeof elem);
        const formData = elem.dataset.tpAjax;
        const response = await ajaxRequest(formData);
        if (response.success) {
            tutor_toast(
                __('Success', 'tutor-periscope'),
                __(response.data, 'tutor-periscope'),
                'success',
            );
        } else {
            tutor_toast(
                __('Failed', 'tutor-periscope'),
                __(response.data, 'tutor-periscope'),
                'error',
            );
        }
    }
    elem.closest('.tp-remove-able-wrapper').remove();
}

const addDeleteButtonToMainAuthor = () => {
    // Make instructor removable
    const instructorList = document.querySelectorAll('.added-instructor-item:not(:first-child)');
    let btnHtml = '<span class="instructor-control"><a href="javascript:void(0)" class="tutor-instructor-delete-btn tutor-action-icon tutor-iconic-btn"><i class="tutor-icon-times"></i></a></span>';
    instructorList.forEach(item => {
        let btnDelete = item.querySelector('.instructor-control');
        if (null === btnDelete) {
            item.insertAdjacentHTML('beforeend', btnHtml);
        }
    })
}
addDeleteButtonToMainAuthor();


const availableInstructors = document.querySelector('.add_instructor_to_course_btn');
if(null !== availableInstructors && typeof availableInstructors != 'undefined'){
availableInstructors.onclick = (e) => {
    setTimeout(() => {
        addDeleteButtonToMainAuthor();
    }, 1000);
}}