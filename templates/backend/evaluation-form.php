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
$form_id          = '';
$media_url		  = '';
if ( is_array( $form_fields ) && count( $form_fields ) ) {
	$form_id          = $form_fields[0]->id;
	$form_title       = $form_fields[0]->form_title;
	$form_description = $form_fields[0]->form_description;
	$media_url        = $form_fields[0]->media_url;
}
$img_display = '' === $media_url ? 'display: none;' : '';
?>
<div class="tp-evaluation-form-wrapper">
	<div class="tutor-row tutor-mb-32">
		<form method="post">
			<?php Utilities::create_nonce_field(); ?>
			<input type="hidden" name="tp_ef_id" value="<?php echo esc_attr( $form_id ); ?>">
			<div class="tutor-row tp-evaluation-form-logo">
				<div class="tutor-col-4 tutor-mb-12" id="tp_upload_button">
					<button class="tutor-btn tutor-btn-primary tutor-btn-sm tutor-mt-12">
						<?php esc_html_e( 'Upload Media', 'tutor-periscope' ); ?>
					</button>
				</div>
				<input type="hidden" id="tp_form_media_url" name="tp_form_media_url">
				<input type="hidden" id="tp_form_media_name" name="tp_form_media_name">
			</div>
			<div id="tp_media_wrapper" class="tutor-row tutor-mb-24" style="<?php echo esc_attr( $img_display ); ?>">
				<div class="tutor-d-flex tutor-align-center">
					<div>
						<img src="<?php echo esc_url( $media_url ); ?>" id="tp_form_media_img" class="tutor-radius-6" alt="media" width="76px" height="76px">
					</div>
					<div id="tp_media_remove">
						<button class="tutor-btn tutor-btn-outline-primary tutor-btn-sm" style="color: tomato;">
							<?php esc_html_e( 'Remove', 'tutor-periscope' ); ?>
						</button>
					</div>
				</div>
			</div>
			<div class="tutor-row tutor-mb-24">
				<div class="tutor-row-12">
					<input type="text" name="tp_ef_con_ed" class="tutor-form-control" placeholder="<?php echo esc_attr( 'Con-ED', 'tutor-periscope' ); ?>" value="<?php echo esc_attr( '' ); ?>">
				</div>
			</div>
			<div class="tutor-row tutor-mb-24">
				<div class="tutor-row-12">
					<input class="tutor-form-control" name="tp_ef_heading" rows="3" placeholder="<?php echo esc_attr( 'Heading...', 'tutor-periscope' ); ?>"/>
				</div>
			</div>
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
					<textarea name="tp_ef_description" rows="3" placeholder="<?php echo esc_attr( 'Description...', 'tutor-periscope' ); ?>" style="width: 100%;"><?php echo esc_textarea( $form_description ); ?></textarea>
				</div>
				<?php if ( is_array( $form_fields ) && count( $form_fields ) ) : ?>
					<?php
					foreach ( $form_fields as $field ) :
						// Don't need to show comment field.
						if ( 'comment' === $field->field_type ) {
							continue;
						}
						?>
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
