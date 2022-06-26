<?php
/**
 * Database cleaning & insert require data. Useful to use
 * with register_activation_hook
 *
 * @since v2.0.0
 *
 * @package Tutor_Periscope\Database
 */

namespace Tutor_Periscope\Database;

use Tutor_Periscope\FormBuilder\FieldOptions;
use Tutor_Periscope\Query\QueryHelper;

/**
 * Insert, clean DB operation
 */
class DBOperation {

	/**
	 * Insert default options for fields. Since we have predefined
	 * options as per field, we can store in DB.
	 *
	 * @since v2.0.0
	 *
	 * @see QueryHelper::insert_multiple_rows for response.
	 *
	 * @return mixed
	 */
	public static function insert_field_options() {
		$compare_fields_options = FieldOptions::compare_field_options();
		$vote_fields_options    = FieldOptions::vote_field_options();

		// Prepare data before insert.
		$data = array();
		foreach ( $compare_fields_options as $field ) {
			$array = array(
				'field_type'  => $field['field_type'],
				'option_name' => $field['value'],
			);
			array_push( $data, $array );
		}
		foreach ( $vote_fields_options as $field ) {
			$array = array(
				'field_type'  => $field['field_type'],
				'option_name' => $field['value'],
			);
			array_push( $data, $array );
		}

		// Insert data.
		global $wpdb;
		do_action( 'tutor_periscope_before_field_option_data_store' );
		$table    = $wpdb->prefix . EvaluationFieldOptions::get_table();
		$response = QueryHelper::insert_multiple_rows( $table, $data );
		do_action( 'tutor_periscope_after_field_option_data_store', $response );
		return $response;
	}

	/**
	 * Clean field_options table before insert data. It will
	 * prevent data duplication.
	 *
	 * @since v2.0.0
	 *
	 * @return bool
	 */
	public static function clean_field_options_table(): bool {
		do_action( 'tutor_periscope_before_field_option_table_clean' );
		global $wpdb;
		$table    = $wpdb->prefix . EvaluationFieldOptions::get_table();
		$response = QueryHelper::table_clean( $table );
		do_action( 'tutor_periscope_after_field_option_table_clean', $response );
		return $response;
	}
}
