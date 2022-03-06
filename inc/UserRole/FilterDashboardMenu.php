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

	const REVIEW_ATTEMPT_SLUG = 'pending-approvals';

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		$reviewer        = new Reviewer();
		$this->user_role = $reviewer->role;

		add_action( 'generate_rewrite_rules', array( $this, 'add_rewrite_rules' ) );
		add_filter( 'tutor_dashboard/nav_items', array( $this, 'filter_menu' ), 100, 1 );
		add_filter( 'load_dashboard_template_part_from_other_location', array( $this, 'load_template' ), 100, 1 );
		add_action( 'template_redirect', array( $this, 'redirect_to_quiz_attempts' ), 100 );
		add_action( 'wp_ajax_tutor_periscope_attempt_details', array( $this, 'attempt_details' ), 100 );
	}

	/**
	 * Add rewrite rules for new url
	 *
	 * @param mixed $wp_rewrite  existing rules.
	 *
	 * @return void
	 */
	public function add_rewrite_rules( $wp_rewrite ) {
		$dashboard_page_id   = (int) tutor_utils()->get_option( 'tutor_dashboard_page_id' );
		$dashboard_page_slug = get_post_field( 'post_name', $dashboard_page_id );

		$dashboard_key = self::REVIEW_ATTEMPT_SLUG;
		$new_rules[ "({$dashboard_page_slug})/{$dashboard_key}/?$" ] = 'index.php?pagename=' . $wp_rewrite->preg_index( 1 ) . '&tutor_dashboard_page=' . $dashboard_key;

		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
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
					self::REVIEW_ATTEMPT_SLUG => __( 'Pending Approvals', 'tutor-periscope' ),
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
			if ( isset( $query_vars['tutor_dashboard_page'] ) && self::REVIEW_ATTEMPT_SLUG === $query_vars['tutor_dashboard_page'] || ( ! isset( $query_vars['tutor_dashboard_page'] ) && 'dashboard' === $query_vars['pagename'] ) ) {
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
				wp_safe_redirect( tutor_utils()->tutor_dashboard_url() . self::REVIEW_ATTEMPT_SLUG );
				exit;
			}
		}
	}

	/**
	 * Get attempt details from Tutor
	 *
	 * @return void send json response on failure, html on success
	 */
	public function attempt_details() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			ob_start();
			tutor_load_template_from_custom_path(
				TUTOR_PERISCOPE_DIR_PATH . 'templates/frontend/attempt-details.php',
				array( 'attempt_id' => sanitize_text_field( $_POST['attempt_id'] ) )
			);
			echo ob_get_clean();
			exit;
		} else {
			wp_send_json_error( __( 'Nonce verification failed', 'tutor-periscope' ) );
		}
	}

}
