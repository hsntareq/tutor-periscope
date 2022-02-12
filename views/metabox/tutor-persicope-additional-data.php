<?php
/**
 * Tutor periscope additiona meta template
 */

defined( 'ABSPATH' ) || exit;

$course_id           = get_the_ID();
$endorsements        = get_post_meta( $course_id, '_tp_endorsements', true );
$learning_objectives = get_post_meta( $course_id, '_tp_learning_objectives', true );
$student_profession  = get_post_meta( $course_id, '_tp_student_profession', true );
$instructors_info    = unserialize( get_post_meta( $course_id, '_tp_instructors_info', true ) );

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
<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="course_endorsements">
			<?php esc_html_e( 'Profession', 'tutor-periscope' ); ?> <br />
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<input type="text" name="_tp_student_profession" classs="tutor-form-control" value="<?php echo esc_html( $student_profession ? $student_profession : '' ); ?>" placeholder="<?php esc_html_e( 'Add student profession.', 'tutor-periscope' ); ?>"/>
	</div>
</div>
<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="course_endorsements">
			<?php esc_html_e( 'Instructor', 'tutor-periscope' ); ?> 
			<span id="tutor-periscope-add-more-instructor" style="color: blue;">
				<?php esc_html_e( '+ Add', 'tutor-periscope' ); ?>
			<span>
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<div style="display: flex; flex-direction: column; row-gap: 15px;">
			<input type="text" name="_tp_instructor_name" class="tutor-form-control" placeholder="<?php esc_attr_e( 'Instructor name', 'tutor-periscope' ); ?>" value="" />
			
			<input type="text" name="_tp_instructor_title" placeholder="<?php esc_attr_e( 'Instructor title', 'tutor-periscope' ); ?>"/>
	   
			<textarea name="_tp_instructor_bio" rows="2" placeholder="<?php esc_attr_e( 'Instructor bio', 'tutor-periscope' ); ?>"></textarea>
		</div>
	</div>
</div>

<input type="hidden" name="_tutor_periscope_course_additional_data_edit" value="true" />

<?php do_action( 'tutor_periscope_course_metabox_after_additional_data' ); ?>
