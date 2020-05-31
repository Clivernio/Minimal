<?php

function dw_kido_sidebars_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dw-kido' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );

	register_sidebar( array(
		'name'          => __( 'Sidebar bottom left', 'dw-kido' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );

	register_sidebar( array(
		'name'          => __( 'Sidebar bottom right', 'dw-kido' ),
		'id'            => 'sidebar-3',
		'description'   => '',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );
}
add_action( 'widgets_init', 'dw_kido_sidebars_init' );