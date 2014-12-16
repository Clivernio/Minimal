<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="form-group">
    <input type="search" value="<?php if ( is_search() ) { echo esc_html( get_search_query() ); } ?>" name="s" class="search-field form-control input-sm border-radisus-rounded-base">
    <label class="sr-only"><?php _e( 'Search for:', 'dw-kido' ); ?></label>
    <button type="submit" class="search-submit btn btn-icon"><span class="sr-only"><?php _e( 'Search', 'dw-kido' ); ?></span><span class="fa fa-search"></span></button>
  </div>
</form>