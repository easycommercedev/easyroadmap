<?php
namespace EasyRoadmap\Controller\Admin;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Asset;
use EasyRoadmap\Helper\Utility;

class Menu {

	use Hook;
	use Asset;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'admin_enqueue_scripts', [ $this, 'add_assets' ] );
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

		if( true ) {
			
			$this->enqueue_style(
				'easyroadmap',
				EASYROADMAP_ASSETS_URL . 'admin/css/style.css'
			);
			
			wp_enqueue_script( 'jquery-ui-sortable' );

			$this->enqueue_script(
				'easyroadmap-sorter',
				EASYROADMAP_ASSETS_URL . 'admin/js/sorter.js'
			);
		}
	}

}