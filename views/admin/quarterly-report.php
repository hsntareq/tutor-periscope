<?php
/**
 * Evaluation quarterly report page
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\Admin\Page
 */
use Tutor_Periscope\FormBuilder\FormBuilder;

$form_builder = FormBuilder::create( 'Form' );
$forms        = $form_builder->get_list();

// pr($forms);
?>
<div class="wrap evaluation-report-wrapper">
	<h1>
		<?php esc_html_e( 'Quarterly Report', 'tutor-periscope' ); ?>
	</h1>
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
			<th>
				<?php esc_html_e( 'Actions', 'tutor-periscope' ); ?><br> <small>Caution to take actions</small>
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
						<span class="button-group">
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="left">View</a>
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="right">Download</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="left">View</a>
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="right">Download</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="left">View</a>
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="right">Download</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="left">View</a>
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="right">Download</a>
						</span>
					</td>
					<td>
						<span class="button-group">
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-view&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="left">Edit</a>
							<a href="<?php echo esc_url( get_home_url() . '/?action=tp-evaluation-report-download&form-id=' . $form->id . '&course-id=' . $form->tutor_course_id ); ?>" class="button" value="right">Delete</a>
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
</div>
