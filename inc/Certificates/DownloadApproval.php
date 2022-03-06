<?php
/**
 * Approval download certificate
 *
 * @since v1.0.0
 *
 * @package TutorPeriscopeCertificate
 */

namespace Tutor_Periscope\Certificates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DownloadApproval' ) ) {

	/**
	 * DownloadApproval
	 */
	class DownloadApproval {

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
				$update = update_user_meta(
					sanitize_text_field( $_POST['user_id'] ),
					'_tp_allow_user_to_download_certificate' . $_POST['course_id'],
					sanitize_text_field( $_POST['course_id'] )
				);
				$update ? wp_send_json_success() : wp_send_json_error();
			}
		}
	}
}
