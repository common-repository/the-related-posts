<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// if not uninstalled plugin
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit(); // out.


/*esle:
	if uninstalled plugin, this options will be deleted.
*/
delete_option('obi_related_posts_limit');
delete_option('obi_related_posts_title');
delete_option('obi_related_posts_list');
delete_option('obi_related_posts_heading');

?>