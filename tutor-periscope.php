<?php
/**
 * Plugin Name: Tutor Periscope
 * Plugin URI: https://www.periscope365.com/
 * Description: This plugin is to add <code><em>Custom Certificate</em></code>, <code>Complaints process</code>, <code>Attendance collection</code>, <code>Assessment method</code>, <code>Faculty selecting criteria</code>, <code>Refund policy deployment</code> for <a href="//periscope365.com">periscope365.com</a>
 * Author: Hasan Tareq
 * Version: 1.0.0
 * Author URI: https://hsntareq.github.io/
 * Requires at least: 5.3
 * Tested up to: 5.8
 * Text Domain: tutor-periscope
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Plugin specific definitions.
define( 'TUTOR_PERISCOPE_VERSION', '1.0.0' );
define( 'TUTOR_PERISCOPE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'TUTOR_PERISCOPE_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Require autoload.
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

register_activation_hook( __FILE__, array( '\Tutor_Periscope\Setup\Setup', 'tutor_periscope_activated' ) );

// Initiate the main class.
if ( class_exists( 'Tutor_Periscope\\Init' ) ) :
	$tutor_periscope = new Tutor_Periscope\Init();
	$tutor_periscope->register_services();
endif;
