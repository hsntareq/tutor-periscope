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
	public function create( array $request ) {
		return QueryHelper::insert_multiple_rows( $this->get_table(), $request );
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
}
