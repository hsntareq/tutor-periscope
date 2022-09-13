<?php
/**
 * Handles registering admin pages
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Setup;

defined( 'ABSPATH' ) || exit;

/**
 * Options class
 */
class Options {

	/**
	 * Register
	 */
	public function register() {
		add_filter( 'tutor/options/attr', array( $this, 'add_options' ), 10 );
	}

	public function add_options( $attr ) {

		$attr['periscope'] = array(
			'label'    => __( 'Periscope', 'tutor' ),
			'slug'     => 'gradebook',
			'desc'     => __( 'Gradebook Settings', 'tutor-pro' ),
			'template' => 'basic',
			'icon'     => 'tutor-icon-gear',
			'blocks'   => array(
				array(
					'slug'       => 'certificate_options_page',
					'label'      => __( 'Certificate Options', 'tutor-pro' ),
					'block_type' => 'uniform',
					'desc'       => __( 'Enable Disable Option to on/off notification on various event', 'tutor-pro' ),
					'fields'     => array(
						array(
							'key'         => 'periscope_certificate_logo',
							'type'        => 'upload_full',
							'label'       => __( 'Add Certificate Logo', 'tutor' ),
							'desc'        => __( 'Upload logo for periscope certificate only.', 'tutor' ),
						),
					),
				),
				array(
					'slug'       => 'course_single_page',
					'label'      => __( 'Course Single Page', 'tutor-pro' ),
					'block_type' => 'uniform',
					'desc'       => __( 'Enable Disable Option to on/off notification on various event', 'tutor-pro' ),
					'fields'     => array(
						array(
							'key'         => 'periscope_remove_free',
							'type'        => 'toggle_switch',
							'label'       => __( 'Free Text of course item', 'tutor' ),
							'label_title' => __( 'Remove Free Text', 'tutor' ),
							'default'     => 'off',
							'desc'        => __( 'Enable this to show free text under course enrollment button of single course item.', 'tutor' ),
						),
					),
				),
				array(
					'slug'       => 'report_info',
					'label'      => __( 'Report Info', 'tutor-pro' ),
					'block_type' => 'uniform',
					'desc'       => __( 'This area is for additional settings of evaluation report', 'tutor-pro' ),
					'fields'     => array(
						array(
							'key'         => 'periscope_provider_name',
							'type'        => 'text',
							'label'       => __( 'Providers\'s Name', 'tutor' ),
							'label_title' => __( 'Write the name of the provider for evaluation report', 'tutor-pro' ),
							'default'     => 'Periscope 360',
							'desc'        => __( 'This providers\'s name will  be appeared in the evaluation form report.', 'tutor' ),
						),
					),
				),
				array(
					'slug'       => 'certificate',
					'label'      => __( 'Certificate Additional', 'tutor-pro' ),
					'block_type' => 'uniform',
					'desc'       => __( 'This area is for additional settings of certificate', 'tutor-pro' ),
					'fields'     => array(
						array(
							'key'         => 'periscope_owner_name',
							'type'        => 'text',
							'label'       => __( 'Owner\'s Name', 'tutor' ),
							'label_title' => __( 'Write the name of the owner for certificate section', 'tutor-pro' ),
							'default'     => '',
							'desc'        => __( 'This owner\'s name will appear in the signature section of the certificate.', 'tutor' ),
						),
						array(
							'key'         => 'periscope_owner_title',
							'type'        => 'text',
							'label'       => __( 'Owner\'s Title', 'tutor' ),
							'label_title' => __( 'Write the title of the owner for certificate section', 'tutor-pro' ),
							'default'     => '',
							'desc'        => __( 'This owner\'s title will appear in the signature section of the certificate.', 'tutor' ),
						),
						array(
							'key'         => 'periscope_owner_address',
							'type'        => 'text',
							'label'       => __( 'Owner\'s Address', 'tutor' ),
							'label_title' => __( 'Write the address of the owner for certificate section', 'tutor-pro' ),
							'default'     => '',
							'desc'        => __( 'This owner\'s address will appear in the signature section of the certificate.', 'tutor' ),
						),
						array(
							'key'         => 'periscope_owner_email',
							'type'        => 'text',
							'label'       => __( 'Owner\'s Email', 'tutor' ),
							'label_title' => __( 'Write the email of the owner for certificate section', 'tutor-pro' ),
							'default'     => '',
							'desc'        => __( 'This owner\'s email will appear in the signature section of the certificate.', 'tutor' ),
						),
					),
				),
			),
		);

		return $attr;
	}

}
