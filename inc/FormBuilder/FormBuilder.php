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

class FormBuilder {

    /**
     * Create object as per type so that client code can
     * interact with concrete class.
     *
     * @since v2.0.0
     * @return FormInterface
     */
    public static function create( string $type ): FormInterface {
        try {
            return new $type();
        } catch ( \Throwable $th ) {
            throw $th;
        }
    }
}
