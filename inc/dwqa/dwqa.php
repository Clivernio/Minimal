<?php 

// User style of theme
function enqueue_style_dwqa() {
	wp_dequeue_style( 'dwqa-style' );
	wp_enqueue_style( 'dwqa-theme-style', get_template_directory_uri() . '/inc/dwqa/css/main.css' ); 
}
add_action( 'wp_enqueue_scripts', 'enqueue_style_dwqa' ); 