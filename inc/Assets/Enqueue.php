<?php
/**
 * Handles Enqueuing all Assets
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Assets;

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

		// add data to use in js files
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
		return array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'tp_nonce' ),
		);
	}
}
