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

	/**
	 * Get form details by id
	 *
	 * @since v2.0.0
	 *
	 * @param int $id form id.
	 *
	 * @return mixed wpdb::get_row response
	 */
	public function get_one( int $id ) {
		return QueryHelper::get_one(
			( new self() )->get_table(),
			array( 'id' => $id )
		);
	}

	/**
	 * Get all form list
	 *
	 * @since v2.0.0
	 *
	 * @return array  wpdb results
	 */
	public function get_list( $offset = 0, $limit = 10, $year = '', $search = '', $from_date = '', $to_date = '' ): array {
		global $wpdb;
		$forms_table    = $this->get_table();
		$fields_table   = $wpdb->prefix . EvaluationFormFields::get_table();
		$feedback_table = $wpdb->prefix . EvaluationFormFeedback::get_table();

		$year_clause = '';
		if ( '' !== $year ) {
			$year_clause = "AND $year = ( 
				SELECT YEAR(feedback.created_at) AS year
					FROM 
					{$feedback_table} AS feedback
					HAVING year = $year
					LIMIT 1
				)
			";
		}
		$date_range = '';
		if ( '' !== $from_date && '' !== $to_date ) {
			$date_range = "AND true = ( 
				SELECT EXISTS (
					SELECT feedback.id
					FROM 
					{$feedback_table} AS feedback
					WHERE DATE(feedback.created_at) 
						BETWEEN DATE('$from_date') AND DATE('$to_date')
					LIMIT 1
				)
			)
			";
		}

		$search_term = '%' . $wpdb->esc_like( $search ) . '%';

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
				form.*,
				course.post_title AS course,
				(
					SELECT COUNT(DISTINCT feedback.user_id)
					FROM {$fields_table} AS field
						INNER JOIN {$feedback_table} AS feedback
							ON feedback.field_id = field.id
					WHERE field.form_id = form.id
				) AS total_submission,
				(
					SELECT MONTH(feedback.created_at)
					FROM {$fields_table} AS field
						INNER JOIN {$feedback_table} AS feedback
							ON feedback.field_id = field.id
					WHERE field.form_id = form.id
					ORDER BY feedback.id ASC	
					LIMIT 1
						
				) AS from_month,
				(
					SELECT MONTH(feedback.created_at)
					FROM {$fields_table} AS field
						INNER JOIN {$feedback_table} AS feedback
							ON feedback.field_id = field.id
					WHERE field.form_id = form.id
					ORDER BY feedback.id DESC	
					LIMIT 1
				) AS to_month

					FROM {$forms_table} AS form
						INNER JOIN {$wpdb->posts} AS course
							ON course.ID = form.tutor_course_id
							AND course.post_type = 'courses'
					WHERE 1 = %d
					AND ( course.post_title LIKE %s )
					{$year_clause}
					LIMIT %d, %d
				",
				1,
				$search_term,
				$offset,
				$limit
			)
		);
		return is_array( $results ) && count( $results ) ? $results : array();
	}

	/**
	 * Count total evaluation form
	 *
	 * @since v2.0.0
	 *
	 * @return mixed  wpdb count value
	 */
	public function total_evaluation_count( $year = '', $search = '', $from_date = '', $to_date = '' ) {
		global $wpdb;
		$forms_table    = $this->get_table();
		$fields_table   = $wpdb->prefix . EvaluationFormFields::get_table();
		$feedback_table = $wpdb->prefix . EvaluationFormFeedback::get_table();

		$year_clause = '';
		if ( '' !== $year ) {
			$year_clause = "AND $year = ( 
				SELECT YEAR(feedback.created_at) AS year
					FROM 
					{$feedback_table} AS feedback
					HAVING year = $year
					LIMIT 1
				)
			";
		}

		$date_range = '';
		if ( '' !== $from_date && '' !== $to_date ) {
			$date_range = "AND true = ( 
				SELECT EXISTS (
					SELECT feedback.id
					FROM 
					{$feedback_table} AS feedback
					WHERE DATE(feedback.created_at) 
						BETWEEN DATE('$from_date') AND DATE('$to_date')
					LIMIT 1
				)
			)
			";
		}

		$search_term = '%' . $wpdb->esc_like( $search ) . '%';
	
		$count = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(form.id)
					FROM {$forms_table} AS form

					INNER JOIN {$wpdb->posts} AS course
						ON course.ID = form.tutor_course_id
						AND course.post_type = 'courses'

					WHERE 1 = %d 
					AND ( course.post_title LIKE %s )
					{$year_clause}
					{$date_range}
				",
				1,
				$search_term
			)
		);
		return $count;
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

	/**
	 * Check if a course has evaluation form
	 *
	 * @param int $course_id  tutor course id.
	 *
	 * @return bool
	 */
	public static function course_has_form( int $course_id ): bool {
		global $wpdb;
		$table = ( new self() )->get_table();
		$query = $wpdb->prepare(
			"SELECT
				COUNT(*)
			FROM {$table}
			WHERE tutor_course_id = %d
			",
			$course_id
		);
		$result = $wpdb->get_var( $query );
		return $result ? true : false;
	}
}
