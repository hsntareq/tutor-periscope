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
		return apply_filters(
			'tutor_periscope_compare_field_options',
			array(
				array(
					'label'     => 1,
					'help_text' => __( 'Lowest', 'tutor-periscope' ),
					'value'     => 1,
					'selected'  => false,
				),
				array(
					'label'     => 2,
					'help_text' => '',
					'value'     => 2,
					'selected'  => false,
				),
				array(
					'label'     => 3,
					'help_text' => '',
					'value'     => 3,
					'selected'  => false,
				),
				array(
					'label'     => 4,
					'help_text' => '',
					'value'     => 4,
					'selected'  => false,
				),
				array(
					'label'     => 5,
					'help_text' => __( 'Highest', 'tutor-periscope' ),
					'value'     => 5,
					'selected'  => true,
				),
				array(
					'label'     => __( 'Not Apply', 'tutor-periscope' ),
					'help_text' => '',
					'value'     => 'Not Apply',
					'selected'  => false,
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
		return apply_filters(
			'tutor_periscope_vote_field_options',
			array(
				array(
					'label'     => __( 'Yes', 'tutor-periscope' ),
					'help_text' => '',
					'value'     => 'Yes',
					'selected'  => true,
				),
				array(
					'label'     => __( 'No', 'tutor-periscope' ),
					'help_text' => '',
					'value'     => 'No',
					'selected'  => false,
				),
				array(
					'label'     => __( 'N/A', 'tutor-periscope' ),
					'help_text' => '',
					'value'     => 'N/A',
					'selected'  => false,
				),
			)
		);
	}
}
