<?php ob_start(); ?>
<style>
<?php require trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'reports-style.css'; ?>
</style>
<?php
//phpcs:ignore WordPress.Security.NonceVerification.Recommended

use Tutor_Periscope\EvaluationReport\Report;
use Tutor_Periscope\FormBuilder\FormBuilder;
use Tutor_Periscope\Users\Users;

$form_id   = $_GET['form-id'] ?? 0;
$course_id = $_GET['course-id'] ?? 0;
$course    = get_post( $course_id );
if ( ! is_a( $course, 'WP_Post' ) ) {
	die( 'Invalid Course' );
}
if ( ! $form_id || ! $course_id ) {
	die( 'Invalid Form or Course ID' );
} else {
	$form      = FormBuilder::create( 'Form' );
	$details   = $form->get_one( $form_id );
	$con_ed    = '';
	$heading   = '';
	$image_url = '';
	if ( is_object( $details ) ) {
		$con_ed    = $details->con_ed;
		$heading   = $details->heading;
		$image_url = $details->media_url;
	}
	$course_date   = date( 'd M, Y', strtotime( $course->post_date ) );
	$total_enroll  = tutor_utils()->count_enrolled_users_by_course( $course_id );
	$total_enroll  = 0;

	$provider_name = tutor_utils()->get_option( 'periscope_provider_name' );
	$job_titles    = '';

	$enrolled_users = Users::get_enrolled_users_id( $course_id );

	if ( is_object( $enrolled_users ) && null !== $enrolled_users->enroll_ids ) {
		$job_titles = Report::get_user_job_titles( $enrolled_users->enroll_ids );
	}
}
?>
<div class="report_template evaluation_summary container">
	<div class="header">
		<div class="logo">
			<?php if ( '' !== $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>">
			<?php endif; ?>
		</div>
		<div class="sub-text">
			<p>
				<?php echo esc_html( $con_ed ); ?>
			</p>
		</div>
	</div>
	<h2 class="pdf_title">
		<?php echo esc_html( $heading ); ?>
	</h2>
	<div class="pdf_body">
		<p><strong>Provider Name: </strong><span><?php echo esc_html( $provider_name ); ?></span></p>
		<p><strong>Course Title: </strong> <span><?php echo esc_html( $course->post_title ); ?></span></p>
		<p><strong>Speaker: </strong>
		<span>
		<?php if ( is_array( $instructors ) && count( $instructors ) ) : ?>
			<?php
				$instructor_string = '';
				$last_elem         = end( $instructors );
			foreach ( $instructors as $instructor ) :
				$comma = ', ';
				if ( ! isset( $instructor->display_name ) || ! isset( $instructor->ID ) ) {
					continue;
				}
				if ( $instructor === $last_elem ) {
					$comma = '';
				}
				echo esc_html( $instructor->display_name . $comma );
				?>
			<?php endforeach; ?>
		<?php endif; ?>
	</p>
	<p><strong>Course Date: </strong> <?php echo esc_html( $course_date ); ?></p>
	<p><strong>Course Location: </strong> Online</p>
	<p>
		<strong>Total Participants: </strong>
		<?php echo esc_html( $total_enroll ); ?>
	</p>
		</p>
		<p><strong>Course Date: </strong> <span> <?php echo esc_html( $course_date ); ?></span></p>
		<p><strong>Course Location: </strong> Online</p>
		<p><strong>Total # of participants: </strong><span><?php echo esc_html( $total_enroll ); ?></span></p>
		<div class="pdf_item_group">
			<?php
			$pt     = 0;
			$pta    = 0;
			$spt    = 0;
			$others = 0;
			if ( is_array( $job_titles ) && count( $job_titles ) ) :
				?>
				<?php
					$pt     = isset( $job_titles[0] ) ? $job_titles[0]->counted : 0;
					$pta    = isset( $job_titles[1] ) ? $job_titles[1]->counted : 0;
					$spt    = isset( $job_titles[2] ) ? $job_titles[2]->counted : 0;
					$others = isset( $job_titles[3] ) ? $job_titles[3]->counted : 0;
				?>
			<?php endif; ?>
			<p>
				<strong>Total # of PT: </strong>
				<?php echo esc_html( $pt ); ?>
			</p>
			<p>
				<strong>Total # of PTA: </strong>
				<?php echo esc_html( $pta ); ?>
			</p>
			<p>
				<strong>Total # of SPT: </strong>
				<?php echo esc_html( $spt ); ?>
			</p>
		</div>
		<p><strong>Specify designation(s) of other: </strong>
			<?php echo esc_html( $others ); ?>
		</p>

		<hr/>

		<!-- <h2 class="pdf_title">Instructions for Submitting your Summary of Evaluations</h2>
		<ol class="comments_list">
			<li>
				<span>Summaries should be submitted as follows:</span>
				<ol>
					<li><span>Within 30 days after the completion of each live course (both face-to-face courses and webinars), including courses held outside of California. Please submit one course date per Summary of Evaluations.</span></li>
					<li><span>On a quarterly basis during your approval period for self-study courses, within 30 days of the completion of each quarter. For example, if your course is approved from January 1 to January 1, your approval period would be broken into 4 periods ending in March 31, June 30, September 30, and December 31. Your Summaries would be due by April 30, July 31, October 31, and January 31</span></li>
				</ol>
			</li>
			<li><span>Complete the top portion of this form. Be sure the Approval Number is correct for the course your are submitting</span></li>
			<li><span>Tally the results from the completed evaluations and provide an aggregate count of the answers. Do not average, summarize or provide percentage breakdowns. Do not send a copy of each evaluation to CPTA. Evaluation results should include all participants’ answers, not exclusively PTs or PTAs.</span></li>
			<li><span>Compile comments from all open-ended questions into one document.</span></li>
			<li><span>Submit your Summary of Evaluations including this cover sheet, evaluation tallies, and comments</span></li>
		</ol>
		<div>Your summary should include ALL questions that were submitted with your approved application. Omitting questions from your administered evaluation could result in revocation of your approval status.</div> -->
		<div class="bold_italic">
			<em>Failure to submit these summaries may result in future courses not being approved</em>
		</div>
	</div>
</div>
