<style>
.evaluation_report * {
	line-height: 1em;
}
.evaluation_report{
	padding: 10px 50px;
}
.evaluation_report .pdf_title{
	text-align:center;
}
.evaluation_report table{
	width:100%;
	margin-bottom: 30px;
}
.evaluation_report table tr td:first-child{
	width:50%;
}
table:not('no-border') td {
	border: 1px solid;
	border-collapse: collapse;
	text-align: center;
}
.image-con-ed-wrapper {
	display: inline-block;
}
.image-con-ed-wrapper strong {
	float: right;
}
</style>
<?php

//phpcs:ignore WordPress.Security.NonceVerification.Recommended

use Tutor_Periscope\FormBuilder\FormBuilder;

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
	$provider_name = tutor_utils()->get_option( 'periscope_provider_name' );
}
?>
<div class="report_template evaluation_report">
	<table class="no-border">
		<tr>
			<td>
				<?php if ( '' !== $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>">
				<?php endif; ?>
			</td>
			<td style="text-align:right">
				<strong>
					<?php echo esc_html( $con_ed ); ?>
				</strong>
			</td>
		</tr>
	</table>
	<h2 class="pdf_title">
		<?php echo esc_html( $heading ); ?>
	</h2>
	<p>
		<strong>Provider Name: </strong>
		<?php echo esc_html( $provider_name ); ?>
	</p>
	<p><strong>Course Title: </strong> <?php echo esc_html( $course->post_title ); ?></p>
	<p><strong>Speaker: </strong>
	<?php
		$instructors = tutor_utils()->get_instructors_by_course( $course_id );
	if ( is_array( $instructors ) && count( $instructors ) ) :
		?>
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
		<strong>Total # of participants: </strong>
		<?php echo esc_html( $total_enroll ); ?>
	</p>
	<p><strong>Total # of PTs: </strong> Online</p>
	<p><strong>Total # of PTAs: </strong> Online</p>
	<p><strong>Total # of SPTs: </strong> Online</p>
	<p><strong>Total # of Other: </strong> Online</p>
	<p><strong>Specify designation(s) of other: </strong> Online</p>
</div>
