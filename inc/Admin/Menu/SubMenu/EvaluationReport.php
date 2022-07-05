<?php
/**
 * EvaluationReport Concrete class
 *
 * @package Tutor_Periscope\Admin\SubMenu
 *
 * @author Shewa <shewa12kpi@gmail.com>
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Admin\Menu\SubMenu;

/**
 * EvaluationReport sub menu
 */
class EvaluationReport implements SubMenuInterface {

	/**
	 * Page title
	 *
	 * @since v2.0.0
	 *
	 * @return string  page title
	 */
	public function page_title(): string {
		return __( 'Evaluation Report', 'tutor-periscope' );
	}

	/**
	 * Menu title
	 *
	 * @since v2.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string {
		return __( 'Evaluation Report', 'tutor-periscope' );
	}

	/**
	 * Capability to access this menu
	 *
	 * @since v2.0.0
	 *
	 * @return string  capability
	 */
	public function capability(): string {
		return 'manage_options';
	}

	/**
	 * Page URL slug
	 *
	 * @since v2.0.0
	 *
	 * @return string  slug
	 */
	public function slug(): string {
		return 'tutor-periscope-evaluation-report';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function view() {
		$view = TUTOR_PERISCOPE_VIEWS . 'admin/evaluation-report.php';
		if ( file_exists( $view ) ) {
			tutor_load_template_from_custom_path(
				$view,
				array()
			);
		} else {
			echo esc_html( "$view file not found", 'tutor-periscope' );
		}
	}
}
