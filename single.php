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
									<div class="entry-meta">
										<?php dw_kido_posted_on(); ?>
									</div>
								</header>

								<?php if ( has_post_thumbnail() ) : ?>
									<div class="entry-thumbnail">
										<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a>
									</div>
								<?php endif; ?>

								<div class="entry-content">
									<?php the_content(); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dw-kido' ), 'after' => '</div>' ) ); ?>
								</div>

								<footer class="entry-footer">
									<div class="row">
										<div class="col-sm-6">
											<?php $tags_list = get_the_tag_list( '', __( ' ', 'dw-kido' ) ); ?>
											<?php if ( $tags_list ) : ?>
												<span class="tags-links">
													<?php printf( __( 'Tags: %1$s', 'dw-kido' ), $tags_list ); ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="col-sm-6">
											<?php $url = rawurlencode( substr(rtrim(get_permalink(), "/"),7) ); ?>
    										<?php $title = rawurlencode( get_the_title() ); ?>

											<ul class="social-links list-inline">
												<li><?php _e( 'Share: ', 'dw-kido' ); ?></li>
												<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>&amp;t=<?php echo $title; ?>" title="<?php _e( 'Share this post on Facebook', 'dw-kido' ) ?>" ><i class="fa fa-facebook"></i></a></li>
								            	<li class="twitter"><a href="https://twitter.com/intent/tweet?text=<?php echo esc_html( $title ) . ' by @clivernco'; ?>&amp;url=<?php echo esc_url( $url ); ?>" title="<?php _e( 'Share this post on Twitter', 'dw-kido' ) ?>"><i class="fa fa-twitter"></i></a></li>
									            <li class="google-plus"><a href="https://plus.google.com/share?url=<?php echo esc_url( $url ); ?>" title="<?php _e( 'Share this post on Google Plus', 'dw-kido' ) ?>"><i class="fa fa-google-plus"></i></a></li>
										    </ul>
										</div>
									</div>
								</footer>
							</article>

							<?php dw_kido_post_nav(); ?>

							<?php // dw_kido_related_posts(); ?>
							<?php if ( comments_open() || '0' != get_comments_number() ) : ?> 
								<?php comments_template();  ?>
							<?php endif; ?>							
						<?php endwhile;?>
					</main>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>