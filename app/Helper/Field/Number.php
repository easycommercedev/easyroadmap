<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * Number Field Class
 */
class Number extends Text {

    public function __construct( $config = [] ) {
        parent::__construct( $config );
        $this->set_type( 'number' );
    }
}