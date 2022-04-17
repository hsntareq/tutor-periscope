<?php
/**
 * Manage instructors
 *
 * @package TutorPeriscope\Instructors
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Instructors;

use Tutor_Periscope\Query\DB_Query;
use Tutor_Periscope\Users\Users;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manage multi instructors
 */
class ManageInstructors extends DB_Query {

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
		// update course main instructor.
		add_action( 'wp_ajax_update_main_instructor', array( $this, 'update_main_instructor' ) );
	}

	/**
	 * Get table name
	 *
	 * @return string table name
	 */
	public function get_table() {
		global $wpdb;
		return $wpdb->posts;
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

	public function update_main_instructor() {
		if ( wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {

			if ( current_user_can( 'manage_options' ) ) {
				$instructor_id = sanitize_text_field( $_POST['instructor_id'] );
				$course_id     = sanitize_text_field( $_POST['course_id'] );

				$update = $this->update(
					array(
						'post_author' => $instructor_id,
					),
					array(
						'ID' => $course_id,
					)
				);
				if ( $update ) {
					/**
					 * Need to update user meta as well since
					 * utils method retrieve instructors info by joining
					 * user meta table.
					 */
					update_user_meta(
						$instructor_id,
						'_tutor_instructor_course_id',
						$course_id,
						$course_id
					);
					return wp_send_json_success(
						__( 'Instructor Updated', 'tutor-periscope' )
					);
				} else {
					return wp_send_json_error(
						__( 'Instructor not updated', 'tutor-periscope' )
					);
				}
			} else {
				return wp_send_json_error(
					__( 'Permission denied', 'tutor-periscope' )
				);
			}
		} else {
			return wp_send_json_error(
				__( 'Nonce verification failed', 'tutor-periscope' )
			);
		}
	}
}
