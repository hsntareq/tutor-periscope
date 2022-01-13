<?php
/**
 * Student course evaluation
 *
 * @package StudentCourseEvaluation
 */
namespace Tutor_Periscope\Evaluation;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Course_Evaluation {

    /**
     * Handle dependencies hooks
     */
    public function __construct() {
        /**
         * Do action hook added
         * file path: tutor/templates/single/course/review-form.php:33
         *
         * Add custom fields
         */
        add_action( 'tutor_before_rating_textarea', array(
            __CLASS__,
            'tutor_before_rating_textarea'
        ) );
    }

    /**
     * Load student course evaluation template
     *
     * @return void
     *
     * @since v1.0.0
     */
    public static function tutor_before_rating_textarea() {
        /**
         * Load course evaluation template facilitating 
         * Tutor function
         */
        tutor_load_template_from_custom_path(
            TUTOR_PERISCOPE_DIR_PATH . 'templates/frontend/course-evaluation.php'
        );
    }
}
