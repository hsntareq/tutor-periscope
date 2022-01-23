<?php
/**
 * Adjust lesson as Tutor Periscope requirement
 *
 * @package TutorPeriscopeLesson
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Lesson;

/**
 * Handle all lesson adjustment activity
 */
class LessonAdjustment {

    /**
     * Register hooks
     *
     * @since v1.0.0
     */
    public function __construct()
    {
        /**
         * Add action to Tutor hook to hide manual complete button
         * Hook name: tutor_lesson/single/after/complete_form
         * file path: tutor/templates/single/lesson/complete_form.php:34
         *
         * @since v1.0.0
         */
        add_action( 'tutor_lesson/single/after/complete_form', array( __CLASS__, 'hide_lesson_complete_form' ) );

    }

    /**
     * Hide manually complete lesson button
     *
     * @since v1.0.0
     */
    public static function hide_lesson_complete_form() {
        ?>
        <script>
            const wrapper = document.querySelector('.tutor-single-lesson-segment.tutor-lesson-complete-form-wrap');
            if (wrapper) {
                wrapper.remove();
            }
        </script>
        <?php
    }
}
