+function($) {

  // Carousel
  // ----------------------------
  
  $('.carousel').carousel();

  // Responsive Iframe
  // ----------------------------

  function responsiveIframe() {
    $('.hentry iframe, .widget iframe').each(function() {
      var parent = $(this).parent().attr('class');
      if (!$(this).hasClass('twitter-tweet') && parent !== 'video-preview form-group') {
        var iw = $(this).attr('width'),
          ih = $(this).attr('height'),
          ip = $(this).parent().width(),
          ipw = ip / iw,
          ipwh = ih * ipw;
        if (iw !== '100%') {
          $(this).css({
            'width': ip, 
            'height': ipwh,
          });
        }
      }
    });
  }

  responsiveIframe();

  $(window).resize(function(){ 
    responsiveIframe();
  });


  // Sidebar toggle
  // ----------------------------

  $('.sidebar-toggle').click(function(){
    $('html').toggleClass('show-sidebar');
  });
  

  // Comment
  // ----------------------------

  function IsEmail( email ) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test( email );
  }

  $('#commentform').on('submit', function(event){
    var flag = true,
        name = $('.comment-respond #author[aria-required]'),
        email = $('.comment-respond #email[aria-required]'),
        content = $('.comment-form-comment textarea#comment'); 

    if ( ! name.val() ) {
      flag = false;
      name.addClass( 'not-valid' );
    } else {
      name.removeClass( 'not-valid') ;
    }

    if ( ! IsEmail( email.val() ) ) {
      flag = false;
      email.addClass( 'not-valid' );
    } else {
      email.removeClass( 'not-valid') ;
    }

    if ( ! content.val() ) {
      flag = false;
      content.addClass( 'not-valid' ); 
    } else {
      content.removeClass( 'not-valid') ;
    }

    $( '#commentform .not-valid' ).focus( function(){
      $( '.comment-alert' ).fadeOut();
    });

    if( ! flag ) {
      event.preventDefault();
      if ( ! $('#commentform .comment-alert').length ) {
        $('.form-submit').after('<div class="comment-alert alert alert-danger">Please fill in the required fields.</div>');

        setTimeout(
          function(){
            $('.comment-alert').fadeIn();
          }, 1
        );
      } else {
        setTimeout(
          function(){
            $('.comment-alert').fadeIn();
          }, 1
        );
      }
    }
  }); 

  // Scroll Top
  // ----------------------------

  var scrollTimeout;
  $(window).scroll(function(){
      clearTimeout(scrollTimeout);
      if($(window).scrollTop()>400){
          scrollTimeout = setTimeout(function(){$('a.scroll-top:hidden').fadeIn();},100);
      }
      else{
          scrollTimeout = setTimeout(function(){$('a.scroll-top:visible').fadeOut();},100);
      }
  });

  $('a.scroll-top').click(function(){
      $('html,body').animate({scrollTop:0},500);
      return false;
  });

  // Social share
  // ----------------------------

  var intentRegex = /twitter\.com(\:\d{2,4})?\/intent\/(\w+)/,
    windowOptions = 'scrollbars=yes,resizable=yes,toolbar=no,location=yes',
    width = 550,
    height = 420,
    winHeight = screen.height,
    winWidth = screen.width;

  $('.entry-footer .social-links a').on('click', function(event) {
    var href = $(this).attr('href');
    // if (!href.match(intentRegex)) {
    event.preventDefault(); 
    var left = Math.round((winWidth / 2) - (width / 2));
    var top = 0;
    if (winHeight > height) {
      top = Math.round((winHeight / 2) - (height / 2));
    }
    window.open(href, 'DWJASON', windowOptions + ',width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
    // }
  });  

}(jQuery);
