<?php
namespace EasyRoadmap\Bootstrap;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Model\Database;

class Installer {

	/**
	 * Run installation routines.
	 */
	public static function install() {
		$installer = new self();

		if ( ! $installer->is_database_up_to_date() ) {
			$installer->update_db_version();
		}
	}

	/**
	 * Check if the database is up to date.
	 *
	 * @return bool
	 */
	protected function is_database_up_to_date() {
		$installed_ver = get_option( 'easyroadmap_db_version' );
		return version_compare( $installed_ver, EASYROADMAP_VERSION, '=' );
	}

	/**
	 * Update or add the database version to the options table.
	 */
	protected function update_db_version() {
		update_option( 'easyroadmap_db_version', EASYROADMAP_VERSION );
	}
}
