	<?php if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) ) : ?>
		<?php $vertocal_line = ''; $col_1 = 'col-md-12'; $col_2 = 'col-md-12'; ?>

		<?php if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) ) { ?>
			<?php $vertocal_line = 'vertocal-line'; $col_1 = 'col-md-5'; $col_2 = 'col-md-5 col-md-offset-2';  ?>
		<?php } ?>

		<aside class="sidebar-bottom bg-dark" role="contentinfo">
			<div class="container">
				<div class="row <?php esc_html_e( $vertocal_line );  ?>">
					<div class="<?php esc_html_e( $col_1 ); ?>">
						<?php dynamic_sidebar( 'sidebar-2' ) ?>
					</div>
					<div class="<?php esc_html_e( $col_2 ); ?>">
						<?php dynamic_sidebar( 'sidebar-3' ) ?>
					</div>
				</div>
			</div>
		</aside>
	<?php endif ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
