<?php
/**
 * Bulk admin menu and page management
 *
 * @package Tutor_Periscope\Admin\Menu
 *
 * @author Shewa <shewa12kpi@gmail.com>
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Admin\Menu;

use Tutor_Periscope\Admin\Menu\SubMenu\SubMenuFactory;
use Tutor_Periscope\Utilities\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create admin menu and page management
 *
 * @package Tutor_Periscope\Admin
 *
 * @author Shewa <shewa12kpi@gmail.com>
 *
 * @since v1.0.0
 */
class MainMenu {

	/**
	 * Capability
	 *
	 * @var string
	 */
	private $capability = 'manage_options';

	/**
	 * Slug for this page
	 *
	 * @var string $slug
	 */
	private $slug = 'tutor-periscope';

	/**
	 * Register hooks
	 *
	 * @param bool $run  to excecute contrustor method.
	 *
	 * @return void
	 */
	public function __construct( $run = true ) {
		if ( $run ) {
			add_action( 'admin_menu', array( $this, 'add_menu' ) );
		}
	}

	/**
	 * Page title
	 *
	 * @return string
	 */
	public function page_title(): string {
		return __( 'Tutor Periscope - Users List ', 'tutor-periscope' );
	}

	/**
	 * Menu title
	 *
	 * @return string
	 */
	public function menu_title(): string {
		return __( 'Tutor Periscope', 'tutor-periscope' );
	}

	/**
	 * Capability
	 *
	 * @return string
	 */
	public function capability(): string {
		return $this->capability;
	}

	/**
	 * Slug
	 *
	 * @return string
	 */
	public function slug(): string {
		return $this->slug;
	}

	/**
	 * Position
	 *
	 * @return int
	 */
	public function position(): int {
		return 2;
	}

	/**
	 * Icon name that will used for page menu icon
	 *
	 * @return string
	 */
	public function icon_name(): string {
		return '';
	}

	/**
	 * Page view
	 *
	 * @return void
	 */
	public function view() {
		$action = isset( $action ) ? $action : '';
		switch ( $action ) {

			case 'list':
				$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-assignment-list.php';
				break;

			default:
				$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-assignment-form.php';
				break;
		}

		if ( file_exists( $template ) ) {
			include $template;
		}
	}

	/**
	 * Main menu register
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function add_menu() {
		do_action( 'tp_before_main_menu_register' );
		// Register main menu.
		add_menu_page(
			$this->page_title(),
			$this->menu_title(),
			$this->capability(),
			$this->slug(),
			array( $this, 'view' ),
			$this->icon_name(),
			$this->position()
		);
		do_action( 'tp_after_main_menu_register' );
		// Available sub-menu.
		$submenus = array(
			'Assignment',
			'BulkUser',
			'EvaluationReport',
		);
		$submenus = apply_filters( 'tp_submenus', $submenus );
		// Register sub-menu by using factory class.
		foreach ( $submenus as $submenu ) {
			$submenu_factory = SubMenuFactory::create( $submenu );
			add_submenu_page(
				$this->slug(),
				$submenu_factory->page_title(),
				$submenu_factory->menu_title(),
				$submenu_factory->capability(),
				$submenu_factory->slug(),
				array( $submenu_factory, 'view' )
			);
		}
		do_action( 'tp_after_sub_menu_register' );
	}
}

