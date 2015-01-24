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
function church_pro_sermons() {
	$args = array(
		'labels'				=> array(
			'name'				=> __( 'Sermons', 'church_pro' ),
			'singular_name'		=> __( 'Sermon', 'church_pro' ),
			'add_new_item'		=> __( 'Add New Sermon', 'church_pro' ),
			'edit_item'			=> __( 'Edit Sermon', 'church_pro' ),
			'view_item'			=> __( 'View Sermon', 'church_pro' ),
			'search_items'		=> __( 'Search Sermons', 'church_pro' )
		),
		'has_archive'			=> false,
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-microphone',
		'menu_position'			=> 20,
		'public'				=> true,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'rewrite'				=> array( 'slug' => 'sermon', 'with_front' => true ),
	);

	register_post_type( 'church-pro-sermons', $args);
}

//* Add meta box fields
function church_pro_sermons_meta_admin() {

	//* Add additional meta information to the Events post type
	add_action( 'add_meta_boxes', 'church_pro_add_sermon_meta_box' );
	function church_pro_add_sermon_meta_box() {
		add_meta_box(
			'church_pro_sermon_details',
			__( 'Sermon Details', 'church_pro' ),
			'church_pro_display_sermon_details_admin',
			'church-pro-sermons',
			'side'
		);
	}

	function church_pro_display_sermon_details_admin( $post ) {

		wp_nonce_field( 'church_pro_speaker_field', 'church_pro_speaker_field_nonce' );
		wp_nonce_field( 'church_pro_sermon_date_field', 'church_pro_sermon_date_field_nonce' );
		wp_nonce_field( 'church_pro_soundcloud_url_field', 'church_pro_soundcloud_url_field_nonce' );

		// Retrieve current information based on post ID
		$sermon_speaker = get_post_meta( $post->ID, '_church_pro_speaker_field', true );
		$sermon_date = get_post_meta( $post->ID, '_church_pro_sermon_date_field', true );
	    $soundcloud_url = get_post_meta( $post->ID, '_church_pro_soundcloud_url_field', true );

    	echo	'<label for="church_pro_sermon_speaker">Speaker</label>',
				'<input type="text" id="sermon-speaker" name="church_pro_speaker_field" value="' . $sermon_speaker . '" size="25" style="width: 100%;" />',
				
				'<label for="church_pro_sermon_date">Sermon Date</label>',
				'<input type="date" id="sermon-date" name="church_pro_sermon_date_field" value="' . $sermon_date . '" size="25" style="width: 100%;" />',
				
				'<label for="church_pro_souncloud_url">Soundcloud URL</label>',
				'<input type="text" id="soundcloud-url" name="church_pro_soundcloud_url_field" value="' . $soundcloud_url . '" size="25" style="width: 100%;" />';

	}

	//* Save the fields
	add_action( 'save_post', 'church_pro_sermons_meta_save', 10, 3 );
	function church_pro_sermons_meta_save( $post_id, $post, $update ) {

		$slug = 'church-pro-sermons';

		if ( $slug != $post->post_type ) {
			return;
		}

		//* OK - It's safe for us to do stuff now */

		//* Make sure that it is set.
		if ( ! isset( $_POST['church_pro_speaker_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['church_pro_sermon_date_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['church_pro_soundcloud_url_field'] ) ) {
			return;
		}

		//* Sanatize
		$speaker_data = sanitize_text_field( $_REQUEST['church_pro_speaker_field'] );
		$sermon_date_data = sanitize_text_field( $_REQUEST['church_pro_sermon_date_field'] );
		$soundclourd_url_data = sanitize_text_field( $_REQUEST['church_pro_soundcloud_url_field'] );

		//* Update the meta field in the database.
		if ( isset( $_REQUEST['church_pro_speaker_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_speaker_field', $speaker_data );
		}
		if ( isset( $_REQUEST['church_pro_sermon_date_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_sermon_date_field', $sermon_date_data );
		}
		if ( isset( $_REQUEST['church_pro_soundcloud_url_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_soundcloud_url_field', $soundclourd_url_data );
		}
	}
}