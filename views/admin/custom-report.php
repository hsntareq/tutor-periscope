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

$form_builder  = FormBuilder::create( 'Form' );
$feedback      = FormBuilder::create( 'Feedback' );
$selected_year = Input::get( 'year', '' );
$search_term   = Input::get( 'search', '' );
$paged_filter  = Input::get( 'paged', 1, Input::TYPE_INT );
$limit         = tutor_utils()->get_option( 'pagination_per_page' );
$offset        = ( $limit * $paged_filter ) - $limit;

$date_range = isset( $_GET['daterange'] ) ? explode( '-', $_GET['daterange'] ) : null;

$from_date   = ! is_null( $date_range ) ? date( 'Y-m-d', strtotime( $date_range[0] ) ) : '';
$to_date     = ! is_null( $date_range ) ? date( 'Y-m-d', strtotime( $date_range[1] ) ) : '';
$forms       = $form_builder->get_list( $offset, $limit, $selected_year, $search_term, $from_date, $to_date );
$total_count = $form_builder->total_evaluation_count( $selected_year, $search_term, $from_date, $to_date );

?>
<div class="wrap evaluation-report-wrapper tutor-admin-wrap">
	<div class="tutor-admin-body">
		<h1>
			<?php esc_html_e( 'Custom Report', 'tutor-periscope' ); ?>
		</h1>

		<form action="<?php echo esc_url( admin_url() . 'admin.php?page=tutor-periscope-quarterly-report' ); ?>" method="get" class="tutor-d-flex tutor-align-end" style="gap: 20px;" id="tp-evaluation-form-sorting">
		<input type="hidden" name="page" value="tutor-periscope-custom-report">
			<div class="tutor-wp-dashboard-filter-item tutor-mb-12" style="flex-grow: .10;">
				<label for="tutor-backend-filter-search" class="tutor-form-label">
					<?php esc_html_e( 'Select the daterange', 'tutor-periscope' ); ?>
				</label>
				<div class="tutor-form-wrap">
					<input type="text" autocomplete="off" name="daterange" class="tutor-form-control daterangepick" placeholder="<?php esc_html_e( 'Select date', 'tutor-periscope' ); ?>">
				</div>
			</div>
			<div class="tutor-wp-dashboard-filter-item tutor-mb-12">
				<button class="tutor-btn tutor-btn-outline-primary">
					<?php esc_html_e( 'Apply', 'tutor-periscope' ); ?>
				</button>
			</div>
		</form>

		<table class="wp-list-table widefat striped table-view-list">
			<thead>
				<th>
					<?php esc_html_e( 'Courses', 'tutor-periscope' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'Evaluation Report', 'tutor-periscope' ); ?><br> <small>View or Download Evaluation Report</small>
				</th>
				<th>
					<?php esc_html_e( 'Summary Report', 'tutor-periscope' ); ?><br> <small>View or Download Course Summary</small>
				</th>
			</thead>
			<tbody>
				<?php if ( is_array( $forms ) && count( $forms ) ) : ?>
					<?php foreach ( $forms as $form ) : ?>
						<?php
						$total_submission = $form->total_submission;

						$evaluation_url = get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&from_date=' . $from_date . '&to_date=' . $to_date;

						$evaluation_download_url = get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&from_date=' . $from_date . '&to_date=' . $to_date;

						$summary_url = get_home_url() . '/?action=tp-evaluation-report-summary&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&from_date=' . $from_date . '&to_date=' . $to_date;

						$summary_download_url = get_home_url() . '/?action=tp-evaluation-report-summary-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&from_date=' . $from_date . '&to_date=' . $to_date;
						?>
						<tr>
							<td>
								<?php echo esc_html( $form->course ); ?>
							</td>
							<td>
								<span class="button-group">
									<a href="<?php echo esc_url( $evaluation_url ); ?>" class="button" value="left" target="_blank">
										<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
									</a>
									<a href="<?php echo esc_url( $evaluation_download_url ); ?>" class="button" value="right" target="_blank">
										<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
									</a>
								</span>
							</td>
							<td>
								<span class="button-group">
									<a href="<?php echo esc_url( $summary_url ); ?>" class="button" value="left" target="_blank">
										<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
									</a>
									<a href="<?php echo esc_url( $summary_download_url ); ?>" class="button" value="right" target="_blank">
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
			if ( $total_count > $limit ) {
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
</div>
<script>
	// const form = document.getElementById('tp-evaluation-form-sorting');
	// form.onsubmit = (e) => {
	// 	e.preventDefault();
	// 	const url = new URL(e.target.action);
	// 	const params = new URLSearchParams(url.search);
	// 	const formData = new FormData(form);
	// 	const year = formData.get('year');
	// 	const search = formData.get('search');
	// 	if (!year && !search) {
	// 		tutor_toast('Error!', 'Please select year or search before submit', 'error');
	// 		return;
	// 	}

	// 	url.searchParams.set('year', year);
	// 	url.searchParams.set('search', search);
	// 	url.searchParams.set('paged', 1);
	// 	window.location.href = url.href;
	// }
</script>
