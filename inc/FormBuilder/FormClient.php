<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle client interaction with form builder
 */
class FormClient {

	/**
	 * Register hooks.
	 *
	 * @since v2.0.2
	 *
	 * @return void
	 */
	public function __construct() {
		$course_post_type = "courses";
		add_action( "save_post_{$course_post_type}", __CLASS__ . '::manage_form', 10 );
	}

	/**
	 * On save post manage form & fields
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public static function manage_form( int $post_id ) {
		$form = FormBuilder::create( 'Form' );
		$post = $_POST;
		$tp_nonce = TP_NONCE;
		if ( ! wp_verify_nonce( $post[$tp_nonce], TP_NONCE_ACTION ) ) {
			die( __( 'Tutor periscope nonce verification failed', 'tutor-periscope' ) );
		}
	}
}
