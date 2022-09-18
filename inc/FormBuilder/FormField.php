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

use Tutor_Periscope\FormBuilder\FormInterface;
use Tutor_Periscope\Query\QueryHelper;

/**
 * Handle form fields. A concrete class.
 */
class FormField implements FormInterface {

	/**
	 * Get table name
	 *
	 * @since v2.0.0
	 *
	 * @return string
	 */
	public function get_table() {
		global $wpdb;
		return $wpdb->prefix . 'tp_evaluation_form_fields';
	}

	/**
	 * Add form field
	 *
	 * @since v2.0.0
	 *
	 * @param array $request  form data.
	 *
	 * @return mixed wpdb query response
	 */
	public function create_multiple( array $request ) {
		return QueryHelper::insert_multiple_rows( $this->get_table(), $request );
	}

	/**
	 * Add form field
	 *
	 * @since v2.0.0
	 *
	 * @param array $request  form data.
	 *
	 * @return mixed wpdb query response
	 */
	public function create( array $request, array $format = array() ) {
		return QueryHelper::insert( $this->get_table(), $request, $format );
	}

	public function get_one( int $id ) {

	}

	public function get_list(): array {

	}

	public function update( array $request, int $id ): bool {

	}

	public function delete( int $id ): bool {

	}

	/**
	 * Delete all form fields by form id
	 *
	 * @since v2.0.0
	 *
	 * @param int $form_id  form id.
	 *
	 * @return bool
	 */
	public static function delete_all_fields_by_form( int $form_id ): bool {
		$form_id = sanitize_text_field( $form_id );
		return QueryHelper::delete(
			( new FormField() )->get_table(),
			array( 'form_id' => $form_id )
		);
	}

	/**
	 * Delete all form fields by form id
	 *
	 * @since v2.0.0
	 *
	 * @param string $submitted_ids  comma separated values.
	 *
	 * @return bool
	 */
	public static function delete_none_submitted_fields( string $submitted_ids ): bool {
		return QueryHelper::delete_where_id_not_in(
			( new FormField() )->get_table(),
			$submitted_ids
		);
	}

	/**
	 * Get all feedback id
	 *
	 * @param string $field_ids  comma separated ids.
	 *
	 * @return array
	 */
	public function get_all_feedback_id( string $field_ids ): array {
		return QueryHelper::select_all_where_in(
			( new Feedback() )->get_table(),
			'field_id',
			'field_id',
			$field_ids
		);
	}

	/**
	 * Get available field types
	 *
	 * @return array
	 */
	public static function field_types(): array {
		$types = array(
			array(
				'key'   => 'compare',
				'value' => __( 'Compare', 'tutor-periscope' ),
			),
			array(
				'key'   => 'vote',
				'value' => __( 'Vote', 'tutor-periscope' ),
			),
		);
		return apply_filters(
			'tutor_periscope_field_types',
			$types
		);
	}
}
