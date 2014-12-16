<?php
function dw_kido_fee_scripts() {
  if ( is_page_template( 'inc/front-end-editor.php' ) ) {
    wp_enqueue_script( 'plupload' );
    wp_enqueue_style( 'dw-kido-fee-style', get_template_directory_uri() . '/inc/front-end-editor/css/style.css', false );
    wp_enqueue_style( 'dw-kido-fee-medium-editor-style', get_template_directory_uri() . '/inc/front-end-editor/css/medium-editor.min.css', false );
    wp_enqueue_style( 'dw-kido-fee-medium-insert-style', get_template_directory_uri() . '/inc/front-end-editor/css/medium-editor-insert-plugin.min.css', false );
    wp_enqueue_style( 'dw-kido-fee-medium-editor-default', get_template_directory_uri() . '/inc/front-end-editor/css/medium-default.min.css', false );

    wp_enqueue_script( 'dw-kido-fee-medium-editor-script', get_template_directory_uri() . '/inc/front-end-editor/js/medium-editor.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'dw-kido-fee-medium-editor-insert-script', get_template_directory_uri() . '/inc/front-end-editor/js/medium-editor-insert-plugin.all.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'dw-kido-fee-script', get_template_directory_uri() . '/inc/front-end-editor/js/script.js', array('jquery'), '', true );

    wp_localize_script( 'dw-kido-fee-script', 'dw_kido', array(
      'ajax_url'  => admin_url( 'admin-ajax.php' ),
      'plupload_init' => array(
        'runtimes'            => 'html5,flash,silverlight,html4',
        'browse_button'       => 'browse-button',
        'container'           => 'add-images-ui',
        'drop_element'        => 'drag-drop-area',
        'file_data_name'      => 'dw-post-form-galerry-images',
        'url'                 => admin_url( 'admin-ajax.php?action=dw-kido-upload' ),
        'flash_swf_url'       => includes_url( 'js/plupload/plupload.flash.swf' ) ,
        'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
        'filters' => array(
          'max_file_size'   => wp_max_upload_size() . 'b',
          'mime_types'      => array(),
        ),
        'multipart_params'    =>  array(
          "post_id" => get_the_ID(),
          "_wpnonce" => wp_create_nonce('dw-kido-post-form'),
          "type" => '',
          "tab" => '',
          "short" => "1",
        ),
      )
    ));
  }
}
add_action( 'wp_enqueue_scripts', 'dw_kido_fee_scripts' );

function dw_kido_fee_manage_post() {
  if ( ! is_user_logged_in() || ! current_user_can( 'publish_posts' ) ) {
    wp_send_json_error( array(
      'message'  => __( 'This post form is for demo only — no actual posts can be published', 'dw-kido' )
    ) );
  } else {
    // $post_title, $post_content, $post_category, $post_image, $post_id
    if ( ! current_user_can( 'publish_posts' ) ) {
      wp_send_json_error( array(
        'message' => __( 'You do not have permission to publish posts', 'dw-kido' ),
      ) );
    }

    //Prepare post data
    $post_title = isset( $_POST['post_title'] ) ? esc_html( $_POST['post_title'] ) : false;
    $post_content = isset( $_POST['post_content'] ) ? sanitize_text_field( $_POST['post_content'] ) : false ;
    $post_thumbnails = isset( $_POST['post_thumbnails'] ) && esc_html( $_POST['post_thumbnails'] ) ? $_POST['post_thumbnails'] : '';
    $post_category = isset( $_POST['post_category'] ) ? intval( $_POST['post_category'] ) : false;
    $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : false;
    $post_thumbnails = isset($_POST['post_thumbnails']) ? sanitize_text_field( $_POST['post_thumbnails'] ) : false;
    
    $gallery = array();
    if ( $post_thumbnails ) {
      $gallery = array_filter( explode( ',', $post_thumbnails ), create_function('$item', 'return $item != \'\'; ' ) );
    }

    if ( ! $post_title || ! $post_content ) {
      wp_send_json_error( array(
        'message' => __( 'Post data is not valid', 'dw-kido' ),
      ) );
    }

    global $current_user;

    $action = 'insert';

    //In case we have post thumbnails on sumbit
    if ( count( $gallery ) > 1 ) {
      $post_content = '<div class="content-featured">[gallery ids="'.$post_thumbnails.'"]</div>' . $post_content;
    }

    $post_args = array(
      'post_title'    => $post_title,
      'post_content'  => $post_content,
      'post_status'   => 'publish',
      'post_author'   => $current_user->ID,
      'post_category' => array($post_category),
    );
    if ( $post_id ) {
      $post_args['ID'] = $post_id;
      $action = 'update';
    }

    $post_id = wp_insert_post( $post_args );
    if ( ! is_wp_error( $post_id ) ) {
      $message = '';
      $message .= sprintf( '<div class="alert alert-success">%s. <a href="%s">%s</a></div>',
                    ( 'insert' == $action ? __( 'Your post has been published', 'dw-kido' ) : __( 'Your post has been updated', 'dw-kido' ) ),
                    get_permalink( $post_id ),
                    __( 'View post', 'dw-kido' )
                  );
      if ( $post_thumbnails ) {
        update_post_meta( $post_id, '_dw_kido_post_thumbnails', $post_thumbnails );
        foreach ( $gallery as $key => $attach_id ) {
          if ( 0 == $key && count( $gallery ) == 1 ) {
            set_post_thumbnail( $post_id, $attach_id );
          }
          wp_update_post( array(
            'ID' => $attach_id,
            'post_parent' => $post_id,
          ) );
        }
      }

      wp_send_json_success( array(
        'message' => $message,
        'post_id' => $post_id,
      ) );
    }
  }
    
}
add_action( 'wp_ajax_dw-kido-post-form-submit', 'dw_kido_fee_manage_post' );
add_action( 'wp_ajax_nopriv_dw-kido-post-form-submit', 'dw_kido_fee_manage_post' );

add_filter( 'get_edit_post_link', 'dw_kido_fee_get_edit_post_link', 10, 2 );
function dw_kido_fee_get_edit_post_link( $admin_edit_url, $post_id ) {
  $pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'inc/front-end-editor.php'
  ));
  if( $pages && !is_admin() ) {
    $edit_url = add_query_arg( array( 'action' => 'edit', 'post' => $post_id ), get_permalink( $pages[0]->ID ) );
  } else {
    $edit_url = $admin_edit_url;
  }
  return $edit_url;
}

//Handle upload file for front-end editor
function dw_kido_handle_upload_file() {
  check_ajax_referer( 'dw-kido-post-form' );

  // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
  require_once( ABSPATH . 'wp-admin/includes/image.php' );

  //Upload file
  $upload = wp_handle_upload( $_FILES['dw-post-form-galerry-images'], array( 'test_form' => false ) );
  // and output the results or something...
  if ( ! isset( $upload['error'] ) ) {

    //$filename should be the path to a file in the upload directory.
    $filename = $upload['file'];

    // The ID of the post this attachment is for.
    $parent_post_id = false;
    //$parent_post_id = 37;

    // Check the type of tile. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype( basename( $filename ), null );

    // Get the path to the upload directory.
    $wp_upload_dir = wp_upload_dir();

    // Prepare an array of post data for the attachment.
    $attachment = array(
      'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
      'post_mime_type' => $filetype['type'],
      'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
      'post_content'   => '',
      'post_status'    => 'inherit'
    );

    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    $upload['attach_id'] = $attach_id;

    wp_send_json_success( array(
      'file' => $upload
    ) );
  } else {
    wp_send_json_error( array(
      'message' => 'Upload fail!'
    ) );
  }
  exit(0);
}
add_action( 'wp_ajax_dw-kido-upload', 'dw_kido_handle_upload_file' );

//Remove image from media manager when click on remove image of image slides
function dw_kido_remove_attachment() {
  if ( ! isset($_POST['attach_id']) ) {
    wp_send_json_error( array(
      'message' => __( 'Attachment ID is missing', 'dw-kido' ),
    ) );
  }

  if ( ! isset($_POST['post_id']) || ! is_user_logged_in() || ! current_user_can( 'edit_post', intval( $_POST['post_id'] ) ) ) {
    wp_send_json_error( array(
      'message' => __('You do not have permission to delete this attachment', 'dw-kido' ),
    ) );
  }
  wp_delete_attachment( $_POST['attach_id'], true );
  wp_send_json_success( array(
    'message' => __('The Attachment was remove successful', 'dw-kido' ),
  ) );
}
add_action( 'wp_ajax_dw-kido-remove-attachment', 'dw_kido_remove_attachment' );
