<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * Color Field Class
 */
class Color extends Text {

    public function __construct( $config = [] ) {
        parent::__construct( $config );
        $this->set_type( 'color' );
    }
}