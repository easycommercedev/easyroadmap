<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * Date Field Class
 */
class Date extends Text {

    public function __construct( $config = [] ) {
        parent::__construct( $config );
        $this->set_type( 'date' );
    }
}