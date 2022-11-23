<?php
/**
 * Manage course meta box
 *
 * @package TutorPeriscope\Course
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Course;

use Tutor_Periscope\Metabox\Metabox;
use Tutor_Periscope\Metabox\MetaboxFactory;
use Tutor_Periscope\Metabox\MetaboxInterface;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * CourseMetabox
 */
class CourseMetabox extends MetaboxFactory {

	const LINEAR_PATH_META_KEY = 'tp_course_linear_path_status';
	const REQ_LOGIN_META_KEY = 'tp_course_req_login_status';
	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
		add_action( 'save_post_courses', array( __CLASS__, 'update_linear_meta' ), 10, 1 );
		add_action( 'save_post_courses', array( __CLASS__, 'update_reqlogin_meta' ), 10, 1 );
	}
	/**
	 * Create meta box
	 *
	 * @return MetaboxInterface
	 */
	public function create_meta_box(): MetaboxInterface {
		return new Metabox(
			'tutor-periscope-linear-path',
			__( 'Linear Path', 'tutor-periscope' ),
			tutor()->course_post_type,
			'side'
		);
		return new Metabox(
			'tutor-periscope-login-required',
			__( 'course enroll login required ', 'tutor-periscope' ),
			tutor()->course_post_type,
			'side'
		);
	}

	/**
	 * Render content
	 *
	 * @return void
	 */
	public function meta_box_view() {
		$status = self::linear_path_status();
		$reqstatus = self::req_login_status();
		?>
		<div class="tutor-periscope-form-group">
			<label>
				<?php esc_html_e( 'Activate the Linear Path: ' ); ?>
				<input type="checkbox" name="tp-linear-status" <?php echo $status ? 'checked' : ''; ?>>
			</label>
		</div>
		<div class="tutor-periscope-form-group">
			<label>
				<?php esc_html_e( 'Activate for enrollment login required: ' ); ?>
				<input type="checkbox" name="tp-reqlogin-status" <?php echo $reqstatus ? 'checked' : ''; ?>>
			</label>
		</div>
		<?php
	}

	/**
	 * Linear path meta status
	 *
	 * @param int $course_id  optional course id.
	 *
	 * @return bool
	 */
	public static function linear_path_status( $course_id = 0 ): bool {
		if ( 0 === $course_id ) {
			$course_id = get_the_ID();
		}
		$status = get_post_meta(
			$course_id,
			self::LINEAR_PATH_META_KEY,
			true
		);
		return $status ? true : false;
	}

	public static function req_login_status( $course_id = 0 ): bool {
		if ( 0 === $course_id ) {
			$course_id = get_the_ID();
		}
		$status = get_post_meta(
			$course_id,
			self::REQ_LOGIN_META_KEY,
			true
		);
		return $status ? true : false;
	}
	/**
	 * Update linear meta
	 *
	 * @param  int $post_id  post id.
	 *
	 * @return void
	 */
	public static function update_linear_meta( int $post_id ) {
		if ( isset( $_POST['tp-linear-status'] ) ) {
			update_post_meta(
				$post_id,
				self::LINEAR_PATH_META_KEY,
				true
			);
		} else {
			update_post_meta(
				$post_id,
				self::LINEAR_PATH_META_KEY,
				false
			);
		}
	}

	public static function update_reqlogin_meta( int $post_id ) {
		if ( isset( $_POST['tp-reqlogin-status'] ) ) {
			update_post_meta(
				$post_id,
				self::REQ_LOGIN_META_KEY,
				true
			);
		} else {
			update_post_meta(
				$post_id,
				self::REQ_LOGIN_META_KEY,
				false
			);
		}
	}
}
