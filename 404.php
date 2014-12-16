<?php get_header(); ?>
<div class="wrap" role="document">
	<div class="container">
		<div class="content">
			<div class="content-inner">
				<div class="row">
					<main class="main col-md-12" role="main">
						<div class="center-block text-center">
							<h1><?php esc_html_e( '404','dw-kido' ) ?></h1>
							<p><?php esc_html_e( 'Oops! This page is lost! Sorry about that!','dw-kido' ) ?></p>
							<p><?php esc_html_e( 'Return to', 'dw-kido' ) ?>: <a href="<?php echo esc_url( site_url() ); ?>"><?php esc_html_e( 'Home', 'dw-kido' ) ?></a></p>
						</div>
					</main>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>