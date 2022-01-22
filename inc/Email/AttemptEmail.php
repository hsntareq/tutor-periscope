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
	protected $subject;

	/**
	 * Set property && hook and other dependency
	 *
	 * @param string $sub | set subject of email.
	 *
	 * @since v1.0.0
	 */
	public function __construct( string $sub ) {
		$this->subject = $sub;
	}

	/**
	 * To mail to send mail
	 *
	 * @return array | array of emails
	 *
	 * @since v1.0.0
	 */
	public function email_to():array {
		$admin_email = get_option( 'admin_email' );
		return array( 'shewa12kpi@gmail.com' );
	}

	/**
	 * Email body
	 *
	 * @since v1.0.0
	 */
	public function email_body() {
		return 'Hello World';
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
