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

$date_range  = isset( $_GET['date_range'] ) ? explode( '-', $_GET['daterange'] ) : null;

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
					<input type="text" name="daterange" class="tutor-form-control daterangepick">
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
						$total_submission    = $form->total_submission;
						$disabled            = 'disabled';
						$report_view_url     = 'javascript:void(0)';
						$report_download_url = 'javascript:void(0)';

						$feedback_date = array( $form->from_month, $form->to_month );
						$jan_to_mar    = array( 1, 2, 3 );
						$apr_to_jun    = array( 4, 5, 6 );
						$jul_to_sep    = array( 7, 8, 9 );
						$oct_to_dec    = array( 10, 11, 12 );

						$quarter_jan_mar_view_url     = '';
						$quarter_jan_mar_download_url = '';

						$quarter_apr_jun_view_url     = '';
						$quarter_apr_jun_download_url = '';

						$quarter_jul_sep_view_url     = '';
						$quarter_jul_sep_download_url = '';

						$quarter_nov_dec_view_url     = '';
						$quarter_nov_dec_download_url = '';

						$quarter_oct_dec_view_url     = '';
						$quarter_oct_dec_download_url = '';

						if ( $total_submission ) {
							$disabled = '';

							$quarter_jan_mar_view_url = get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=jan-mar';

							$quarter_jan_mar_download_url = get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=jan-mar';

							$quarter_apr_jun_view_url = get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=apr-jun';

							$quarter_apr_jun_download_url = get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=apr-jun';

							$quarter_jul_sep_view_url = get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=jul-sep';

							$quarter_jul_sep_download_url = get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=jul-sep';

							$quarter_oct_dec_view_url = get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=oct-dec';

							$quarter_oct_dec_download_url = get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id . '&quarter=oct-dec';
						}
						$has_jan_to_mar = array_intersect( $feedback_date, $jan_to_mar );
						$has_apr_to_jun = array_intersect( $feedback_date, $apr_to_jun );
						$has_jul_to_sep = array_intersect( $feedback_date, $jul_to_sep );
						$has_oct_to_dec = array_intersect( $feedback_date, $oct_to_dec );
						?>
						<tr>
							<td>
								<?php echo esc_html( $form->course ); ?>
							</td>
							<td>
								<span class="button-group">
									<a href="<?php echo esc_url( $quarter_jul_sep_view_url ); ?>" class="button" value="left" <?php echo esc_attr( ! $has_jul_to_sep ? 'disabled' : '' ); ?> <?php echo ( ! $has_jul_to_sep ) ? 'onclick="return false;"' : ''; ?> target="_blank">
										<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
									</a>
									<a href="<?php echo esc_url( $quarter_jul_sep_download_url ); ?>" class="button" value="right" <?php echo esc_attr( ! $has_jul_to_sep ? 'disabled' : '' ); ?> <?php echo ( ! $has_jul_to_sep ) ? 'onclick="return false;"' : ''; ?> target="_blank">
										<?php esc_html_e( 'Download', 'tutor-periscope' ); ?>
									</a>
								</span>
							</td>
							<td>
								<span class="button-group">
									<a href="<?php echo esc_url( $quarter_oct_dec_view_url ); ?>" class="button" value="left" <?php echo esc_attr( ! $has_oct_to_dec ? 'disabled' : '' ); ?> <?php echo ( ! $has_oct_to_dec ) ? 'onclick="return false;"' : ''; ?> target="_blank">
										<?php echo esc_html_e( 'View', 'tutor-periscope' ); ?>
									</a>
									<a href="<?php echo esc_url( $quarter_oct_dec_download_url ); ?>" class="button" value="right" <?php echo esc_attr( ! $has_oct_to_dec ? 'disabled' : '' ); ?> <?php echo ( ! $oct_to_dec ) ? 'onclick="return false;"' : ''; ?> target="_blank">
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
