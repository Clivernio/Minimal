<?php 

// User style of theme
function inline_comments_style_dwqa() {
	wp_enqueue_style( 'inline-comments-theme-style', get_template_directory_uri() . '/inc/inline-comments/css/main.css' ); 
}
add_action( 'wp_enqueue_scripts', 'inline_comments_style_dwqa' ); 