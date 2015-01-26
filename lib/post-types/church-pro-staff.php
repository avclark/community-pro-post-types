<?php

/**
 * General purpose theme functions.
 *
 * @package     ChurchPro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Bottlerocket Creative, LLC.
 * @license     GPL-2.0+
 * @since       1.0.0
 */

//* Register Sermons Post Type
function church_pro_staff() {
	$args = array(
		'labels'				=> array(
			'name'				=> __( 'Staff', 'church_pro' ),
			'singular_name'		=> __( 'Staff Member', 'church_pro' ),
			'add_new_item'		=> __( 'Add New Staff Member', 'church_pro' ),
			'edit_item'			=> __( 'Edit Staff Member', 'church_pro' ),
			'view_item'			=> __( 'View Staff Member', 'church_pro' ),
			'search_items'		=> __( 'Search Staff', 'church_pro' )
		),
		'has_archive'			=> false,
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-admin-users',
		'menu_position'			=> 20,
		'public'				=> true,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'genesis-seo' ),
		'rewrite'				=> array( 'slug' => 'staff', 'with_front' => true ),
	);

	register_post_type( 'church-pro-staff', $args);
}