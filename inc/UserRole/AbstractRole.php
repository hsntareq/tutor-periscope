<?php
/**
 * Abstract Role
 *
 * An abstract class creating role, just extend this class use the
 * extended the methods
 *
 * @package Tutor_Periscope\UserRole
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\UserRole;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

abstract class AbstractRole {

    public abstract function capabilities(): array;

    /**
     * Add role
     *
     * @since v1.0.0
     *
     * @return void
     */
    public function add_role() {
        add_role( $this->role, $this->display_name, $this->capabilities() );
    }
    
    /**
     * Remove role
     *
     * @since v1.0.0
     *
     * @return void
     */
    public function remove_role() {
        remove_role( $this->role );
    }
}