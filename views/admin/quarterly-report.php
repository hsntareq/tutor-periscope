<?php
/**
 * Evaluation quarterly report page
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\Admin\Page
 */

use TUTOR\Input;
use Tutor_Periscope\FormBuilder\FormBuilder;

$form_builder = FormBuilder::create( 'Form' );
$feedback     = FormBuilder::create( 'Feedback' );
$years        = $feedback->feedback_years();

$selected_year = Input::get( 'year', '' );
$paged_filter  = Input::get( 'paged', 1, Input::TYPE_INT );
$limit         = tutor_utils()->get_option( 'pagination_per_page' );
$offset        = ( $limit * $paged_filter ) - $limit;
$forms         = $form_builder->get_list( $offset, $limit, $selected_year );
$total_count   = $form_builder->total_evaluation_count( $selected_year );
?>
<div class="wrap evaluation-report-wrapper">
	<h1>
		<?php esc_html_e( 'Quarterly Report', 'tutor-periscope' ); ?>
	</h1>

	<div class="tutor-wp-dashboard-filter-item tutor-mb-12" style="max-width: 240px;">
		<label class="tutor-form-label" for="feedback-year">
			<?php echo esc_html_e( 'Select Year', 'tutor_periscope' ); ?>
		</label>
		<?php if ( is_array( $years ) && count( $years ) ) : ?>
			<select type="text" class="tutor-form-select" name="feedback-year" id="feedback-year">
				<option value="">
					<?php echo esc_html_e( 'Select Year', 'tutor-periscope' ); ?>
				</option>
				<?php foreach ( $years as $feedback_year ) : ?>
					<option value="<?php echo esc_attr( $feedback_year->year ); ?>">
						<?php echo esc_html( $feedback_year->year ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php else : ?>
			<p>
				<?php echo esc_html_e( 'No submission found', 'tutor-periscope' ); ?>
			</p>
		<?php endif; ?>
	</div>
	
	<table class="wp-list-table widefat striped table-view-list">
		<thead>
			<th>
				<?php esc_html_e( 'Course', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( '1st Quarter', 'tutor-periscope' ); ?><br> <small>1st January to 31th March</small>
			</th>
			<th>
				<?php esc_html_e( '2nd Quarter', 'tutor-periscope' ); ?><br> <small>1st April to 30th June</small>
			</th>
			<th>
				<?php esc_html_e( '3rd Quarter', 'tutor-periscope' ); ?><br> <small>1st July to 30th September</small>
			</th>
			<th>
				<?php esc_html_e( '4th Quarter', 'tutor-periscope' ); ?><br> <small>1st November to 31st December</small>
			</th>
		</thead>
		<tbody>
			<?php if ( is_array( $forms ) && count( $forms ) ) : ?>
				<?php foreach ( $forms as $form ) : ?>
					<?php
					$total_submission    = $form->total_submission;
					$disabled            = 'disabled';
					$report_view_url     = 'javascript:void(0)';
					$report_download_url = 'javascript:void(0)';
					if ( $total_submission ) {
						$disabled            = '';
						$report_view_url     = get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id;
						$report_download_url = get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id;
					}
					?>
				<tr>
					<td>
						<?php echo esc_html( $form->course ); ?>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( $report_view_url ); ?>" class="button" value="left" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
							</a>
							<a href="<?php echo esc_url( $report_download_url ); ?>" class="button" value="right" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
							</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( $report_view_url ); ?>" class="button" value="left" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
							</a>
							<a href="<?php echo esc_url( $report_download_url ); ?>" class="button" value="right" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
							</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( $report_view_url ); ?>" class="button" value="left" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
							</a>
							<a href="<?php echo esc_url( $report_download_url ); ?>" class="button" value="right" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
							</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( $report_view_url ); ?>" class="button" value="left" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							 target="_blank">
								<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
							</a>
							<a href="<?php echo esc_url( $report_download_url ); ?>" class="button" value="right" <?php echo esc_attr( $disabled ); ?> <?php echo ( '' !== $disabled ) ? 'onclick="return false;"' : ''; ?>
							target="_blank">
								<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
							</a>
						</span>
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
	<div class="tutor-admin-page-pagination-wrapper tutor-mt-32">
			<?php
			/**
			 * Prepare pagination data & load template
			 */
			if($total_count > $limit) {
				$pagination_data     = array(
					'total_items' => $total_count,
					'per_page'    => $limit,
					'paged'       => $paged_filter,
				);
				$pagination_template = tutor()->path . 'views/elements/pagination.php';
				tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
			}
			?>
		</div>	
</div>
