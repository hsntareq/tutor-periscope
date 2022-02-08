<?php
/**
 * Utility functions
 *
 * @package Tutor Periscope
 */

defined( 'ABSPATH' ) || exit;

function pr($var){
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}


function verify_nonce(){
    if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

        $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );

        if ( ! wp_verify_nonce( $nonce ) )
            wp_die( 'You don\'t have permission to perform this action!' );
    }
}
/**
 * Additional quiz fedback template
 */
function periscope_additional_quiz_feedback_template( $quiz_id = '' ) { ?>
    <div class="tutor-quiz-builder-group">
        <h4><?php esc_html_e( 'Quiz Feedback Mode Extended', 'tutor-periscope' ); ?></h4>
        <p class="help"><?php esc_html_e( 'Pick the assessment behaviour for quiz', 'tutor-persicope' ); ?></p>
        <div class="tutor-quiz-builder-row">
            <div class="tutor-quiz-builder-col">
                <label class="tutor-quiz-feedback-mode">
                    <input type="radio" name="quiz_option[feedback_mode]" value="strict" <?php checked( 'strict', tutor_utils()->get_quiz_option( $quiz_id, 'feedback_mode' ) ); ?>>
                    <span class="radio-icon"></span>
                    <div class="tutor-quiz-feedback-mode-option">
                        <h4 class="tutor-quiz-feedback-option-option-title"><?php esc_html_e( 'Strict', 'tutor-periscope' ); ?></h4>
                        <p class="tutor-quiz-feedback-option-subtitle"><?php esc_html_e( 'Answers shown only after 90% mark is achieved', 'tutor-periscope' ); ?></p>
                    </div>
                </label>
            </div>
        </div>
    </div>
<?php }

/**
 * Insert a new Course Evaluation
 *
 * @param array $args
 */
function periscope_insert_course_evaluation( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'                                 => null,
        'periscope_course_name'              => '',
        'periscope_course_code'              => '',
        'periscope_content_matched'          => '',
        'periscope_learning_outcome'         => '',
        'periscope_current_evidence'         => '',
        'periscope_instructional_activities' => '',
        'periscope_content_delivered'        => '',
        'periscope_course_valuable'          => '',
        'periscope_promotion_product'        => '',
        'periscope_environment'              => '',
        'periscope_no_hours'                 => '',
        'periscope_apply_practice'           => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'course_evaluations';

    // some basic validation
    if ( empty( $args['periscope_course_name'] ) ) {
        return new WP_Error( 'no-periscope_course_name', __( 'No Course Name provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_course_code'] ) ) {
        return new WP_Error( 'no-periscope_course_code', __( 'No Course Code provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_content_matched'] ) ) {
        return new WP_Error( 'no-periscope_content_matched', __( 'No Course content matched the session description: provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_learning_outcome'] ) ) {
        return new WP_Error( 'no-periscope_learning_outcome', __( 'No The learning outcomes were met: provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_current_evidence'] ) ) {
        return new WP_Error( 'no-periscope_current_evidence', __( 'No Current evidence was cited for specific content: provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_instructional_activities'] ) ) {
        return new WP_Error( 'no-periscope_instructional_activities', __( 'No Instructional activities added value to my learning experience provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_content_delivered'] ) ) {
        return new WP_Error( 'no-periscope_content_delivered', __( 'No Course content was effectively delivered provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_course_valuable'] ) ) {
        return new WP_Error( 'no-periscope_course_valuable', __( 'No Overall, the course was valuable: provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_promotion_product'] ) ) {
        return new WP_Error( 'no-periscope_promotion_product', __( 'No Promotion of a product or service was NOT presented provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_environment'] ) ) {
        return new WP_Error( 'no-periscope_environment', __( 'No The environment was supportive of my learning experience provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_no_hours'] ) ) {
        return new WP_Error( 'no-periscope_no_hours', __( 'No Number of hours it took to complete - ONLY for Online Courses provided.', 'tutor-periscope' ) );
    }
    if ( empty( $args['periscope_apply_practice'] ) ) {
        return new WP_Error( 'no-periscope_apply_practice', __( 'No Agree - How will you apply this in your practice provided.', 'tutor-periscope' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        $args['created_at'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}

/**
 * Get all Course Evaluation
 *
 * @param $args array
 *
 * @return array
 */
function periscope_get_all_course_evaluation( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'course-evaluation-all';
    $items     = wp_cache_get( $cache_key, 'tutor-periscope' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'course_evaluations ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'tutor-periscope' );
    }

    return $items;
}

/**
 * Fetch all Course Evaluation from database
 *
 * @return array
 */
function periscope_get_course_evaluation_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'course_evaluations' );
}

/**
 * Fetch a single Course Evaluation from database
 *
 * @param int   $id
 *
 * @return array
 */
function periscope_get_course_evaluation( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'course_evaluations WHERE id = %d', $id ) );
}

/**
 * Delete a single Course Evaluation from database
 *
 * @param int   $id
 *
 * @return bool|void
 */
function periscope_delete_course_evaluation( $id = 0 ) {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix . 'course_evaluations', array( 'id' => $id ) );
}

/**
 * Course Dropdown
 */
function tutor_periscope_course_select_dropdown( $selected = '' ) {
    $courses = tutor_utils()->get_courses();
    $options = '';
    foreach ( $courses as $course ) {
        $options .= '<option value="' . $course->post_title . '" ' . selected( $selected, $course->post_title, false ) . '> ' . $course->post_title . ' </option>';
    }
    echo $options;
}