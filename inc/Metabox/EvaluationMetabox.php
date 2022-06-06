<?php
/**
 * Initialize evaluation meta  box on course post
 *
 * @package TutorPeriscope\Metabox
 *
 * @since v2.0.0
 */

namespace Tutor_Periscope\Metabox;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Evaluation form meta box
 */
class EvaluationMetabox extends MetaboxFactory {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
	}

	/**
	 * Create new meta box, implementation of abstract method
	 *
	 * @since v2.0.0
	 *
	 * @return MetaboxInterface
	 */
	public function create_meta_box(): MetaboxInterface {
		return new Metabox(
			'tp-evaluation-form',
			__( 'Create Evaluation Form', 'tutor-periscope' ),
			tutor()->course_post_type,
			'advanced',
			'low'
		);
	}

	/**
	 * Meta box view
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function meta_box_view() {
		$template = TUTOR_PERISCOPE_TEMPLATES . 'backend/evaluation-form.php';
		if ( file_exists( $template ) ) {
			tutor_load_template_from_custom_path(
				$template
			);
		}
	}
}
