<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * URL Field Class
 */
class URL extends Text {

    public function __construct( $config = [] ) {
        parent::__construct( $config );
        $this->set_type( 'url' );
    }
}