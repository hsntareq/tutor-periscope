<style>
.evaluation_report * {
	line-height: 2em;
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
table td {
	border: 1px solid;
	border-collapse: collapse;
	text-align: center;
}

</style>
<?php

use Tutor_Periscope\EvaluationReport\Report;

	$form_id = $_GET['form-id'] ?? 0;
if ( ! $form_id ) {
	die( 'Invalid Form ID' );
} else {
	$statistics = Report::get_statistics( $form_id );
}
?>
<div class="report_template evaluation_report">
	<h2 class="pdf_title">
		Periscope Evaluation Statistics Report
	</h2>
	<p><strong>Title: </strong> We are eager to hear your opinion . Please use the scale below to grade the following areas.</p>
	<p><strong>Presenter: </strong> Mike, Skyler, Steve</p>

	<table>
		<tr>
			<td>Question</td>
			<td align="center">Lowest <br> 1</td>
			<td align="center">2</td>
			<td align="center">3</td>
			<td align="center">4</td>
			<td align="center">Highest <br> 5</td>
			<td align="center">Not Apply</td>
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
							<td>
								<?php echo esc_html( $count ); ?>
							</td>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

	</table>

	<table>
		<tr>
			<td>Question</td>
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
							<td>
								<?php echo esc_html( $count ); ?>
							</td>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

	</table>

	<p><strong>Comments:</strong></p>
	<?php
		$evaluation_comments = array_column( $statistics, 'comments' );
		$evaluation_comments = array_unique( $evaluation_comments );
	?>
	<ol>
		<?php if ( is_array( $evaluation_comments ) && count( $evaluation_comments ) ) : ?>
			<?php foreach ( $evaluation_comments as $comment ) : ?>
				<li>
					<?php echo esc_textarea( $comment ); ?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ol>
</div>
