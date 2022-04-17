import ajaxRequest from "../frontend/ajax";
const {__} = wp.i18n;

document.addEventListener( 'DOMContentLoaded', function () {
    const update_instructor = document.getElementById('tutor_periscope_main_author');
    if (update_instructor) {
        update_instructor.onchange = async (e) => {
            if (confirm(__( 'Do you want to update the Instructor?', 'tutor-periscope'))) {
                const formData = new FormData();
                formData.set('instructor_id', e.currentTarget.value);
                formData.set('course_id', update_instructor.dataset.courseId);
                formData.set('action', 'update_main_instructor');
                formData.set('nonce', tp_data.nonce);
                console.log(update_instructor.dataset.courseId);
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
        }
    }
});