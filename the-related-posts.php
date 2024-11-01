<?php
/*
Plugin Name: The Related Posts
Plugin URI: http://wp-plugins.in/the-related-posts
Description: Add related posts after content automatically, related posts by tags, full customize, easy to use.
Version: 1.0.0
Author: Alobaidi
Author URI: http://wp-plugins.in
License: GPLv2 or later
*/

/*  Copyright 2015 Alobaidi (email: wp-plugins@outlook.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function alobaidi_the_related_posts_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'the-related-posts.php' ) !== false ) {
		
		$new_links = array(
						'<a href="http://wp-plugins.in/the-related-posts" target="_blank">Explanation of Use</a>',
						'<a href="https://profiles.wordpress.org/alobaidi#content-plugins" target="_blank">More Plugins</a>',
						'<a href="http://j.mp/ET_WPTime_ref_pl" target="_blank">Elegant Themes</a>'
					);
		
		$links = array_merge( $links, $new_links );
		
	}
	
	return $links;
	
}
add_filter( 'plugin_row_meta', 'alobaidi_the_related_posts_plugin_row_meta', 10, 2 );


function alobaidi_the_related_posts_plugin_action_links( $actions, $plugin_file ){
	
	static $plugin;

	if ( !isset($plugin) ){
		$plugin = plugin_basename(__FILE__);
	}
		
	if ($plugin == $plugin_file) {
		
		if ( is_ssl() ) {
			$settings_link = '<a href="'.admin_url( 'plugins.php?page=alobaidi_related_posts_settings', 'https' ).'">Settings</a>';
		}else{
			$settings_link = '<a href="'.admin_url( 'plugins.php?page=alobaidi_related_posts_settings', 'http' ).'">Settings</a>';
		}
		
		$settings = array($settings_link);
		
		$actions = array_merge($settings, $actions);
			
	}
	
	return $actions;
	
}
add_filter( 'plugin_action_links', 'alobaidi_the_related_posts_plugin_action_links', 10, 5 );


include( plugin_dir_path(__FILE__).'/settings.php' );


function alobaidi_related_posts_shortcode( $atts, $content = null ){

	if( !is_single() ){
		return false;
	}

	if( get_option('obi_related_posts_limit') ){
		$ob_limit = get_option('obi_related_posts_limit');
	}else{
		$ob_limit = 5;
	}

	if( get_option('obi_related_posts_list') ){
		$ob_list = get_option('obi_related_posts_list');
	}else{
		$ob_list = 'ul';
	}

	if( get_option('obi_related_posts_title') ){
		$ob_title = get_option('obi_related_posts_title');
	}else{
		$ob_title = 'Related Posts';
	}

	if( get_option('obi_related_posts_heading') ){
		$ob_heading = get_option('obi_related_posts_heading');
	}else{
		$ob_heading = 'h4';
	}

	extract(
		shortcode_atts(
			array(
				'limit'    	 =>		$ob_limit,
				'list'     	 =>		$ob_list,
				'title'    	 =>		$ob_title,
				'heading'    =>		$ob_heading
			),$atts
		)
	);

	global $post;
	$get_tags = wp_get_post_tags($post->ID);
	$tag_ids = array();

	if( !$get_tags ){
		return false;
	}

	if( $get_tags ){

		foreach( $get_tags as $get_tag ){
			$tag_ids[] = $get_tag->term_id;
		}

	}

	$args = array(
				'numberposts' 	=> 	$limit,
				'tag__in' 		=> 	$tag_ids,
				'post__not_in' 	=>	array( $post->ID ),
				'post_status' 	=>	'publish'
			);

	$related_posts = get_posts($args);

	if( !$related_posts ){
		return false;
	}

	$get_list = '';

	foreach( $related_posts as $related_post ){
		$get_list .= '<li><a href="'.esc_url( get_permalink($related_post->ID) ).'" title="'.get_the_title($related_post->ID).'">'.get_the_title($related_post->ID).'</a></li>';
	}

	$filter_before = apply_filters('alobaidi_related_posts_filter_wrap_before', '');
	$filter_after  = apply_filters('alobaidi_related_posts_filter_wrap_after', '');

	ob_start();

	?>
		<?php
			$class_title = ' class="alobaidi-related-posts-title"';
			$class_list = ' class="alobaidi-related-posts-list"';
			echo "<$heading$class_title>".$title."</$heading>";
			echo "<$list$class_list>";
			echo $get_list;
			echo "</$list>";
		?>
	<?php

	return $filter_before.ob_get_clean().$filter_after;

}
add_shortcode('obi_related_posts', 'alobaidi_related_posts_shortcode');


function alobaidi_related_posts_after_content( $content ){
	return $content.do_shortcode('[obi_related_posts]');
}
add_filter('the_content', 'alobaidi_related_posts_after_content', 999);

?>