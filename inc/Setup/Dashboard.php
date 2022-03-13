<?php
/**
 * Handles registering admin pages
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Setup;

defined( 'ABSPATH' ) || exit;

/**
 * Dashboard class
 */
class Dashboard {

	/**
	 * Register
	 */
	public function register() {
		add_action( 'tutor_admin_register', array( $this, 'register_periscope_course_evaluation' ) );
	}

	/**
	 * Register Course Evaluation
	 */
	public function register_periscope_course_evaluation() {
		add_submenu_page( 'tutor', __( 'Course Evaluation', 'tutor-periscope' ), __( 'Course Evaluation', 'tutor-periscope' ), 'manage_tutor', 'course-evaluation', array( $this, 'course_evaluation_markup' ) );
		add_submenu_page( 'tutor', __( 'Course Assignment', 'tutor-periscope' ), __( 'Course Assignment', 'tutor-periscope' ), 'manage_tutor', 'course-assignment', array( $this, 'course_assignment_markup' ) );
	}

	/**
	 * Markup for evaluation
	 *
	 * @return void
	 */
	public function course_assignment_markup() {

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
	 * Markup for evaluation
	 *
	 * @return void
	 */
	public function course_evaluation_markup() {

		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

		switch ( $action ) {
			case 'view':
				$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-evaluation-single.php';
				break;

			case 'edit':
				$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-evaluation-edit.php';
				break;

			case 'new':
				$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-evaluation-new.php';
				break;

			default:
				$template = TUTOR_PERISCOPE_DIR_PATH . 'views/admin/course-evaluation-list.php';
				break;
		}

		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}
