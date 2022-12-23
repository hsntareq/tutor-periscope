<?php
/**
 * Utilities
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\Utilities
 */

namespace Tutor_Periscope\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Contains static method for common task.
 */
class Utilities {

	/**
	 * Create nonce field.
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public static function create_nonce_field() {
		wp_nonce_field( TP_NONCE_ACTION, TP_NONCE );
	}

	/**
	 * Verify nonce not it verified then die
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public static function verify_nonce() {
		$tp_nonce = TP_NONCE;
		if ( isset( $_POST[ $tp_nonce ] ) && ! wp_verify_nonce( $_POST[ $tp_nonce ], TP_NONCE_ACTION ) ) {
			die( __( 'Tutor periscope nonce verification failed', 'tutor-periscope' ) );
		}
	}

	/**
	 * Verify ajax nonce
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public static function verify_ajax_nonce() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( $_POST['nonce'], 'tp_nonce' ) ) {
			wp_send_json_error( __( 'Tutor periscope nonce verification failed', 'tutor-periscope' ) );
		}
	}

	/**
	 * Load template file
	 *
	 * @since v2.0.0
	 *
	 * @param string $template  required template file path.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_template( string $template, $data, $once = false ) {
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		}
	}

	/**
	 * Show date range on custom report PDF
	 *
	 * @return void
	 */
	public static function custom_report_date_range() {
		$from_date       = isset( $_GET['from_date'] ) ? $_GET['from_date'] : '';
		$to_date         = isset( $_GET['to_date'] ) ? $_GET['to_date'] : '';
		$course_id       = (int) isset( $_GET['course-id'] ) ? $_GET['course-id'] : 0;
		$date_range_text = '';
		if ( '' !== $from_date && '' !== $to_date ) {
			$from_date       = gmdate( 'd M, Y', strtotime( $from_date ) );
			$to_date         = gmdate( 'd M, Y', strtotime( $to_date ) );
			$date_range_text = "From <b>{$from_date}</b> to <b>{$to_date}</b>";
		} else {
			$course_date = $course_id ? get_the_date( 'd M, Y', $course_id ) : '';
			$today       = gmdate( 'd M, Y', time() );
			if ( '' !== $course_date ) {
				$date_range_text = "From <b>{$course_date}</b> to <b>{$today}</b>";
			}
		}
		if ( '' !== $date_range_text ) {
			?>
			<p>
				<?php echo $date_range_text; //phpcs:ignore ?>
			</p>
			<?php
		}
	}
}
