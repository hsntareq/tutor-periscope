<?php
/**
 * Manage instructors
 *
 * @package TutorPeriscope\Instructors
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Instructors;

use Tutor_Periscope\Users\Users;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manage multi instructors
 */
class ManageInstructors {

	/**
	 * Hold instructors list
	 *
	 * @var mixed
	 */
	public $instructors;

	/**
	 * Role
	 *
	 * @var string
	 */
	protected $role = 'tutor_instructor';

	/**
	 * Number to retrieve instructor
	 *
	 * @var $number
	 */
	protected $number = -1;

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'tutor_periscope_before_instructor_meta_box', array( $this, 'main_instructor_view' ) );
	}

	/**
	 * Instructor meta box for showing main author of this course
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public function main_instructor_view() {
		// $instructors var will used from view file.
		$instructors = $this->get_instructors();
		$view        = TUTOR_PERISCOPE_VIEWS . 'metabox/instructor.php';
		if ( file_exists( $view ) ) {
			include $view;
		}
	}

	/**
	 * Get instructor list
	 *
	 * @return object
	 */
	public function get_instructors(): object {
		$args                     = array(
			'role'   => $this->role,
			'number' => $this->number,
		);
		return $this->instructors = Users::get( $args );
	}
}
