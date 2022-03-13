<?php
/**
 * Certificate approval list table
 *
 * @package TutorPeriscopeDatabase
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CertificateApprovalTable ' ) ) {

	/**
	 * CertificateApprovalTable
	 */
	class CertificateApprovalsTable {

		const TABLE_NAME = 'tp_certificate_approvals';

		/**
		 * Certificate table creation
		 *
		 * @return void
		 */
		public static function create_table() {
			do_action( 'tutor_periscope_before_certificate_approvals_table' );
			global $wpdb;
			$table_name      = $wpdb->prefix . self::TABLE_NAME;
			$charset_collate = $wpdb->get_charset_collate();
			$sql             = "CREATE TABLE {$table_name} (
                id int(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                certificate_no VARCHAR(255) NOT NULL, 
                approver_id bigint NOT NULL,
                course_id bigint NOT NULL,
                student_id bigint NOT NULL,
                created_at datetime default CURRENT_TIMESTAMP
            ) $charset_collate;
            ";
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
			do_action( 'tutor_periscope_after_certificate_approvals_table' );
		}

		/**
		 * Drop Table if exists
		 *
		 * @return void
		 */
		public static function drop_table() {
			global $wpdb;
			do_action( 'tutor_periscope_before_certificate_approvals_table_drop' );
			$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . self::TABLE_NAME );
			do_action( 'tutor_periscope_after_certificate_approvals_table_drop' );
		}
	}
}
