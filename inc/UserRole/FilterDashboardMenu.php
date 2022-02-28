<?php
/**
 * Filter dashboard menu on the front end as per user role
 *
 * @package Tutor_Periscope\UserRole
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\UserRole;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add methods for filter front end dashboard menu and template
 * for add menu.
 */
class FilterDashboardMenu {
    
    /**
     * Register hooks
     *
     * @return void
     */
    public function __construct()
    {
        add_filter( 'tutor_dashboard/nav_items', array( $this, 'filter_menu' ), 10, 1 );   
    }
    
    /**
     * Filter menu
     *
     * @since v1.0.0
     *
     * @param  mixed $menu value to filter
     *
     * @return array containing key value pair of menu items
     */
    public function filter_menu( array $menu ): array {
        $reviewer = new Reviewer;
        if ( wc_current_user_has_role( $reviewer->role ) ) {
            $menu = array(
                'review-attempts'   => __( 'Review Attempts', 'tutor-periscope' )
            );
        }
        return $menu;
    }
}