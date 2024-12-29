<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * Range Field Class
 */
class Range extends Text {

    public function __construct( $config = [] ) {
        parent::__construct( $config );
        $this->set_type( 'range' );
    }
}