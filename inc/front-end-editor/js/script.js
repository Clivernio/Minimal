var editor = new MediumEditor('.editable', {
  buttons: ['bold', 'italic', 'underline', 'anchor', 'header1', 'header2', 'quote', 'image'],
  placeholder: "Start writing here ...",
});

(function($) {
  var entry_title = $('.front-end-editor-wrap .entry-title').text();
  $('.front-end-editor-wrap .entry-title').click(function() {
    $(this).removeClass('error');
    if( $(this).text() === 'Add title ...') {
      $(this).text('');
    }
  }).blur(function() {
    if( $(this).text() === '' || $(this).text() === 'Add title ...' ) {
      $(this).text('Add title ...');
      $(this).addClass('error');
    }
    if (entry_title !== $(this).text() ){
      entry_title = $(this).text();
      $('#post_title').val( entry_title );
    }
  });

  var entry_content = $('.front-end-editor-wrap .entry-content').html();
  $('.front-end-editor-wrap .entry-content').blur(function() {
    if (entry_content !== $(this).html() ){
      entry_content = $(this).html();
      $('#post_content').val( entry_content );
    } 
    if ( ! $(this).text().length ) {
      $(this).addClass('error');
    }
  }).click(function() {
    $(this).removeClass('error');
  });

  /*var featured_image_frame;

  $('.add-images').click(function(e) {
    e.preventDefault();

    //If the frame already exists, reopen it
    if (typeof(featured_image_frame)!=="undefined") {
      featured_image_frame.close();
    }

    //Create WP media frame.
    featured_image_frame = wp.media.frames.customHeader = wp.media({
      //Title of media manager frame
      title: "Upload Feature Image",
      library: {
        type: 'image'
      },
      button: {
        //Button text
        text: "Set Feature Image"
      },
      //Do not allow multiple files, if you want multiple, set true
      multiple: false
    });

    //callback for selected image
    featured_image_frame.on('select', function() {
      var attachment = featured_image_frame.state().get('selection').first().toJSON();
      //alert(attachment);
      $('.entry-thumbnail').html('<img src="'+attachment.url+'">');
      $('#post_image').val(attachment.id);
    });

    //Open modal
    featured_image_frame.open();

    //return false;
  });*/

  $('.entry-meta .entry-author a').click(function() {
    return false;
  });

  $('.entry-meta .entry-categories .dropdown-menu a').click(function() {
    $('.entry-meta').removeClass('error');
    $('.entry-meta .entry-categories').removeClass('open');
    $('.entry-meta .entry-categories .dropdown-toggle span').text( $(this).text() );
    $('#post_category').val( $(this).parent().attr('class').replace( 'cat-item cat-item-','' ) );
    return false;
  });

  //form validate
  $('.submit-post input').click(function() {
    var flag = true;
    if( ! $('#post_title').val() || $('#post_title').val() === 'Add title ...' ) {
      flag = false;
      $('.front-end-editor-wrap .entry-title').addClass('error');
    }

    if( ! $('#post_category').val() ) {
      flag = false;
      $('.front-end-editor-wrap .entry-meta').addClass('error');
    }

    if( ! $('#post_content').val() || $('#post_content').val() === '<p><br></p>' ) {
      flag = false;
      $('.front-end-editor-wrap .entry-content').addClass('error');
    }
    if( ! flag ) { 
      return false; 
    }
  });

  //Gallery uploader
  var uploading_image = false;
  var carousel = $('#gallery-'+dw_kido.plupload_init.multipart_params.post_id );

  dw_kido.plupload_init.filters.mime_types.push({
    'title' : 'Image files',
    'extensions' : 'jpg,gif,png',
  });

  // Bind remove item aciton for remove button
  carousel.on( 'click', '.item a.remove', function( event ){
    event.preventDefault();
    var item = $(this).parent();
    if ( $(this).data('attach-id') ) {
      var attach_id = $(this).data('attach-id');
      //This ismage is an attachment
      var find_regex = new RegExp( attach_id + ',' );
      $('#post_thumbnails').val( $('#post_thumbnails').val().replace(find_regex,'') );
      //Remove attachment from media manager
      var post_id = $('#post_id').val();
      if ( post_id ) {
        $.ajax({
          url: dw_kido.ajax_url,
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'dw-kido-remove-attachment',
            attach_id : attach_id,
            post_id : post_id
          },
        });
      } // Remove attachment done


      $('body').addClass('post-form-submitting');
      post_form_submit( $('#dw-kido-post-form') );
    }

    if( carousel.find('.item').length >= 1 ) {
      var idx = carousel.find('.carousel-inner .item').index( item  );
      if ( idx >= 0 ) {
        carousel.find('.carousel-indicators li').eq( idx ).remove();
      }
      if ( item.hasClass('active') ) {
        item.removeClass('active');
        if ( item.next('div.item').length > 0 ) {
          item.next('div.item').addClass('active');
        } else {
          carousel.find('.item:first').addClass('active');
        }
      }
    }

    if ( item.data('file-id').length > 0 ) {
      uploader.removeFile( item.data('file-id') );
    }
    console.log( uploader.files );

    item.remove();
    if( carousel.find('.carousel-inner .item').length <= 0 ) {
      var demoItem = '<div class="item active demo"><i class="fa fa-plus"></i><strong>Add Images</strong><span>Suggested size 580x385px<br>(1160x772px ideal for hi-res)</span></div>';
      $(demoItem).prependTo( carousel.find('.carousel-inner') );
      var input = new mOxie.FileInput({
          browse_button: carousel.find('.carousel-inner .item.demo .fa-plus').get(0),
          multiple: true
      });
      input.onchange = function( event ) {
          uploader.addFile( input.files );
      };
      input.init();
    }
  });
  // I take the given File object (as presented by
  // Plupload), and show the client-side-only preview of
  // the selected image object.
  function showImagePreview( file ) {
    var itemClass = 'item';
    var item = $( '<div class="'+itemClass+'" data-file-id="'+file.id+'"><a href="#" class="remove"><i class="fa fa-times"></i></a></div>' ).prependTo( carousel.find( '.carousel-inner') );
    var image = $( new Image() ).appendTo( item );

    var indicators = $( '<li data-target="#'+carousel.attr('id')+'" data-slide-to="0"></li>').prependTo( carousel.find('.carousel-indicators') );
    var thumb = $( new Image() ).appendTo( indicators );


    // Create an instance of the mOxie Image object. This
    // utility object provides several means of reading in
    // and loading image data from various sources.
    var preloader = new mOxie.Image();

    // Define the onload BEFORE you execute the load()
    // command as load() does not execute async.
    preloader.onload = function() {

      // This will scale the image 
      // preloader.downsize( 750, 750 );
      image.prop( "src", preloader.getAsDataURL() );
      thumb.prop( 'src', preloader.getAsDataURL() );


      carousel.find('.carousel-indicators li').each(function(index, el) {
        $(el).attr('data-slide-to', index );
      });
      carousel.carousel(0);
    };

    // Calling the .getSource() on the file will return an
    // instance of mOxie.File, which is a unified file
    // wrapper that can be used across the various runtimes.
    preloader.load( file.getSource() );
    if( ! carousel.is(':visible') ) {
      carousel.show();
    }

  }

  dw_kido.plupload_init.init = {
      FilesAdded: function(up, files) {
        plupload.each(files, function(file) {
          // Show the client-side preview using the loaded File.
          showImagePreview( file );
        });
      },
      FileUploaded:function( up, file, info ) {
        var response;
        response = eval( '(' + info.response + ')' );
        if( response.success ) { // When attachment was created
          file = response.data.file;
          $('#post_thumbnails').val( $('#post_thumbnails').val() + file.attach_id + ',' );
        }
      },
      UploadComplete: function( up, files ) {
        post_form_submit( $('#dw-kido-post-form') );
      }
  };

  var uploader = new plupload.Uploader( dw_kido.plupload_init );
  uploader.init();

  //Remove Demo Item When carousel have new item
  carousel.on( 'slid.bs.carousel', function() {
    $(this).find('.carousel-inner .item.demo').remove();
  });
  //Bind Browse Button for Demo item
  if ( carousel.find('.carousel-inner .item.demo').length > 0 ) {
    var input = new mOxie.FileInput({
        browse_button: carousel.find('.carousel-inner .item.demo .fa-plus').get(0),
        multiple: true
    });
    input.onchange = function( event ) {
        uploader.addFile( input.files );
    };
    input.init();
  }

  // Post form submit
  function post_form_submit( form ) {
    if ( form.data('submitting') ) {
      return false;
    }
    form.data('submitting',true);
    $.ajax({
      url: dw_kido.ajax_url,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'dw-kido-post-form-submit',
        post_thumbnails: $('#post_thumbnails').val(),
        post_id: $('#post_id').val(),
        post_category: $('#post_category').val(),
        post_title: $('#post_title').val(),
        post_content : $('#post_content').val()
      },
    })
    .done(function( resp ) {
      var message = $('.front-end-editor-wrap').find('.form-submit-complete-message');
      if (message.length<=0) {
        $('<div class="form-submit-complete-message"></div>').prependTo('.front-end-editor-wrap');
      }
      if( resp.success ) {
        //Do something when posb was insert/update success full
        $('#post_id').val( resp.data.post_id );
        $('.front-end-editor-wrap .form-submit-complete-message').html( resp.data.message );
      } else {
        $('.front-end-editor-wrap .form-submit-complete-message').addClass('alert alert-info').html( resp.data.message );
      }
    })
    .always(function() {
      $('body').removeClass('post-form-submitting');
      var point = $('.front-end-editor-wrap .form-submit-complete-message');

      $('html,body').animate({
        'scrollTop': point.offset().top - point.outerHeight()
      }, 500 );
      form.data('uploading',false);
      form.data('submitting',false);
    });
  }

  $('#dw-kido-post-form').on('submit', function(event){
    event.preventDefault();
    var form = $(this);
    if ( form.data('uploading') ) {
      return false;
    }
    form.data('uploading', true);
    $('body').addClass('post-form-submitting');
    if( uploader.files.length > 0 ) {
      uploader.start();
      return false;
    }
    post_form_submit( form );

  });

})(jQuery);
