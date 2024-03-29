<?php

/**
 * Handles Enqueuing all Assets
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Assets;

use Tutor_Periscope\Attempt\AttemptManagement;
use Tutor_Periscope\Course\CourseMetabox;
use Tutor_Periscope\FormBuilder\Form;
use Tutor_Periscope\FormBuilder\FormField;
use Tutor_Periscope\Lesson\LessonProgress;

defined('ABSPATH') || exit;

/**
 * Enqueue class
 */
class Enqueue
{

	/**
	 * Register
	 */
	public function register()
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_backend_assets'));
		add_filter('tp_stop_public_access', array($this, 'stop_public_access'));
	}

	public function stop_public_access($id)
	{
		return CourseMetabox::req_login_status($id);
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_frontend_assets()
	{
		if (!wp_script_is('tutor-periscope-frontend', 'enqueued')) {
			wp_enqueue_style('tutor-periscope-frontend', TUTOR_PERISCOPE_DIR_URL . '/assets/css/frontend.min.css', null, TUTOR_PERISCOPE_VERSION, 'all');
			wp_enqueue_script('tutor-periscope-frontend', TUTOR_PERISCOPE_DIR_URL . '/assets/js/frontend.js', array('wp-i18n'), TUTOR_PERISCOPE_VERSION, true);

			wp_add_inline_script('tutor-periscope-frontend', 'const tp_data = ' . json_encode($this->inline_script_data()), 'before');
		}
	}

	/**
	 * Enqueue backend assets
	 */
	public function enqueue_backend_assets()
	{
		wp_enqueue_style('tutor-periscope-backend', TUTOR_PERISCOPE_DIR_URL . 'assets/css/backend.min.css', null, TUTOR_PERISCOPE_VERSION, 'all');

		wp_enqueue_script('tutor-periscope-backend', TUTOR_PERISCOPE_DIR_URL . 'assets/js/backend.js', array('jquery', 'wp-i18n'), TUTOR_PERISCOPE_VERSION, true);

		wp_enqueue_style('select2css', TUTOR_PERISCOPE_DIR_URL . 'assets/css/select2.min.css', true, '1.0', 'all');

		wp_enqueue_script('select2js', TUTOR_PERISCOPE_DIR_URL . 'assets/js/select2.min.js', array('jquery'), '1.0', true);

		// add data to use in js files.
		wp_add_inline_script('tutor-periscope-backend', 'const tp_data = ' . json_encode($this->inline_script_data()), 'before');

		if (isset($_GET['page']) && $_GET['page'] == 'tutor-periscope-custom-report') {
			wp_enqueue_script('moment.js', TUTOR_PERISCOPE_DIR_URL . 'assets/js/moment.min.js', array('jquery'), TUTOR_PERISCOPE_VERSION, true);
			wp_enqueue_script('daterangepicker.js', TUTOR_PERISCOPE_DIR_URL . 'assets/js/daterangepicker.min.js', array('jquery'), TUTOR_PERISCOPE_VERSION, true);
			wp_enqueue_style('daterangepicker.css', TUTOR_PERISCOPE_DIR_URL . 'assets/css/daterangepicker.min.css', true, '1.0', 'all');
		}
	}

	/**
	 * Inline script data to use in js files
	 *
	 * @return array
	 *
	 * @since v1.0.0
	 */
	public function inline_script_data(): array
	{
		$id              = get_the_ID();
		$user_id         = get_current_user_id();
		$post_type       = get_post_type($id);
		$has_lesson_time = false;
		if ('lesson' === $post_type) {
			// get if this user has pause lesson.
			$has_lesson_time = LessonProgress::get_lesson_pause_time($id, $user_id);
		}

		/**
		 * Determine if need to show evaluation form to user
		 *
		 * @since v1.0.0
		 */
		$tutor_course_id             = 0;
		$should_show_evaluation_form = false;
		if ('tutor_quiz' === $post_type) {
			$topic           = get_post_parent(get_post($id));
			$course          = get_post_parent($topic);
			$tutor_course_id = $course->ID;
			$last_attempt    = AttemptManagement::get_last_attempt($id, $user_id);
			if ($last_attempt) {
				$earned_percentage = $last_attempt->earned_marks > 0 ? (number_format(($last_attempt->earned_marks * 100) / $last_attempt->total_marks)) : 0;
				$passing_grade     = (int) tutor_utils()->get_quiz_option($last_attempt->quiz_id, 'passing_grade', 0);

				// if user pass & not already submitted then show evaluation form.
				$already_evaluated = get_user_meta(
					$user_id,
					'tp_user_evaluated_course_' . $course->ID,
					true
				);
				if ($earned_percentage >= $passing_grade && !$already_evaluated && Form::course_has_form($tutor_course_id)) {
					$should_show_evaluation_form = true;
				}
			}
		}

		if ('lesson' === $post_type) {
			$topic           = get_post_parent(get_post($id));
			$course          = get_post_parent($topic);
			$tutor_course_id = $course->ID;
		}
		$admin_page       = isset($_GET['page']) && is_admin() ? $_GET['page'] : '';
		$user_attempts    = AttemptManagement::attempt_details($user_id);

		$has_quiz_attempt = isset($user_attempts['remaining']) && (int) $user_attempts['remaining'] > 0 ? true : false;

		$data = array(
			'url'                         => admin_url('admin-ajax.php'),
			'nonce'                       => wp_create_nonce('tp_nonce'),
			'has_lesson_time'             => $has_lesson_time,
			'should_show_evaluation_form' => $should_show_evaluation_form,
			'tutor_course_id'             => $tutor_course_id,
			'current_post_id'             => $id,
			'current_post_type'           => $post_type,
			'linear_path'                 => CourseMetabox::linear_path_status($tutor_course_id),
			'admin_page'                  => $admin_page,
			'has_quiz_attempt'            => (bool) $has_quiz_attempt,
			'field_types'                 => FormField::field_types(),
		);

		/**
		 * Add inline css for video player
		 * if linear path on the hide video progress control.
		 */

		$meta_key = '_tutor_completed_lesson_id_' . $id;
		$lesson_status = get_user_meta($user_id, $meta_key, true);

		if ($data['linear_path'] && !$lesson_status) {
			$custom_css = '
			.plyr__progress{
				pointer-events: none;
			}';
			wp_add_inline_style('tutor-periscope-frontend', $custom_css);
		}

		return apply_filters('tutor_periscope_inline_style_data', $data);
	}
}
