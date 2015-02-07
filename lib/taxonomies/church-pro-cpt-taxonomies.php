<?php

/**
 * Custom Taxonomies for CPTs
 *
 * @package     ChurchPro
 * @author 		Calvin Makes
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Bottlerocket Creative, LLC.
 * @license     GPL-2.0+
 * @since       1.0.0
 */

function church_pro_staff_taxonomies() {
	
	$labels = array(
		'name'				=> _x( 'Staff Categories', 'church_pro' ),
		'singular_name'		=> _x( 'Staff Category', 'church_pro' ),
		'search_items'		=> __( 'Search Staff Categories' ),
		'all_items'         => __( 'All Staff Categories' ),
		'parent_item'       => __( 'Parent Staff Category' ),
		'parent_item_colon' => __( 'Parent Staff Category:' ),
		'edit_item'         => __( 'Edit Staff Category' ),
		'update_item'       => __( 'Update Staff Category' ),
		'add_new_item'      => __( 'Add New Staff Category' ),
		'new_item_name'     => __( 'New Staff Category' ),
		'menu_name'         => __( 'Staff Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'staff-category' ),
	);

	register_taxonomy( 'staff', array('church-pro-staff'), $args);
}

function church_pro_sermon_taxonomies() {

	$labels = array(
		'name'				=> _x( 'Sermon Categories', 'church_pro' ),
		'singular_name'		=> _x( 'Sermon Category', 'church_pro' ),
		'search_items'		=> __( 'Search Sermon Categories' ),
		'all_items'         => __( 'All Sermon Categories' ),
		'parent_item'       => __( 'Parent Sermon Category' ),
		'parent_item_colon' => __( 'Parent Sermon Category:' ),
		'edit_item'         => __( 'Edit Sermon Category' ),
		'update_item'       => __( 'Update Sermon Category' ),
		'add_new_item'      => __( 'Add New Sermon Category' ),
		'new_item_name'     => __( 'New Sermon Category' ),
		'menu_name'         => __( 'Sermon Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'sermon-category' ),
	);

	register_taxonomy( 'sermons', array('church-pro-sermons'), $args);
}