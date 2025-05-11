<?php
/**
 * Plugin Name: EasyRoadmap
 * Plugin URI: https://easysuite.io/easyroadmap
 * Author: EasySuite
 * Author URI: https://easysuite.io
 * Description: A simple WordPress plugin for creating and sharing interactive product roadmaps effortlessly.
 * Version: 0.9
 * Requires at least: 6.0
 * Tested up to: 6.7.2
 * Requires PHP: 7.4
 * Text Domain: easyroadmap
 * Domain Path: /languages
 *
 * EasyRoadmap is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * EasyRoadmap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace EasyRoadmap;

defined( 'ABSPATH' ) || exit;

define( 'EASYROADMAP_FILE', __FILE__ );
define( 'EASYROADMAP_VERSION', '0.9' );
define( 'EASYROADMAP_PLUGIN_DIR', plugin_dir_path( EASYROADMAP_FILE ) );
define( 'EASYROADMAP_PLUGIN_URL', plugin_dir_url( EASYROADMAP_FILE ) );
define( 'EASYROADMAP_ASSETS_URL', EASYROADMAP_PLUGIN_URL . 'assets/' );

require_once 'vendor/autoload.php';

/**
 * Register the activation hook.
 * This hook is triggered when the plugin is activated.
 * It installs necessary database tables, sets initial seeds,
 * and checks database versions.
 */
register_activation_hook( EASYROADMAP_FILE, __NAMESPACE__ . '\\easyroadmap_install' );
function easyroadmap_install() {
	Bootstrap\Installer::install();
}

/**
 * Register the deactivation hook.
 * This hook is triggered when the plugin is activated.
 * It uninstalls necessary database tables, sets initial seeds,
 * and checks database versions.
 */
register_deactivation_hook( EASYROADMAP_FILE, __NAMESPACE__ . '\\easyroadmap_uninstall' );
function easyroadmap_uninstall() {
	Bootstrap\Uninstaller::uninstall();
}

/**
 * Add action for plugins_loaded to activate the plugin.
 * This action is triggered when all active plugins are fully loaded.
 * It sets up cron jobs, registers custom user roles, and performs other
 * necessary activation tasks.
 */
add_action( 'plugins_loaded', __NAMESPACE__ . '\\easyroadmap_activate' );
function easyroadmap_activate() {
	Bootstrap\Activator::activate();
}

/**
 * Add action for plugins_loaded to initialize the plugin.
 * This action is triggered when all active plugins are fully loaded.
 * It sets the plugin's runtime environment and initializes hooks.
 */
add_action( 'plugins_loaded', __NAMESPACE__ . '\\easyroadmap_initialize' );
function easyroadmap_initialize() {
	Bootstrap\Initializer::initialize();
}
