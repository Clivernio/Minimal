<?php

if ( ! defined( 'DW_KIDO_PATH' ) ) {
	define( 'DW_KIDO_PATH', trailingslashit( get_template_directory() ) );
}

if ( ! defined( 'DW_KIDO_URI' ) ) {
	define( 'DW_KIDO_URI', trailingslashit( get_template_directory_uri() ) );
}


require_once DW_KIDO_PATH . '/inc/customizer.php';     					// Customizer functions
require_once DW_KIDO_PATH . '/inc/init.php';           					// Initial theme setup and constants
require_once DW_KIDO_PATH . '/inc/sidebars.php';        				// Sidebars and widgets
require_once DW_KIDO_PATH . '/inc/scripts.php';        					// Scripts and stylesheets
require_once DW_KIDO_PATH . '/inc/template-tags.php';  					// Custom template tags
require_once DW_KIDO_PATH . '/inc/extras.php';         					// Custom functions
require_once DW_KIDO_PATH . '/inc/activation.php';         				// Custom functions
require_once DW_KIDO_PATH . '/inc/front-end-editor/functions.php';     	// Front end editor 


// Plugins
// ------------------------------------------

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'dw-question-answer/dw-question-answer.php' ) ) {
	require_once DW_KIDO_PATH . 'inc/dwqa/dwqa.php';
}

if ( is_plugin_active( 'inline-comments/functions.php' ) ) {
	require_once DW_KIDO_PATH . 'inc/inline-comments/inline-comments.php';
}

//Push Features
// --------------------------------------------
require_once DW_KIDO_PATH . '/push/core.php';
require_once DW_KIDO_PATH . '/push/forms.php';
require_once DW_KIDO_PATH . '/push/portfolio.php';
require_once DW_KIDO_PATH . '/push/twitter.php';

function register_twitter_widget()
{
      register_widget('Twitter');
}
function register_portfolio_widget()
{
      register_widget('Portfolio');
}
add_action('widgets_init', 'register_twitter_widget');
add_action('widgets_init', 'register_portfolio_widget');