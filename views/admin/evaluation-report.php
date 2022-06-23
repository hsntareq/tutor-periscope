<?php
/**
 * Evaluation report page
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\Admin\Page
 */

use Tutor_Periscope\FormBuilder\FormBuilder;

$form_builder = FormBuilder::create( 'Form' );
$forms        = $form_builder->get_list();
?>
<div class="wrap evaluation-report-wrapper">
	<h1>
		<?php esc_html_e( 'Evaluation Report', 'tutor-periscope' ); ?>
	</h1>
	<table class="wp-list-table widefat striped table-view-list">
		<thead>
			<th>
				<?php esc_html_e( 'Course', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Form Title', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Total Submission', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'View', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Summary', 'tutor-periscope' ); ?>
			</th>
		</thead>
		<tbody>
			<?php if ( is_array( $forms ) && count( $forms ) ) : ?>
				<?php foreach ( $forms as $form ) : ?>
				<tr>
					<td>
						<?php echo esc_html( $form->course ); ?>
					</td>
					<td>
						<?php echo esc_html( $form->form_title ); ?>
					</td>
					<td>
						<?php echo esc_html( $form->total_submission ); ?>
					</td>
					<td>
						<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-view' ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm" target="_blank">
							<?php esc_html_e( 'View', 'tutor-periscope' ); ?>
						</a>
					</td>
					<td>
						<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-download' ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm" target="_blank">
							<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
						</a>
					</td>
					<td>
						<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-summary' ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm" target="_blank">
							<?php esc_html_e( 'Evaluation Summary', 'tutor-periscope' ); ?>
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="100%">
						<?php esc_html_e( 'No records found.', 'tutor-periscope' ); ?>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
