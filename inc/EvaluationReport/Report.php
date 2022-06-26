<?php
/**
 * Evaluation Report
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\EvaluationReport
 */

namespace Tutor_Periscope\EvaluationReport;

use Tutor_Periscope\Database\EvaluationFieldOptions;
use Tutor_Periscope\Database\EvaluationForm;
use Tutor_Periscope\Database\EvaluationFormFeedback;
use Tutor_Periscope\Database\EvaluationFormFields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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
	 * Get a particular form submission statistics report
	 *
	 * @since v2.0.0
	 *
	 * @param int $form_id form id.
	 *
	 * @return array wpdb::get_results
	 */
	public static function get_statistics( int $form_id ) {
		global $wpdb;
		$form_id             = sanitize_text_field( $form_id );
		$prefix              = $wpdb->prefix;
		$form_table          = $prefix . EvaluationForm::get_table();
		$field_table         = $prefix . EvaluationFormFields::get_table();
		$feedback_table      = $prefix . EvaluationFormFeedback::get_table();
		$field_options_table = $prefix . EvaluationFieldOptions::get_table();

		$query = "SELECT form.form_title, form.form_description, fields.field_label, fields.field_type, options.option_name,
			IFNULL(
				( SELECT COUNT(*)
						FROM {$feedback_table}
						WHERE feedback = options.option_name
							AND field_id = fields.id
						GROUP BY feedback
				), 0
			) AS total_count,
			
			CAST(
					IFNULL(
					(
						SELECT COUNT(*) * 100 / 
						(
							SELECT COUNT(*)
							FROM {$feedback_table}
								WHERE field_id = fields.id
						)

								FROM {$feedback_table}
								WHERE feedback = options.option_name
									AND field_id = fields.id
								GROUP BY feedback

					), 0
				) AS decimal (6,2)
			)
			AS percent,
			(
				SELECT GROUP_CONCAT(feedback.feedback SEPARATOR '\n')
					FROM {$form_table} AS form
					INNER JOIN {$field_table} AS fields
						ON fields.form_id = form.id
						AND fields.field_type = 'comment'
					INNER JOIN {$feedback_table} AS feedback
						ON feedback.field_id = fields.id
					WHERE form.id = 3
			) AS comments
			
			FROM {$field_table} AS fields

			INNER JOIN {$field_options_table} AS options
				ON options.field_type = fields.field_type

			INNER JOIN {$form_table} AS form
				ON form.id = fields.form_id

			WHERE form.id = %d

			ORDER BY fields.id
			
		";

		$response = $wpdb->get_results(
			$wpdb->prepare(
				$query,
				$form_id
			)
		);
		return $response;
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
		}
		if ( 'tp-evaluation-report-summary' === $action ) {
			$view = trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'evaluation-report-summary.php';
		}

		/**
		 * If user trigger report action then view file
		 * will be available then do as per action.
		 *
		 * Otherwise do nothing.
		 */
		if ( '' !== $view && file_exists( $view ) ) {
			tutor_load_template_from_custom_path(
				$view
			);
			$content       = apply_filters( 'tutor_periscope_evaluation_statistics', ob_get_clean() );
			$pdf_file_name = 'periscope-evaluation-report.pdf';
			PDFManager::render( $content, $pdf_file_name, $should_download );
			exit;
		}
	}
}
