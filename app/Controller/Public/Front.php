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
		$this->filter( 'body_class', array( $this, 'add_body_class' ) );
		$this->action( 'wp_enqueue_scripts', array( $this, 'add_assets' ) );
	}

	public function add_body_class( $classes ) {
		if ( current_user_can( 'edit_pages' ) ) {
			$classes[] = 'task-editor';
		}

		return $classes;
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
