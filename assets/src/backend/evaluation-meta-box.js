import addDynamicField, { removeElement } from "./form-controls";

/**
 * Evaluation form controls management
 *
 * @since v2.0.0
 */
const {__} = wp.i18n;
document.addEventListener('DOMContentLoaded', function() {
    const addField = document.querySelector('.tp-add-field');
    const formData = {
        action: 'test'
    };
    if (addField) {
        addField.onclick = (event) => {
            const html = `
            <div class="tutor-col-12 tutor-mb-24 tp-remove-able-wrapper tutor-d-flex tutor-justify-between">
            <input type="text" name="tp_ef_fields[]" class="tutor-form-control tutor-mr-24" placeholder="${__( 'Add new label', 'tutor-periscope' )}">
            <div class="tp-action-btn-wrapper tutor-d-flex">
                <div class="form-control">
                    <select name="tp_ef_field_type[]" class="tutor-mr-12" title="${__( 'Field type', 'tutor-periscope' )}">
                        <option value="compare">
                            ${__( 'Compare', 'tutor-periscope' )}
                        </option>
                        <option value="vote">
                            ${__( 'Vote', 'tutor-periscope' )}
                        </option>
                    </select>
                </div>
                <button type="button" class="tp-remove-able tutor-btn tutor-btn-outline-primary tutor-btn-sm">
                    ${__( 'Remove', 'tutor-periscope' )}
                </button>
            </div>
        </div>
            `;
            const wrapperSelector = '.tp-form-controls';
            //Add dynamic field.
            addDynamicField(html, wrapperSelector);
        } 
    }

    // remove element.
    const wrapper = document.querySelector('.tp-evaluation-form-wrapper');
    if (wrapper) {
        wrapper.onclick = (event) => {
            event.preventDefault();
            const target = event.target;
            if (event.target.classList.contains('tp-remove-able')) {
                removeElement(target);
            } else {
                return;
            }
        }
    }

    var file_frame;
    const uploadBtn = document.getElementById('tp_upload_button');
    uploadBtn.onclick = () => {
        if ( file_frame ) {
            file_frame.open();
            return;
        }
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: __('Select or Upload Media', 'tutor-periscope'),
            button: {
              text: __('Use this media', 'tutor-periscope')
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            console.log(attachment)
        });
    }
     
});