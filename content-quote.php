<?php $post_class = has_post_thumbnail() ? 'has-thumbnail' : ''; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<header class="entry-header">
		<h2 class="entry-title sr-only"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php dw_kido_posted_on(); ?>
		</div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php the_content( '' ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dw-kido' ), 'after' => '</div>', ) ); ?>
	</div>
</article>
