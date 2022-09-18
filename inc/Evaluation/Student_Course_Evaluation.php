<?php
/**
 * Student course evaluation
 *
 * @package StudentCourseEvaluation
 */
namespace Tutor_Periscope\Evaluation;

use Tutor_Periscope\Database\EvaluationFormFeedback;
use Tutor_Periscope\FormBuilder\Feedback;
use Tutor_Periscope\FormBuilder\FormBuilder;
use Tutor_Periscope\Query\DB_Query;
use Tutor_Periscope\Query\QueryHelper;
use Tutor_Periscope\Utilities\Utilities;

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
		Utilities::verify_ajax_nonce();
		$post      = $_POST;
		$form_data = array();
		$user_id   = get_current_user_id();
		foreach ( $post['field_id'] as $key => $id ) {
			$arr = array(
				'field_id' => $id,
				'feedback' => $post['feedback'][ $key ],
				'user_id'  => $user_id,
			);
			array_push( $form_data, $arr );
		}

		// Create instance of form builder.
		$form_builder = FormBuilder::create( 'Feedback' );

		// Save default comment input value.
		$comments           = $post['comments'];
		$form_field_builder = FormBuilder::create( 'FormField' );
		foreach ( $form_data as $key => $data ) {
			$form_field_builder->update_default_input( $data['field_id'], $comments[ $key ] );
		}

		$save_feedback = $form_builder->create( $form_data );
		if ( $save_feedback ) {
			// store a identifier that user evaluated course.
			update_user_meta(
				$user_id,
				'tp_user_evaluated_course_' . $post['course_id'],
				true
			);
			wp_send_json_success();

		} else {
			wp_send_json_error();
		}
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

