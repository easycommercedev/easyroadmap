<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

$deletable_options = [ 'easyroadmap_activated', 'easyroadmap_db_version' ];
foreach ( $deletable_options as $option ) {
    delete_option( $option );
}