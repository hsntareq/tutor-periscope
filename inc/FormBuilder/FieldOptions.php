<?php
/**
 * Form options for form fields
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\FormBuilder
 */

namespace Tutor_Periscope\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Static methods to get form field options
 */
class FieldOptions {

	/**
	 * Get compare type field options
	 *
	 * @since v2.0.0
	 *
	 * @return array options.
	 */
	public static function compare_field_options(): array {
		$field_type = 'compare';
		return apply_filters(
			'tutor_periscope_compare_field_options',
			array(
				array(
					'label'      => 1,
					'help_text'  => __( 'Strongly Disagree', 'tutor-periscope' ),
					'value'      => 1,
					'selected'   => false,
					'field_type' => $field_type,
				),
				array(
					'label'      => 2,
					'help_text'  => __( 'Disagree', 'tutor-periscope' ),
					'value'      => 2,
					'selected'   => false,
					'field_type' => $field_type,
				),
				array(
					'label'      => 3,
					'help_text'  => __( 'Neutral', 'tutor-periscope' ),
					'value'      => 3,
					'selected'   => false,
					'field_type' => $field_type,
				),
				array(
					'label'      => 4,
					'help_text'  => __( 'Agree', 'tutor-periscope' ),
					'value'      => 4,
					'selected'   => false,
					'field_type' => $field_type,
				),
				array(
					'label'      => 5,
					'help_text'  => __( 'Strongly Agree', 'tutor-periscope' ),
					'value'      => 5,
					'selected'   => true,
					'field_type' => $field_type,
				),
				array(
					'label'      => __( 'Not Apply', 'tutor-periscope' ),
					'help_text'  => '',
					'value'      => 'Not Apply',
					'selected'   => false,
					'field_type' => $field_type,
				),
			)
		);
	}

	/**
	 * Get voting type field options
	 *
	 * @since v2.0.0
	 *
	 * @return array options.
	 */
	public static function vote_field_options(): array {
		$field_type = 'vote';
		return apply_filters(
			'tutor_periscope_vote_field_options',
			array(
				array(
					'label'      => __( 'Yes', 'tutor-periscope' ),
					'help_text'  => '',
					'value'      => 'Yes',
					'selected'   => true,
					'field_type' => $field_type,
				),
				array(
					'label'      => __( 'No', 'tutor-periscope' ),
					'help_text'  => '',
					'value'      => 'No',
					'selected'   => false,
					'field_type' => $field_type,
				),
				array(
					'label'      => __( 'N/A', 'tutor-periscope' ),
					'help_text'  => '',
					'value'      => 'N/A',
					'selected'   => false,
					'field_type' => $field_type,
				),
			)
		);
	}
}
