<?php
/**
 * Evaluation form
 *
 * @since v2.0.0
 * @package TutorPeriscope\Template
 */

?>
<div class="tp-evaluation-form-wrapper">
	<div class="tutor-row tutor-mb-32">
		<form action="">
			<div class="tutor-row">
				<div class="tutor-col-4">
					<button type="button" class="tutor-mb-24 tutor-mt-12 tutor-btn tutor-btn-outline-primary tutor-btn-sm">
						<?php esc_html_e( '+ Add Field', 'tutor-periscope' ); ?>
					</button>
				</div>
				<div class="tutor-col-12 tutor-mb-24">
					<input type="text" name="title" class="tutor-form-control" placeholder="<?php echo esc_attr( 'Title', 'tutor-periscope' ); ?>">
				</div>
				<div class="tutor-col-12 tutor-mb-24">
					<textarea name="description" rows="3" placeholder="<?php echo esc_attr( 'Description...', 'tutor-periscope' ); ?>" style="width: 100%;"></textarea>
				</div>
			</div>
		</form>
	</div>
</div>
