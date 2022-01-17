<?php

/**
 * Handles defining assessment method rules
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Assessment;

defined('ABSPATH') || exit;

/**
 * Assessment class
 */
class Assessment
{

    /**
     * Register
     */
    public function register()
    {
        add_action('tutor_quiz_edit_modal_settings_tab_after', array($this, 'additional_quiz_feedback_mode'), 10, 1);
        add_action('admin_init', array($this, 'handle_assessment_form'));
    }

    /**
     * Handle the Course Evaluation new and edit form
     *
     * @return void
     */
    public function handle_assessment_form()
    {
        if (!isset($_POST['submit_assignment'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['_wpnonce'], 'tutor_periscope_nonce')) {
            die(__('Are you cheating?', 'tutor-periscope'));
        }
        if (!current_user_can('read')) {
            wp_die(__('Permission Denied!', 'tutor-periscope'));
        }

        $course_id = sanitize_text_field($_POST['assigned_course']);
        $user_ids = $_POST['assigned_user'];

        print_r($user_ids);
        die;
        $user_id = $this->get_user_id($user_id);
        $title   = __('Course Enrolled', 'tutor') . ' &ndash; ' . date(get_option('date_format')) . ' @ ' . date(get_option('time_format'));

        if ($course_id && $user_id) {
            if ($this->is_enrolled($course_id, $user_id)) {
                return;
            }
        }

        $enrolment_status = 'completed';

        if ($this->is_course_purchasable($course_id)) {
            /**
             * We need to verify this enrollment, we will change the status later after payment confirmation
             */
            $enrolment_status = 'pending';
        }

        $enroll_data = array(
            'post_type'   => 'tutor_enrolled',
            'post_title'  => $title,
            'post_status' => $enrolment_status,
            'post_author' => $user_id,
            'post_parent' => $course_id,
        );

        // Insert the post into the database
        $isEnrolled = wp_insert_post($enroll_data);
        if ($isEnrolled) {

            print_r($_REQUEST);
        }
    }
    /**
     * Additional quiz feedback mode
     */
    public function additional_quiz_feedback_mode($quiz)
    {
        periscope_additional_quiz_feedback_template($quiz->ID);
    }
}
