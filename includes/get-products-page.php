<div class="wrap sunfrog-wrap">
    <h2><?php _e( 'SunFrog Get Products', 'sunfrog' ); ?></h2>

    <?php
    if ( isset( $_POST['sunfrog_get_products'] ) && check_admin_referer( 'sunfrog_get_products_action' ) ) {
        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You are not allowed to be on this page', 'sunfrog' ) );
        }
        $category = sanitize_title( $_POST['category'] );
        $category_url = esc_html( $_POST['category_url'] );

        if ( !sunfrog_valid_category_url($category_url) )
            printf('<p style="color:orangered">%s</p>', __('Invalid URL', 'sunfrog'));
        else
            sunfrog_get_products_by_category( $category, $category_url );
    }
    ?>

    <form action="" method="post">
        <p><?php _e('Select your product category', 'sunfrog') ?></p>

        <p>

            <?php $terms = get_terms( array( 'taxonomy' => 'sunfrog-category', 'hide_empty' => false ) ) ?>

            <select name="category">

                <?php if (is_array($terms)) foreach ($terms as $term): ?>

                    <option value="<?php echo $term->name ?>"><?php echo 'ID='.$term->term_id.'. '.$term->name.' ('.$term->count.' products)' ?></option>

                <?php endforeach; ?>

            </select>
        </p>

        <p><?php _e('Input your category URL', 'sunfrog') ?></p>

        <p><input type="text" name="category_url"></p>

        <?php  wp_nonce_field( 'sunfrog_get_products_action' ); ?>

        <p><input type="submit" name="sunfrog_get_products" value="<?php _e('Get', 'sunfrog') ?>" class="button"></p>

    </form>
</div>