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
		$this->action( 'admin_enqueue_scripts', [ $this, 'add_assets' ] );
		$this->action( 'admin_menu', [ $this, 'register' ] );
	}

	public function add_assets() {
		global $current_screen;

		if( strpos( $current_screen->base, 'easyroadmap' ) !== false ) {
			
			$this->enqueue_script(
				'easyroadmap_main-menu',
				EASYROADMAP_PLUGIN_URL . 'spa/build/admin.bundle.js',
				[ 'wp-element', 'easyroadmap_common' ]
			);
		}

		if( strpos( $current_screen->base, 'easyroadmap' ) !== false ) {
			
			$this->enqueue_style(
				'easyroadmap_settings',
				EASYROADMAP_ASSETS_URL . 'admin/css/settings.css'
			);

			$this->enqueue_script(
				'easyroadmap_settings',
				EASYROADMAP_ASSETS_URL . 'admin/js/settings.js'
			);
		}
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