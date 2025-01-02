<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * Password Field Class
 */
class Password extends Text {

	public function __construct( $config = array() ) {
		parent::__construct( $config );
		$this->set_type( 'password' );
	}
}
