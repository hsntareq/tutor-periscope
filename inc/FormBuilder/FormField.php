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

	public function create( array $request ): int {
		return QueryHelper::insert( $this->get_table(), $request );
	}

	public function get_one( int $id ): object {

	}

	public function get_list(): array {

	}

	public function update( array $request, int $id ): bool {

	}

	public function delete( int $id ): bool {

	}
}
