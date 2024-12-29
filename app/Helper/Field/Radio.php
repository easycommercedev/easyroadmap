<?php
namespace EasyRoadmap\Helper\Field;

use EasyRoadmap\Abstract\Field;

defined( 'ABSPATH' ) || exit;

/**
 * Radio Field Class
 */
class Radio extends Multicheck {
    protected $option_type = 'radio';
}