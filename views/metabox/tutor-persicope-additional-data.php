<?php
/**
 * Tutor periscope additiona meta template
 */

defined( 'ABSPATH' ) || exit;

$course_id           = get_the_ID();
$endorsements        = get_post_meta( $course_id, '_tp_endorsements', true );
$learning_objectives = get_post_meta( $course_id, '_tp_learning_objectives', true );

do_action( 'tutor_periscope_course_metabox_before_additional_data' ); ?>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="learning_objectives">
            <?php esc_html_e( 'Learning Objectives', 'tutor-periscope' ); ?>
        </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<textarea name="learning_objectives" rows="2"><?php echo esc_html( $learning_objectives ); ?></textarea>
		<p class="desc">
			<?php esc_html_e( 'List the learning objectives here. (One per line)', 'tutor-periscope' ); ?>
		</p>
	</div>
</div>
<div class="tutor-option-field-row">
    <div class="tutor-option-field-label">
        <label for="course_endorsements">
			<?php esc_html_e( 'Endorsements', 'tutor-periscope' ); ?> <br />
        </label>
    </div>
    <div class="tutor-option-field tutor-option-tooltip">
        <textarea name="course_endorsements" rows="2"><?php echo esc_html( $endorsements ); ?></textarea>

        <p class="desc">
			<?php esc_html_e( 'Endorsements or special instructions. (One per line)', 'tutor-periscope' ); ?>
        </p>
    </div>
</div>

<input type="hidden" name="_tutor_periscope_course_additional_data_edit" value="true" />

<?php do_action( 'tutor_periscope_course_metabox_after_additional_data' ); ?>
