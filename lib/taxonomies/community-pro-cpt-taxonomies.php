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
		'name'				=> _x( 'Staff Categories', 'community_pro' ),
		'singular_name'		=> _x( 'Staff Category', 'community_pro' ),
		'search_items'		=> __( 'Search Staff Categories', 'community_pro' ),
		'all_items'         => __( 'All Staff Categories', 'community_pro' ),
		'parent_item'       => __( 'Parent Staff Category', 'community_pro' ),
		'parent_item_colon' => __( 'Parent Staff Category:', 'community_pro' ),
		'edit_item'         => __( 'Edit Staff Category', 'community_pro' ),
		'update_item'       => __( 'Update Staff Category', 'community_pro' ),
		'add_new_item'      => __( 'Add New Staff Category', 'community_pro' ),
		'new_item_name'     => __( 'New Staff Category', 'community_pro' ),
		'menu_name'         => __( 'Staff Categories', 'community_pro' ),
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
		'name'				=> _x( 'Sermon Categories', 'community_pro' ),
		'singular_name'		=> _x( 'Sermon Category', 'community_pro' ),
		'search_items'		=> __( 'Search Sermon Categories', 'community_pro' ),
		'all_items'         => __( 'All Sermon Categories', 'community_pro' ),
		'parent_item'       => __( 'Parent Sermon Category', 'community_pro' ),
		'parent_item_colon' => __( 'Parent Sermon Category:', 'community_pro' ),
		'edit_item'         => __( 'Edit Sermon Category', 'community_pro' ),
		'update_item'       => __( 'Update Sermon Category', 'community_pro' ),
		'add_new_item'      => __( 'Add New Sermon Category', 'community_pro' ),
		'new_item_name'     => __( 'New Sermon Category', 'community_pro' ),
		'menu_name'         => __( 'Sermon Categories', 'community_pro' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'sermon-category' ),
	);

	register_taxonomy( 'sermons', array('community-pro-sermons'), $args);
}