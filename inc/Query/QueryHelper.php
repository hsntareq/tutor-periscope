<?php
/**
 * Qeury help class contains static helper methods
 *
 * @package TutorPeriscopeQuery
 */

namespace Tutor_Periscope\Query;

/**
 * This class is for using from derived class.
 * Derived class must have $table_name property.
 *
 * Extend this class and use basic DB query.
 */
class QueryHelper {

	/**
	 * Insert data in the instance table
	 *
	 * @param string $table  table name.
	 * @param array  $data | data to insert in the table.
	 *
	 * @return int, inserted id.
	 *
	 * @since v1.0.0
	 */
	public static function insert( string $table, array $data ): int {
		global $wpdb;
		// Sanitize text field.
		$data = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$data
		);

		$insert = $wpdb->insert(
			$table,
			$data
		);
		return $insert ? $wpdb->insert_id : 0;
	}

	/**
	 * Update data in the instance table
	 *
	 * @param string $table  table name.
	 * @param array  $data | data to update in the table.
	 * @param array  $where | condition array.
	 *
	 * @return bool, true on success false on failure
	 *
	 * @since v1.0.0
	 */
	public static function update( string $table, array $data, array $where ): bool {
		global $wpdb;
		// Sanitize text field.
		$data = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$data
		);

		$where = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$where
		);

		$update = $wpdb->update(
			$table,
			$data,
			$where
		);
		return $update ? true : false;
	}
}
