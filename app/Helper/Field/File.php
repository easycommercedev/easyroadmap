<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * File Field Class
 */
class File extends Text {

	public function __construct( $config = array() ) {
		parent::__construct( $config );
		$this->set_type( 'file' );
		$this->set_value();
	}
}
