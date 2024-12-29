<?php
namespace EasyRoadmap\Controller\Public;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;

class Front {

	use Hook;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'wp_head', [ $this, 'test' ] );
	}

	public function test() {}

}