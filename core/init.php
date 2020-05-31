<?php
if ( ! function_exists( 'dw_kido_setup' ) ) {
	function dw_kido_setup() {
		load_theme_textdomain( 'dw-kido', get_template_directory() . '/languages' );

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'automatic-feed-links' );

		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'dw-kido' ),
			));

		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			));

		add_editor_style();

		add_image_size( 'logo', 52, 52 );
	}
}
add_action( 'after_setup_theme', 'dw_kido_setup' );

if ( ! isset( $content_width ) ) { $content_width = 640; }
