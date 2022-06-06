<?php
/**
 * Evaluation form
 *
 * @since v2.0.0
 * @package TutorPeriscope\Template
 */

use Tutor_Periscope\FormBuilder\FormClient;
use Tutor_Periscope\Utilities\Utilities;

$form_fields      = FormClient::get_form_fields( get_the_ID() );
$form_title       = '';
$form_description = '';

if ( is_array( $form_fields ) && count( $form_fields ) ) {
	$form_title       = $form_fields[0]->form_title;
	$form_description = $form_fields[0]->form_description;
}
?>
<div class="tp-evaluation-form-wrapper">
	<div class="tutor-row tutor-mb-32">
		<form method="post">
			<?php Utilities::create_nonce_field(); ?>
			<div class="tutor-row tp-form-controls">
				<div class="tutor-col-4">
					<button type="button" class="tutor-mb-24 tutor-mt-12 tutor-btn tutor-btn-outline-primary tutor-btn-sm tp-add-field">
						<?php esc_html_e( '+ Add Field', 'tutor-periscope' ); ?>
					</button>
				</div>
				<div class="tutor-col-12 tutor-mb-24">
					<input type="text" name="tp_ef_title" class="tutor-form-control" placeholder="<?php echo esc_attr( 'Title', 'tutor-periscope' ); ?>" value="<?php echo esc_attr( $form_title ); ?>">
				</div>
				<div class="tutor-col-12 tutor-mb-24">
					<textarea name="tp_ef_description" rows="3" placeholder="<?php echo esc_attr( 'Description...', 'tutor-periscope' ); ?>" style="width: 100%;"><?php echo esc_attr( $form_description ); ?></textarea>
				</div>
				<?php if ( is_array( $form_fields ) && count( $form_fields ) ) : ?>
					<?php foreach ( $form_fields as $field ) : ?>
						<div class="tutor-col-12 tutor-mb-24 tp-remove-able-wrapper tutor-d-flex tutor-justify-between">
							<input type="text" name="tp_ef_fields[]" class="tutor-form-control tutor-mr-24" placeholder="<?php esc_html_e( 'Add field label', 'tutor-periscope' ); ?>" value="<?php echo esc_attr( $field->field_label ); ?>">
							<div class="tp-action-btn-wrapper tutor-d-flex">
								<div class="form-control">
									<select name="tp_ef_field_type[]" class="tutor-mr-12" title="<?php esc_attr_e( 'Field type', 'tutor-periscope' ); ?>">
										<option value="compare" <?php selected( $field->field_type, 'compare' ); ?>>
											<?php esc_html_e( 'Compare', 'tutor-periscope' ); ?>
										</option>
										<option value="vote" <?php selected( $field->field_type, 'vote' ); ?>>
											<?php esc_html_e( 'Vote', 'tutor-periscope' ); ?>
										</option>
									</select>
								</div>
								<button type="button" class="tp-remove-able tutor-btn tutor-btn-outline-primary tutor-btn-sm">
									<?php esc_html_e( 'Remove', 'tutor-periscope' ); ?>
								</button>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</form>
	</div>
</div>
