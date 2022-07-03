import addDynamicField, { removeElement } from "./form-controls";

/**
 * Evaluation form controls management
 *
 * @since v2.0.0
 */
const { __ } = wp.i18n;
document.addEventListener("DOMContentLoaded", function () {
    const addField = document.querySelector(".tp-add-field");
    const formData = {
        action: "test",
    };
    if (addField) {
        addField.onclick = (event) => {
            const html = `
            <div class="tutor-col-12 tutor-mb-24 tp-remove-able-wrapper tutor-d-flex tutor-justify-between">
            <input type="text" name="tp_ef_fields[]" class="tutor-form-control tutor-mr-24" placeholder="${__(
                "Add new label",
                "tutor-periscope",
            )}">
            <div class="tp-action-btn-wrapper tutor-d-flex">
                <div class="form-control">
                    <select name="tp_ef_field_type[]" class="tutor-mr-12" title="${__(
                        "Field type",
                        "tutor-periscope",
                    )}">
                        <option value="compare">
                            ${__("Compare", "tutor-periscope")}
                        </option>
                        <option value="vote">
                            ${__("Vote", "tutor-periscope")}
                        </option>
                    </select>
                </div>
                <button type="button" class="tp-remove-able tutor-btn tutor-btn-outline-primary tutor-btn-sm">
                    ${__("Remove", "tutor-periscope")}
                </button>
            </div>
        </div>
            `;
            const wrapperSelector = ".tp-form-controls";
            //Add dynamic field.
            addDynamicField(html, wrapperSelector);
        };
    }

    // remove element.
    const wrapper = document.querySelector(".tp-evaluation-form-wrapper");
    if (wrapper) {
        wrapper.onclick = (event) => {
            event.preventDefault();
            const target = event.target;
            if (event.target.classList.contains("tp-remove-able")) {
                removeElement(target);
            } else {
                return;
            }
        };
    }

    const uploadBtn = document.getElementById("tp_upload_button");
    const removeBtn = document.getElementById("tp_media_remove");
    const mediaWrapper = document.getElementById("tp_media_wrapper");
    const mediaImg = document.getElementById("tp_form_media_img");
    const mediaURLField = document.getElementById("tp_form_media_url");
    const mediaNameField = document.getElementById("tp_form_media_name");
    const allowedMimeTypes = ["image/png", "image/jpg", "image/jpeg"];

    if (uploadBtn) {
        uploadBtn.onclick = () => {
            wpMediaManager(
                mediaURLField,
                mediaImg,
                mediaWrapper,
                allowedMimeTypes,
                mediaNameField
            );
        };
    }
    if (removeBtn) {
        removeBtn.onclick = () => {
            removeMedia(mediaURLField, mediaImg, mediaWrapper, mediaNameField);
        };
    }

    /**
     * Open wp media manager & set media as per param
     *
     * @param string urlField  where media url should put, expect el id
     * @param string imgTag    for setting img src value, expect el id
     * @param string wrapper   to set display none or block, expect el id
     *
     * @returns
     */
    // Need to make this var global;
    var file_frame;
    function wpMediaManager(urlField, imgTag, wrapper, mimeTypes = [], nameField = '') {
        if (file_frame) {
            file_frame.open();
            return;
        }
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: __("Select or Upload Media", "tutor-periscope"),
            button: {
                text: __("Use this media", "tutor-periscope"),
            },
            multiple: false, // Set to true to allow multiple files to be selected
        });
        file_frame.on("select", function () {
            const attachment = file_frame.state().get("selection").first().toJSON();
            console.dir(attachment);
            const mime = attachment.mime;
            const name = attachment.name;
            let isAllowed = true;
            if (mimeTypes.length) {
                isAllowed = mimeTypes.includes(mime);
            }
            if (!isAllowed) {
                alert(`${mime} is not allowed to select`);
                file_frame.open();
            } else {
                if (nameField !== '') {
                    nameField.value = name;
                }
                urlField.value = attachment.url;
                imgTag.src = attachment.url;
                wrapper.style = "display: block;";
            }
        });
    }

    /**
     * Remove media
     *
     * @param string urlField  remove field value, expect el id
     * @param string imgTag    remove img src value, expect el id
     * @param string wrapper   set wrapper display none, expect el id
     *
     * @returns void
     */
    function removeMedia(urlField, imgTag, wrapper, nameField = '') {
        urlField.value = "";
        imgTag.src = "";
        wrapper.style = "display:none;";
        if (nameField !== '') {
            nameField.value = '';
        }
    }
});
