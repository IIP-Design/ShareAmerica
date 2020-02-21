<?php

/**
* Clear database on plugin uninstall
*/

if ( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}
	
delete_option('sti_settings');		