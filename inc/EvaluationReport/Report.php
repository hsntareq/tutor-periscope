<?php
/**
 * Evaluation Report
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\EvaluationReport
 */

namespace Tutor_Periscope\EvaluationReport;

/**
 * Handle report
 */
class Report {

    /**
     * Register Hooks
     *
     * @since v2.0.0
     * 
     * @return void
     */
	public function __construct() {
		add_action( 'template_redirect', __CLASS__ . '::render_report' );
	}

    /**
     * Render report in PDF
     *
     * @since v2.0.0
     * 
     * @return void
     */
	public static function render_report(): void {
		$action = $_GET['action'] ?? '';

        $should_download = false;
        if ( 'tp-evaluation-report-download' === $action ) {
            $should_download = true;
        }

        // Prepare view file.
        $view = '';
        if ( 'tp-evaluation-report-download' === $action || 'tp-evaluation-report-view' === $action ) {
            $view = trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'evaluation-statistics-report.php';
        } else {
            $view = trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'evaluation-report-summary.php';
        }

        /**
         * If user trigger report action then view file
         * will be available then do as per action.
         * 
         * Otherwise do nothing. 
         */
        if ( file_exists( $view ) ) {
            tutor_load_template_from_custom_path(
                $view
            );
            $content = apply_filters( 'tutor_periscope_evaluation_statistics', ob_get_clean() );
            $pdf_file_name = 'periscope-evaluation-report.pdf';
            PDFManager::render( $content, $pdf_file_name, $should_download );
            exit;
        }
	}
}
