<?php
/**
 * Single course evaluation template
 */

defined( 'ABSPATH' ) || exit;

$evaluation_id   = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
$evaluation_data = periscope_get_course_evaluation( $evaluation_id );
?>

<a href="<?php echo esc_url( admin_url( 'admin.php?page=course-evaluation' ) ); ?>" style="text-decoration:none; margin-top:40px;">&larr; Back</a>

<div class="single-evaluation-wrapper">
    <p><?php esc_html_e( 'Course Title: ', 'tutor-periscope' ); ?><?php echo esc_html( $evaluation_data->periscope_course_name ); ?></p>
    <p><?php esc_html_e( 'Course Code: ', 'tutor-periscope' ); ?><?php echo esc_html( $evaluation_data->periscope_course_code ); ?></p>
    <h2><?php esc_html_e( 'APTA Evaluation', 'tutor-periscope' ); ?></h2>
    <p><?php esc_html_e( '1. Course content matched the session description: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_content_matched ) ); ?></p>
    <p><?php esc_html_e( '2. The learning outcomes were met: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_learning_outcome ) ); ?></p>
    <p><?php esc_html_e( '3. Current evidence was cited for specific content: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_current_evidence ) ); ?></p>
    <p><?php esc_html_e( '4. Instructional activities added value to my learning experience: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_instructional_activities ) ); ?></p>
    <p><?php esc_html_e( '5. Course content was effectively delivered: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_content_delivered ) ); ?></p>
    <p><?php esc_html_e( '6. Overall, the course was valuable: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_course_valuable ) ); ?></p>
    <p><?php esc_html_e( '7. Promotion of a product or service was NOT presented: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_promotion_product ) ); ?></p>
    <p><?php esc_html_e( '8. The environment was supportive of my learning experience: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_environment ) ); ?></p>
    <p><?php esc_html_e( '9. Number of hours it took to complete - ONLY for Online Courses: ', 'tutor-periscope' ); ?><?php echo esc_html( $evaluation_data->periscope_no_hours ); ?></p>
    <p><?php esc_html_e( '10. Agree - How will you apply this in your practice? ', 'tutor-periscope' ); ?></p>
    <p><?php echo esc_html( $evaluation_data->periscope_apply_practice ); ?></p>
</div>
<!--Printable Area-->
<div id="div-to-print" class="single-evaluation-wrapper" style="display:none;">
    <p id="title" data-title="<?php echo esc_attr( $evaluation_data->periscope_course_name ); ?>"><?php esc_html_e( 'Course Title: ', 'tutor-periscope' ); ?><?php echo esc_html( $evaluation_data->periscope_course_name ); ?></p>
    <p><?php esc_html_e( 'Course Code: ', 'tutor-periscope' ); ?><?php echo esc_html( $evaluation_data->periscope_course_code ); ?></p>
    <h2><?php esc_html_e( 'APTA Evaluation', 'tutor-periscope' ); ?></h2>
    <p><?php esc_html_e( '1. Course content matched the session description: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_content_matched ) ); ?></p>
    <p><?php esc_html_e( '2. The learning outcomes were met: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_learning_outcome ) ); ?></p>
    <p><?php esc_html_e( '3. Current evidence was cited for specific content: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_current_evidence ) ); ?></p>
    <p><?php esc_html_e( '4. Instructional activities added value to my learning experience: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_instructional_activities ) ); ?></p>
    <p><?php esc_html_e( '5. Course content was effectively delivered: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_content_delivered ) ); ?></p>
    <p><?php esc_html_e( '6. Overall, the course was valuable: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_course_valuable ) ); ?></p>
    <p><?php esc_html_e( '7. Promotion of a product or service was NOT presented: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_promotion_product ) ); ?></p>
    <p><?php esc_html_e( '8. The environment was supportive of my learning experience: ', 'tutor-periscope' ); ?><?php echo esc_html( ucfirst( $evaluation_data->periscope_environment ) ); ?></p>
    <p><?php esc_html_e( '9. Number of hours it took to complete - ONLY for Online Courses: ', 'tutor-periscope' ); ?><?php echo esc_html( $evaluation_data->periscope_no_hours ); ?></p>
    <p><?php esc_html_e( '10. Agree - How will you apply this in your practice? ', 'tutor-periscope' ); ?></p>
    <p><?php echo esc_html( $evaluation_data->periscope_apply_practice ); ?></p>
</div>
<!--End Printable Area-->

<button onClick="PrintDiv();" style="background: #2271b1; padding:8px 20px; color: #ffffff; border: none; border-radius:4px;cursor:pointer;margin-top:20px;"><?php esc_html_e( 'Print', 'tutor-periscope' ); ?></button>
<button onClick="exportPDF();" style="background: #2271b1; padding:8px 20px; color: #ffffff; border: none; border-radius:4px;cursor:pointer;margin-top:20px;"><?php esc_html_e( 'Download PDF', 'tutor-periscope' ); ?></button>