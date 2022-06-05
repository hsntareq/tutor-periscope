<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

use Tutor_Periscope\Query\DB_Query;
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
		Utilities::verify_nonce();
		$form = FormBuilder::create( 'Form' );

		$post = $_POST;

		$form_data = array(
			'tutor_course_id'  => $post_id,
			'form_title'       => $post['tp_ef_title'],
			'form_description' => $post['tp_ef_description'],
		);

		if ( isset( $post['tp_ef_id'] ) && '' !== $post['tp_ef_id'] ) {
			$form_data['tp_ef_id'] = $post['tp_ef_id'];
		}

		/**
		 * Note: we assume form->create() will always return true because
		 * if some rows not update
		 * then wpdb::update may provide false and then this method will not
		 * proceed for form fields.
		 */
		$form_id = 0;
		if ( isset( $form_data['tp_ef_id'] ) ) {
			$form->update( $form_data, $form_data['tp_ef_id'] );
			$form_id = $form_data['tp_ef_id'];
		} else {
			$form_id = $form->create( $form_data );
		}

		if ( $form_id ) {
			if ( isset( $post['tp_ef_fields'] ) ) {
				foreach ( $post['tp_ef_fields'] as $key => $field ) {
					$data = array(
						'form_id'         => $form_id,
						'tutor_course_id' => $post_id,
						'field_label'     => $field,
						'field_type'      => 'compare',
					);
					$form_field_builder = FormBuilder::create( 'FormField');
					$form_field_builder->create( $data );
				}
			}
		}

	}
}
