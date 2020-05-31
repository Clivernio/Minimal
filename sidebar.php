<div class="sidebar-inner">

	<div class="site-header hidden-xs hidden-sm">
		<?php dw_kido_logo(); ?>
		<div class="side-desc">
			<?php if ( dw_kido_get_theme_option( 'site_desc' ) ): ?>
				<?php echo wp_kses_post( dw_kido_get_theme_option( 'site_desc' ) ); ?>
			<?php endif ?>
		</div>
	</div>

	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<section id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</section>

		<section class="widget">
			<h3 class="widget-title"><?php _e( 'Archives', 'dw-kido' ); ?></h3>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</section>

		<section class="widget">
			<h3 class="widget-title"><?php _e( 'Meta', 'dw-kido' ); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</section>

	<?php endif; ?>

	<div role="contentinfo">
		<div class="copyright">
			<?php if ( dw_kido_get_theme_option( 'copyright' ) ) : ?>
				<?php echo wp_kses_post( dw_kido_get_theme_option( 'copyright' ) ); ?><br>
			<?php endif ?>
			Copyright &copy; <?php echo esc_html( date( 'Y' ) ) ?> <a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
		</div>

		<?php dw_kido_social_links( array( 'facebook', 'twitter', 'google_plus', 'behance', 'dribbble', 'youtube', 'flickr', 'instagram', 'github', 'linkedin' ) ); ?>
	</div>
</div>