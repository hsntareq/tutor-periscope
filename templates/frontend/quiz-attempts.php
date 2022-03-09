<?php
/**
 * Students Quiz Attempts Frontend
 *
 * @since v.1.4.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.6.4
 */

use Tutor_Periscope\Certificates\DownloadApproval;

$per_page     = 20;
$current_page = max( 1, tutils()->array_get( 'current_page', tutor_sanitize_data( $_GET ) ) );
$offset       = ( $current_page - 1 ) * $per_page;
?>

<h3><?php esc_html_e( 'Pending Approvals for Downloading Certificate', 'tutor-periscope' ); ?></h3>
<?php

$quiz_attempts = tutor_utils()->get_quiz_attempts( $start = $current_page, $limit = 10, $search_filter = '', $course_filter = '', $date_filter = '', $order_filter = 'DESC' );

/**
 * Filter duplicate records
 *
 * Filter with user_id & course_id, if the same user_id & course_id
 * already in records then don't store in filter_attempts.
 */
// $filter_attempts = array();
// if ( is_array( $quiz_attempts ) && count( $quiz_attempts ) ) {
// foreach ( $quiz_attempts as $key => $attempt ) {
// $user_id   = $attempt->user_id;
// $course_id = $attempt->course_id;
// $already_exists = false;
// if ( count( $filter_attempts ) ) {
// if ( $user_id === $filter_attempts[ count( $filter_attempts ) - 1 ]->user_id && $course_id === $filter_attempts[ count( $filter_attempts ) - 1 ]->course_id ) {
// $already_exists = true;
// }
// }
// if ( $already_exists ) {
// continue;
// }
// array_push( $filter_attempts, $attempt );
// }
// }


$quiz_attempts_count = tutor_utils()->get_total_quiz_attempts();

if ( $quiz_attempts_count ) {
	?>
	<div class="tutor-dashboard-content tutor-quiz-attempt-history tutor-periscope-pending-approval-list">
		<table class="tutor-table">
			<tr>
				<th><?php esc_html_e( 'Course Info', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Student', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Correct Answer', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Incorrect Answer', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Earned Mark', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Result', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Details', 'tutor-periscope' ); ?></th>
				<th><?php esc_html_e( 'Action', 'tutor-periscope' ); ?></th>
				<?php do_action( 'tutor_quiz/student_attempts/table/thead/col' ); ?>
			</tr>
			<?php
			foreach ( $quiz_attempts as $attempt ) {
				$attempt_action    = tutor_utils()->get_tutor_dashboard_page_permalink( 'quiz-attempts/quiz-reviews/?attempt_id=' . $attempt->attempt_id );
				$earned_percentage = $attempt->earned_marks > 0 ? ( number_format( ( $attempt->earned_marks * 100 ) / $attempt->total_marks ) ) : 0;
				$passing_grade     = tutor_utils()->get_quiz_option( $attempt->quiz_id, 'passing_grade' );
				$answers           = tutor_utils()->get_quiz_answers_by_attempt_id( $attempt->attempt_id );
				// is allowed to download certificate.
				$is_allowed = DownloadApproval::is_approved( $attempt->user_id, $attempt->course_id );

				if ( ! $earned_percentage >= $passing_grade ) {
					continue;
				}
				?>
				<tr>
					<td>
						<div class="course">
							<a href="<?php echo esc_url( get_the_permalink( $attempt->course_id ) ); ?>" target="_blank"><?php echo get_the_title( $attempt->course_id ); ?></a>
						</div>
						<div class="course-meta">
							<span><?php echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $attempt->attempt_ended_at ) ); ?></span>
							<span><?php esc_html_e( 'Question: ', 'tutor-periscope' ); ?><strong><?php echo esc_attr( count( $answers ) ); ?></strong></span>
							<span><?php esc_html_e( 'Total Marks: ', 'tutor-periscope' ); ?><strong><?php echo esc_attr( $attempt->total_marks ); ?></strong></span>
						</div>
					</td>
					<td>
						<div class="student">
							<?php echo esc_attr( $attempt->display_name ); ?></span>
						</div>
						<div class="student-meta">
							<span><?php echo esc_attr( $attempt->user_email ); ?></span>
						</div>
					</td>
					<td>
						<?php
							$correct   = 0;
							$incorrect = 0;
						if ( is_array( $answers ) && count( $answers ) > 0 ) {
							foreach ( $answers as $answer ) {
								if ( (bool) isset( $answer->is_correct ) ? $answer->is_correct : '' ) {
									$correct++;
								} else {
									if ( $answer->question_type === 'open_ended' || $answer->question_type === 'short_answer' ) {
									} else {
										$incorrect++;
									}
								}
							}
						}
							echo $correct;
						?>
					</td>
					<td>
						<?php echo $incorrect; ?>
					</td>
					<td>
						<?php echo $attempt->earned_marks . ' (' . $earned_percentage . '%)'; ?>
					</td>
					<td>
						<?php
						if ( $attempt->attempt_status === 'review_required' ) {
							echo '<span class="result-review-required">' . __( 'Under Review', 'tutor-periscope' ) . '</span>';
						} else {
							echo $earned_percentage >= $passing_grade ?
								'<span class="result-pass">' . __( 'Pass', 'tutor-periscope' ) . '</span>' :
								'<span class="result-fail">' . __( 'Fail', 'tutor-periscope' ) . '</span>';
						}
						?>
					</td>
					<td><a  href="#" class="tutor-periscope-attempt-details" data-id="<?php echo esc_attr( $attempt->attempt_id ); ?>"><?php esc_html_e( 'Details', 'tutor-periscope' ); ?></a></td>
					<?php do_action( 'tutor_quiz/student_attempts/table/tbody/col', $attempt ); ?>

					<td>
						<a href="#" class="<?php echo esc_attr( $is_allowed ? 'tutor-status-approved-context' : 'tutor-status-pending-approval' ); ?> tutor-periscope-allow-download-cert" data-user-id="<?php echo esc_attr( $attempt->user_id ); ?>" data-course-id="<?php echo esc_attr( $attempt->course_id ); ?>" title="<?php esc_attr_e( 'Allow user to download certificate', 'tutor-periscope' ); ?>">
							<i class="tutor-icon-mark"></i>
						</a>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	<div class="tutor-pagination">
		<?php
		echo paginate_links(
			array(
				'format'  => '?current_page=%#%',
				'current' => $current_page,
				'total'   => ceil( $quiz_attempts_count / $per_page ),
			)
		);
		?>
	</div>
	<?php
} else {
	esc_html_e( 'No quiz attempt yet.', 'tutor-periscope' );
}
?>

<!-- modal -->
<div class="tutor-modal-wrap tutor-periscope-attempt-modal">
	<div class="tutor-modal-content">
		<div class="modal-header">
			<div class="modal-title">
				<h1><?php esc_html_e( 'Attempt Details', 'tutor-periscope' ); ?></h1>
			</div>
			<div class="lesson-modal-close-wrap">
				<a href="javascript:;" class="modal-close-btn"><i class="tutor-icon-line-cross"></i></a>
			</div>
		</div>
		<div class="modal-container" id="tutor-periscope-attempt-details-wrap">

		</div>
		<div class="modal-footer">
		</div>
	</div>
</div>

