<?php $post_class = has_post_thumbnail() ? 'has-thumbnail' : ''; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php dw_kido_posted_on(); ?>
		</div>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( '<span>continue reading &raquo;</span>' ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'dw-kido' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<?php endif; ?>
</article>
