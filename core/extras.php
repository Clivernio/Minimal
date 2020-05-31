<?php
function dw_kido_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'dw_kido_page_menu_args' );

function dw_kido_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'dw_kido_body_classes' );

function dw_kido_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'dw-kido' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'dw_kido_wp_title', 10, 2 );

function dw_kido_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'dw_kido_setup_author' );

function dw_kido_footer_action() {
	echo '<button class="sidebar-toggle btn btn-icon"><i class="fa fa-bars"></i></button>';
	echo '<a class="scroll-top hidden-xs" href="#" title="' .  esc_html__( 'Scroll to top', 'dw-kido' ) .'"><i class="fa fa-caret-up"></i></i></a>';
}
add_action( 'wp_footer','dw_kido_footer_action' );

function dw_kido_site_header_mobile() {
	?>
	<div class="side-header-mobile hidden-md hidden-lg">
		<?php dw_kido_logo(); ?>
		<div class="side-desc">
			<?php if ( dw_kido_get_theme_option( 'site_desc' ) ): ?>
				<?php echo wp_kses_post( dw_kido_get_theme_option( 'site_desc' ) ); ?>
			<?php endif ?>
		</div>
	</div>
	<?php
}

function dw_kido_postclasses( $classes ) {
	if ( ! comments_open() ) {
		$classes[] = 'comments-close';
	}
	return $classes;
}
add_action( 'post_class', 'dw_kido_postclasses' );