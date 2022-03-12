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
        add_action('wp_ajax_periscope_user_import', array($this, 'periscope_user_import'));
    }

    public function periscope_user_import(){
        verify_nonce();

		$imported_data = json_decode( wp_unslash( $_POST['bulk_user'] ), true );
        $user_meta = ['user_login','user_email','display_name'];

        $user_data_to_import = [];
        foreach( $imported_data as $imported ) {
            // pr($imported);
            foreach ($imported as $key => $value) {
                if(in_array($key,$user_meta)){
                    $data_to_import[$key]=$value;
                }else{
                    $data_to_import['user_data'][$key]=$value;
                }
            }
            $user_data_to_import [] = $data_to_import;

        }
// pr($user_data_to_import);die;

        $users = array();
        foreach ( $user_data_to_import as $data_import ) {

			$data = array(
				'user_login' => $data_import['user_login'],
				'user_email' => $data_import['user_email'],
				'user_pass'  => $data_import['user_login'],
				'display_name'  => $data_import['display_name'],
			);

			$user_id = wp_insert_user( $data );

			if ( ! is_wp_error( $user_id ) ) {

                foreach($data_import['user_data'] as $meta_key => $user_additional ){
                    add_user_meta( $user_id, '__'.$meta_key, $user_additional);
                }

				$users[] = $user_id;

			}
		}

		wp_send_json(  $users );

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

        $course_id = (int) sanitize_text_field($_POST['assigned_course']);
        $user_ids = $_POST['assigned_user'];
        if(!empty($user_ids)){
            foreach ($user_ids as $key => $user_id) {

                $is_enrolled = tutils()->is_enrolled($course_id, $user_id);

                if ($is_enrolled) {
                    $this->success_msgs = get_tnotice(__('This user has been already enrolled on this course', 'tutor-pro'), 'Error', 'danger');
                } else if (tutils()->is_course_fully_booked($course_id)) {
                    $this->success_msgs = get_tnotice(__('Maximum student is reached!', 'tutor-pro'), 'Error', 'danger');
                } else {
                    $title   = __('Course Enrolled', 'tutor') . ' &ndash; ' . date(get_option('date_format')) . ' @ ' . date(get_option('time_format'));

                    $enroll_data =  array(
                        'post_type'     => 'tutor_enrolled',
                        'post_title'    => $title,
                        'post_status'   => 'completed',
                        'post_author'   => $user_id,
                        'post_parent'   => $course_id,
                    );

                    // Insert the post into the database
                    $is_enrolled = wp_insert_post( $enroll_data );
                    if ($is_enrolled) {
                        do_action('tutor_after_enroll', $course_id, $is_enrolled);

                        // Run this hook for only completed enrollment regardless of payment provider and free/paid mode
                        if ($enroll_data['post_status'] == 'completed') {
                            do_action('tutor_after_enrolled', $course_id, $user_id, $is_enrolled);
                        }

                        //Change the enrol status again. to fire complete hook
                        tutils()->course_enrol_status_change($is_enrolled, 'completed');
                        //Mark Current User as Students with user meta data
                        update_user_meta( $user_id, '_is_tutor_student', tutor_time() );

                        do_action('tutor_enrollment/after/complete', $is_enrolled);
                    }

                    $success_msgs = get_tnotice(__('Enrolment has been done', 'tutor-pro'), 'Success', 'success');
                    set_transient( 'action_message', $success_msgs, 1000 );
                }
            }
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
