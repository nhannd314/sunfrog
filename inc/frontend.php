<?php

/**
 * Iframe
 */

if ( !function_exists( 'sunfrog_get_product_iframe' ) )
{
    function sunfrog_get_product_iframe()
    {
        return '<iframe class="sunfrog-iframe" src="' . get_post_meta( get_the_ID(), '_url', true ) . '?' . get_option( 'sunfrog_affiliate_id' ) . '&details&shelloff&social=1&showPayIcons=1&showSatisfaction=1&&btn=3&showUSAIcon=1&recentView=1&crossSell=1&socialComments=1&&social=1&txt=a&ppOn"  frameborder="0" allowfullscreen scrolling="no"></iframe>';
    }
}

add_shortcode( 'product-iframe', 'sunfrog_get_product_iframe' );

/**
 * Get product image link
 */

if ( !function_exists( 'sunfrog_get_product_img_link' ) )
{
    function sunfrog_get_product_img_link()
    {
        return get_post_meta( get_the_ID(), '_img_link', true );
    }
}

add_shortcode( 'product-img-link', 'sunfrog_get_product_img_link' );

/**
 * Get product URL
 */

if ( !function_exists( 'sunfrog_get_product_url' ) )
{
    function sunfrog_get_product_url()
    {
        return get_post_meta( get_the_ID(), '_url', true );
    }

}

add_shortcode( 'product-url', 'sunfrog_get_product_url' );