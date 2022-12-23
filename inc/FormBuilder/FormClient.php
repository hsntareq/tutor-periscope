<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

use Tutor_Periscope\Database\EvaluationForm;
use Tutor_Periscope\Database\EvaluationFormFields;
use Tutor_Periscope\Query\QueryHelper;
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
		/**
		 * Dynamically load evaluation form modal.
		 *
		 * @since v2.0.0
		 */
		add_action( 'wp_ajax_tp_evaluation_form', __CLASS__ . '::evaluation_modal' );
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
		global $wpdb;

		$form               = FormBuilder::create( 'Form' );
		$form_field_builder = FormBuilder::create( 'FormField' );
		$post               = $_POST;

		$form_data = array(
			'tutor_course_id'  => $post_id,
			'form_title'       => $post['tp_ef_title'] ?? '',
			'form_description' => $post['tp_ef_description'] ?? '',
			'media_name'       => $post['tp_ef_media_name'] ?? '',
			'media_url'        => $post['tp_ef_media_url'] ?? '',
			'con_ed'           => $post['tp_ef_con_ed'] ?? '',
			'heading'          => $post['tp_ef_heading'] ?? '',
		);

		if ( isset( $post['tp_ef_id'] ) && (int) $post['tp_ef_id'] ) {
			$form_data['id'] = (int) $post['tp_ef_id'];
		} else {
			// Check DB if this post has form to prevent duplicate form.
			$get_form = QueryHelper::get_one(
				$wpdb->prefix . EvaluationForm::get_table(),
				array(
					'tutor_course_id' => $post_id
				)
			);
			if ( $get_form ) {
				$form_data['id'] = $get_form->id;
			}
		}

		/**
		 * Note: we assume form->create() will always return true because
		 * if some rows not update
		 * then wpdb::update may provide false and then this method will not
		 * proceed for form fields.
		 */
		$form_id               = 0;
		$already_submitted_ids = array();
		if ( isset( $form_data['id'] ) ) {
			$form->update( $form_data, $form_data['id'] );
			$form_id = $form_data['id'];

			// Check if field has submitted data.
			$fields_id = $_POST['ep_ef_fields_id'];
			$fields_id = is_array( $fields_id ) && count( $fields_id ) ? implode( ',', $fields_id ) : '';

			$already_submitted_ids = $form_field_builder->get_all_feedback_id( $fields_id );
			$already_submitted_ids = array_column( $already_submitted_ids, 'field_id' );

			// Delete form fields since it's going to be updated.
			$already_submitted_ids_string = is_array( $already_submitted_ids ) && count( $already_submitted_ids ) ? implode( ',', $already_submitted_ids ) : '';

			// Delete fields that don't has data, to prevent duplicate entries.
			if ( '' !== $already_submitted_ids_string ) {
				FormField::delete_none_submitted_fields( $already_submitted_ids_string );
			} else {
				FormField::delete_all_fields_by_form( $form_id );
			}
		} else {
			$form_id = $form->create( $form_data );
		}

		if ( $form_id ) {
			if ( isset( $post['tp_ef_fields'] ) ) {
				$field_data = array();
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
					array_push( $field_data, $data );
				}

				if ( count( $field_data ) > 1 ) {
					$form_field_builder->create_multiple( $field_data );
					$form_field_builder->create_default_input_fields( $form_id );
				} else {
					if ( count( $field_data ) ) {
						$form_field_builder->create( $field_data[0] );
						do_action( 'tutor_periscope_after_single_question_create', $form_id, $field_data );
					}
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
		$course_id      = sanitize_text_field( $course_id );
		$form_table     = ( new Form() )->get_table();
		$fields_table   = ( new FormField() )->get_table();
		$feedback_table = ( new Feedback() )->get_table();
		$response       = $wpdb->get_results(
			$wpdb->prepare(
				" SELECT
					form.*,
					field.id AS field_id,
					field_label,
					field_type,
				(
					SELECT
						id
					FROM {$feedback_table}
					WHERE field_id = field.id
					LIMIT 1
				) AS feedback_id
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
	 * Render evaluation form and send json response
	 *
	 * @since v2.0.0
	 */
	public static function evaluation_modal() {
		Utilities::verify_nonce();

		$course_id = (int) sanitize_text_field( $_POST['course_id'] ); //phpcs:ignore
		$modal     = self::render_form( $course_id, false );
		$response  = array( 'template' => $modal );
		wp_send_json_success( $response );
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
					'data' => self::get_form_fields( $course_id ),
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
