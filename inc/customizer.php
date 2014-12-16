<?php
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

class DW_Kido_Textarea_Control extends WP_Customize_Control {

	public $type = 'textarea';
	public $statuses;
	public function __construct( $manager, $id, $args = array() ) {

		$this->statuses = array( '' => __( 'Default', 'dw-minion' ) );
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
				<?php echo esc_textarea( $this->value() ); ?>
			</textarea>
		</label>
		<?php
	}
}

function dw_kido_customize_register( $wp_customize ) {

	// Logo
	// -------------------------------------

	$wp_customize->add_setting( 'dw_kido_theme_options[logo]', array(
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label' => __( 'Site Logo', 'dw-kido' ),
		'section' => 'title_tagline',
		'settings' => 'dw_kido_theme_options[logo]',
		'priority' => 10,
		)));

	$wp_customize->add_setting( 'dw_kido_theme_options[header_display]', array(
		'default'        => 'site_title',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		'sanitize_callback' => 'dw_kido_sanitize_header_display',
		));
	$wp_customize->add_control( 'header_display', array(
		'settings' => 'dw_kido_theme_options[header_display]',
		'label'   => __( 'Display as', 'dw-kido' ),
		'section' => 'title_tagline',
		'type'    => 'select',
		'choices'    => array(
			'site_title' => __( 'Site Title', 'dw-kido' ),
			'site_logo' => __( 'Site Logo', 'dw-kido' ),
			),
		'priority'   => 11,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[site_desc]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( new DW_Kido_Textarea_Control( $wp_customize, 'site_desc', array(
		'label'      => __( 'Site Description', 'dw-kido' ),
		'section'    => 'title_tagline',
		'settings'   => 'dw_kido_theme_options[site_desc]',
		'priority'   => 13,
		)));



	// Favicon
	// -------------------------------------

	$wp_customize->add_setting( 'dw_kido_theme_options[favicon]', array(
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'favicon', array(
		'label' => __( 'Site Favicon', 'dw-kido' ),
		'section' => 'title_tagline',
		'settings' => 'dw_kido_theme_options[favicon]',
		'priority'   => 12,
		)));


	// Fonts
	// ------------------------------------

	$wp_customize->add_section( 'dw_kido_fonts', array(
		'title' => __( 'Font selector', 'dw-kido' ),
		'priority' => 280,
		));

	// Heading font

	$wp_customize->add_setting( 'dw_kido_theme_options[heading_font_import]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'heading_font_import', array(
		'settings' => 'dw_kido_theme_options[heading_font_import]',
		'label' => __( 'Headding font - Link', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 1,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[heading_font_font_family]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'heading_font_font_family', array(
		'settings' => 'dw_kido_theme_options[heading_font_font_family]',
		'label' => __( 'Headding font - Font family', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 2,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[heading_font_fw_default]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'heading_font_fw_default', array(
		'settings' => 'dw_kido_theme_options[heading_font_fw_default]',
		'label' => __( 'Headding font - Font weight', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 3,
		));

	// Body font

	$wp_customize->add_setting( 'dw_kido_theme_options[body_font_import]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'body_font_import', array(
		'settings' => 'dw_kido_theme_options[body_font_import]',
		'label' => __( 'Body font - Link', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 4,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[body_font_font_family]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'body_font_font_family', array(
		'settings' => 'dw_kido_theme_options[body_font_font_family]',
		'label' => __( 'Body font - Font family', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 5,
		));


	$wp_customize->add_setting( 'dw_kido_theme_options[body_font_fw_default]', array(
		'default' => '',
		'capability'  => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'body_font_fw_default', array(
		'settings' => 'dw_kido_theme_options[body_font_fw_default]',
		'label'   => __( 'Body font - Font weight', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 6,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[body_font_fw_bold]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		));
	$wp_customize->add_control( 'body_font_fw_bold', array(
		'settings' => 'dw_kido_theme_options[body_font_fw_bold]',
		'label' => __( 'Body font - Font weight bold', 'dw-kido' ),
		'section' => 'dw_kido_fonts',
		'priority' => 7,
		));


	// Brand primary
	// ------------------------------------

	$wp_customize->add_section( 'dw_kido_primary_color', array(
		'title'    => __( 'Style selector', 'dw-kido' ),
		'priority' => 290,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[custom-color]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'        => __( 'Primary color', 'dw-kido' ),
		'section'    => 'dw_kido_primary_color',
		'settings'   => 'dw_kido_theme_options[custom-color]',
		)));


	// Footer
	// -------------------------------------

	$wp_customize->add_section( 'dw_kido_footer', array(
		'title'    => __( 'Footer', 'dw-kido' ),
		'priority' => 300,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[copyright]', array(
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'copyright', array(
		'label'      => __( 'Copyright Info', 'dw-kido' ),
		'section'    => 'dw_kido_footer',
		'settings'   => 'dw_kido_theme_options[copyright]',
		));


	// Socials
	// -------------------------------------

	$wp_customize->add_section( 'dw_kido_social_links', array(
		'title'    => __( 'Social Links', 'dw-kido' ),
		'priority' => 301,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[facebook]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'facebook', array(
		'label'      => __( 'Facebook', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[facebook]',
		'priority'   => 1,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[twitter]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'twitter', array(
		'label'      => __( 'Twitter', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[twitter]',
		'priority'   => 2,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[google_plus]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'google_plus', array(
		'label'      => __( 'Google+', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[google_plus]',
		'priority'   => 3,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[behance]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'behance', array(
		'label'      => __( 'Behance', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[behance]',
		'priority'   => 4,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[dribbble]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'dribbble', array(
		'label'      => __( 'Dribbble', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[dribbble]',
		'priority'   => 5,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[youtube]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'youtube', array(
		'label'      => __( 'YouTube', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[youtube]',
		'priority'   => 6,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[flickr]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'flickr', array(
		'label'      => __( 'Flickr', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[flickr]',
		'priority'   => 7,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[instagram]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'instagram', array(
		'label'      => __( 'Instagram', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[instagram]',
		'priority'   => 8,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[github]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'github', array(
		'label'      => __( 'Github', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[github]',
		'priority'   => 9,
		));

	$wp_customize->add_setting( 'dw_kido_theme_options[linkedin]', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		));
	$wp_customize->add_control( 'linkedin', array(
		'label'      => __( 'LinkedIn', 'dw-kido' ),
		'section'    => 'dw_kido_social_links',
		'settings'   => 'dw_kido_theme_options[linkedin]',
		'priority'   => 10,
		));
}
add_action( 'customize_register', 'dw_kido_customize_register' );

/**
* Get Theme Option
*/

function dw_kido_get_theme_option( $option_name, $default = '' ) {
	$options = get_option( 'dw_kido_theme_options' );
	if ( isset( $options[ $option_name ] ) ) {
		return $options[ $option_name ];
	}
	return $default;
}

/**
* Sanitize Settings
*/
function dw_kido_sanitize_header_display( $header_display ) {
	if ( ! in_array( $header_display, array( 'site_title', 'site_logo' ) ) ) {
		$header_display = 'site_title';
	}
	return $header_display;
}

/**
* colour Brightness
*/

function colour_brightness( $hex, $percent ) {
	// Work out if hash given
	$hash = '';
	if ( stristr( $hex, '#' ) ) {
		$hex = str_replace( '#', '', $hex );
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array( hexdec( substr( $hex, 0, 2 ) ), hexdec( substr( $hex, 2, 2 ) ), hexdec( substr( $hex, 4, 2 ) ) );
	//// CALCULATE 
	for ( $i = 0; $i < 3; $i++ ) {
		// See if brighter or darker
		if ( $percent > 0 ) {
			// Lighter
			$rgb[$i] = round( $rgb[$i] * $percent ) + round( 255 * ( 1 - $percent ) );
		} else {
			// Darker
			$positivePercent = $percent - ( $percent*2 );
			$rgb[$i] = round( $rgb[$i] * $positivePercent ) + round( 0 * ( 1-$positivePercent ) );
		}
		// In case rounding up causes us to go to 256
		if ( $rgb[$i] > 255 ) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for( $i = 0; $i < 3; $i++ ) {
		// Convert the decimal digit to hex
		$hexDigit = dechex( $rgb[$i] );
		// Add a leading zero if necessary
		if( strlen( $hexDigit ) == 1 ) {
			$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

/**
* Display Logo
*/

function dw_kido_get_attachment_id_by_url( $url ) {
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}

	global $wpdb;
	$logo_id = get_option( 'dw-logo' );
	$logo_url = wp_get_attachment_url( $logo_id );

	if ( empty( $logo_id ) && $logo_url !== $url ) {
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );
		$logo_id = $attachment[0];
		if ( $logo_url !== $url ) {
			update_option( 'dw-logo', $logo_id );
		} else {
			add_option( 'dw-logo', $logo_id );
		}	
	}	
	return $logo_id;
}

function dw_kido_logo() {
	$header_display = dw_kido_get_theme_option( 'header_display', 'site_title' );

	if ( $header_display == 'site_logo' ) {
		$header_class = 'display-logo';
	} else {
		$header_class = 'display-title';
	}

	$logo = esc_url( dw_kido_get_theme_option( 'logo' ) );
	$logo_id = dw_kido_get_attachment_id_by_url( $logo );
	$logo_url = wp_get_attachment_image_src( $logo_id, 'logo' );
	if ( $logo_url ) {
		$logo_url = $logo_url[0];
	}

	$tagline = get_bloginfo( 'description' );

	echo '<div class="site-title ' . esc_html( $header_class ) . '"><a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';

	if ( $header_class != 'display-title' && $logo ) {
		echo '<img alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" src="' . esc_url( $logo_url ) . '" />';
	}
	if ( $header_class != 'display-logo' ) {
		echo esc_html( get_bloginfo( 'name' ) );
	}
	echo '</a></div>';

	if ( $tagline && $header_class != 'display-logo' )
		echo '<div class="site-tagline sr-only">' . esc_html( $tagline ) . '</div>';
}


/**
* Display Favicon
*/
function dw_kido_favicon() {
	$favicon = dw_kido_get_theme_option( 'favicon' );
	if ( $favicon )
		echo '<link type="image/x-icon" href="'. esc_url( $favicon ) .'" rel="shortcut icon">';
}
add_action( 'wp_head', 'dw_kido_favicon' );


/**
 * Font Selector
 */
if ( ! function_exists( 'dw_kido_typo_font' ) ) {
	function dw_kido_typo_font(){

		// Heading font

		$heading_font_import = dw_kido_get_theme_option( 'heading_font_import' );
		$heading_font_font_family = dw_kido_get_theme_option( 'heading_font_font_family' );
		$heading_font_fw_default = dw_kido_get_theme_option( 'heading_font_fw_default' );

		if ( $heading_font_import ) :
			?>
			<?php echo wp_kses( $heading_font_import, array(
				'link' => array(
					'href' => array(),
					'rel' => array(),
					'type' => array(),
				),
			)); ?>
			<style type="text/css" id="heading_font" media="screen">
			h1,h2,h3,h4,h5,h6
			.h1,.h2,.h3,.h4,.h5,.h6 {
			<?php echo wp_kses_post( str_replace( ';',' !important;', $heading_font_font_family ) ); ?>
				font-weight: <?php echo esc_html( $heading_font_fw_default ); ?> !important;
			}
			</style>
			<?php
		endif;

		// body font 

		$body_font_import = dw_kido_get_theme_option( 'body_font_import' );
		$body_font_font_family = dw_kido_get_theme_option( 'body_font_font_family' );
		$body_font_fw_default = dw_kido_get_theme_option( 'body_font_fw_default' );
		$body_font_fw_bold = dw_kido_get_theme_option( 'body_font_fw_bold' );

		if ( $body_font_import ) :
			?>
			<?php echo wp_kses( $body_font_import, array(
				'link' => array(
					'href' => array(),
					'rel' => array(),
					'type' => array(),
				),
			)); ?>
			<style type="text/css" id="body_font" media="screen">

			body {
			<?php echo wp_kses_post( str_replace( ';',' !important;', $body_font_font_family ) ); ?>
				font-weight: <?php echo esc_html( $body_font_fw_default ); ?> !important;
			}

			strong, b {
				font-weight: <?php echo esc_html( $body_font_fw_bold ); ?> !important;;
			}

			</style>
			<?php
		endif;
	}
	add_filter( 'wp_head','dw_kido_typo_font' );
}

/**
* Color Selector
*/
if ( ! function_exists( 'dw_kido_typo_color' ) ) {
	function dw_kido_typo_color() {
		$primary_color = dw_kido_get_theme_option( 'custom-color' );

		if ( $primary_color ) { ?>
			<style type="text/css" id="primary_color" media="screen">
			a:hover,a:focus{color:<?php echo esc_html( $primary_color );?>}.text-primary{color:<?php echo esc_html( $primary_color );?>}.bg-primary{background-color:<?php echo esc_html( $primary_color );?>}.btn-primary{background-color:<?php echo esc_html( $primary_color );?>;border-color:<?php echo esc_html( $primary_color );?>}.btn-primary.disabled,.btn-primary[disabled],fieldset[disabled] .btn-primary,.btn-primary.disabled:hover,.btn-primary[disabled]:hover,fieldset[disabled] .btn-primary:hover,.btn-primary.disabled:focus,.btn-primary[disabled]:focus,fieldset[disabled] .btn-primary:focus,.btn-primary.disabled:active,.btn-primary[disabled]:active,fieldset[disabled] .btn-primary:active,.btn-primary.disabled.active,.btn-primary[disabled].active,fieldset[disabled] .btn-primary.active{background-color:<?php echo esc_html( $primary_color );?>;border-color:<?php echo esc_html( $primary_color );?>}.btn-primary .badge{color:<?php echo esc_html( $primary_color );?>}.btn-link:hover,.btn-link:focus{color:<?php echo esc_html( $primary_color );?>}.dropdown-menu > .active > a,.dropdown-menu > .active > a:hover,.dropdown-menu > .active > a:focus{color:<?php echo esc_html( $primary_color );?>}.nav-pills > li.active > a,.nav-pills > li.active > a:hover,.nav-pills > li.active > a:focus{background-color:<?php echo esc_html( $primary_color );?>}.pagination > li > a:hover,.pagination > li > span:hover,.pagination > li > a:focus,.pagination > li > span:focus{color:<?php echo esc_html( $primary_color );?>}.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus{background-color:<?php echo esc_html( $primary_color );?>;border-color:<?php echo esc_html( $primary_color );?>}.label-primary{background-color:<?php echo esc_html( $primary_color );?>}.progress-bar{background-color:<?php echo esc_html( $primary_color );?>}.list-group-item.active,.list-group-item.active:hover,.list-group-item.active:focus{background-color:<?php echo esc_html( $primary_color );?>;border-color:<?php echo esc_html( $primary_color );?>}.panel-primary{border-color:<?php echo esc_html( $primary_color );?>}.panel-primary > .panel-heading{color:#ffffff;background-color:<?php echo esc_html( $primary_color );?>;border-color:<?php echo esc_html( $primary_color );?>}.panel-primary > .panel-heading + .panel-collapse > .panel-body{border-top-color:<?php echo esc_html( $primary_color );?>}.panel-primary > .panel-heading .badge{color:<?php echo esc_html( $primary_color );?>}.panel-primary > .panel-footer + .panel-collapse > .panel-body{border-bottom-color:<?php echo esc_html( $primary_color );?>}a:hover,a:focus{color:<?php echo esc_html( $primary_color );?>}.page-header{border-bottom:4px solid <?php echo esc_html( $primary_color );?>}.nav-tabs > li.active > a:before{background:<?php echo esc_html( $primary_color );?>}.dropdown-menu a:hover{color:<?php echo esc_html( $primary_color );?>!important}.scroll-top:hover{border-color:<?php echo esc_html( $primary_color );?>;color:<?php echo esc_html( $primary_color );?>}.site-title.display-title a:hover{color:<?php echo esc_html( $primary_color );?>}.comment-meta a:hover{color:<?php echo esc_html( $primary_color );?>}.comment .reply a:hover{color:<?php echo esc_html( $primary_color );?>}.related-title a:hover{color:<?php echo esc_html( $primary_color );?>}.hentry{border-bottom:4px solid <?php echo esc_html( $primary_color );?>}.hentry .entry-title a:hover{color:<?php echo esc_html( $primary_color );?>}.hentry .entry-meta a:hover{color:<?php echo esc_html( $primary_color );?>}.hentry .entry-footer a:hover{color:<?php echo esc_html( $primary_color );?>}.sidebar-bottom a:hover{color:<?php echo esc_html( $primary_color );?>}.widget_categories .current-cat > a{color:<?php echo esc_html( $primary_color );?>}.widget_nav_menu a{color:<?php echo esc_html( $primary_color );?>}.widget_pages .current_page_item > a{color:<?php echo esc_html( $primary_color );?>}.btn-primary:hover,.btn-primary:focus,.btn-primary:active,.btn-primary.active,.open > .dropdown-toggle.btn-primary{background-color:<?php echo esc_html( colour_brightness( $primary_color,-0.9 ) );?>;border-color:<?php echo esc_html( colour_brightness( $primary_color,-0.85 ) );?>}blockquote{border-left-color:<?php echo esc_html( $primary_color );?>}
			</style>
		<?php
		}
	}
	add_filter( 'wp_head', 'dw_kido_typo_color' );
}

/**
* Display Social Links
*/
function dw_kido_social_links( $social_networks = array( 'facebook', 'twitter', 'google_plus', 'behance', 'dribbble', 'youtube', 'flickr', 'instagram', 'github', 'linkedin' ) ) {
	$social_links = array();
	for ( $i = 0; $i < count( $social_networks ); $i++ ) {
		$social_links[ $social_networks[ $i ] ] = dw_kido_get_theme_option( $social_networks[ $i ] );
	}
	if ( count( $social_links ) > 0 ) {
		echo '<ul class="social-links list-inline">';
		foreach ( $social_links as $social_link => $value ) {
			if ( $value ) { ?>
				<li class="<?php echo esc_html( str_replace( '_', '-', $social_link ) ); ?>"><a href="<?php echo esc_url( $value ); ?>" target="_blank"><i class="fa fa-<?php echo esc_html( str_replace( '_', '-', $social_link ) ); ?>"></i></a></li>
			<?php }
		}
		echo '</ul>';
	}
}
