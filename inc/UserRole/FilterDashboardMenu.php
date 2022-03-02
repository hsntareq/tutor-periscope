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
	 * Current user role
	 *
	 * @var mixed
	 */
	protected $user_role;

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		$reviewer        = new Reviewer();
		$this->user_role = $reviewer->role;

		add_filter( 'tutor_dashboard/nav_items', array( $this, 'filter_menu' ), 100, 1 );
		add_filter( 'load_dashboard_template_part_from_other_location', array( $this, 'load_template' ), 100, 1 );
		add_action( 'template_redirect', array( $this, 'redirect_to_quiz_attempts' ), 100 );
	}

	/**
	 * Filter menu
	 *
	 * @since v1.0.0
	 *
	 * @param array $menu value to filter.
	 *
	 * @return array containing key value pair of menu items
	 */
	public function filter_menu( array $menu ): array {
		if ( wc_current_user_has_role( $this->user_role ) ) {
			$new_menu = apply_filters(
				'tutor_periscope_frontend_dashboard_menu',
				array(
					'review-attempts' => __( 'Review Attempts', 'tutor-periscope' ),
				)
			);
			$menu     = $new_menu;
		}
		return $menu;
	}

	/**
	 * Get review attempts template
	 *
	 * @return string  file path
	 */
	public function template() {
		return TUTOR_PERISCOPE_DIR_PATH . 'templates/frontend/quiz-attempts.php';
	}

	/**
	 * Include quiz attempt template
	 *
	 * @since v1.0.0
	 *
	 * @param  string $template  template file path to alter.
	 *
	 * @return string
	 */
	public function load_template( string $template ): string {
		global $wp_query;
		$query_vars = $wp_query->query_vars;

		if ( wc_current_user_has_role( $this->user_role ) ) {
			if ( isset( $query_vars['tutor_dashboard_page'] ) && 'review-attempts' === $query_vars['tutor_dashboard_page'] || ( ! isset( $query_vars['tutor_dashboard_page'] ) && 'dashboard' === $query_vars['pagename'] ) ) {
				$quiz_attempt_template = $this->template();

				if ( file_exists( $quiz_attempt_template ) ) {
					$template = apply_filters( 'tutor_periscope_quiz_attempt_template', $quiz_attempt_template );
				}
			}
		}
		return $template;
	}

	/**
	 * Redirect to review-attempts url if current user
	 * has reviewer role and try to access tutor dashboard page.
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public function redirect_to_quiz_attempts() {
		global $wp_query;
		$query_vars = $wp_query->query_vars;

		if ( wc_current_user_has_role( $this->user_role ) ) {
			if ( ! isset( $query_vars['tutor_dashboard_page'] ) && 'dashboard' === $query_vars['pagename'] ) {
				wp_safe_redirect( tutor_utils()->tutor_dashboard_url() . 'review-attempts' );
				exit;
			}
		}
	}

}
