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
		 * Meta key, course id need to be concat at the end
		 * ex: '_tp_allow_user_to_download_certificate' . $course_id
		 *
		 * @var string
		 */
		const META_KEY = '_tp_allow_user_to_download_certificate';

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
			 * Hook path: tutor-pro/addons/tutor-certificate/classes/Certificate.php
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
					self::META_KEY . $_POST['course_id'],
					sanitize_text_field( $_POST['course_id'] )
				);
				$update ? wp_send_json_success() : wp_send_json_error();
			}
		}

		/**
		 * Filter download button
		 *
		 * @param string $content  content for filtering.
		 *
		 * @return string   filter content
		 */
		public static function filter_download_button( $content ) {
			$user_id   = get_current_user_id();
			$course_id = get_the_ID();
			$post      = get_post( $course );
			if ( $post && 'courses' === $post->post_type ) {
				$is_allowed_download = get_user_meta( $user_id, self::META_KEY . $course_id );
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
	}

}
