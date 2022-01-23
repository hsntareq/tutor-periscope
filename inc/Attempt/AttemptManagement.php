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

use Tutor_Periscope\Email\AttemptEmail;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AttemptManagement {

	/**
	 * User assigned attempt key
	 *
	 * @const ASSIGNED_ATTEMPT_KEY
	 */
	const  ASSIGNED_ATTEMPT_KEY = 'tutor_periscope_student_allow_attempt';

	/**
	 * User attempt taken key
	 *
	 * @const ATTEMPT_TAKEN_KEY
	 */
	const  ATTEMPT_TAKEN_KEY = 'tutor_periscope_student_attempt_taken';

	/**
	 * Register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_tutor_periscope_update_attempt', array( __CLASS__, 'tutor_periscope_update_attempt' ) );

		add_action( 'wp_ajax_tutor_periscope_all_student_attempts', array( __CLASS__, 'all_student_attempts' ) );

		/**
		 * Add action after quiz attempt
		 *
		 * @since v1.0.0
		 */
		add_action( 'tutor_quiz/attempt_ended', array( __CLASS__, 'update_attempt_taken' ), 10, 3 );
		add_action( 'tutor_quiz/attempt_ended', array( __CLASS__, 'email_notification' ), 10, 3 );
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
					self::ASSIGNED_ATTEMPT_KEY,
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

	/**
	 * Get all students attempt details to show on student list page
	 *
	 * @return void | send json response.
	 *
	 * @since v1.0.0
	 */
	public static function all_student_attempts() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$students = array();
			if ( function_exists( 'tutor_utils' ) ) {
				$students = tutor_utils()->get_students( 0, 20 );
				if ( is_array( $students ) && count( $students ) ) {
					foreach ( $students as $student ) {
						$student->attempt_details = self::attempt_details( $student->ID );
					}
				}
			}
			wp_send_json_success( $students );
		} else {
			wp_send_json_error( __( 'Nonce verification failed', 'tutor-periscope' ) );
		}
	}

	/**
	 * Get attempt details
	 *
	 * @param int $user_id | user id to get details.
	 *
	 * @return array | details on success, empty array if invalid user.
	 *
	 * @since v1.0.0
	 */
	public static function attempt_details( int $user_id ): array {
		$user_id = sanitize_text_field( $user_id );
		$user    = get_userdata( $user_id );
		if ( $user ) {
			$assigned_attempt = (int) get_user_meta( $user->ID, self::ASSIGNED_ATTEMPT_KEY, true );
			$attempt_taken    = (int) get_user_meta( $user->ID, self::ATTEMPT_TAKEN_KEY, true );
			return array(
				'assigned'  => $assigned_attempt,
				'taken'     => $attempt_taken,
				'remaining' => $assigned_attempt - $attempt_taken,
			);
		}
		return array();
	}

	/**
	 * Update student attempt taken meta after quiz ended
	 * action hook is added on Tutor core:tutor/classes/Quiz.php:469
	 *
	 * @param int $attempt_id | attempt id.
	 * @param int $course_id | course id.
	 * @param int $user_id | student id.
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function update_attempt_taken( $attempt_id, $course_id, $user_id ) {
		$taken_attempt = (int) get_user_meta( $user_id, self::ATTEMPT_TAKEN_KEY, true );
		update_user_meta( $user_id, self::ATTEMPT_TAKEN_KEY, $taken_attempt + 1 );
	}

	/**
	 * If student is out of attempt then send notification to admin
	 * by listening Tutor hook.
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function email_notification( $attempt_id, $course_id, $user_id ) {
		$user_attempt = self::attempt_details( $user_id );
		$remaining_attempt = $user_attempt['assigned'] - $user_attempt['taken'];
		$user_data = get_userdata( $user_id );
		if ( 1 > $remaining_attempt && $user_data ) {
			// send mail.
			$subject = __( 'A student is out of attempt', 'tutor-periscope' );
			$email = new AttemptEmail;
			$email->subject = $subject;
			$email->send_mail();
		}
	}
}
