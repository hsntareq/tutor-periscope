<?php
/**
 * Utilities
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\Utilities
 */

namespace Tutor_Periscope\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Contains static method for common task.
 */
class Utilities {

	/**
	 * Create nonce field.
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public static function create_nonce_field() {
		wp_nonce_field( TP_NONCE_ACTION, TP_NONCE );
	}

	/**
	 * Verify nonce not it verified then die
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public static function verify_nonce() {
		$tp_nonce = TP_NONCE;
		if ( isset( $_POST[ $tp_nonce ] ) && ! wp_verify_nonce( $_POST[ $tp_nonce ], TP_NONCE_ACTION ) ) {
			die( __( 'Tutor periscope nonce verification failed', 'tutor-periscope' ) );
		}
	}
}
