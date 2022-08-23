<?php
/**
 * Tutor periscope additiona meta template
 */

defined( 'ABSPATH' ) || exit;

$course_id            = get_the_ID();
$endorsements         = get_post_meta( $course_id, '_tp_endorsements', true );
$education_approval         = get_post_meta( $course_id, '_tp_education_approval', true );
$learning_objectives  = get_post_meta( $course_id, '_tp_learning_objectives', true );
$certificate_approver = get_post_meta( $course_id, '_tp_certificate_approver', true );
$approver_state_content     = unserialize( get_post_meta( $course_id, '_tp_education_approver', true ) );
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
			<?php esc_html_e( 'Education Approval', 'tutor-periscope' ); ?> <br />
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<textarea name="education_approval" rows="2"><?php echo esc_html( $endorsements ); ?></textarea>

		<p class="desc">
			<?php esc_html_e( 'Endorsements or special instructions. (One per line)', 'tutor-periscope' ); ?>
		</p>
	</div>
</div>
<!-- <div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="course_endorsements">
			<?php //esc_html_e( 'Profession', 'tutor-periscope' ); ?> <br />
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<input type="text" name="_tp_student_profession" classs="tutor-form-control" value="<?php // echo esc_html( $student_profession ? $student_profession : '' ); ?>" placeholder="<?php // esc_html_e( 'Add student profession.', 'tutor-periscope' ); ?>"/>
	</div>
</div> -->
<!-- <div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="course_endorsements">
			<?php //esc_html_e( 'Certificate Approver', 'tutor-periscope' ); ?> <br />
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<select class="tutor-select" name="_tp_certificate_approver">
		<?php
		/* $approvers = get_users( array( 'role' => 'periscope_reviewer' ) );
		foreach ( $approvers as $approver ) {
			$approver = get_userdata( $approver->ID );
			?>
					<option value="<?php echo $approver->ID; ?>" <?php echo $approver->ID == $certificate_approver ? 'selected' : ''; ?>><?php echo $approver->display_name; ?></option>
				<?php
		} */
		?>
		</select>
	</div>
</div> -->


<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="course_endorsements">
			<?php esc_html_e( 'Approval State', 'tutor-periscope' ); ?>
		<span id="tutor-periscope-add-more-instructor" style="color: #1d90d5;">
				<?php esc_html_e( '+ Add', 'tutor-periscope' ); ?>
			<span>
		</label>
	</div>
	<div class="tutor-option-field" id="tutor-periscope-instructors-metabox">
		<div style="display: flex; flex-direction: column; row-gap: 15px;">
			<textarea name="state_approver[]" rows="2" placeholder="<?php esc_attr_e( 'State Approver', 'tutor-periscope' ); ?>"><?php echo isset( $approver_state_content[0]['state_approver'] ) ? esc_textarea( $approver_state_content[0]['state_approver'] ) : ''; ?></textarea>
		</div>
		<?php
		if ( is_array( $approver_state_content ) && count( $approver_state_content ) ) : ?>
			<?php
			foreach ( $approver_state_content as $k => $instructor ) :
				if ( 0 === $k ) {
					continue;
				}
				?>
				<div class="tutor-periscope-each-instructor-box" style="display: flex; flex-direction: column; row-gap: 15px; margin-top: 15px">
					<textarea name="state_approver[]" rows='2' placeholder="<?php esc_html_e( 'State Approver', 'tutor-periscope' ); ?>"><?php echo esc_textarea( $instructor['state_approver'] ); ?></textarea>
				</div>
			<?php endforeach; ?>
		<?php endif;
		?>
	</div>
</div>


<input type="hidden" name="_tutor_periscope_course_additional_data_edit" value="true" />

<?php do_action( 'tutor_periscope_course_metabox_after_additional_data' ); ?>
