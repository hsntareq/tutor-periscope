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
		Utilities::verify_nonce();
		$form               = FormBuilder::create( 'Form' );
		$form_field_builder = FormBuilder::create( 'FormField' );
		$post               = $_POST;

		$form_data = array(
			'tutor_course_id'  => $post_id,
			'form_title'       => $post['tp_ef_title'],
			'form_description' => $post['tp_ef_description'],
		);

		if ( isset( $post['tp_ef_id'] ) && '' !== $post['tp_ef_id'] ) {
			$form_data['id'] = $post['tp_ef_id'];
		}

		/**
		 * Note: we assume form->create() will always return true because
		 * if some rows not update
		 * then wpdb::update may provide false and then this method will not
		 * proceed for form fields.
		 */
		$form_id = 0;
		if ( isset( $form_data['id'] ) ) {
			$form->update( $form_data, $form_data['id'] );
			$form_id = $form_data['id'];
			// Delete form fields since it's going to be updated.
			FormField::delete_all_fields_by_form( $form_id );
		} else {
			$form_id = $form->create( $form_data );
		}

		if ( $form_id ) {
			if ( isset( $post['tp_ef_fields'] ) ) {
				foreach ( $post['tp_ef_fields'] as $key => $field ) {
					if ( '' === $field ) {
						continue;
					}
					$data = array(
						'form_id'         => $form_id,
						'tutor_course_id' => $post_id,
						'field_label'     => $field,
						'field_type'      => $post['tp_ef_field_type'][ $key ],
					);
					$form_field_builder->create( $data );
				}
			}
		}

	}

	/**
	 * Get form fields by course id
	 *
	 * @since v2.0.0
	 *
	 * @param int $course_id  course id.
	 *
	 * @return mixed  based on wpdb response
	 */
	public static function get_form_fields( int $course_id ) {
		global $wpdb;
		$course_id    = sanitize_text_field( $course_id );
		$form_table   = ( new Form() )->get_table();
		$fields_table = ( new FormField() )->get_table();
		$response     = $wpdb->get_results(
			$wpdb->prepare(
				" SELECT form.*, field.id AS field_id, field_label, field_type
					FROM {$form_table} AS form
						INNER JOIN {$fields_table} AS field
							ON field.form_id = form.id
					WHERE form.tutor_course_id = %d
				",
				$course_id
			)
		);
		return $response;
	}

	/**
	 * Render evaluation form based on course id
	 * to view on the front-end
	 *
	 * @since v2.0.0
	 *
	 * @param int  $course_id  course id.
	 * @param bool $echo  whether it will echo or return.
	 */
	public static function render_form( int $course_id, $echo = true ) {
		ob_start();
		$template = TUTOR_PERISCOPE_TEMPLATES . 'frontend/evaluation-form-view.php';
		if ( file_exists( $template ) ) {
			tutor_load_template_from_custom_path(
				$template,
				array(
					'data' => self::get_form_fields( $course_id )
				)
			);
			$view = apply_filters( 'tp_evaluation_form_view', ob_get_clean() );
			if ( $echo ) {
				echo $view;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $view;
			}
		}
	}
}
