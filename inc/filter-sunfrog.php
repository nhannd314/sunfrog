<?php

function sunfrog_add_taxonomy_filters() {
    global $typenow;
    global $wp_query;
    //echo var_dump($wp_query);
    if ( $typenow == 'sunfrog' ) {
        $taxonomy = 'sunfrog-category';
        $business_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' =>  __("Show All {$business_taxonomy->label}"),
            'taxonomy'        =>  $taxonomy,
            'selected'        =>  isset( $wp_query->query['cat'] ) ? $wp_query->query['cat'] : '',
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true, // Show # listings in parens
            'hide_empty'      =>  true, // Don't show businesses w/o listings
        ));
    }
}