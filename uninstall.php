<?php
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit;

	delete_option( 'sv-sticky-menu-page-options' );
?>