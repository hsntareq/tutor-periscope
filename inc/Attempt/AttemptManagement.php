<?php
/**
 * Student attempt management.
 *
 * Assign attempt, update, remove all operation will done from here.
 *
 * @package TutorPeriscopeAttemptManagement
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Attempt;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AttemptManagement {

	/**
	 * Register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_tutor_periscope_update_attempt', array( __CLASS__, 'tutor_periscope_update_attempt' ) );
	}

	/**
	 * Add user meta. Allow user to attempt quiz by the assign value.
	 *
	 * @return void | send wp_json response.
	 *
	 * @since v1.0.0
	 */
	public static function tutor_periscope_update_attempt() {
		$post = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$_POST
		);
		if ( wp_verify_nonce( $post['nonce'], 'tp_nonce' ) ) {
			$user_data = get_user_by( 'email', $post['user_email'] );
			if ( $user_data ) {
				$update = update_user_meta(
					$user_data->ID,
					'tutor_periscope_student_allow_attempt',
					$post['attempt']
				);
				if ( $update ) {
					wp_send_json_success();
				} else {
					wp_send_json_error();
				}
			} else {
				wp_send_json_error( __( 'Invalid user', 'tutor-periscope' ) );
			}
		} else {
			wp_send_json_error( __( 'Nonce verification failed', 'tutor-periscope' ) );
		}
	}
}
