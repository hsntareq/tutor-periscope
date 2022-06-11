<?php
/**
 * Admin module loader
 *
 * @package TutorPeriscope\Admin
 *
 * @since v2.0.0
 */

namespace Tutor_Periscope\Admin;

use Tutor_Periscope\Admin\Menu\MainMenu;

/**
 * Admin Package loader
 *
 * @since v2.0.0
 */
class Admin {

	/**
	 * Load dependencies
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		new MainMenu();
	}
}
