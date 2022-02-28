<?php

/**
 * Reviewer role to review student's submitted data
 * and other Periscope stuffs
 *
 * @package TutorPeriscope\UserRole
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\UserRole;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Reviewer extends AbstractRole {
    
    /**
     * Role name
     *
     * @var string
     */
    public $role = 'periscope_reviewer';
        
    /**
     * Role's display name
     *
     * @var string
     */
    public $display_name = 'Periscope Reviewer';
        
    /**
     * Register hooks
     *
     * @return void
     */
    public function __construct()
    {
        add_action( 'init', array( $this, 'add_role' ) );
    }

    /**
     * Capabilities for this role
     *
     * @since v1.0.0
     *
     * @return array
     */
    public function capabilities(): array {
        return array(
            'read'  => true
        );
    }
    
}
