<?php
namespace EasyRoadmap\Controller\Public;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Helper\Utility;

class Shortcode {

	use Hook;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->shortcode( 'roadmap', [ $this, 'callback_roadmap' ] );
	}

	public function callback_roadmap() {
		$tasks = [];
		
		return Utility::get_template( 'shortcodes/roadmap.php', [ 'tasks' => $tasks ] );
	}

}