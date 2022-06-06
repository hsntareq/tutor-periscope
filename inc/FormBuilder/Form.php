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

	public function get_list(): array {

	}

	public function update( array $request, int $id ): bool {
		return QueryHelper::update(
			$this->get_table(),
			$request,
			array(
				'id' => $request['tp_ef_id'],
			)
		);
	}

	public function delete( int $id ): bool {

	}
}
