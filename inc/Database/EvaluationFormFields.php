<?php
/**
 * Create evaluation form fields table
 *
 * @package TutorPeriscopeDatabase
 *
 * @since v2.0.0
 */

namespace Tutor_Periscope\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Evaluation_Table
 */
class EvaluationFormFields extends DatabaseTable {

	/**
	 * Course evaluation table name
	 *
	 * @var $table_name
	 */
	private static $table_name = 'tp_evaluation_form_fields';

	/**
	 * Get table name
	 *
	 * @since v2.0.0
	 *
	 * @return string
	 */
	public static function get_table(): string {
		return self::$table_name;
	}

	/**
	 * Prepare table, primary key, character set
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function create_table(): void {
		do_action( 'tutor_periscope_before_evaluation_table' );
		global $wpdb;
		$evaluation_form_table = $wpdb->prefix . EvaluationForm::get_table();

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . self::$table_name;
		$sql             = "CREATE TABLE $table_name (
        id INT(9) unsigned NOT NULL AUTO_INCREMENT,
		form_id INT(9) unsigned NOT NULL,
        tutor_course_id INT(9) NOT NULL,
        field_id INT(3),
        field_label VARCHAR(255),
        field_type VARCHAR(255),

		FOREIGN KEY (form_id)
			REFERENCES $evaluation_form_table(id)
			ON DELETE CASCADE,
		
        PRIMARY KEY  (id)
        ) ENGINE = INNODB
		$charset_collate;";

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
