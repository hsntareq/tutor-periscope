<?php
/**
 * Form builder factory class
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Form build factory concrete class for creating object
 * on fly so that client code can interact with object.
 */
class FormBuilder {

	/**
	 * Create object as per type so that client code can
	 * interact with concrete class.
	 *
	 * @since v2.0.0
	 *
	 * @param string $type  object type for creating.
	 *
	 * @return FormInterface
	 */
	public static function create( string $type ): FormInterface {
		try {
			$class = "Tutor_Periscope\\FormBuilder\\{$type}";
			return new $class();
		} catch ( \Throwable $th ) {
			echo esc_html( $th->getMessage() );
		}
	}
}
