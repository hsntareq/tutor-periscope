<?php
/**
 * New evaluation form
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="wrap">
    <h1><?php esc_html_e( 'Course Evaluations', 'tutor-periscope' ); ?></h1>

    <form action="" method="post">

        <table class="form-table periscope-evaluation-form">
            <tbody>
                <tr class="row-periscope-course-name">
                    <th scope="row">
                        <label for="periscope_course_name"><?php esc_html_e( 'Course Name', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_course_name" id="periscope_course_name" required="required">
                            <?php tutor_periscope_course_select_dropdown(); ?>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-course-code">
                    <th scope="row">
                        <label for="periscope_course_code"><?php esc_html_e( 'Course Code', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="periscope_course_code" id="periscope_course_code" class="regular-text" placeholder="<?php echo esc_attr( 'LMS-916', 'tutor-periscope' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-periscope-content-matched">
                    <th scope="row">
                        <label for="periscope_content_matched"><?php esc_html_e( 'Course content matched the session description:', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_content_matched" id="periscope_content_matched" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-learning-outcome">
                    <th scope="row">
                        <label for="periscope_learning_outcome"><?php esc_html_e( 'The learning outcomes were met:', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_learning_outcome" id="periscope_learning_outcome" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-current-evidence">
                    <th scope="row">
                        <label for="periscope_current_evidence"><?php esc_html_e( 'Current evidence was cited for specific content:', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_current_evidence" id="periscope_current_evidence" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-instructional-activities">
                    <th scope="row">
                        <label for="periscope_instructional_activities"><?php esc_html_e( 'Instructional activities added value to my learning experience', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_instructional_activities" id="periscope_instructional_activities" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-content-delivered">
                    <th scope="row">
                        <label for="periscope_content_delivered"><?php esc_html_e( 'Course content was effectively delivered', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_content_delivered" id="periscope_content_delivered" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-course-valuable">
                    <th scope="row">
                        <label for="periscope_course_valuable"><?php esc_html_e( 'Overall, the course was valuable:', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_course_valuable" id="periscope_course_valuable" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-promotion-product">
                    <th scope="row">
                        <label for="periscope_promotion_product"><?php esc_html_e( 'Promotion of a product or service was NOT presented', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_promotion_product" id="periscope_promotion_product" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-environment">
                    <th scope="row">
                        <label for="periscope_environment"><?php esc_html_e( 'The environment was supportive of my learning experience', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <select name="periscope_environment" id="periscope_environment" required="required">
                            <option value="agree"><?php esc_html_e( 'Agree', 'tutor-periscope' ); ?></option>
                            <option value="neutral"><?php esc_html_e( 'Neutral', 'tutor-periscope' ); ?></option>
                            <option value="disagree"><?php esc_html_e( 'Disagree', 'tutor-periscope' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-periscope-no-hours">
                    <th scope="row">
                        <label for="periscope_no_hours"><?php esc_html_e( 'Number of hours it took to complete - ONLY for Online Courses', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="periscope_no_hours" id="periscope_no_hours" class="regular-text" placeholder="<?php echo esc_attr( '1.5-2 hrs', 'tutor-periscope' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-periscope-apply-practice">
                    <th scope="row">
                        <label for="periscope_apply_practice"><?php esc_html_e( 'Agree - How will you apply this in your practice', 'tutor-periscope' ); ?></label>
                    </th>
                    <td>
                        <textarea name="periscope_apply_practice" id="periscope_apply_practice" placeholder="<?php echo esc_attr( 'Descriptions', 'tutor-periscope' ); ?>" rows="5" cols="30" required="required"></textarea>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'tutor_periscope_nonce' ); ?>
        <?php submit_button( __( 'Add New Evaluation', 'tutor-periscope' ), 'primary', 'submit_evaluation' ); ?>

    </form>
</div>