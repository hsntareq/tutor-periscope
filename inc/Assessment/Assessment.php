<?php
/**
 * Handles defining assessment method rules
 * 
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Assessment;

defined( 'ABSPATH' ) || exit;

/**
 * Assessment class
 */
class Assessment {

    /**
     * Register
     */
    public function register() {
        add_action( 'tutor_quiz_edit_modal_settings_tab_after', array( $this, 'additional_quiz_feedback_mode' ), 10, 1 );
    }

    /**
     * Additional quiz feedback mode
     */
    public function additional_quiz_feedback_mode( $quiz ) {
        periscope_additional_quiz_feedback_template( $quiz->ID );
	}
}