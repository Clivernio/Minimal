<?php
function dw_kido_scripts() {
	if ( defined( 'WP_ENV' ) && WP_ENV === 'development' ) {
		$assets = array(
			'css'       => '/assets/css/main.css',
			'js'        => '/assets/js/scripts.js',
			'modernizr' => '/assets/vendor/modernizr/modernizr.js',
			);
	} else {
		$get_assets = file_get_contents( get_template_directory() . '/assets/manifest.json' );
		$assets     = json_decode( $get_assets, true );
		$assets     = array(
			'css'       => '/assets/css/main.min.css?' . $assets['assets/css/main.min.css']['hash'],
			'js'        => '/assets/js/scripts.min.js?' . $assets['assets/js/scripts.min.js']['hash'],
			'modernizr' => '/assets/vendor/modernizr/modernizr.min.js',
			);
	}

	wp_enqueue_style( 'cl_min_css', get_template_directory_uri() . $assets['css'], false, null );
	wp_enqueue_style( 'cl_min_style', get_stylesheet_uri(), false );

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . $assets['modernizr'], array(), null, false );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'cl_min_js', get_template_directory_uri() . $assets['js'], array(), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script('cl_min_js', 'dw_kido', array(
		'site_uri' => get_template_directory_uri(),
		'settings' => array(
			'paging_nav' => dw_kido_get_theme_option( 'paging_nav', 'infinite' )
			)
		) );

	if ( ! empty( $_GET['grid'] ) && $_GET['grid'] == true ) {
		wp_enqueue_style( 'dw-jason-show-grid', 'http://basehold.it/26' );
	}
}
add_action( 'wp_enqueue_scripts', 'dw_kido_scripts' );
