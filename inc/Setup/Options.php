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
		add_filter('tutor/options/attr', array($this, 'add_options'), 10);
	}

	public function add_options($attr){
		$attr['periscope'] = array(
			'label'     => __('Periscope Option', 'tutor-pro'),
			'sections'    => array(
				'general' => array(
					'label' => __('Course Single Page', 'tutor-pro'),
					'desc' => __('Enable Disable Option to on/off notification on various event', 'tutor-pro'),
					'fields' => array(
						'periscope_remove_free' => array(
							'type'          => 'checkbox',
							'label'         => __('Free Text of course item', 'tutor-pro'),
							'label_title'   => __('Remove Free Text', 'tutor-pro'),
							'default' 		=> '0',
							'desc'          => __('Enable this to show free text under course enrollment button of single course item.', 'tutor-pro') ,
						),
					),
				),
				'certificate' => array(
					'label' => __('Certificate Additional', 'tutor-pro'),
					'desc' => __('This area is for additional settings of certificate', 'tutor-pro'),
					'fields' => array(
						'periscope_owner_name' => array(
							'type'          => 'text',
							'label'         => __('Owner\'s Name', 'tutor-pro'),
							'label_title'   => __('Write the name of the owner for certificate section', 'tutor-pro'),
							'default' 		=> '0',
							'desc'          => __('This owner\'s name will appear in the signature section of the certificate.', 'tutor-pro') ,
						),
						'periscope_owner_title' => array(
							'type'          => 'text',
							'label'         => __('Owner\'s Title', 'tutor-pro'),
							'label_title'   => __('Write the title of the owner for certificate section', 'tutor-pro'),
							'default' 		=> 'Periscope Founder, CEO0',
							'desc'          => __('This owner\'s title will appear in the signature section of the certificate.', 'tutor-pro') ,
						),
						'periscope_owner_address' => array(
							'type'          => 'text',
							'label'         => __('Owner\'s Address', 'tutor-pro'),
							'label_title'   => __('Write the address of the owner for certificate section', 'tutor-pro'),
							'default' 		=> '1633 Westlake Avenue North, Suite 200, Seattle, WA 98109',
							'desc'          => __('This owner\'s title will appear in the signature section of the certificate.', 'tutor-pro') ,
						),
						'periscope_owner_email' => array(
							'type'          => 'text',
							'label'         => __('Owner\'s Email', 'tutor-pro'),
							'label_title'   => __('Write the email of the owner for certificate section', 'tutor-pro'),
							'default' 		=> 'admin@sitedomain.com',
							'desc'          => __('This owner\'s title will appear in the signature section of the certificate.', 'tutor-pro') ,
						),
					),
				),
			),
		);

		return $attr;
	}

}
