<div class="wrap">
    <h2><?php _e( 'SunFrog Plugin', 'sunfrog' ); ?></h2>

    <div class="sunfrog-wrap">
        <h3><?php _e( 'Affiliate ID', 'sunfrog' ) ?></h3>

        <?php
        if ( isset($_POST['sunfrog_change_affiliate_id']) && check_admin_referer( 'sunfrog_change_affiliate_id_action' ) ) {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_die( __( 'You are not allowed to be on this page', 'sunfrog' ) );
            }
            $affiliate_id = sanitize_text_field( $_POST['affiliate-id'] );

            if ( !sunfrog_valid_affiliate_id($affiliate_id) )
                printf( '<p style="color:orangered">%s</p>', __( 'Invalid Affiliate ID', 'sunfrog' ) );
            else
                update_option( 'sunfrog_affiliate_id', $affiliate_id );
        }
        ?>

        <p><?php printf( __( 'Your Affiliate ID is <strong>%s</strong>', 'sunfrog' ), get_option('sunfrog_affiliate_id')) ?></p>
        <form method="post" action="">
            <p>
                <label><?php _e( 'Change your Affiliate ID', 'sunfrog' ) ?></label>
                <input type="text" name="affiliate-id" placeholder="<?php _e( 'Affiliate ID' ) ?>">
            </p>

            <?php wp_nonce_field( 'sunfrog_change_affiliate_id_action' ) ?>

            <input type="submit" class="button" name="sunfrog_change_affiliate_id" value="<?php _e( 'Save', 'sunfrog' ) ?>">
        </form>
    </div>
    <!--/ .sunfrog-wrap -->

    <div class="sunfrog-wrap">
        <h3><?php _e( 'Sunfrog Options', 'sunfrog' ) ?></h3>

        <?php
        if ( isset($_POST['sunfrog_change_options']) && check_admin_referer( 'sunfrog_change_options_action' ) ) {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_die( __( 'You are not allowed to be on this page', 'sunfrog' ) );
            }
            if (isset( $_POST['show-iframe'] ) && $_POST['show-iframe'] == 1)
                update_option( 'sunfrog_show_iframe', 1 );
            else
                update_option( 'sunfrog_show_iframe', 0 );

            $iframe_css = sanitize_text_field( $_POST['iframe-css'] );
            if ( sunfrog_valid_css_style( $iframe_css ) )
                update_option( 'sunfrog_iframe_css', $iframe_css );
        }
        ?>

        <form method="post" action="">
            <p>
                <label><?php _e( 'Show iframe in single post', 'sunfrog' ) ?></label>
                <input type="checkbox" name="show-iframe" value="1" <?php echo ( get_option( 'sunfrog_show_iframe' ) == '1' ? 'checked' : '' ) ?>>
            </p>
            <p>
                <label><?php _e( 'Iframe CSS', 'sunfrog' ) ?></label>
                <textarea name="iframe-css" rows="7"><?php echo get_option( 'sunfrog_iframe_css' ) ?></textarea>
            </p>

            <?php wp_nonce_field( 'sunfrog_change_options_action' ) ?>

            <input type="submit" class="button" name="sunfrog_change_options" value="<?php _e( 'Save Options', 'sunfrog' ) ?>">
        </form>
    </div>
    <!--/ .sunfrog-wrap -->

    <div class="sunfrog-wrap">
        <h3><?php _e( 'Instruction', 'sunfrog' ) ?></h3>
        <ul class="instruction-list">
            <li>Manually input the product categories in Menu: <strong>Products > Product Category</strong></li>
            <li>Return product iframe in loop: <code>&lt;?php sunfrog_product_iframe() ?&gt;</code></li>
            <li>Shortcode Get product iframe: <code>[product-iframe]</code></li>
            <li>Return product image link in loop: <code>&lt;?php sunfrog_product_img_link() ?&gt;</code></li>
            <li>Shortcode Get product image link: <code>[product-img-link]</code></li>
            <li>Return product url in loop: <code>&lt;?php sunfrog_product_url() ?&gt;</code></li>
            <li>Shortcode Get product url: <code>[product-url]</code></li>
        </ul>
    </div>
</div>