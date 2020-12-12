<?php 
if( ! defined('WP_UNINSTALL_PLUGIN') )
	exit;

wp_clear_scheduled_hook( 'ls_cb_update_curse' );
delete_option('ls_cb_kurs');