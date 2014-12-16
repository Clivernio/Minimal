<?php get_header(); ?>
<div class="wrap" role="document">
	<div class="container">
		<div class="content">
			<div class="content-inner has-sidebar">
				<div class="row">
					<aside class="sidebar col-md-3" role="complementary">
						<?php get_sidebar(); ?>
					</aside>
					
					<main class="main col-md-9" role="main">
						<?php dw_kido_site_header_mobile(); ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">
									<h1 class="entry-title"><?php the_title(); ?></h1>
								</header>
								
								<div class="entry-content">
									<?php the_content(); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dw-kido' ), 'after' => '</div>' ) ); ?>
								</div>
							</article>
							<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
								<?php comments_template(); ?>
							<?php endif; ?>
						<?php endwhile; ?>
					</main>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>