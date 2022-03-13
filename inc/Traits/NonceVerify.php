<?php
/**
 * Nonce verification traits
 *
 * @since v1.0.0
 *
 * @package TutorPeriscopeTraits
 */

namespace Tutor_Periscope\Traits;

trait NonceVerify {

	/**
	 * Verify nonce
	 *
	 * @param string $nonce  nonce for verification.
	 *
	 * @return bool true on success, false and exit on failure
	 */
	public static function verify_nonce( string $nonce ): bool {
		if ( wp_verify_nonce( $nonce, 'tp_nonce' ) ) {
			return true;
		} else {
			return false;
			exit;
		}
	}
}
