<?php
/**
 * Assignment Concrete class
 *
 * @package Tutor_Periscope\Admin\SubMenu
 *
 * @author Hasan Tareq <hsntareq@gmail.com>
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Admin\Menu\SubMenu;

use Tutor_Periscope\Admin\Menu\MainMenu;

/**
 * Assignment sub menu
 */
class Assignment implements SubMenuInterface {

	/**
	 * Page title
	 *
	 * @since v2.0.0
	 *
	 * @return string  page title
	 */
	public function page_title(): string {
		return __( 'Assignment', 'tutor-periscope' );
	}

	/**
	 * Menu title
	 *
	 * @since v2.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string {
		return __( 'Assignment', 'tutor-periscope' );
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
		return 'tutor-periscope-assignment';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function view() {
		$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-assignment-form.php';
		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}
