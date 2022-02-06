<?php
/**
 * Handles Enqueuing all Assets
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Assets;

use Tutor_Periscope\Lesson\LessonProgress;

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue class
 */
class Enqueue {

	/**
	 * Register
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_assets' ) );
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_frontend_assets() {
		wp_enqueue_style( 'tutor-periscope-frontend', TUTOR_PERISCOPE_DIR_URL . '/assets/css/frontend.min.css', null, TUTOR_PERISCOPE_VERSION, 'all' );
		wp_enqueue_script( 'tutor-periscope-frontend', TUTOR_PERISCOPE_DIR_URL . '/assets/js/frontend.js', array( 'wp-i18n' ), TUTOR_PERISCOPE_VERSION, true );

		// add data to use in js files
		wp_add_inline_script( 'tutor-periscope-frontend', 'const tp_data = ' . json_encode( $this->inline_script_data() ), 'before' );
	}

	/**
	 * Enqueue backend assets
	 */
	public function enqueue_backend_assets() {
		wp_enqueue_style( 'tutor-periscope-backend', TUTOR_PERISCOPE_DIR_URL . '/assets/css/backend.min.css', null, TUTOR_PERISCOPE_VERSION, 'all' );

		wp_enqueue_script( 'tutor-periscope-backend', TUTOR_PERISCOPE_DIR_URL . '/assets/js/backend.js', array( 'jquery', 'wp-i18n' ), TUTOR_PERISCOPE_VERSION, true );

		wp_enqueue_style( 'select2css', TUTOR_PERISCOPE_DIR_URL . '/assets/css/select2.min.css', true, '1.0', 'all' );

		wp_enqueue_script( 'select2js', TUTOR_PERISCOPE_DIR_URL . '/assets/js/select2.min.js', array( 'jquery' ), '1.0', true );

		wp_enqueue_script( 'tutor-periscope-scripts', TUTOR_PERISCOPE_DIR_URL . '/assets/js/tp-scripts.js', array( 'jquery' ), TUTOR_PERISCOPE_VERSION, true );

		// add data to use in js files.
		wp_add_inline_script( 'tutor-periscope-backend', 'const tp_data = ' . json_encode( $this->inline_script_data() ), 'before' );
	}

	/**
	 * Inline script data to use in js files
	 *
	 * @return array
	 *
	 * @since v1.0.0
	 */
	public function inline_script_data(): array {
		$id              = get_the_ID();
		$user_id         = get_current_user_id();
		$post_type       = get_post_type( $id );
		$has_lesson_time = false;
		if ( 'lesson' === $post_type ) {
			// get if this user has pause lesson.
			$has_lesson_time = LessonProgress::get_lesson_pause_time( $id, $user_id );
		}
		$data = array(
			'url'             => admin_url( 'admin-ajax.php' ),
			'nonce'           => wp_create_nonce( 'tp_nonce' ),
			'has_lesson_time' => $has_lesson_time,
		);
		return apply_filters( 'tutor_periscope_inline_script_data', $data );
	}
}

