<?php
/**
 * Create course evaluation table
 *
 * @package TutorPeriscopeDatabase
 */

namespace Tutor_Periscope\Database;

/**
 * Evaluation_Table
 */
class Evaluation_Table {

	/**
	 * Course evaluation table name
	 *
	 * @var $table_name
	 */
	private static $table_name = 'tp_course_evaluation';

	/**
	 * Prepare table, primary key, character set
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function create_table() {
		do_action( 'tutor_periscope_before_evaluation_table' );
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . self::$table_name;
		$sql = "CREATE TABLE $table_name (
        id int(9) NOT NULL AUTO_INCREMENT,
        student_id int(9) NOT NULL,
        course_id int(9) NOT NULL,
        content_matched varchar(255),
        outcome_met varchar(255),
        specific_content varchar(255),
        added_value varchar(255),
        effectively_delivered varchar(255),
        was_valuable varchar(255),
        promotion_present varchar(255),
        supportive_environment varchar(255),
        number_of_hours varchar(255),
        apply_in_practice varchar(255),
        PRIMARY KEY  (id)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		do_action( 'tutor_periscope_after_evaluation_table' );
	}

	/**
	 * Drop Table if exists
	 *
	 * @return void
	 */
	public static function drop_table() {
		global $wpdb;
		do_action( 'tutor_periscope_before_evaluation_table_drop' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . self::$table_name );
		do_action( 'tutor_periscope_after_evaluation_table_drop' );
	}
}
