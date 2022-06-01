<?php
/**
 * DB trait for using common functionality.
 *
 * @package TutorPeriscope/Database
 *
 * @since v2.0.0
 */

namespace Tutor_Periscope\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * An abstract database table class.
 */
abstract class DatabaseTable {

	/**
	 * Get table name for implementing on Concrete Class
	 *
	 * @since v2.0.0
	 *
	 * @return string   table name.
	 */
	abstract public static function get_table(): string;

	/**
	 * Create table for implementing on Concrete Class.
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	abstract public static function create_table(): void;

	/**
	 * Drop Table if exists
	 *
	 * @return void
	 */
	public static function drop_table() {
		global $wpdb;
		do_action( 'tutor_periscope_before_drop_' . self::get_table() );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . self::$table_name );
		do_action( 'tutor_periscope_after_drop_' . self::$table_name );
	}
}
