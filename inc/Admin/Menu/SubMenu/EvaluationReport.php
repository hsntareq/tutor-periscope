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

use \Dompdf\Dompdf;
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
		return __( 'Evalution Report', 'tutor-periscope' );
	}

	/**
	 * Menu title
	 *
	 * @since v2.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string {
		return __( 'Evalution Report', 'tutor-periscope' );
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
		return 'tutor-periscope-evalution-report';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function view() {
		$page   = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$view = '';
		if ( 'tutor-periscope-evalution-report' === $page && 'report-view' === $action ) {
			$view = TUTOR_PERISCOPE_VIEWS . 'admin/evaluation-report-view.php';
			ob_start();
			tutor_load_template_from_custom_path(
				$view,
				array()
			);
			$html = ob_get_clean();
			// instantiate and use the dompdf class.
			$dompdf = new Dompdf();
			$dompdf->loadHtml( $html );
			// (Optional) Setup the paper size and orientation.
			$dompdf->setPaper( 'A4', 'landscape' );
			// Render the HTML as PDF.
			$dompdf->render();
			// Output the generated PDF to Browser.
			$dompdf->stream( 'evaluation-report-view.pdf', array( 'Attachment' => 0 ) );

			exit();
		} elseif ( 'tutor-periscope-evalution-report' === $page && 'report-download' === $action ) {
			$view = TUTOR_PERISCOPE_VIEWS . 'admin/evaluation-report-download.php';
		} elseif ( 'tutor-periscope-evalution-report' === $page && 'report-summary' === $action ) {
			$view = TUTOR_PERISCOPE_VIEWS . 'admin/evaluation-report-summary.php';
		} else {
			$view = TUTOR_PERISCOPE_VIEWS . 'admin/evaluation-report.php';
		}
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
