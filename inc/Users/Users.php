<?php
/**
 * Users management
 *
 * @since v1.0.0
 *
 * @package TutorPeriscope\Users
 */

namespace Tutor_Periscope\Users;

use \WP_User_Query;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Users related operation management
 */
class Users {

	/**
	 * Orderby
	 *
	 * @var string
	 */
	private static $orderby = 'ID';

	/**
	 * Order
	 *
	 * @var string
	 */
	private static $order = 'DESC';

	/**
	 * User's Role
	 *
	 * @var string
	 */
	private static $role = 'subscriber';

	/**
	 * Offset
	 *
	 * @var int
	 */
	private static $offset = 0;

	/**
	 * Number or users for retrieving
	 *
	 * @var int
	 */
	public static $number = 10;

	/**
	 * Paged
	 *
	 * @var int
	 */
	private static $paged = 1;

	/**
	 * Total number users found
	 *
	 * @var bool
	 */
	private static $count_total = true;

	/**
	 * Get users list.
	 *
	 * @param  array $args  arguments for retrieving users. See this link:
	 * https://developer.wordpress.org/reference/classes/WP_User_Query/prepare_query/
	 * for available arguments.
	 *
	 * @return object  list of users or empty array.
	 */
	public static function get( array $args ): object {
		$default_args = array(
			'role'        => self::$role,
			'orderby'     => self::$orderby,
			'order'       => self::$order,
			'offset'      => self::$offset,
			'number'      => self::$number,
			'paged'       => self::$paged,
			'count_total' => self::$count_total,
		);

		$args = wp_parse_args( $args, $default_args );

		$query       = new WP_User_Query( $args );
		$users       = $query->get_results();
		$total_count = $query->get_total();

		$result = array(
			'users'       => $users,
			'total_count' => $total_count,
		);

		return apply_filters( 'tutor_periscope_users_list', (object) $result );
	}

	/**
	 * Users list view
	 *
	 * @param  bool $echo  echo or return.
	 *
	 * @return string  if echo then echo out otherwise return string.
	 */
	public static function users_list( bool $echo = true ) {
		ob_start();
		$view_file = TUTOR_PERISCOPE_VIEWS . 'admin/users-list.php';
		if ( file_exists( $view_file ) ) {
			include $view_file;
		}
		$views = apply_filters( 'tutor_perisocpe_users_list_views', ob_get_clean() );

		if ( $echo ) {
			echo $views; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $views;
		}
	}
}

