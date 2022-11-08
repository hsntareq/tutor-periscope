<?php
/**
 * BulkUser Concrete class
 *
 * @package Tutor_Periscope\Admin\SubMenu
 *
 * @author Hasan Tareq <hsntareq@gmail.com>
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Admin\Menu\SubMenu;

use Tutor_Periscope\Users\Users;

/**
 * BulkUser sub menu
 */
class Bulkuser implements SubMenuInterface {

	/**
	 * Page title
	 *
	 * @since v2.0.0
	 *
	 * @return string  page title
	 */
	public function page_title(): string {
		return __( 'Bulk Student', 'tutor-periscope' );
	}

	/**
	 * Menu title
	 *
	 * @since v2.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string {
		return __( 'Bulk Student', 'tutor-periscope' );
	}

	/**
	 * Capability to access this menu
	 *
	 * @since v2.0.0
	 *
	 * @return string  capability
	 */
	public function capability(): string {
		return 'manage_options';
	}

	/**
	 * Page URL slug
	 *
	 * @since v2.0.0
	 *
	 * @return string  slug
	 */
	public function slug(): string {
		return 'tutor-periscope-bulk-user';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function view() {
		?>
		<div class="wrap">
			<?php
			if(isset($_GET['add-student'])){
					// @codingStandardsIgnoreStart
					echo '<h1 class="wp-heading-inline">
					' . __( 'Add Student', 'tutor-periscope' ) . '
				</h1>';
				// @codingStandardsIgnoreEnd
				Users::user_add(true );
			}else{
				// @codingStandardsIgnoreStart
					echo '<h1 class="wp-heading-inline">
					' . __( 'Bulk Student', 'tutor-periscope' ) . '
				</h1>';
				// @codingStandardsIgnoreEnd
				Users::users_list( true );
			}
			?>
		</div>
		<?php
	}
}
