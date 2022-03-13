<?php
/**
 * Handle database basic logics
 * for example CRUD operation
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
abstract class DB_Query {

	/**
	 * To implement to the derived class
	 *
	 * @return void
	 */
	abstract public function get_table();

	/**
	 * Insert data in the instance table
	 *
	 * @param array $data | data to insert in the table.
	 *
	 * @return bool, true on success false on failure
	 *
	 * @since v1.0.0
	 */
	protected function insert( array $data ): bool {
		global $wpdb;
		// Sanitize text field.
		$data = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$data
		);

		$insert = $wpdb->insert(
			$this->get_table(),
			$data
		);
		return $insert ? true : false;
	}

	/**
	 * Update data in the instance table
	 *
	 * @param array $data | data to update in the table.
	 * @param array $where | condition array.
	 *
	 * @return bool, true on success false on failure
	 *
	 * @since v1.0.0
	 */
	protected function update( array $data, array $where ): bool {
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
			$this->get_table(),
			$data,
			$where
		);
		return $update ? true : false;
	}

}
