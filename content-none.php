<section class="no-results not-found">
	<?php if ( ! is_search() ): ?>
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'dw-kido' ); ?></h1>
	</header>
	<?php endif ?>

	<article class="hentry">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'dw-kido' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'dw-kido' ); ?></p>
			<div class="row">
				<div class="col-sm-6">
					<?php get_search_form(); ?>
				</div>
			</div>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'dw-kido' ); ?></p>
			<div class="row">
				<div class="col-sm-6">
					<?php get_search_form(); ?>
				</div>
			</div>

		<?php endif; ?>
	</article>
</section>
