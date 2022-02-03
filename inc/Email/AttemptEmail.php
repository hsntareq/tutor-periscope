<?php
/**
 * Attempt email to the admin
 *
 * @package TutorPeriscopeAttemptMail
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Email;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Handle attempt email
 */
class AttemptEmail extends EmailAbstract {

	/**
	 * Email Subject
	 *
	 * @var $subject
	 */
	public $subject;

	/**
	 * To mail to send mail
	 *
	 * @return array | array of emails
	 *
	 * @since v1.0.0
	 */
	public function email_to():array {
		$admin_email = get_option( 'admin_email' );
		return array( $admin_email );
	}

	/**
	 * Email body
	 *
	 * @since v1.0.0
	 */
	public function email_body() {
		$user_data = get_userdata( get_current_user_id() );
		$name = '' !== $user_data->display_name ? $user_data->display_name : $user_data->user_login;
		$message = __( 'A student named: ' . $name . ' and email: ' . $user_data->user_email . ' is out of attempt!' , 'tutor-periscope' );
		return $message;
	}

	/**
	 * Email headers to specify headers
	 *
	 * @return array | header on array formated.
	 *
	 * @since v1.0.0
	 */
	public function email_headers(): array {
		return array( 'Content-Type: text/html; charset=UTF-8' );
	}

}
