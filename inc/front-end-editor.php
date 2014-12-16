<?php
/**
 * Template Name: Post Form
 */

if( ! empty( $_GET['post'] ) && ( $post_edit = get_post( intval( $_GET['post'] ) ) ) && ! empty( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
  $post_title = sanitize_text_field( $post_edit->post_title );


  $post_thumbnails = get_post_meta( $post_edit->ID, '_dw_kido_post_thumbnails', true );
  if( $post_thumbnails ) {
    $post_thumbnails_array = explode( ',', $post_thumbnails );
    //Get images for carousel slider
    $carousel_thumbnails = array();
    $post_thumbnails = '';
    foreach ( $post_thumbnails_array as $attach_id ) {
      $image_src = wp_get_attachment_image_src( $attach_id, 'full' );
      if ( $image_src ) {
        $post_thumbnails .= $attach_id . ',';
        $carousel_thumbnails[] = array(
          'attach_id' => $attach_id,
          'src'       => $image_src[0]
        );
      }
    }
  }
  if( $post_thumbnails ) {
    $post_content = preg_replace('/\[gallery[^\]]*ids="'.$post_thumbnails.'"[^\]]*\]/', '', $post_edit->post_content );
  } else {
    $post_content = $post_edit->post_content;
  }
  $post_content = apply_filters( 'the_content', $post_content );

  $category = get_the_category( $_GET['post'] );
  $post_category = esc_attr($category[0]->term_id);
  $post_image = esc_attr( get_post_thumbnail_id( $_GET['post'] ) );
  $button_text = 'Update';
  $post_id = esc_attr($_GET['post']);

} else {
  $post_thumbnails = false;
  $post_title = (!empty($_POST['post_title'])) ? sanitize_text_field($_POST['post_title']) : '';
  $post_content = (!empty($_POST['post_content'])) ? wp_kses_post($_POST['post_content']) : '';
  $post_category = (!empty($_POST['post_category'])) ? esc_attr($_POST['post_category']) : '';
  $post_image = (!empty($_POST['post_image'])) ? esc_attr( $_POST['post_image'] ) : '';
  $button_text = 'Publish';
  $post_id = (!empty($_POST['post_id'])) ? esc_attr( $_POST['post_id'] ) : '';
}
get_header(); ?>
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

            <form id="dw-kido-post-form" class="submit-post" action="<?php the_permalink(); ?>" method="post" >
						<article class="hentry front-end-editor-wrap">
							<header class="entry-header">
								<h1 class="entry-title error" contenteditable="true"><?php echo !empty($post_title) ? $post_title : __( 'Add title ...', 'dw-kido' ); ?></h1>
								<div class="entry-meta error">
									<span class="entry-author">
										<span>by</span>
                    <?php
                      if ( ! is_user_logged_in() ) :
                        echo 'Anonymous';
                      else :
                      global $current_user;
                      get_currentuserinfo();
                    ?>
										<a href="<?php echo get_author_posts_url( $current_user->ID ); ?>"><?php echo $current_user->display_name; ?></a>
                    <?php endif; ?>
									</span>
									<span class="entry-categories">
										<span>in</span>
                		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo !empty( $post_category ) ? get_cat_name( $post_category ) : 'Choose Category'; ?></span>
                      <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                      <?php wp_list_categories('hide_empty=0&title_li='); ?>
                    </ul>
                  </span>
            		</div>
              </header>
          		<div class="entry-thumbnail" id="add-images-ui">
                <div id="gallery-<?php echo get_the_ID(); ?>" class="carousel slide" data-interval="false">
                  <div class="carousel-inner" id="drag-drop-area">
                    <?php if ( ! empty( $carousel_thumbnails ) ) : ?>
                      <?php foreach ($carousel_thumbnails as $key => $item) : ?>
                        <div class="item <?php echo 0 == $key ? 'active' : ''; ?>">
                          <a href="#" class="remove" data-attach-id="<?php echo $item['attach_id'] ?>"><i class="fa fa-times"></i></a>
                          <img src="<?php echo $item['src'] ?>" >
                        </div>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <div class="item active demo">
                        <i class="fa fa-plus"></i>
                        <strong><?php _e( 'Drop Images here or Select Images', 'dw-kido' ) ?></strong>
                        <span>Suggested size 580x385px<br>(1160x772px ideal for hi-res)</span>
                      </div>
                    <?php endif; ?>
                  </div>

                  <a class="carousel-control left" href="#gallery-<?php echo get_the_ID(); ?>" data-slide="prev"><span class="fa fa-angle-left"></span></a>
                  <a class="carousel-control right" href="#gallery-<?php echo get_the_ID(); ?>" data-slide="next"><span class="fa fa-angle-right"></span></a>

                  <ol class="carousel-indicators">
                    <!-- <li class="active" data-target="#gallery-123" data-slide-to="0"><img src="http://placehold.it/150x100/"></li> -->
                    <?php if ( ! empty( $carousel_thumbnails ) ) : $i = 0; ?>
                      <?php foreach ($carousel_thumbnails as $key => $item) : ?>
                        <li class="active" data-target="#gallery-<?php echo get_the_ID(); ?>" data-slide-to="<?php echo $i; ?>"><img src="<?php echo $item['src'] ?>"></li>
                        <?php $i++; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    <li><a href="#" class="add-more-image" id="browse-button"><i class="fa fa-plus"></i></a></li>
                  </ol>
                </div>
          		</div>
          		<div class="entry-content <?php echo empty($post_content) ? 'error' : ''; ?> editable"><?php echo !empty($post_content) ? $post_content : ''; ?></div>
                <input type="hidden" value="<?php echo !empty($post_category) ? $post_category : ''; ?>" name="post_category" id="post_category">
                <input type="hidden" value="<?php echo !empty($post_title) ? $post_title : ''; ?>" name="post_title" id="post_title">
                <input type="hidden" value="<?php echo !empty($post_content) ? htmlentities( $post_content ) : ''; ?>" name="post_content" id="post_content">
                <input type="hidden" name="post_thumbnails" value="<?php echo $post_thumbnails ? $post_thumbnails : ''; ?>" id="post_thumbnails">
                <?php if( is_user_logged_in() && current_user_can( 'publish_posts' ) ) : ?>
                <input type="hidden" value="<?php echo !empty($post_id) ? $post_id : ''; ?>" name="post_id" id="post_id">
                
                <input type="submit" name="submit" class="btn btn-primary" value="<?php echo !empty ( $button_text ) ? $button_text : 'Publish'; ?>">
                <?php else : ?>
                <input type="submit" name="submit" class="btn btn-primary" value="<?php echo !empty ( $button_text ) ? $button_text : 'Publish'; ?>">
							  <?php endif; ?>
              </form>
						</article>
            <?php endwhile; ?>
					</main>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
