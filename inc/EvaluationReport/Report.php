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
use \wpdb;

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

		$query = "SELECT
			form.form_title,
			form.form_description,
			fields.field_label,
			fields.field_type,
			GROUP_CONCAT(options.option_name) AS option_name,
			GROUP_CONCAT(
				IFNULL(
					( SELECT COUNT(*)
							FROM {$feedback_table}
							WHERE feedback = options.option_name
								AND field_id = fields.id
							GROUP BY feedback
					), 0
				)
				SEPARATOR
				','
			) AS total_count,

			GROUP_CONCAT(
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
				SEPARATOR
				','
			) AS percent,
			(
				SELECT GROUP_CONCAT(feedback.feedback SEPARATOR ' _ ')
					FROM {$form_table} AS form
					INNER JOIN {$field_table} AS fields
						ON fields.form_id = form.id
						AND fields.field_type = 'comment'
					INNER JOIN {$feedback_table} AS feedback
						ON feedback.field_id = fields.id
					WHERE form.id = $form_id
			) AS comments

			FROM {$field_table} AS fields

			INNER JOIN {$field_options_table} AS options
				ON options.field_type = fields.field_type

			INNER JOIN {$form_table} AS form
				ON form.id = fields.form_id

			WHERE form.id = %d

			GROUP BY fields.id

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
		$action    = $_GET['action'] ?? '';
		$course_id = $_GET['course-id'] ?? 0;
		if ( ! $course_id ) {
			die( esc_html_e( 'Invalid course id', 'tutor-periscope' ) );
		}
		$course_id       = sanitize_text_field( $course_id );
		$should_download = false;
		if ( 'tp-evaluation-report-download' === $action ) {
			$should_download = true;
		}

		// Prepare view file.
		$view          = '';
		$pdf_file_name = str_replace( ' ', '-', strtolower( get_the_title( $course_id ) ) );
		if ( 'tp-evaluation-report-download' === $action || 'tp-evaluation-report-view' === $action ) {
			$view          = trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'evaluation-statistics-report.php';
			$pdf_file_name = $pdf_file_name . '-evaluation-statistics-report';
		}
		if ( 'tp-evaluation-report-summary' === $action ) {
			$view          = trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'evaluation-report-summary.php';
			$pdf_file_name = $pdf_file_name . '-evaluation-summary-report';
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
			$content = apply_filters( 'tutor_periscope_evaluation_statistics', ob_get_clean() );
			PDFManager::render( $content, $pdf_file_name, $should_download );
			exit;
		}
	}

	/**
	 * Get job titles by course id
	 *
	 * It will return all the job titles that a enroll student have
	 * on a particular course.
	 *
	 * @since v2.0.0
	 *
	 * @param int $course_id   tutor course id.
	 *
	 * @return mixed  wpdb::get_results
	 * response details:
	 * https://developer.wordpress.org/reference/classes/wpdb/get_results/
	 */
	public static function get_user_job_titles( int $course_id ) {
		global $wpdb;
		$course_id      = sanitize_text_field( $course_id );
		$course_table   = $wpdb->posts;
		$enroll_table   = $wpdb->posts;
		$usermeta_table = $wpdb->usermeta;

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
					course.ID,
					GROUP_CONCAT(enroll.id SEPARATOR ',') AS enroll_id,
					GROUP_CONCAT(meta.meta_value SEPARATOR ',') AS title

					FROM {$course_table} AS course

					INNER JOIN {$enroll_table} AS enroll
						ON enroll.post_parent = course.ID
						AND enroll.post_type = 'tutor_enrolled'
						AND enroll.post_status = 'completed'

					INNER JOIN {$usermeta_table} AS meta
						ON meta.user_id = enroll.post_author
						AND meta.meta_key = '__title'

					WHERE course.ID = %d

					GROUP BY course.ID
				",
				$course_id
			)
		);
	}
}
