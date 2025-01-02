<?php
// Dynamically includes all PHP files in the app/Config directory, excluding the curren file
foreach ( glob( dirname( __DIR__ ) . '/Config/*.php' ) as $config_file ) {
	if ( basename( $config_file ) === 'autoload.php' ) {
		continue;
	}

	require_once $config_file;
}
