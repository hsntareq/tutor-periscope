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
			),
		);

		return $attr;
	}

}
