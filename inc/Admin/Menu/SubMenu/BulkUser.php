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
class Bulkuser implements SubMenuInterface
{

	/**
	 * Page title
	 *
	 * @since v2.0.0
	 *
	 * @return string  page title
	 */
	public function page_title(): string
	{
		return __('LMS Students', 'tutor-periscope');
	}

	/**
	 * Menu title
	 *
	 * @since v2.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string
	{
		return __('LMS Students', 'tutor-periscope');
	}

	/**
	 * Capability to access this menu
	 *
	 * @since v2.0.0
	 *
	 * @return string  capability
	 */
	public function capability(): string
	{
		return 'manage_options';
	}

	/**
	 * Page URL slug
	 *
	 * @since v2.0.0
	 *
	 * @return string  slug
	 */
	public function slug(): string
	{
		return 'tutor-periscope-students';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function view()
	{
?>
		<div class="wrap">
			<?php
			if (isset($_GET['add'])) {
				// @codingStandardsIgnoreStart
				echo '<h1 class="wp-heading-inline">
					' . __('Add Student', 'tutor-periscope') . '
				</h1> <a href="' . admin_url('admin.php?page=tutor-periscope-students&import') . '" class="page-title-action">Bulk Import</a><hr class="wp-header-end">';
				// @codingStandardsIgnoreEnd
				Users::user_add(true);
			} elseif (isset($_GET['edit'])) {
				// @codingStandardsIgnoreStart
				echo '<h1 class="wp-heading-inline">
				' . __('Edit Student', 'tutor-periscope') . '
			</h1> <a href="' . admin_url('admin.php?page=tutor-periscope-students&add') . '" class="page-title-action">Add a Student</a><a href="' . admin_url('admin.php?page=tutor-periscope-students&import') . '" class="page-title-action">Bulk Import</a><hr class="wp-header-end">';
				// @codingStandardsIgnoreEnd
				Users::user_edit(true);
			} elseif (isset($_GET['import'])) {
				// @codingStandardsIgnoreStart
				echo '<h1 class="wp-heading-inline">
				' . __('Import Student', 'tutor-periscope') . '
			</h1> <a href="' . admin_url('admin.php?page=tutor-periscope-students&add') . '" class="page-title-action">Add a Student</a><hr class="wp-header-end">';
				// @codingStandardsIgnoreEnd
				Users::user_import(true);
			} else {
				// @codingStandardsIgnoreStart <h1 class="wp-heading-inline">

				echo '<h1 class="wp-heading-inline">
					' . __('LMS Students', 'tutor-periscope') . '
				</h1> <a href="' . admin_url('admin.php?page=tutor-periscope-students&add') . '" class="page-title-action">Add a Student</a><a href="' . admin_url('admin.php?page=tutor-periscope-students&import') . '" class="page-title-action">Bulk Import</a><hr class="wp-header-end">';
				// @codingStandardsIgnoreEnd
				Users::users_list(true);
			}
			?>
		</div>
<?php
	}
}
