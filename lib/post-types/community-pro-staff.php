<?php

/**
 * General purpose theme functions.
 *
 * @package     Community Pro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Bottlerocket Creative, LLC.
 * @license     GPL-2.0+
 * @since       1.1.0
 */

//* Register Sermons Post Type
function community_pro_staff() {
	$args = array(
		'labels'				=> array(
			'name'				=> __( 'Staff', 'community-pro' ),
			'singular_name'		=> __( 'Staff Member', 'community-pro' ),
			'add_new_item'		=> __( 'Add New Staff Member', 'community-pro' ),
			'edit_item'			=> __( 'Edit Staff Member', 'community-pro' ),
			'view_item'			=> __( 'View Staff Member', 'community_pro' ),
			'search_items'		=> __( 'Search Staff', 'community_pro' )
		),
		'has_archive'			=> true,
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-admin-users',
		'menu_position'			=> 20,
		'public'				=> true,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'rewrite'				=> array( 'slug' => 'staff', 'with_front' => true ),
	);

	register_post_type( 'community-pro-staff', $args);
}