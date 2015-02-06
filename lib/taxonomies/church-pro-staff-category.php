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