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

add_action( 'init', 'sunfrog_create_custom_post_type_taxonomy' );

add_action( 'plugins_loaded', 'sunfrog_init' );

add_action( 'add_meta_boxes', 'sunfrog_meta_box' );
add_action( 'save_post', 'sunfrog_save_meta_box' );

add_action( 'admin_menu', 'sunfrog_admin_menu' );

add_action( 'admin_enqueue_scripts', 'sunfrog_admin_enqueue_scripts' );

/**
 * Add filter product by category
 */
//add_action( 'restrict_manage_posts', 'sunfrog_add_taxonomy_filters' );