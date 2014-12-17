<?php
if ( ! function_exists( 'dw_kido_page_header' ) ) {
	function dw_kido_page_header() {
		echo '<header class="page-header">';
		echo '<h1 class="page-title">';
		if ( is_category() ) {
			_e( 'Catgory: ', 'dw-kido' );
			single_cat_title();

		} elseif ( is_tag() ) {
			_e( 'Tag: ', 'dw-kido' );
			single_tag_title(); 

		} elseif ( is_author() ) {
			printf( __( 'Author: %s', 'dw-kido' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_day() ) {
			printf( __( 'Day: %s', 'dw-kido' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			printf( __( 'Month: %s', 'dw-kido' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'dw-kido' ) ) . '</span>' );
		} elseif ( is_year() ) {
			printf( __( 'Year: %s', 'dw-kido' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'dw-kido' ) ) . '</span>' );
		} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
			_e( 'Fomat: Asides','dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			_e( 'Fomat: Galleries', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			_e( 'Fomat: Images', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			_e( 'Fomat: Videos', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			_e( 'Fomat: Quotes', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			_e( 'Fomat: Links', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			_e( 'Fomat: Statuses', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			_e( 'Fomat: Audios', 'dw-kido' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			_e( 'Fomat: Chats', 'dw-kido' );
		} else {
			_e( 'Archives', 'dw-kido' );
		}

		echo '</h1>';
		
		$term_description = term_description();
		if ( ! empty( $term_description ) ) {
			printf( '<div class="taxonomy-description">%s</div>', $term_description );
		}

		echo '</header>';
	}
}

if ( ! function_exists( 'dw_kido_paging_nav' ) ) {
	function dw_kido_paging_nav( $wp_query = false ) {
		if ( ! $wp_query ) {
			global $wp_query;
		}
		//solve issue with dw-kido Version 1.0
		$paging_nav = dw_kido_get_theme_option( 'paging_nav', 'infinite' );
		//end solving issue
		?>

		<?php if ( $wp_query->max_num_pages < 2 ) : ?>
			<nav class="navigation paging-navigation <?php echo esc_html( $paging_nav ); ?>" role="navigation">
				<span class="sr-only"><?php _e( 'Posts navigation', 'dw-kido' ); ?></span>
				<ul class="pager">
					<li class="previous"><span class="text-muted"><?php _e( '&laquo; Older Entries ', 'dw-kido' ) ?></span></li>
					<li class="next"><span class="text-muted"><?php _e( 'Newer Entries &raquo;', 'dw-kido' ) ?></span></li>
				</ul>
			</nav>
		<?php else : ?>
			<nav class="navigation paging-navigation <?php echo esc_html( $paging_nav ); ?>" role="navigation">
				<span class="sr-only"><?php _e( 'Posts navigation', 'dw-kido' ); ?></span>
				<ul class="pager">
					<?php if ( get_next_posts_link() ) : ?>
						<li class="previous"><?php next_posts_link( __( '&laquo; Older Entries ', 'dw-kido' ) ); ?></li>
					<?php else : ?>
						<li class="previous"><span class="text-muted"><?php _e( '&laquo; Older Entries ', 'dw-kido' ) ?></span></li>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
						<li class="next"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'dw-kido' ) ); ?></li>
					<?php else : ?>
						<li class="next"><span class="text-muted"><?php _e( 'Newer Entries &raquo;', 'dw-kido' ) ?></span></li>
					<?php endif; ?>
				</ul>
			</nav>	
		<?php endif ?>
		<?php
	}
}

if ( ! function_exists( 'dw_kido_post_nav' ) ) {
	function dw_kido_post_nav() {
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		?>
		<?php if ( ! $next && ! $previous ) : ?>
			<nav class="navigation post-navigation" role="navigation">
				<span class="sr-only"><?php _e( 'Post navigation', 'dw-kido' ); ?></span>
				<ul class="pager">
					<li class="previous"><span class="text-muted"><?php _e( '&laquo; Older Entries ', 'dw-kido' ) ?></span></li>
					<li class="next"><span class="text-muted"><?php _e( 'Newer Entries &raquo;', 'dw-kido' ) ?></span></li>
				</ul>
			</nav>
		<?php else : ?>
			<nav class="navigation post-navigation" role="navigation">
				<span class="sr-only"><?php _e( 'Post navigation', 'dw-kido' ); ?></span>
				<ul class="pager">
					<?php if ( $previous ) : ?>
						<?php previous_post_link( '<li class="previous">%link</li>', _x( '&laquo; Older Entries ', 'Previous post link', 'dw-kido' ) ); ?>
					<?php else : ?>
						<li class="previous"><span class="text-muted"><?php _e( '&laquo; Older Entries ', 'dw-kido' ) ?></span></li>
					<?php endif; ?>
					
					<?php if ( $next ): ?>
						<?php next_post_link( '<li class="next">%link</li>', _x( 'Newer Entries &raquo;', 'Next post link', 'dw-kido' ) ); ?>	
					<?php else : ?>
						<li class="next"><span class="text-muted"><?php _e( 'Newer Entries &raquo;', 'dw-kido' ) ?></span></li>
					<?php endif ?>
				</ul>
			</nav>
		<?php endif ?>
		<?php
	}
}

if ( ! function_exists( 'dw_kido_posted_on' ) ) {
	function dw_kido_posted_on() {
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
		} else {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
			);

		$categories_list = get_the_category_list( __( ', ', 'dailyplus' ) );

		echo '<span class="byline"><span>' . esc_html__( 'By ','dw-kido' ) . '</span><span>'. get_the_author() .'</span></span>';
		echo '<span class="post-on"><span>' . esc_html__( ' On ','dw-kido' ) . '</span><span>' . wp_kses_post( $time_string ) . '</span></span>';
		echo '<span class="post-in"><span>' . esc_html__( ' In ','dw-kido' ) . '</span><span>' . $categories_list . '</span></span>';
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
			echo '<span class="comments-link"><span>' . esc_html__( ' with ','dw-kido' ) . '</span><span>'; 
			comments_popup_link( __( '0 Comment', 'dw-kido' ), __( '1 Comment', 'dw-kido' ), __( '% Comments', 'dw-kido' ) );
		}
		echo '</span></span>';
	}
}

if ( ! function_exists( 'dw_kido_categorized_blog' ) ) {
	function dw_kido_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'dw_kido_categories' ) ) ) {
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2,
				) );

			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'dw_kido_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			return true;
		} else {
			return false;
		}
	}
}

function dw_kido_category_transient_flusher() {
	delete_transient( 'dw_kido_categories' );
}
add_action( 'edit_category', 'dw_kido_category_transient_flusher' );
add_action( 'save_post',     'dw_kido_category_transient_flusher' );


if ( ! function_exists( 'dw_kido_related_posts' ) ) {
	function dw_kido_related_posts( $post_id = false ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$tags = wp_get_post_tags( $post_id );
		if ( $tags ) {
			$tag_ids = array();
			foreach ( $tags as $individual_tag ) $tag_ids[] = $individual_tag->term_id;
			$args = array(
				'tag__in' => $tag_ids,
				'post__not_in' => array( $post_id ),
				'posts_per_page' => 3,
				'ignore_sticky_posts' => 1,
				);
		} else {
			$args = array(
				'post__not_in' => array( $post_id ),
				'posts_per_page' => 3,
				'ignore_sticky_posts' => 1,
				);
		} 

		$related_query = new wp_query( $args ); ?>

		<?php if ( $related_query->have_posts() ) : ?>
			<div class="related-posts">
				<h2 class="related-posts-title"><?php _e( 'Related Posts', 'dw-kido' ); ?></h2>
				<div class="related-content">
					<div class="row">
						<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
							<div class="col-sm-4">
								<article class="related-post clearfix">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="entry-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a></div>
									<?php endif; ?>
									<h3 class="related-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
								</article>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php wp_reset_postdata();
	}
}

function dw_kido_add_post_class( $classes ) {
	if ( ! in_array( 'hentry', $classes ) && is_search() ) {
		$classes[] = 'hentry';
	}
	return $classes;
}
add_filter( 'post_class','dw_kido_add_post_class', 99 );


if ( ! function_exists( 'dw_kido_gallery_shortcode' ) ) {
	function dw_kido_gallery_shortcode( $attr ) {
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' )
			return $output;

		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] )
				unset( $attr['orderby'] );
		}

		extract( shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'li',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			), $attr));

		$id = intval( $id );
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( ! empty( $include ) ) {
			
			$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $exclude ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
		}
		if ( empty( $attachments ) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			return $output;
		}

		$itemtag = tag_escape( $itemtag );
		$captiontag = tag_escape( $captiontag );
		$columns = intval( $columns );
		$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = $gallery_div = '';
		$size_class = sanitize_html_class( $size );

		$gid = rand( 1, 15 );
		$carousel_div = "<div id='gallery-{$id}{$gid}' class='gallery carousel slide'> <div class='carousel-inner' data-interval='7000'>";
		$output .= apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $carousel_div );

		$i = 0;
		$thumbnails = array();

		foreach ( $attachments as $img_id => $attachment ) {
			$link = isset( $attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link( $img_id, $size, false, false ) : wp_get_attachment_link( $img_id, $size, true, false );
			$full_url = wp_get_attachment_image_src( $img_id, 'full' );
			$thumb_url = wp_get_attachment_image_src( $img_id, $size );
			$thumbnails[] = $thumb_url;

			$output .= '<div class="item';
			if ( $i == 0 ) {
				$output .= ' active';
				$i++;
			}
			$output .= '">';
			$output .= '<img src="' . $full_url[0] . '" />';
			if ( $attachment->post_excerpt ) {
				$output .= '<div class="gallery-caption carousel-caption"><div class="carousel-caption-inner">' . $attachment->post_excerpt . '</div></div>';
			}
			$output .= '</div>';
		}
		$output .= ' </div>';
		
		if ( count( $attachments ) > 1 ) {
			$output .= '<div class="carousel-nav"><ul></ul></div>';

			//Carousel nav
			$output .= '<a class="carousel-control left" href="#gallery-' . $id . $gid . '" data-slide="prev"><span class="fa fa-angle-left"></span></a>
			<a class="carousel-control right" href="#gallery-' . $id . $gid . '" data-slide="next"><span class="fa fa-angle-right"></span></a>';
			$output .= '</div>';
		}
		return $output;
	}
	remove_shortcode( 'gallery', 'gallery_shortcode' );
	add_shortcode( 'gallery', 'dw_kido_gallery_shortcode' );
}

if ( ! function_exists( 'dw_kido_password_form' ) ) {
	function dw_kido_password_form() {
		global $post;
		$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
		$o  = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
		$o .= '<span class="help-block">To view this protected post, enter the password below:</span>';
		$o .= '<div class="form-group">';
		$o .= '<input class="form-control" name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" placeholder="password" />';
		$o .= '</div>';

		$o .= '<input class="btn btn-default" type="submit" name="Submit" value="' . esc_attr__( 'Submit' ) . '" />';
		$o .= '</form>';

		return $o;
	}
	add_filter( 'the_password_form', 'dw_kido_password_form' );
}
