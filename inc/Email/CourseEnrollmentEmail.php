<?php
/**
 * Send email to the students after enrollment
 *
 * @package TutorPeriscopeEnrollmentEmail
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Email;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Handle enrollment email
 */
class CourseEnrollmentEmail extends EmailAbstract {

	/**
	 * Email Subject
	 *
	 * @var $subject
	 */
	public $subject;

	/**
	 * Holds enrollments data
	 *
	 * @var mixed
	 */
	protected $enrollments;

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		$this->subject = __( 'Enrollment Success', 'tutor-periscope' );
		add_action( 'tutor_enrollment/after/complete', array( $this, 'after_enrollment' ), 10, 2 );
	}

	/**
	 * To mail to send mail
	 *
	 * @since v1.0.0
	 */
	public function email_to() {
		$email_to = '';

		if ( is_array( $this->enrollments ) && isset( $this->enrollments['post_author'] ) ) {
			$user_id   = $this->enrollments['post_author'];
			$user_data = get_userdata( $user_id );
			if ( is_a( $user_data, 'WP_User' ) ) {
				$email_to = $user_data->user_email;
			}
		}
		return $email_to;
	}

	/**
	 * Email body
	 *
	 * @since v1.0.0
	 */
	public function email_body() {
		$course_id = '';
		$message   = '';
		// if has course id index.
		if ( is_array( $this->enrollments ) && isset( $this->enrollments['post_parent'] ) ) {
			$course_id = $this->enrollments['post_parent'];
		}
		if ( '' !== $course_id ) {
			$message = __( 'You are successfully enrolled on this: ' . \get_the_title( $course_id ) . ' course!', 'tutor-periscope' );
		}
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


	/**
	 * Handle hook, set enrollment props & then send email
	 *
	 * @param array $enrollments  array containing enrollments info.
	 *
	 * @return void
	 */
	public function after_enrollment( $is_enrolled, array $enrollments ) {
		if ( $is_enrolled ) {
			$this->enrollments = $enrollments;
			$this->send_mail();
		}
	}
}
