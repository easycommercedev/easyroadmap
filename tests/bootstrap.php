<?php
// Define WordPress directory and load necessary files
$wp_dir = '../../../'; // '/var/www/html/wp.wp'
require_once $wp_dir . '/wp-load.php';
require_once $wp_dir . '/wp-admin/includes/plugin.php';

// Load the plugin file
require_once EASYROADMAP_FILE;