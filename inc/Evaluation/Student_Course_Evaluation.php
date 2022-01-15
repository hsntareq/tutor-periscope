<?php
/**
 * Student course evaluation
 *
 * @package StudentCourseEvaluation
 */
namespace Tutor_Periscope\Evaluation;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Course_Evaluation {

	/**
	 * Handle dependencies hooks
	 */
	public function __construct() {
		/**
		 * Do action hook added
		 * file path: tutor/templates/single/course/review-form.php:33
		 *
		 * Add custom fields
		 */
		add_action(
			'tutor_before_rating_textarea',
			array(
				__CLASS__,
				'tutor_before_rating_textarea',
			)
		);

		/**
		 * Student course evaluation ajax request handle
		 *
		 * @since v1.0.0
		 */
		add_action(
			'wp_ajax_tutor_periscope_evaluation',
			array(
				__CLASS__,
				'course_evaluation',
			)
		);
	}

	/**
	 * Load student course evaluation template
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function tutor_before_rating_textarea() {
		/**
		 * Load course evaluation template facilitating
		 * Tutor function
		 */
		tutor_load_template_from_custom_path(
			TUTOR_PERISCOPE_DIR_PATH . 'templates/frontend/course-evaluation.php'
		);
	}

	/**
	 * Course evaluation ajax request handle
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function course_evaluation() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$post = $_POST;

			//Sanitize each item.
			$post = array_map( function($item) {
				return sanitize_text_field( $item );
			}, $post);
			
		}
		wp_send_json_error( __('Nonce verification failed', 'tutor_periscope' ) );
	}
}
