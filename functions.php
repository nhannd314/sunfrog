<?php

include 'inc/curl.php';
include 'inc/simplehtmldom/simple_html_dom.php';

/**
 * Create custom post type and custom taxonomy
 */

if ( !function_exists('sunfrog_create_custom_post_type_taxonomy') )
{
    function sunfrog_create_custom_post_type_taxonomy()
    {
        register_post_type('sunfrog', array(
            'labels' => array(
                'name' => __('Products', 'sunfrog'),
                'singular_name' => __('Product', 'sunfrog')
            ),
            'description' => __('SunFrog Products', 'sunfrog'),
            'supports' => array(
                'title', 'editor', 'thumbnail'
            ),

            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 7,
            'menu_icon' => 'dashicons-images-alt2',
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
            'taxonomies' => array( 'post_tag' )
        ));

        register_taxonomy('sunfrog-category', 'sunfrog', array(
            'labels' => array(
                'name' => __('Product Categories', 'sunfrog'),
                'singular' => __('Product Category', 'sunfrog'),
                'menu_name' => __('Product Category', 'sunfrog')
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        ));
    }
}

/**
 * SunFrog init function
 */

if ( !function_exists('sunfrog_init') )
{
    function sunfrog_init()
    {
        global $sunfrog_plugin_dir;
        load_plugin_textdomain( 'sunfrog', false, $sunfrog_plugin_dir );
    }
}

/**
 * Include style and js in admin
 */

if ( !function_exists( 'sunfrog_admin_enqueue_scripts' ) )
{
    function sunfrog_admin_enqueue_scripts()
    {
        wp_enqueue_style( 'sunfrog_admin_css', plugins_url( 'assets/css/style.css', __FILE__ ), false, '1.0.0' );
    }
}

/**
 * Create admin menu
 */

if ( !function_exists('sunfrog_admin_menu') )
{
    function sunfrog_admin_menu() {
        add_menu_page( 'SunFrog', 'SunFrog', 'manage_options', 'sunfrog', 'sunfrog_admin_page', 'dashicons-smiley', 6  );
        add_submenu_page( 'sunfrog', 'Get Products', 'Get Products', 'manage_options', 'get_products', 'sunfrog_admin_page_get_products' );
    }
}

/**
 * Main admin page
 */

if ( !function_exists('sunfrog_admin_page') )
{
    function sunfrog_admin_page()
    {
        include 'includes/sunfrog-page.php';
    }
}

/**
 * Sunfrog valid affiliate ID
 */

if ( !function_exists( 'sunfrog_valid_affiliate_id' ) )
{
    function sunfrog_valid_affiliate_id($ID)
    {
        if ( empty($ID) ) return false;
        if ( !is_numeric($ID) ) return false;
        return true;
    }
}

/**
 * Sunfrog valid category URL
 */

if ( !function_exists( 'sunfrog_valid_category_url' ) )
{
    function sunfrog_valid_category_url($url)
    {
        if ( empty($url) ) return false;
        return true;
    }
}

/**
 * Check valid product URL
 */

if ( !function_exists( 'sunfrog_valid_product_url' ) )
{
    function sunfrog_valid_product_url($url)
    {
        if ( empty($url) ) return false;
        return true;
    }
}

if ( !function_exists( 'sunfrog_valid_css_style' ) )
{
    function sunfrog_valid_css_style( $str )
    {
        if ($str == '') return false;
        return true;
    }

}
/**
 * Get products page
 */

if ( !function_exists('sunfrog_admin_page_get_products') )
{
    function sunfrog_admin_page_get_products()
    {
        include 'includes/get-products-page.php';
    }
}

/**
 * Get products by category url
 */

if ( !function_exists( 'sunfrog_get_products_by_category' ) )
{
    function sunfrog_get_products_by_category($category, $category_url)
    {
        $str = sunfrog_curl( html_entity_decode( $category_url ) );

        if (!$str) return;

        // Create a DOM object
        $html_base = new simple_html_dom();
        // Load HTML from a string
        $html_base->load($str);

        $base_url = 'https://www.sunfrog.com';

        // get all category links
        $list_products = $html_base->find( '.frameitWrapper' );
        echo 'Total product ' . sizeof( $list_products ) . '<br>';
        $i = 1;
        foreach ( $list_products as $element )
        {
            // get url of product item
            echo '<br>' . $i++ . '. ';
            $url = html_entity_decode( $element->find('a', 0)->href );
            sunfrog_get_single_product( $category, $url );
        }

        $html_base->clear();
        unset($html_base);
    }
}

/**
 * Get products by category url
 */

if ( !function_exists( 'sunfrog_get_single_product' ) )
{
    function sunfrog_get_single_product( $category, $url )
    {
        echo 'URL: ' . $url . '<br>';

        $post_query = new WP_Query( "post_type=sunfrog&meta_key=_url&meta_value=$url&order=ASC" );

        // if post not exist then insert new post
        if ( !$post_query->have_posts() )
        {
            $product_array = sunfrog_product_array($url);

            if ( !empty( $product_array ) ) {
                echo 'Name: '.$product_array['name'].'<br>';
                echo 'Image link: '.$product_array['img_link'].'<br>';

                $post_id = wp_insert_post(array(
                    'post_title' => $product_array['name'],
                    'post_status' => 'publish',
                    'post_type' => 'sunfrog',
                    'post_content' => $product_array['description']
                ));
                // if insert successful
                if ( $post_id ) {
                    // add post to category
                    wp_set_object_terms( $post_id, $category, 'sunfrog-category');

                    // add post meta
                    add_post_meta($post_id, '_url', $url);
                    add_post_meta($post_id, '_img_link', $product_array['img_link']);
                }
            }
        } // end if post not exist
    }
}

/**
 * Return product array from URL
 */

if ( !function_exists( 'sunfrog_product_array' ) )
{
    function sunfrog_product_array($url)
    {
        $str = sunfrog_curl($url);

        if ( !$str ) return array();

        $product_array = array();

        // Create a DOM object
        $html_base = new simple_html_dom();
        // Load HTML from a string
        $html_base->load($str);

        // get image link
        $product_array['img_link'] = $html_base->find('.productFrame', 0)->find('img', 0)->src;

        $product_explain = $html_base->find('.explain', 0);
        // get name
        $product_array['name'] = $product_explain->find('h1', 0)->innertext;
        // get product description
        $product_array['description'] = trim( $product_explain->find('p', 1)->innertext );

        $html_base->clear();
        unset($html_base);

        return $product_array;
    }
}

/**
 * Add meta box
 */

function sunfrog_meta_box()
{
    add_meta_box( '_img_link', 'Image link', 'sunfrog_img_link_meta_box', 'sunfrog' );
    add_meta_box( '_url', 'URL', 'sunfrog_url_meta_box', 'sunfrog' );
}

function sunfrog_img_link_meta_box( $post )
{
    wp_nonce_field( 'sunfrog_save_meta_box_action', 'sunfrog_nonce' );
    echo '<input type="text" class="sunfrog-text-box" id="sunfrog_img_link" name="sunfrog_img_link" value="'.esc_attr( get_post_meta( $post->ID, '_img_link', true ) ).'" />';
}

function sunfrog_url_meta_box( $post )
{
    echo '<input type="text" class="sunfrog-text-box" id="sunfrog_url" name="sunfrog_url" value="'.esc_attr( get_post_meta( $post->ID, '_url', true ) ).'" />';
}

function sunfrog_save_meta_box( $post_id )
{
    if ( isset( $_POST['sunfrog_nonce'] ) && wp_verify_nonce( $_POST['sunfrog_nonce'], 'sunfrog_save_meta_box_action' ) )
    {
        $img_link = sanitize_text_field( $_POST['sunfrog_img_link'] );
        update_post_meta( $post_id, '_img_link', $img_link);

        $url = sanitize_text_field( $_POST['sunfrog_url'] );
        update_post_meta( $post_id, '_url', $url);
    }
}

/**
 * Insert iframe after post content
 */

function sunfrog_insert_iframe( $content ) {
    if ( get_option( 'sunfrog_show_iframe' ) == '1' && is_singular( 'sunfrog' ) ) {
        $content .= sunfrog_get_product_iframe();
    }
    return $content;
}

/**
 * Enqueue iframe css style
 */

function sunfrog_enqueue_iframe_css() {

    $output = '<style> .sunfrog-iframe { ' . get_option( 'sunfrog_iframe_css' ) . ' } </style>';
    echo $output;

}