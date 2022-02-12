<?php
/**
 * Track user's progress on lesson. Mark complete or store video pause length
 *
 * @since v1.0.0
 *
 * @package TutorPeriscopeLesson
 */

namespace Tutor_Periscope\Lesson;

/**
 * LessonProgress tracking
 */
class LessonProgress {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		// store video time to start again from there.
		add_action( 'wp_ajax_tutor_periscope_store_video_time', array( __CLASS__, 'store_video_time' ) );

		// mark a lesson as complete.
		add_action( 'wp_ajax_tutor_periscope_mark_lesson_complete', array( __CLASS__, 'mark_lesson_complete' ) );

		// check if current lesson is complete.
		add_action( 'wp_ajax_tutor_periscope_is_done_current_lesson', array( __CLASS__, 'is_done_current_lesson' ) );
	}

	/**
	 * Handle ajax request and store video pause time
	 *
	 * @since v1.0.0
	 *
	 * @return void, send json response
	 */
	public static function store_video_time() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$lesson_id = isset( $_POST['lesson_id'] ) ? sanitize_text_field( $_POST['lesson_id'] ) : 0;
			$time      = isset( $_POST['time'] ) ? sanitize_text_field( $_POST['time'] ) : 0;
			if ( $lesson_id ) {
				$meta_key = 'lesson_pause_time_' . $lesson_id;
				do_action( 'before_lesson_pause_time_store', $lesson_id, $time );
				update_user_meta(
					get_current_user_id(),
					$meta_key,
					$time
				);
				do_action( 'after_lesson_pause_time_store', $lesson_id, $time );
				wp_send_json_success();
			} else {
				wp_send_json_error( __( 'Invalid lesson id.', 'tutor-periscope' ) );
			}
		} else {
			wp_send_json_error( __( 'Nonce verification failed.', 'tutor-periscope' ) );
		}
	}

	/**
	 * Handle ajax request, mark lesson as complete
	 *
	 * @return void, send json response
	 */
	public function mark_lesson_complete() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$lesson_id = isset( $_POST['lesson_id'] ) ? sanitize_text_field( $_POST['lesson_id'] ) : 0;
			// remove if it has pause time.
			self::remove_lesson_pause_time( $lesson_id, get_current_user_id() );
			// don't reinvent the wheel, use existing func.
			tutor_utils()->mark_lesson_complete( $lesson_id, get_current_user_id() );
			wp_send_json_success();
		} else {
			wp_send_json_error( __( 'Nonce verification failed.', 'tutor-periscope' ) );
		}
	}

	/**
	 * Get lesson pause time. It will be used to resume from end time.
	 *
	 * @param  int $lesson_id , lesson id.
	 * @param  int $user_id , user id.
	 * @return mixed, string value or false if failed
	 */
	public static function get_lesson_pause_time( int $lesson_id, int $user_id ) {
		return get_user_meta( $user_id, 'lesson_pause_time_' . $lesson_id, true );
	}

	/**
	 * Get lesson pause time. It will be used to resume from end time.
	 *
	 * @param  int $lesson_id , lesson id.
	 * @param  int $user_id , user id.
	 * @return mixed, string value or false if failed
	 */
	public static function remove_lesson_pause_time( int $lesson_id, int $user_id ) {
		return delete_user_meta( $user_id, 'lesson_pause_time_' . $lesson_id );
	}

	/**
	 * Handle ajax request to check if current lesson or quiz
	 * is done or not.
	 *
	 * Basically this post request has next post id
	 * so first need to get the current post id and then check whether it's lesson
	 * or quiz type then check is done or not.
	 *
	 * @since v1.0.0
	 *
	 * @return void  send wp_json response
	 */
	public static function is_done_current_lesson() {
		$is_done = false;
		$message = '';
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			$next_lesson_id = isset( $_POST['next_lesson_id'] ) ? sanitize_text_field( $_POST['next_lesson_id'] ) : 0;
			if ( $next_lesson_id ) {
				/**
				 * Since i have next post id then prev id means the current post
				 * id
				 */
				$current_post_id = tutor_utils()->get_course_previous_content_id( $next_lesson_id );
				$current_post    = get_post( $current_post_id );
				if ( $current_post ) {
					$post_type = get_post_type( $current_post );
					if ( 'lesson' === $post_type ) {
						$is_completed_lesson = tutor_utils()->is_completed_lesson( $current_post->ID );
						if ( $is_completed_lesson ) {
							$is_done = true;
							$message = __( 'Lesson is completed', 'tutor-periscope' );
						} else {
							$message = __( 'Lesson is not completed', 'tutor-periscope' );
						}
					}
					if ( 'tutor_quiz' === $post_type ) {
						$has_attempt = tutor_utils()->quiz_attempts( $current_post->ID, get_current_user_id() );
						if ( $has_attempt ) {
							$is_done = true;
							$message = __( 'Quiz attempt taken', 'tutor-periscope' );
						} else {
							$message = __( 'Quiz attempt not taken', 'tutor-periscope' );
						}
					}
				} else {
					$message = __( 'Invalid post', 'tutor-periscope' );
				}
			} else {
				$message = __( 'Invalid lesson id', 'tutor-periscope' );
			}

			$response = array(
				'done'    => $is_done,
				'message' => $message,
			);
			wp_send_json_success( $response );

		} else {
			wp_send_json_error( __( 'Nonce verify failed', 'tutor-periscope' ) );
		}
	}
}
