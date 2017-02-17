<?php
/*
Plugin Name: tena.cious Events (Custom Post Type)
Plugin URI: http://tenaciousedge.com
Description: Events content type for tena.cious website
Author: Amy Dalrymple
Version: 1.0
Author URI: http://amydalrymple.org/
*/

add_action( 'init', 'register_cpt_events' );

function register_cpt_events() {

    $labels = array( 
        'name' => _x( 'Events', 'tenaciousdoes' ),
        'singular_name' => _x( 'Event', 'tenaciousdoes' ),
        'all_items' => __('All Events', 'tenaciousdoes' ),
        'add_new' => _x( 'Add New', 'tenaciousdoes' ),
        'add_new_item' => _x( 'Add New Event', 'tenaciousdoes' ),
        'edit_item' => _x( 'Edit Event', 'tenaciousdoes' ),
        'new_item' => _x( 'New Event', 'tenaciousdoes' ),
        'view_item' => _x( 'View Event', 'tenaciousdoes' ),
        'search_items' => _x( 'Search Events', 'tenaciousdoes' ),
        'not_found' => _x( 'No events found', 'tenaciousdoes' ),
        'not_found_in_trash' => _x( 'No events found in Trash', 'tenaciousdoes' ),
        'parent_item_colon' => _x( 'Parent Event:', 'tenaciousdoes' ),
        'menu_name' => _x( 'Events', 'tenaciousdoes' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
// 			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
        'menu_icon' => 'dashicons-calendar-alt',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 
            'slug' => 'tenaciousdoes', 
            'with_front' => false//,
//             'feeds' => false,
//             'pages' => true
        ),
        'capability_type' => 'post',
        'taxonomies' => array('post_tag')
    );

    register_post_type( 'tenaciousdoes', $args );
}

// Add/remove permalinks when deactivating/reactivating plugin
function tenacious_events_activate() {
	add_action( 'init', 'flush_rewrite_rules', 999 );
}
register_activation_hook( __FILE__, 'tenacious_events_activate' );

function tenacious_events_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tenacious_events_deactivate' );