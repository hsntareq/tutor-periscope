<?php
/**
 * Handles setting up initial dependencies
 * 
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Setup;

defined( 'ABSPATH' ) || exit;

/**
 * Setup class
 */
class Setup {

    /**
     * Register
     * 
     * @return void
     */
    public function register() {
        add_action( 'init', array( $this, 'tutor_periscope_language_load' ) );
    }

    /**
     * Activation callback
     *
     * @return void
     */
    public static function tutor_periscope_activated() {
        // Handles stuff at plugin activation.
        do_action( 'tutor_periscope_before_activation' );
        
        $installed_time = get_option( 'tutor_periscope_installed_at' );

        if ( ! $installed_time ) {
            update_option( 'tutor_periscope_installed_at', time() );
        }

        update_option( 'tutor_periscope_version', TUTOR_PERISCOPE_VERSION );

        do_action( 'tutor_periscope_after_activation' );
    }

    /**
     * Load plugin text domain for translation
     */
    public function tutor_periscope_language_load() {
        load_plugin_textdomain( 'tutor-periscope', false, TUTOR_PERISCOPE_DIR_PATH . '/languages' );
    }
}