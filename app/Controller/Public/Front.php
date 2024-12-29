<?php
namespace EasyRoadmap\Controller\Public;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Asset;

class Front {

	use Hook;
	use Asset;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'wp_enqueue_scripts', [ $this, 'add_assets' ] );
	}

	public function add_assets() {

		$this->enqueue_style(
			'easyroadmap-public',
			EASYROADMAP_ASSETS_URL . 'public/css/style.css'
		);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		$this->enqueue_script(
			'easyroadmap-public',
			EASYROADMAP_ASSETS_URL . 'public/js/script.js'
		);
	}

}