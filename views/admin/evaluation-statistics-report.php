<?php ob_start();?>
<style>
<?php include( trailingslashit( TUTOR_PERISCOPE_VIEWS . 'admin' ) . 'reports-style.css' ); ?>
</style>
<?php

use Tutor_Periscope\EvaluationReport\Report;
//phpcs:ignore WordPress.Security.NonceVerification.Recommended
$form_id   = $_GET['form-id'] ?? 0;
$course_id = $_GET['course-id'] ?? 0;
if ( ! $form_id || ! $course_id ) {
	die( 'Invalid Form or Course ID' );
} else {
	$statistics = Report::get_statistics( $form_id );
}
?>
<div class="report_template evaluation_report container">
	<h2 class="pdf_title">
		Periscope Evaluation Statistics Report
	</h2>
	<div class="header">
		<p>
			<strong>Title:</strong>
			<?php echo esc_html( get_the_title( $course_id ) ); ?>
		</p>
		<p style="margin-bottom: 20px">
			<strong>Presenter: </strong>
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
		<br/>
		<p>We are eager to hear your opinion. Please use the scale below to grade the following areas: </p>
	</div>
	<table>
		<tr>
			<th></th>
			<th align="left" colspan="4"><em>Lowest</em></th>
			<th align="center"><em>Highest </em></th>
			<th align="center"><em>Not Apply </em></th>
		</tr>
		<tr>
			<th></th>
			<th align="center">1</th>
			<th align="center">2</th>
			<th align="center">3</th>
			<th align="center">4</th>
			<th align="center">5</th>
			<th align="center"></th>
		</tr>

		<?php if ( is_array( $statistics ) && count( $statistics ) ) : ?>
			<?php
			foreach ( $statistics as $statistic ) :
				if ( 'vote' === $statistic->field_type ) {
					continue;
				}
				$total_counts = explode( ',', $statistic->total_count );
				?>
				<tr>
					<td><?php echo esc_html( $statistic->field_label ); ?></td>
					<?php if ( is_array( $total_counts ) && count( $total_counts ) ) : ?>
						<?php foreach ( $total_counts as $count ) : ?>
							<td align="center">
								<?php echo esc_html( $count ); ?>
							</td>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
				<tr>
					<?php if ( '' !== $statistic->comments && ! is_null( $statistic->comments ) ) : ?>
						<?php
							$user_comments = explode( '_', $statistic->comments );
							$user_comments = array_unique( $user_comments );
						?>
						<?php if ( is_array( $user_comments ) && count( $user_comments ) ) : ?>
							<ol>
							<?php foreach ( $user_comments as $uc ) : ?>
								<li>
									<?php echo esc_html( $uc ); ?>
								</li>
							<?php endforeach; ?>
							</ol>
						<?php endif; ?>						
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

	</table>

	<table>
		<tr>
			<td></td>
			<td align="center">Yes</td>
			<td align="center">No</td>
			<td align="center">N/A</td>
		</tr>
		<?php if ( is_array( $statistics ) && count( $statistics ) ) : ?>
			<?php
			foreach ( $statistics as $statistic ) :
				if ( 'compare' === $statistic->field_type ) {
					continue;
				}
				$vote_counts = explode( ',', $statistic->total_count );
				?>
				<tr>
					<td><?php echo esc_html( $statistic->field_label ); ?></td>
					<?php if ( is_array( $vote_counts ) && count( $vote_counts ) ) : ?>
						<?php foreach ( $vote_counts as $count ) : ?>
							<td align="center"><?php echo esc_html( $count ); ?></td>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
				<tr>
					<?php if ( '' !== $statistic->comments && ! is_null( $statistic->comments ) ) : ?>
						<?php
						$user_comments = explode( '_', $statistic->comments );
						$user_comments = array_unique( $user_comments );
						?>
						<?php if ( is_array( $user_comments ) && count( $user_comments ) ) : ?>
							<ol>
							<?php foreach ( $user_comments as $uc ) : ?>
								<li>
									<?php echo esc_html( $uc ); ?>
								</li>
							<?php endforeach; ?>
							</ol>
						<?php endif; ?>						
					<?php endif; ?>
				</tr>				
			<?php endforeach; ?>
		<?php endif; ?></table>

</div>
