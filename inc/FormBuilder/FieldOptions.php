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
		return array(
			'option' => array(
				'label'     => 1,
				'help_text' => __( 'Lowest', 'tutor_periscope' ),
				'value'     => 1,
			),
			'option' => array(
				'label'     => 2,
				'help_text' => '',
				'value'     => 2,
			),
			'option' => array(
				'label'     => 3,
				'help_text' => '',
				'value'     => 3,
			),
			'option' => array(
				'label'     => 4,
				'help_text' => '',
				'value'     => 4,
			),
			'option' => array(
				'label'     => 5,
				'help_text' => __( 'Highest', 'tutor_periscope' ),
				'value'     => 5,
			),
			'option' => array(
				'label'     => __( 'Not Apply', 'tutor-periscope' ),
				'help_text' => '',
				'value'     => 'Not Apply',
			),
		);
	}
}
