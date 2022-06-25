<?php
/**
 * Evaluation form view template
 *
 * @since v2.0.0
 * @package TutorPeriscope\Template
 */

use Tutor_Periscope\FormBuilder\FieldOptions;

if ( ! isset( $data ) ) {
	die( __( 'Data not set', 'tutor-periscope' ) );
}
// Variable getting passed from Controller.
$form_fields = $data['data'];
$form_title  = '';
$description = '';
if ( is_array( $form_fields ) && count( $form_fields ) ) {
	$form_title  = $form_fields[0]->form_title;
	$description = $form_fields[0]->form_description;
}

?>

<div class="tutor-modal-content">
	<div class="tutor-modal-header">
		<div class="tutor-modal-title">
			<h3>
				<?php echo esc_html( $form_title ); ?>
			</h3>
		</div>
		<button data-tutor-modal-close="" class="tutor-iconic-btn tutor-modal-close">
			<span class="tutor-icon-times" area-hidden="true"></span>
		</button>
	</div>
	<div class="tutor-modal-body modal-container" style="padding:20px;">
		<div class="tutor-periscope-student-course-evaluation-wrapper">
			<p>
				<?php echo esc_textarea( $description ); ?>
			</p>
			<form id="tutor-periscope-evaluation-form">
				<?php if ( is_array( $form_fields ) && count( $form_fields ) ) : ?>
					<?php foreach ( $form_fields as $key => $field ) : ?>
						<input type="hidden" name="field_id[]" value="<?php echo esc_attr( $field->field_id ); ?>">
						<div class="tutor-form-group mb-3 clearfix">
							<label class="d-inline-block">
								<?php echo esc_html( $field->field_label ); ?>
							</label>
							<?php if ( 'compare' === $field->field_type ) : ?>
							<select name="feedback[]" id="" class="tutor-form-control">
								<?php foreach ( FieldOptions::compare_field_options() as $key => $option ) : ?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>"
									<?php
									if ( true === $option['selected'] ) {
										echo 'selected';
									}
									?>
									>
										<?php echo esc_html( $option['label'] ); ?>
										<?php if ( '' !== $option['help_text'] ) : ?>
											(<?php echo esc_html( $option['help_text'] ); ?>)
										<?php endif; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?php endif; ?>
							<?php if ( 'vote' === $field->field_type ) : ?>
							<select name="feedback[]" id="" class="tutor-form-control">
								<option value="yes">
									<?php echo esc_html_e( 'Yes', 'tutor-periscope' ); ?>
								</option>
								<option value="no">
									<?php echo esc_html_e( 'No', 'tutor-periscope' ); ?>
								</option>
								<option value="na">
									<?php echo esc_html_e( 'N/A', 'tutor-periscope' ); ?>
								</option>
							</select>
							<?php endif; ?>
							<?php if ( 'comment' === $field->field_type ) : ?>
							<div class="tutor-form-group mb-3 clearfix">
								<textarea name="feedback[]"></textarea>
							</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<div class="tutor-form-group mb-3 clearfix">
					<button class="tutor-periscope-evaluation-submit-button tutor-button">
						<?php esc_html_e( 'Submit', 'tutor-periscope' ); ?>
					</button>
				</div>
			</form>
		</div>

	</div>
</div>
