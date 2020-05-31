<?php
/**
 * Theme activation
 */
if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' == $GLOBALS['pagenow'] ) {
    wp_redirect( admin_url( 'themes.php?page=theme_activation_options' ) );
    exit;
}

function dw_kido_theme_activation_options_init() {
    register_setting(
        'dw_kido_activation_options',
        'dw_kido_theme_activation_options'
        );
}
add_action( 'admin_init', 'dw_kido_theme_activation_options_init' );

function dw_kido_activation_options_page_capability( $capability ) {
    return 'edit_theme_options';
}
add_filter( 'option_page_capability_dw_kido_activation_options', 'dw_kido_activation_options_page_capability' );

function dw_kido_theme_activation_options_add_page() {
    $dw_kido_activation_options = dw_kido_get_theme_activation_options();

    if ( ! $dw_kido_activation_options ) {
        $theme_page = add_theme_page(
            __( 'Theme Activation', 'dw-kido' ),
            __( 'Theme Activation', 'dw-kido' ),
            'edit_theme_options',
            'theme_activation_options',
            'dw_kido_theme_activation_options_render_page'
            );
    } else {
        if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] === 'theme_activation_options' ) {
            flush_rewrite_rules();
            wp_redirect( admin_url( 'themes.php' ) );
            exit;
        }
    }
}
add_action( 'admin_menu', 'dw_kido_theme_activation_options_add_page', 50 );

function dw_kido_get_theme_activation_options() {
    return get_option( 'dw_kido_theme_activation_options' );
}

function dw_kido_theme_activation_options_render_page() { ?>
    <div class="wrap">
        <h2><?php printf( __( '%s Theme Activation', 'dw-kido' ), wp_get_theme() ); ?></h2>
        <div class="update-nag">
            <?php esc_html_e( 'These settings are optional and should usually be used only on a fresh installation', 'dw-kido' ); ?>
        </div>
        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'dw_kido_activation_options' ); ?>

            <table class="form-table">

                <!-- Change permalink structure  -->

                <tr valign="top"><th scope="row"><?php esc_html_e( 'Change permalink structure ?', 'dw-kido' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e( 'Update permalink structure ?', 'dw-kido' ); ?></span></legend>
                            <select name="dw_kido_theme_activation_options[change_permalink_structure]" id="change_permalink_structure">
                                <option selected="selected" value="true"><?php esc_html_e( 'Yes', 'dw-kido' ); ?></option>
                                <option value="false"><?php esc_html_e( 'No', 'dw-kido' ); ?></option>
                            </select>
                            <p class="description"><?php printf( esc_html__( 'Change permalink structure to /&#37;postname&#37;/', 'dw-kido' ) ); ?></p>
                        </fieldset>
                    </td>
                </tr>

                <tr valign="top"><th scope="row"><?php esc_html_e( 'Change number of posts per page ?', 'dw-kido' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e( 'Change number of posts per page ?', 'dw-kido' ); ?></span></legend>
                            <select name="dw_kido_theme_activation_options[change_posts_per_page]" id="change_posts_per_page">
                                <option selected="selected" value="true"><?php esc_html_e( 'Yes', 'dw-kido' ); ?></option>
                                <option value="false"><?php esc_html_e( 'No', 'dw-kido' ); ?></option>
                            </select>
                            <p class="description"><?php printf( esc_html__( 'Change blog pages show at most 5 posts', 'dw-kido' ) ); ?></p>
                        </fieldset>
                    </td>
                </tr>

                <tr valign="top"><th scope="row"><?php esc_html_e( 'Update image sizes ?', 'dw-kido' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e( 'Update image size ?', 'dw-kido' ); ?></span></legend>
                            <select name="dw_kido_theme_activation_options[change_image_sizes]" id="change_image_sizes">
                                <option selected="selected" value="true"><?php esc_html_e( 'Yes', 'dw-kido' ); ?></option>
                                <option value="false"><?php esc_html_e( 'No', 'dw-kido' ); ?></option>
                            </select>
                        </fieldset>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

    <?php
}

function dw_kido_theme_activation_action() {
    if ( ! ( $dw_kido_theme_activation_options = dw_kido_get_theme_activation_options() ) ) {
        return;
    }

    if ( strpos( wp_get_referer(), 'page=theme_activation_options' ) === false ) {
        return;
    }


    // Theme settings
    // -------------------------------

    // Permalink

    if ( $dw_kido_theme_activation_options['change_permalink_structure'] === 'true' ) {
        $dw_kido_theme_activation_options['change_permalink_structure'] = false;

        if ( get_option( 'permalink_structure' ) !== '/%postname%/' ) {
            global $wp_rewrite;
            $wp_rewrite->set_permalink_structure( '/%postname%/' );
            flush_rewrite_rules();
        }
    }

    // Post per page

    if ( $dw_kido_theme_activation_options['change_posts_per_page'] === 'true' ) {
        $dw_kido_theme_activation_options['change_posts_per_page'] = false;

        update_option( 'posts_per_page', '5' );
    }

    // Image Sizes

    if ( $dw_kido_theme_activation_options['change_image_sizes'] === 'true' ) {
        $dw_kido_theme_activation_options['change_image_sizes'] = false;

        update_option( 'thumbnail_size_w', '740' );
        update_option( 'thumbnail_size_h', '520' );
        update_option( 'thumbnail_crop', '1' );

        update_option( 'large_size_w', '740' );
        update_option( 'large_size_h', '520' );
    }

    // ##
    // -------------------------------

    update_option( 'dw_kido_theme_activation_options', $dw_kido_theme_activation_options );

}
add_action( 'admin_init','dw_kido_theme_activation_action' );

function dw_kido_deactivation() {
    delete_option( 'dw_kido_theme_activation_options' );
}
add_action( 'switch_theme', 'dw_kido_deactivation' );
