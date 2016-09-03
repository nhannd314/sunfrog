<div class="wrap">
    <h2><?php _e( 'Get Products', 'sunfrog' ); ?></h2>

    <!-- get products by category URL -->
    <div class="sunfrog-wrap">
        <h3><?php _e( 'Get Products By Category URL', 'sunfrog' ); ?></h3>
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
            <p>
                <label><?php _e('Select your product category', 'sunfrog') ?></label>

                <?php $terms = get_terms( array( 'taxonomy' => 'sunfrog-category', 'hide_empty' => false ) ) ?>

                <select name="category">

                    <?php if (is_array($terms)) foreach ($terms as $term): ?>

                        <option value="<?php echo $term->name ?>"><?php echo 'ID='.$term->term_id.'. '.$term->name.' ('.$term->count.' products)' ?></option>

                    <?php endforeach; ?>

                </select>
            </p>

            <p>
                <label><?php _e('Input your category URL', 'sunfrog') ?></label>
                <input type="text" name="category_url">
            </p>

            <?php  wp_nonce_field( 'sunfrog_get_products_action' ); ?>

            <input type="submit" name="sunfrog_get_products" value="<?php _e('Get Products', 'sunfrog') ?>" class="button">

        </form>
    </div>
    <!--/ .sunfrog-wrap -->

    <div class="sunfrog-wrap">
        <h3><?php _e( 'Get Single Product', 'sunfrog' ); ?></h3>

        <?php
        if ( isset( $_POST['sunfrog_get_single_product'] ) && check_admin_referer( 'sunfrog_get_single_product_action' ) ) {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_die( __( 'You are not allowed to be on this page', 'sunfrog' ) );
            }
            $category = sanitize_title( $_POST['category'] );
            $product_url = esc_html( $_POST['product_url'] );

            if ( !sunfrog_valid_product_url($product_url) )
                printf('<p style="color:orangered">%s</p>', __('Invalid URL', 'sunfrog'));
            else
                sunfrog_get_single_product( $category, $product_url );
        }
        ?>

        <form action="" method="post">
            <p>

                <?php $terms = get_terms( array( 'taxonomy' => 'sunfrog-category', 'hide_empty' => false ) ) ?>

                <label><?php _e('Select your product category', 'sunfrog') ?></label>
                <select name="category">

                    <?php if (is_array($terms)) foreach ($terms as $term): ?>

                        <option value="<?php echo $term->name ?>"><?php echo 'ID='.$term->term_id.'. '.$term->name.' ('.$term->count.' products)' ?></option>

                    <?php endforeach; ?>

                </select>
            </p>

            <p>
                <label><?php _e('Input your product URL', 'sunfrog') ?></label>
                <input type="text" name="product_url">
            </p>

            <?php  wp_nonce_field( 'sunfrog_get_single_product_action' ); ?>

            <input type="submit" name="sunfrog_get_single_product" value="<?php _e('Get Product', 'sunfrog') ?>" class="button">

        </form>
    </div>
    <!--/ .sunfrog-wrap -->

</div>