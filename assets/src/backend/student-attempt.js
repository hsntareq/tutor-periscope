import ajaxRequest from "../frontend/ajax";

/**
 * Student attempt script
 *
 * Attempt assignment field add dom manipulation will be managed from here.
 *
 * @since v1.0.0
 */
const {__} = wp.i18n;

window.document.addEventListener('DOMContentLoaded', async function() {
    const adminPage = tp_data.admin_page;
    const studentTable = document.querySelector('table');
    if (adminPage == 'tutor-students' && studentTable) {
        const theadTr = studentTable.querySelector('thead tr');
        const tbodyTr = studentTable.querySelectorAll('tbody tr');
    
        const theadMarkup = 
        `<th scope="col" id="tp_student_assigned_attempt" class="manage-column column-display_name column-primary">
            ${__( 'Assigned Attempt', 'tutor-periscope')}
        </th>
        <th scope="col" id="tp_student_available_attempt" class="manage-column column-display_name column-primary">
            ${__( 'Attempt Taken', 'tutor-periscope')}
        </th>
        <th scope="col" id="tp_student_remaining_attempt" class="manage-column column-display_name column-primary">
            ${__( 'Remaining Attempt', 'tutor-periscope')}
        </th>
        `;
        // append th
        theadTr.insertAdjacentHTML(
            'beforeend',
            theadMarkup
        );
        // append td for showing value in table body
        tbodyTr.forEach((eachTr) => {
            // make sure there is tr exists
            const userEmail = eachTr.cells[2].innerText;
            if (!userEmail) {
                return;
            }
            eachTr.insertAdjacentHTML(
                    'beforeend',
                    `
                    <td scope="col" id="" class="manage-column column-display_name column-primary">
                        <input type="number" class="tp_student_assigned_attempt_value" data-email="${userEmail}" value=""/>
                    </td>
                    <td scope="col" id="" class="manage-column column-display_name column-primary">
                        <input type="number" class="tp_student_attempt_taken_value" value="" readonly/>
                    </td>
                    <td scope="col" class="manage-column column-display_name column-primary">
                        <input type="number" class="tp_student_remaining_attempt_value" value="" readonly/>
                    </td>
                    `
            );
        });
    
    }

    //on change attempt value store in DB
    const assignAttempt = document.querySelectorAll('.tp_student_assigned_attempt_value');
    assignAttempt.forEach((attempt) => {
        attempt.onchange = async (e) => {
            const target = e.currentTarget;
            const formData = new FormData();
            formData.set('attempt', target.value);
            formData.set('user_email', target.dataset.email);
            formData.set('nonce', tp_data.nonce);
            formData.set('action', 'tutor_periscope_update_attempt');
            const response = await ajaxRequest(formData);
            if (!response.success) {
                if (response.data) {
                    tutor_toast(
                        __('Failed', 'tutor-periscope'),
                        __(response.data, 'tutor-periscope'),
                        'error',
                    );
                } else {
                    tutor_toast(
                        __('Failed', 'tutor-periscope'),
                        __("Attempt assign failed, please try again!", 'tutor-periscope'),
                        'error',
                    );
                }
            } else {
                tutor_toast(
                    __('Success', 'tutor-periscope'),
                    __("Attempt has been assigned successfully!", 'tutor-periscope'),
                    'success',
                );
            }
        }
    });

    /**
     * get attempt lists
     */
    const url = new URL(window.location.href);
    const params = url.searchParams;
    if (params.has('page') && params.get('page') == 'tutor-students') {
        //if tutor-students page get attempt list
        const formData = new FormData();
        formData.set('action', 'tutor_periscope_all_student_attempts');
        formData.set('nonce', tp_data.nonce);
        const response = await ajaxRequest(formData);
        if (response.success && response.data.length) {
            let i = 0;
            response.data.forEach((item) => {
                const details = item.attempt_details;
                document.querySelectorAll('.tp_student_assigned_attempt_value')[i].value = details.assigned;
                document.querySelectorAll('.tp_student_attempt_taken_value')[i].value = details.taken;
                document.querySelectorAll('.tp_student_remaining_attempt_value')[i].value = details.remaining;
                i++;
            });
        }
    }

});