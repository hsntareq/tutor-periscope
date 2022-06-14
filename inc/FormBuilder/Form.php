<?php
/**
 * Form concrete class
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor_Periscope\Database\EvaluationFormFeedback;
use Tutor_Periscope\Database\EvaluationFormFields;
use Tutor_Periscope\FormBuilder\FormInterface;
use Tutor_Periscope\Query\QueryHelper;

/**
 * Form management
 */
class Form implements FormInterface {

	/**
	 * Get table name
	 *
	 * @since v2.0.0
	 *
	 * @return string
	 */
	public function get_table() {
		global $wpdb;
		return $wpdb->prefix . 'tp_evaluation_forms';
	}

	/**
	 * Create or update form
	 *
	 * @since v2.0.0
	 *
	 * @param array $request   array data to insert or update
	 * if tp_ef_id exist then it will make update request
	 * otherwise create.
	 *
	 * @return bool
	 */
	public function create( array $request ): int {
		return QueryHelper::insert( $this->get_table(), $request );
	}

	public function get_one( int $id ): object {

	}

	/**
	 * Get all form list
	 *
	 * @since v2.0.0
	 *
	 * @return array  wpdb results
	 */
	public function get_list(): array {
		global $wpdb;
		$forms_table    = $this->get_table();
		$fields_table   = $wpdb->prefix . EvaluationFormFields::get_table();
		$feedback_table = $wpdb->prefix . EvaluationFormFeedback::get_table();

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT form.*, course.post_title AS course, (
					SELECT COUNT(DISTINCT feedback.user_id)
						FROM {$fields_table} AS field
							INNER JOIN {$feedback_table} AS feedback
								ON feedback.field_id = field.id
						WHERE field.form_id = form.id
				) AS total_submission
					FROM {$forms_table} AS form
						INNER JOIN {$wpdb->posts} AS course
							ON course.ID = form.tutor_course_id
							AND course.post_type = 'courses'
					WHERE 1 = %d
				",
				1
			)
		);
		return is_array( $results ) && count( $results ) ? $results : array();
	}

	/**
	 * Update form based on id
	 *
	 * @since v2.0.0
	 *
	 * @param array $request  form data.
	 * @param int   $id  form id to delete.
	 *
	 * @return bool  true on success otherwise false
	 */
	public function update( array $request, int $id ): bool {
		return QueryHelper::update(
			$this->get_table(),
			$request,
			array(
				'id' => $request['id'],
			)
		);
	}

	public function delete( int $id ): bool {

	}
}
