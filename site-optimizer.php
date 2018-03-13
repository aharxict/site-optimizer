<?php
/*
Plugin Name: Site Optimizer
Description: Clean load from draft and add SEO features.
Version: 1.0
Author: AHAPX
License: GPL2
*/

// Clean up wp_head
// Remove Really simple discovery link
remove_action('wp_head', 'rsd_link');
// Remove Windows Live Writer link
remove_action('wp_head', 'wlwmanifest_link');
// Remove the version number
remove_action('wp_head', 'wp_generator');

// Remove curly quotes
remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');

// Allow HTML in user profiles
remove_filter('pre_user_description', 'wp_filter_kses');

// add except as description
function excerpt_to_description(){
	global $post;
	if(is_single() || is_page()){
		$all_post_content = wp_get_single_post($post->ID);
		$excerpt = substr($all_post_content->post_content, 0, 100).' [...]';
		echo "<meta name='description' content='".$excerpt."' />\r\n";
	}
	else{
		echo "<meta name='description' content='".get_bloginfo('description')."' />\r\n";
	}
}
add_action('wp_head','excerpt_to_description');

function tags_to_keywords(){
	global $post;
	if(is_single() || is_page()){
		$tags = wp_get_post_tags($post->ID);
		foreach($tags as $tag){
			$tag_array[] = $tag->name;
		}
		$tag_string = implode(', ',$tag_array);
		if($tag_string !== ''){
			echo "<meta name='keywords' content='".$tag_string."' />\r\n";
		}
	}
}
add_action('wp_head','tags_to_keywords');

?>