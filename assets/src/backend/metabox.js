/**
 * Meta box scripts
 *
 * Add remove instructor info meta boxes
 *
 * @since v1.0.0
 */
const {__} = wp.i18n;
document.addEventListener('DOMContentLoaded', function() {
    const addMore = document.getElementById('tutor-periscope-add-more-instructor');
    const metaBox = document.getElementById('tutor-periscope-instructors-metabox');
   
    if (addMore) {
        addMore.onclick = (e) => {
            if (metaBox) {
                metaBox.insertAdjacentHTML(
                    'beforeend',
                    `<div class="tutor-periscope-each-instructor-box" style="display: flex; flex-direction: column; row-gap: 15px; margin-top: 15px">
    
                    <div style="display: flex; column-gap: 10px;">
                        <input type="text" name="_tp_instructor_name[]" class="tutor-form-control" placeholder="${__( 'Instructor name', 'tutor-periscope' )}" value="" />
                        <span class="tutor-periscope-remove-instructor" style="color:tomato; cursor: pointer;">Remove</span>
                    </div>
                    
                    <input type="text" name="_tp_instructor_title[]" placeholder="${__( 'Instructor title', 'tutor-periscope' )}"/>
               
                    <textarea name="_tp_instructor_bio[]" rows="2" placeholder="${__( 'Instructor bio', 'tutor-periscope' )}"></textarea>
                </div>`
                );
            }
        }
    }

    // remove boxes
    const periscopeMetaBox = document.getElementById('tutor-periscope-additional-data');
    if (periscopeMetaBox) {
        periscopeMetaBox.onclick = (e) => {
            if (e.target.classList.contains('tutor-periscope-remove-instructor')) {
                e.target.closest('.tutor-periscope-each-instructor-box').remove();
            }
        }
    }
});