<?php
/**
 * Student course evaluation
 *
 * @package StudentCourseEvaluation
 */
namespace Tutor_Periscope\Evaluation;

use Tutor_Periscope\Query\DB_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Course_Evaluation extends DB_Query {

	private $table_name;
	/**
	 * Handle dependencies hooks
	 */
	public function __construct() {
		/**
		 * Init table name
		 *
		 * @var $table_name
		 */
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tp_course_evaluation';

		/**
		 * Do action hook added
		 * file path: tutor/templates/single/course/review-form.php:33
		 *
		 * Add custom fields
		 */
		// add_action(
		// 'tutor_before_rating_textarea',
		// array(
		// __CLASS__,
		// 'tutor_before_rating_textarea',
		// )
		// );

		/**
		 * Student course evaluation ajax request handle
		 *
		 * @since v1.0.0
		 */
		add_action(
			'wp_ajax_tutor_periscope_evaluation',
			array(
				$this,
				'course_evaluation',
			)
		);
	}

	/**
	 * Get table name
	 *
	 * @return string
	 *
	 * @since v1.0.0
	 */
	public function get_table() {
		return $this->table_name;
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
	public function course_evaluation() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$post = $_POST;

			// unset index that won't be store in DB.
			unset( $post['action'] );
			unset( $post['nonce'] );
			$post['student_id'] = get_current_user_id();
			$create_or_update   = $this->create_or_update( $post );
			if ( $create_or_update ) {
				// store a identifier that user evaluated course.
				update_user_meta(
					get_current_user_id(),
					'tp_user_evaluated_course_' . $post['tutor_course_id'],
					true
				);
				wp_send_json_success();

			} else {
				wp_send_json_error();
			}
		}
		wp_send_json_error( __( 'Nonce verification failed', 'tutor_periscope' ) );
	}

	/**
	 * Create or update course evaluation based on post array
	 *
	 * It will call the extended class for operation.
	 *
	 * @param array $post post data for insert or update.
	 *
	 * @return bool, true on success false on failure
	 *
	 * @since v1.0.0
	 */
	public function create_or_update( array $post ): bool {
		if ( isset( $post['id'] ) ) {
			return $this->update( $post, array( 'id' => $post['id'] ) );
		} else {
			return $this->insert( $post );
		}
	}
}

