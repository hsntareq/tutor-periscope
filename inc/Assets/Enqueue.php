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
        wp_enqueue_script( 'tutor-periscope-frontend', TUTOR_PERISCOPE_DIR_URL . '/assets/js/frontend.js', array(), TUTOR_PERISCOPE_VERSION, true );
    }

    /**
     * Enqueue backend assets
     */
    public function enqueue_backend_assets() {

        wp_enqueue_style( 'select2css', TUTOR_PERISCOPE_DIR_URL . '/assets/css/select2.min.css', true, '1.0', 'all' );
        wp_enqueue_style( 'tutor-periscope-backend', TUTOR_PERISCOPE_DIR_URL . '/assets/css/backend.min.css', null, TUTOR_PERISCOPE_VERSION, 'all' );

        wp_enqueue_script( 'select2js', TUTOR_PERISCOPE_DIR_URL . '/assets/js/select2.min.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'tutor-periscope-backend', TUTOR_PERISCOPE_DIR_URL . '/assets/js/backend.js', array( 'jquery' ), TUTOR_PERISCOPE_VERSION, true );
        wp_enqueue_script( 'tutor-periscope-scripts', TUTOR_PERISCOPE_DIR_URL . '/assets/js/tp-scripts.js', array( 'jquery' ), TUTOR_PERISCOPE_VERSION, true );
    }

}