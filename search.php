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
						<header class="page-header">
							<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'dw-kido' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header>
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'search' ); ?>
							<?php endwhile; ?>
							<?php dw_kido_paging_nav(); ?>
						<?php else : ?>
							<?php get_template_part( 'content', 'none' ); ?>
						<?php endif; ?>
					</main>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>