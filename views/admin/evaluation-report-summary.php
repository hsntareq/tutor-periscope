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
	<p><strong>Provider Name:: </strong> We are eager to hear</p>
	<p><strong>Course Title: </strong> Mike, Skyler, Steve</p>
	<p><strong>Speaker: </strong> Mike, Skyler, Steve</p>
	<p><strong>Course Date: </strong> 01-01-2022 to 02-02-2022</p>
	<p><strong>Course Location: </strong> Online</p>
	<p><strong>Total # of participants: </strong> Online</p>
	<p><strong>Total # of PTs: </strong> Online</p>
	<p><strong>Total # of PTAs: </strong> Online</p>
	<p><strong>Total # of SPTs: </strong> Online</p>
	<p><strong>Total # of Other: </strong> Online</p>
	<p><strong>Specify designation(s) of other: </strong> Online</p>
</div>
