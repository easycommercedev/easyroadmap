<?php
namespace EasyRoadmap\Bootstrap;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;

class Activator {

	use Hook;

	/**
	 * Static method for plugin activation tasks.
	 */
	public static function activate() {
	    $activator = new self();

	    $activator->set_cron();
	    $activator->register_post_types();
	    $activator->register_taxonomies();

		// Set a flag that indicates the plugin has been activated
		update_option( 'easyroadmap_activated', true );
	}

	public function set_cron() {
		// code...
	}

	public function register_post_types() {
		$this->action( 'init', [ new Activator\Post_Type, 'register' ] );
	}

	public function register_taxonomies() {
		$this->action( 'init', [ new Activator\Taxonomy, 'register' ] );
	}

}