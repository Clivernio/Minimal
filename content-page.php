<?php $post_class = has_post_thumbnail() ? 'has-thumbnail' : ''; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a>
		</div>
	<?php endif; ?>
	<header class="page-header">
		<h2 class="page-title"><?php the_title(); ?></h2>
	</header>

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( '' ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'dw-kido' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<?php endif; ?>
</article>
