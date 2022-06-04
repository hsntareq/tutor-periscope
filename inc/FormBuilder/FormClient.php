<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

use Tutor_Periscope\Utilities\Utilities;

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
		$course_post_type = 'courses';
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

		Utilities::verify_nonce();
		$form_data = array(
			'tutor_course_id'  => $post_id,
			'form_title'       => $post['tp_ef_title'],
			'form_description' => $post['tp_ef_description'],
		);

		$form_fields = array();
		if ( isset( $post['tp_ef_fields'] ) ) {
			foreach ( $post['tp_ef_fields'] as $key => $field ) {
				$data = array(
					'form_id'         => '',
					'tutor_course_id' => $post_id,
					'field_label'     => $field,
					'field_type'      => '',
				);
				array_push( $form_fields, $data );
			}
		}

		echo '<pre>';
		print_r( $form_fields );
		exit;
	}
}
