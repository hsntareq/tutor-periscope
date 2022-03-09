<?php
/**
 * Approval download certificate
 *
 * @since v1.0.0
 *
 * @package TutorPeriscopeCertificate
 */

namespace Tutor_Periscope\Certificates;

use Tutor_Periscope\Query\DB_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DownloadApproval' ) ) {

	/**
	 * DownloadApproval
	 */
	class DownloadApproval extends DB_Query {

		const CERTIFICATE_APPROVALS_TABLE = 'tp_certificate_approvals';

		/**
		 * Traits for verification nonce
		 *
		 * @since v1.0.0
		 */
		use \Tutor_Periscope\Traits\NonceVerify;

		/**
		 * Register hooks
		 *
		 * @return void
		 */
		public function __construct() {
			add_action(
				'wp_ajax_tutor_periscope_allow_to_download_certificate',
				array(
					__CLASS__,
					'download_approval',
				)
			);

			/**
			 * Custom filter hook added.
			 * Hook path: tutor-pro/addons/tutor-certificate/classes/Certificate.php:399
			 */
			add_filter(
				'tutor_certificate_button',
				array(
					__CLASS__,
					'filter_download_button',
				)
			);
		}

		/**
		 * Filter download button
		 *
		 * @param string $content  content for filtering.
		 *
		 * @return string   filter content
		 */
		public static function filter_download_button( $content ) {
			$student_id = get_current_user_id();
			$course_id  = get_the_ID();
			$post       = get_post( $course_id );
			if ( $post && 'courses' === $post->post_type ) {
				$is_allowed_download = self::is_approved( $student_id, $course_id );
				if ( ! $is_allowed_download ) {
					ob_start();
					?>
					<p>
						<?php esc_html_e( 'You are not allowed to download certificate yet.', 'tutor-periscope' ); ?>
					</p>
					<?php
					$content = ob_get_clean();
				}
			}
			return $content;
		}

		/**
		 * Approve Download
		 *
		 * Save user meta to indicate download approval
		 *
		 * @return void  send json data
		 */
		public static function download_approval() {
			if ( self::verify_nonce( $_POST['nonce'] ) ) {
				$data   = array(
					'certificate_no' => $_POST['certificate_no'],
					'approver_id'    => get_current_user_id(),
					'course_id'      => $_POST['course_id'],
					'student_id'     => $_POST['student_id'],
				);
				$insert = ( new self() )->insert( $data );
				$insert ? wp_send_json_success() : wp_send_json_error( __( 'Approve failed, please try again.', 'tutor-periscope' ) );
			} else {
				wp_send_json_error( __( 'Nonce verification failed', 'tutor-periscope' ) );
			}
		}

		/**
		 * Check if student's certificate download approved or not.
		 *
		 * @param int $student_id  student id.
		 * @param int $course_id  course id.
		 *
		 * @return bool
		 */
		public static function is_approved( int $student_id, int $course_id ): bool {
			$get = self::approval_details( $student_id, $course_id );
			return $get ? true : false;
		}

		/**
		 * Get approval details
		 *
		 * @param int $student_id  student id.
		 * @param int $course_id  course id.
		 *
		 * @return mixed  on success object containing row, null on failure
		 */
		public static function approval_details( int $student_id, int $course_id ) {
			global $wpdb;
			$course_id  = sanitize_text_field( $course_id );
			$student_id = sanitize_text_field( $student_id );
			$table      = ( new self() )->get_table();
			return $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * 
					FROM {$table}
						WHERE course_id = %d
						AND student_id = %d
				",
					$course_id,
					$student_id
				)
			);
		}
		/**
		 * Get certificate approvals table name
		 *
		 * @return string table name
		 */
		public function get_table() {
			global $wpdb;
			return $wpdb->prefix . self::CERTIFICATE_APPROVALS_TABLE;
		}

	}

}
