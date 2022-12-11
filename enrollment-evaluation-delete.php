<?php
global $wpdb;

$delete_evaluation = $wpdb->query(
	"DELETE
        FROM $wpdb->usermeta
        WHERE meta_key LIKE '%tp_user_evaluated_course_%'
    "
);
$delete_enrolment  = $wpdb->query(
	"DELETE
        FROM $wpdb->posts
        WHERE post_type = 'tutor_enrolled'
    "
);

if ( $delete_evaluation ) {
	echo 'Evaluation Deleted';
} else {
	echo 'Evaluation delete failed';
}

if ( $delete_enrolment ) {
	echo 'Enrollments Deleted';
} else {
	echo 'Enrollments delete failed';
}


