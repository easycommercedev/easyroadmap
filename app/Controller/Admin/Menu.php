<?php
namespace EasyRoadmap\Controller\Admin;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Asset;
use EasyRoadmap\Trait\Menu as Menu_Trait;
use EasyRoadmap\Helper\Utility;

class Menu {

	use Hook;
	use Asset;
	use Menu_Trait;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'admin_menu', [ $this, 'register' ] );
	}

	public function register() {

		add_submenu_page(
			'edit.php?post_type=task',
			__( 'Settings', 'easyroadmap' ),
			__( 'Settings', 'easyroadmap' ),
			'manage_options',
			'easyroadmap-settings',
			[ $this, 'callback_submenu' ]
		);
	}

	public function callback_submenu() {
		echo Utility::get_template( 'settings/layout.php' );
	}

}