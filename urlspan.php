<?php
/*
Plugin Name: urltospan
Plugin URI: http://kirill-dyatlov.ru
Description: Automatically replaces all outgoing links with tag span
Version: 0.1
Author: Kirill Dyatlov
Author URI: http://kirill-dyatlov.ru
License: GPL2
*/

// Frontend
if(!function_exists('urlspan_script')){

	function urlspan_script(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'urlspan_script', plugins_url( 'urlspan.js' , __FILE__ ),'', '1.0',true );
	
	}

}

add_action( 'wp_enqueue_scripts', 'urlspan_script',true ); 

// Function
if ( ! function_exists( 'rmlinks' ) ) :

function rmlinks($content) {
    $host = strtr($_SERVER['HTTP_HOST'], array('.' => '\.'));
    $pattern = '/<a (.*?)href=[\"\']([a-z0-9]+)\:\/\/(?!'.$host.')(.*?)\/?(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
    $replace = "$1<span class='spanlink' onclick=\"GoTo('_$4')\">$6</span>$7";
    $content = preg_replace($pattern, $replace, $content);
    return $content;
}
add_filter ('the_content', 'rmlinks');
add_filter ('the_excerpt', 'rmlinks');
add_filter ('get_comment_author_link', 'rmlinks');

endif;