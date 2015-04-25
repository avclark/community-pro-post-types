<?php

/**
 * Custom Taxonomies for CPTs
 *
 * @package     Community Pro
 * @author 		Calvin Makes
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Bottlerocket Creative, LLC.
 * @license     GPL-2.0+
 * @since       1.1.0
 */

function community_pro_staff_taxonomies() {
	
	$labels = array(
		'name'				=> _x( 'Staff Categories', 'Taxonomy plural name', 'community-pro-post-types' ),
		'singular_name'		=> _x( 'Staff Category', 'Taxonomy singular name', 'community-pro-post-types' ),
		'search_items'		=> __( 'Search Staff Categories', 'community-pro-post-types' ),
		'all_items'         => __( 'All Staff Categories', 'community-pro-post-types' ),
		'parent_item'       => __( 'Parent Staff Category', 'community-pro-post-types' ),
		'parent_item_colon' => __( 'Parent Staff Category:', 'community-pro-post-types' ),
		'edit_item'         => __( 'Edit Staff Category', 'community-pro-post-types' ),
		'update_item'       => __( 'Update Staff Category', 'community-pro-post-types' ),
		'add_new_item'      => __( 'Add New Staff Category', 'community-pro-post-types' ),
		'new_item_name'     => __( 'New Staff Category', 'community-pro-post-types' ),
		'menu_name'         => __( 'Staff Categories', 'community-pro-post-types' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'staff-category' ),
	);

	register_taxonomy( 'staff', array('community-pro-staff'), $args);
}

function community_pro_sermon_taxonomies() {

	$labels = array(
		'name'				=> _x( 'Sermon Categories', 'Taxonomy plural name', 'community-pro-post-types' ),
		'singular_name'		=> _x( 'Sermon Category', 'Taxonomy singular name', 'community-pro-post-types' ),
		'search_items'		=> __( 'Search Sermon Categories', 'community-pro-post-types' ),
		'all_items'         => __( 'All Sermon Categories', 'community-pro-post-types' ),
		'parent_item'       => __( 'Parent Sermon Category', 'community-pro-post-types' ),
		'parent_item_colon' => __( 'Parent Sermon Category:', 'community-pro-post-types' ),
		'edit_item'         => __( 'Edit Sermon Category', 'community-pro-post-types' ),
		'update_item'       => __( 'Update Sermon Category', 'community-pro-post-types' ),
		'add_new_item'      => __( 'Add New Sermon Category', 'community-pro-post-types' ),
		'new_item_name'     => __( 'New Sermon Category', 'community-pro-post-types' ),
		'menu_name'         => __( 'Sermon Categories', 'community-pro-post-types' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'sermon-category' ),
	);

	register_taxonomy( 'sermon', array('community-pro-sermon'), $args);
}