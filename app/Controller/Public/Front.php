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
			'easyroadmap',
			EASYROADMAP_ASSETS_URL . 'public/css/style.css'
		);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		$this->enqueue_script(
			'easyroadmap',
			EASYROADMAP_ASSETS_URL . 'public/js/script.js'
		);

		// Localize
		$localized = [
			'api_base'	=> rest_url( '/easyroadmap/v1' )
		];

		$this->localize_script(
		    'easyroadmap',
		    'EASYROADMAP',
		    apply_filters( 'easyroadmap-localized_vars', $localized )
		);
	}

}