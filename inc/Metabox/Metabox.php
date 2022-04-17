<?php
/**
 * Meta box Factory concrete class
 *
 * @package TutorPeriscope\Metabox
 *
 * @since v1.0.0
 */

namespace Tutor_Periscope\Metabox;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * SidebarMetabox
 */
class Metabox implements MetaboxInterface {

	private $id, $title, $screen, $context, $priority, $args;

	public function __construct(
		$id,
		$title,
		$screen,
		$context,
		$priority = 'default',
		$args = ''
	) {
		$this->id       = $id;
		$this->title    = $title;
		$this->screen   = $screen;
		$this->context  = $context;
		$this->priority = $priority;
		$this->args     = $args;
	}

	public function get_id(): string {
		return $this->id;
	}

	public function get_title(): string {
		return $this->title;
	}

	public function get_screen() {
		return $this->screen;
	}

	public function get_context(): string {
		return $this->context;
	}

	public function get_priority(): string {
		return $this->priority;
	}

	public function get_args() {
		return $this->args;
	}

}
