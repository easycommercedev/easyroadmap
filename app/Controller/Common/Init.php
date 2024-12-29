<?php
namespace EasyRoadmap\Controller\Common;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Asset;

class Init {

	use Hook;
	use Asset;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'wp_head', [ $this, 'modal' ] );
		$this->action( 'admin_head', [ $this, 'modal' ] );
		$this->action( 'wp_enqueue_scripts', [ $this, 'add_assets' ] );
		$this->action( 'admin_enqueue_scripts', [ $this, 'add_assets' ] );
	}

	public function modal() {
		echo '
		<div id="easyroadmap-modal" style="display: none">
			<img id="easyroadmap-modal-loader" src="' . esc_attr( EASYROADMAP_ASSETS_URL . 'common/img/loader.gif' ) . '" />
		</div>';
	}

	public function add_assets() {
		global $current_screen;

		if( strpos( $current_screen->base, 'easyroadmap' ) !== false || ! is_admin() ) {
			
			$this->enqueue_script(
				'easyroadmap_common',
				EASYROADMAP_ASSETS_URL . 'common/js/init.js'
			);

			$this->enqueue_style(
				'easyroadmap_common',
				EASYROADMAP_ASSETS_URL . 'common/css/init.css'
			);
		}
	}
}