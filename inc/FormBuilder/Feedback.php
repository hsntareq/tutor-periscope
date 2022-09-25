<?php
/**
 * Form field concrete class
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor_Periscope\Database\EvaluationFieldOptions;
use Tutor_Periscope\Database\EvaluationForm;
use Tutor_Periscope\Database\EvaluationFormFields;
use Tutor_Periscope\FormBuilder\FormInterface;
use Tutor_Periscope\Query\QueryHelper;

/**
 * Handle form fields. A concrete class.
 */
class Feedback implements FormInterface {

	/**
	 * Get table name
	 *
	 * @since v2.0.0
	 *
	 * @return string
	 */
	public function get_table() {
		global $wpdb;
		return $wpdb->prefix . 'tp_evaluation_form_feedback';
	}

	/**
	 * Add form field
	 *
	 * @since v2.0.0
	 *
	 * @param array $request  form data.
	 *
	 * @return mixed  wpdb query response
	 */
	public function create( array $request ) {
		return QueryHelper::insert_multiple_rows( $this->get_table(), $request );
	}

	public function get_one( int $id ): object {

	}

	public function get_list(): array {

	}

	public function update( array $request, int $id ): bool {

	}

	public function delete( int $id ): bool {

	}

	/**
	 * Get unique years that has feedback
	 *
	 * @return array
	 */
	public function feedback_years() {
		global $wpdb;
		// $form_table     = $wpdb->prefix . EvaluationForm::get_table();
		// $fields_table   = $wpdb->prefix . EvaluationFormFields::get_table();
		$feedback_table = $this->get_table();
		$years          = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
					DISTINCT( YEAR(feedback.created_at) ) AS year

					FROM {$feedback_table} AS feedback

					WHERE 1 = %d
				",
				1
			)
		);
		return $years;
	}

}
