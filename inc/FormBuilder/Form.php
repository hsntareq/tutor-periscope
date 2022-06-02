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

class Form implements FormInterface {

    public function create( array $request ) {

    }

    public function get_one( int $id ): object {

    }

    public function get_list(): array {

    }

    public function update( array $request, int $id): bool {

    }

    public function delete( int $id ): bool {

    }
}
