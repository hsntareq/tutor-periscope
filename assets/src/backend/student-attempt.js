/**
 * Student attempt script
 *
 * Attempt assignment field add dom manipulation will be managed from here.
 *
 * @since v1.0.0
 */
const {__} = wp.i18n;

window.document.addEventListener('DOMContentLoaded', function() {
    const studentTable = document.querySelector('.wp-list-table.students');
    const theadTr = studentTable.querySelector('thead tr');
    const tbodyTr = studentTable.querySelector('tbody tr');
    const tfootTr = studentTable.querySelector('tfoot tr');

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
    tbodyTr.insertAdjacentHTML(
        'beforeend',
        `
        <td scope="col" id="" class="manage-column column-display_name column-primary">
            <input type="number" id="tp_student_assigned_attempt_value" value="12"/>
        </td>
        <td scope="col" id="" class="manage-column column-display_name column-primary">
            <input type="number" id="tp_student_available_attempt_value" value="12" readonly/>
        </td>
        <td scope="col" id="tp_student_remaining_attempt_value" class="manage-column column-display_name column-primary">
            <input type="number" id="tp_student_remaining_attempt_value" value="4" readonly/>
        </td>
        `
    );

    // append thead on table footer
    tfootTr.insertAdjacentHTML(
        'beforeend',
        theadMarkup
    );
});