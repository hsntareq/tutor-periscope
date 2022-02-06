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

			// don't reinvent the wheel, use existing func.
			tutor_utils()->mark_lesson_complete( $lesson_id, get_current_user_id() );
			wp_send_json_success();
		} else {
			wp_send_json_error( __( 'Nonce verification failed.', 'tutor-periscope' ) );
		}
	}
}
