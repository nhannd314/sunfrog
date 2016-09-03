<?php
/**
 * Plugin Name: SunFrog
 * Plugin URI: http://vifonic.vn/
 * Description: SunFrog
 * Version: 1.0.0
 * Author: Vifonic
 * Author URI: http://vifonic.vn/
 * License: GPLv2 or later
 */

$sunfrog_plugin_dir = basename(dirname(__FILE__));

include 'functions.php';
include 'inc/filter-sunfrog.php';
include 'inc/frontend.php';

// create custom post type and custom taxonomy
add_action( 'init', 'sunfrog_create_custom_post_type_taxonomy' );

// init plugin
add_action( 'plugins_loaded', 'sunfrog_init' );

// add _url and _img_link meta box
add_action( 'add_meta_boxes', 'sunfrog_meta_box' );
add_action( 'save_post', 'sunfrog_save_meta_box' );

add_action( 'admin_menu', 'sunfrog_admin_menu' );

// insert admin css
add_action( 'admin_enqueue_scripts', 'sunfrog_admin_enqueue_scripts' );

// Add filter product by category
//add_action( 'restrict_manage_posts', 'sunfrog_add_taxonomy_filters' );

// insert iframe in post_content()
add_filter ( 'the_content', 'sunfrog_insert_iframe' );

// insert iframe css
add_action('wp_head','sunfrog_enqueue_iframe_css');