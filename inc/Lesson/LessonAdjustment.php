<?php
/**
 * Adjust lesson as Tutor Periscope requirement
 *
 * @package TutorPeriscopeLesson
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Lesson;

/**
 * Handle all lesson adjustment activity
 */
class LessonAdjustment {

	/**
	 * Register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		/**
		 * Add action to Tutor hook to hide manual complete button
		 * Hook name: tutor_lesson/single/after/complete_form
		 * file path: tutor/templates/single/lesson/complete_form.php:34
		 *
		 * @since v1.0.0
		 */
		add_action( 'tutor_lesson/single/after/complete_form', array( __CLASS__, 'hide_lesson_complete_form' ) );

		/**
		 * User previous course content status check
		 * handle ajax request
		 *
		 * @since v1.0.0
		 */
		add_action( 'wp_ajax_tutor_periscope_previous_content_status', array( $this, 'previous_content_status' ) );

	}

	/**
	 * Hide manually complete lesson button
	 *
	 * @since v1.0.0
	 */
	public static function hide_lesson_complete_form() {
		?>
		<script>
			const wrapper = document.querySelector('.tutor-single-lesson-segment.tutor-lesson-complete-form-wrap');
			if (wrapper) {
				wrapper.remove();
			}
		</script>
		<?php
	}

	/**
	 * Check user's previous course content status
	 * handle ajax request
	 *
	 * @since v.1.0.0
	 *
	 * @return void | send wp_json response
	 */
	public function previous_content_status() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$content_id = isset( $_POST['content-id'] ) ? sanitize_text_field( $_POST['content-id'] ) : 0;
			$user_id    = get_current_user_id();
			if ( $content_id ) {
				// get the previous content id from tutor.
				$current_post        = get_post( $content_id );
				$previous_content_id = tutor_utils()->get_course_previous_content_id( $current_post );
				if ( $previous_content_id ) {
					$previous_post            = get_post( $previous_content_id );
					$previous_post_type       = get_post_type( $previous_post );
					$is_complete_prev_content = false;
					if ( 'lesson' === $previous_post_type ) {
						$is_complete_prev_content = tutor_utils()->is_completed_lesson( $previous_post->ID, $user_id );
					}
					if ( 'tutor_quiz' === $previous_post_type ) {
						$is_complete_prev_content = $this->has_attempted_quiz( $user_id, $previous_post->ID );
					}
					if ( 'tutor_assignments' === $previous_post_type ) {
						$is_complete_prev_content = tutor_utils()->is_assignment_submitted( $previous_post->ID, $user_id );
					}
					if ( $is_complete_prev_content ) {
						wp_send_json_success();
					} else {
						wp_send_json_error( array( 'url' => get_permalink( $previous_post->ID ) ) );
					}
				} else {
					// if not previous id then send success.
					wp_send_json_success();
				}
			} else {
				wp_send_json_error( 'Content ID not found' );
			}
		}
	}

	/**
	 * Check a user has attempted a quiz
	 *
	 * @param string $user_id | user that taken course.
	 * @param string $quiz_id | quiz id that need to check wheather attempted or not.
	 * @return bool | true if attempted otherwise false.
	 */
	public function has_attempted_quiz( $user_id, $quiz_id ): bool {
		global $wpdb;
		// Sanitize data
		$user_id   = sanitize_text_field( $user_id );
		$quiz_id   = sanitize_text_field( $quiz_id );
		$attempted = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT quiz_id
				FROM {$wpdb->tutor_quiz_attempts}
				WHERE user_id = %d
					AND quiz_id = %d
			",
				$user_id,
				$quiz_id
			)
		);
		return $attempted ? true : false;
	}
}
