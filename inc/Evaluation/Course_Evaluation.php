<?php
/**
 * Handles Course evaluation records
 * 
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Evaluation;

defined( 'ABSPATH' ) || exit;

/**
 * Course Evaluation class
 */
class Course_Evaluation {

    /**
     * Register
     */
    public function register() {
        add_action( 'init', array( $this, 'create_evaluation_db_table' ) );
		add_action( 'admin_init', array( $this, 'handle_evaluation_form' ) );
    }

    /**
     * Create evaluation database table
     */
    public function create_evaluation_db_table() {
        global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$evaluations_table = "CREATE TABLE {$wpdb->prefix}course_evaluations (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			periscope_course_name varchar(255),
			periscope_course_code varchar(255),
			periscope_content_matched tinytext,
			periscope_learning_outcome tinytext,
			periscope_current_evidence tinytext,
			periscope_instructional_activities tinytext,
			periscope_content_delivered tinytext,
			periscope_course_valuable tinytext,
			periscope_promotion_product tinytext,
			periscope_environment tinytext,
            periscope_no_hours tinytext,
            periscope_apply_practice text,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) $charset_collate;";
		
		// Require the upgrade file.
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $evaluations_table );
    }

	/**
     * Handle the Course Evaluation new and edit form
     *
     * @return void
     */
    public function handle_evaluation_form() {
        if ( ! isset( $_POST['submit_evaluation'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'tutor_periscope_nonce' ) ) {
            die( __( 'Are you cheating?', 'tutor-periscope' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'tutor-periscope' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=course-evaluation' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $periscope_course_name              = isset( $_POST['periscope_course_name'] ) ? sanitize_text_field( $_POST['periscope_course_name'] ) : '';
        $periscope_course_code              = isset( $_POST['periscope_course_code'] ) ? sanitize_text_field( $_POST['periscope_course_code'] ) : '';
        $periscope_content_matched          = isset( $_POST['periscope_content_matched'] ) ? sanitize_text_field( $_POST['periscope_content_matched'] ) : '';
        $periscope_learning_outcome         = isset( $_POST['periscope_learning_outcome'] ) ? sanitize_text_field( $_POST['periscope_learning_outcome'] ) : '';
        $periscope_current_evidence         = isset( $_POST['periscope_current_evidence'] ) ? sanitize_text_field( $_POST['periscope_current_evidence'] ) : '';
        $periscope_instructional_activities = isset( $_POST['periscope_instructional_activities'] ) ? sanitize_text_field( $_POST['periscope_instructional_activities'] ) : '';
        $periscope_content_delivered        = isset( $_POST['periscope_content_delivered'] ) ? sanitize_text_field( $_POST['periscope_content_delivered'] ) : '';
        $periscope_course_valuable          = isset( $_POST['periscope_course_valuable'] ) ? sanitize_text_field( $_POST['periscope_course_valuable'] ) : '';
        $periscope_promotion_product        = isset( $_POST['periscope_promotion_product'] ) ? sanitize_text_field( $_POST['periscope_promotion_product'] ) : '';
        $periscope_environment              = isset( $_POST['periscope_environment'] ) ? sanitize_text_field( $_POST['periscope_environment'] ) : '';
        $periscope_no_hours                 = isset( $_POST['periscope_no_hours'] ) ? sanitize_text_field( $_POST['periscope_no_hours'] ) : '';
        $periscope_apply_practice           = isset( $_POST['periscope_apply_practice'] ) ? wp_kses_post( $_POST['periscope_apply_practice'] ) : '';

        // some basic validation
        if ( ! $periscope_course_name ) {
            $errors[] = __( 'Error: Course Name is required', 'tutor-periscope' );
        }

        if ( ! $periscope_course_code ) {
            $errors[] = __( 'Error: Course Code is required', 'tutor-periscope' );
        }

        if ( ! $periscope_content_matched ) {
            $errors[] = __( 'Error: Course content matched the session description: is required', 'tutor-periscope' );
        }

        if ( ! $periscope_learning_outcome ) {
            $errors[] = __( 'Error: The learning outcomes were met: is required', 'tutor-periscope' );
        }

        if ( ! $periscope_current_evidence ) {
            $errors[] = __( 'Error: Current evidence was cited for specific content: is required', 'tutor-periscope' );
        }

        if ( ! $periscope_instructional_activities ) {
            $errors[] = __( 'Error: Instructional activities added value to my learning experience is required', 'tutor-periscope' );
        }

        if ( ! $periscope_content_delivered ) {
            $errors[] = __( 'Error: Course content was effectively delivered is required', 'tutor-periscope' );
        }

        if ( ! $periscope_course_valuable ) {
            $errors[] = __( 'Error: Overall, the course was valuable: is required', 'tutor-periscope' );
        }

        if ( ! $periscope_promotion_product ) {
            $errors[] = __( 'Error: Promotion of a product or service was NOT presented is required', 'tutor-periscope' );
        }

        if ( ! $periscope_environment ) {
            $errors[] = __( 'Error: The environment was supportive of my learning experience is required', 'tutor-periscope' );
        }

        if ( ! $periscope_no_hours ) {
            $errors[] = __( 'Error: Number of hours it took to complete - ONLY for Online Courses is required', 'tutor-periscope' );
        }

        if ( ! $periscope_apply_practice ) {
            $errors[] = __( 'Error: Agree - How will you apply this in your practice is required', 'tutor-periscope' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'periscope_course_name'              => $periscope_course_name,
            'periscope_course_code'              => $periscope_course_code,
            'periscope_content_matched'          => $periscope_content_matched,
            'periscope_learning_outcome'         => $periscope_learning_outcome,
            'periscope_current_evidence'         => $periscope_current_evidence,
            'periscope_instructional_activities' => $periscope_instructional_activities,
            'periscope_content_delivered'        => $periscope_content_delivered,
            'periscope_course_valuable'          => $periscope_course_valuable,
            'periscope_promotion_product'        => $periscope_promotion_product,
            'periscope_environment'              => $periscope_environment,
            'periscope_no_hours'                 => $periscope_no_hours,
            'periscope_apply_practice'           => $periscope_apply_practice,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = periscope_insert_course_evaluation( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = periscope_insert_course_evaluation( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}