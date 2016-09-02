<div class="wrap sunfrog-wrap">
    <h2><?php _e( 'SunFrog', 'sunfrog' ); ?></h2>

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
        <p><?php _e( 'Change your Affiliate ID', 'sunfrog' ) ?></p>
        <p><input type="text" name="affiliate-id" placeholder="<?php _e( 'Affiliate ID' ) ?>"></p>

        <?php wp_nonce_field( 'sunfrog_change_affiliate_id_action' ) ?>

        <p><input type="submit" class="button" name="sunfrog_change_affiliate_id" value="<?php _e('Save') ?>"></p>
    </form>

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