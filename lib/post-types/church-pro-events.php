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

//* Register Events Post Type
function church_pro_events() {
	$args = array(
		'labels'				=> array(
			'name'				=> __( 'Events', 'church_pro' ),
			'singular_name'		=> __( 'Event', 'church_pro' ),
			'add_new_item'		=> __( 'Add New Event', 'church_pro' ),
			'edit_item'			=> __( 'Edit Event', 'church_pro' ),
			'view_item'			=> __( 'View Event', 'church_pro' ),
			'search_items'		=> __( 'Search Events', 'church_pro' )
		),
		'has_archive'			=> false,
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-calendar-alt',
		'menu_position'			=> 20,
		'public'				=> true,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'genesis-seo' ),
		'rewrite'				=> array( 'slug' => 'event', 'with_front' => true ),
	);

	register_post_type( 'church-pro-events', $args);
}

//* Add meta box fields
function church_pro_events_meta_admin() {

	//* Add additional meta information to the Events post type
	add_action( 'add_meta_boxes', 'church_pro_add_meta_box' );
	function church_pro_add_meta_box() {
		add_meta_box(
			'church_pro_event_details',
			__( 'Event Details', 'church_pro' ),
			'church_pro_display_event_details_admin',
			'church-pro-events',
			'side'
		);
	}

	function church_pro_display_event_details_admin( $post ) {

		wp_nonce_field( 'church_pro_venue_field', 'church_pro_venue_field_nonce' );
		wp_nonce_field( 'church_pro_address_field', 'church_pro_address_field_nonce' );
		wp_nonce_field( 'church_pro_time_field', 'church_pro_time_field_nonce' );

		// Retrieve current information based on post ID
		$event_venue = get_post_meta( $post->ID, '_church_pro_venue_field', true );
	    $event_address = get_post_meta( $post->ID, '_church_pro_address_field', true );
	    $event_date = get_post_meta( $post->ID, '_church_pro_date_field', true );
	    $event_time = get_post_meta( $post->ID, '_church_pro_time_field', true );
	    $event_cost = get_post_meta( $post->ID, '_church_pro_cost_field', true );

    	echo	'<label for="church_pro_event_venue">Venue</label>',
				'<input type="text" id="event-venue" name="church_pro_venue_field" value="' . $event_venue . '" size="25" style="width: 100%;" />',
				'<label for="church_pro_event_address">Address</label>',
				'<input type="text" id="event-address" name="church_pro_address_field" value="' . $event_address . '" size="25" style="width: 100%;" />',
				'<label for="church_pro_event_date">Date</label>',
				'<input type="date" id="event-date" name="church_pro_date_field" value="' . $event_date . '" size="25" style="width: 100%;" />',
				'<label for="church_pro_event_time">Time</label>',
				'<input type="time" id="event-time" name="church_pro_time_field" value="' . $event_time . '" size="25" style="width: 100%;" />',
				'<label for="church_pro_event_cost">Cost (if applicable)</label>',
				'<input type="text" id="event-cost" name="church_pro_cost_field" value="' . $event_cost . '" size="25" style="width: 100%;" />';

	}

	//* Save the fields
	add_action( 'save_post', 'church_pro_events_meta_save', 10, 3 );
	function church_pro_events_meta_save( $post_id, $post, $update ) {

		$slug = 'church-pro-events';

		if ( $slug != $post->post_type ) {
			return;
		}

		//* OK - It's safe for us to do stuff now */

		//* Make sure that it is set.
		if ( ! isset( $_POST['church_pro_venue_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['church_pro_address_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['church_pro_date_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['church_pro_time_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['church_pro_cost_field'] ) ) {
			return;
		}

		//* Sanatize
		$venue_data = sanitize_text_field( $_REQUEST['church_pro_venue_field'] );
		$address_data = sanitize_text_field( $_REQUEST['church_pro_address_field'] );
		$date_data = sanitize_text_field( $_REQUEST['church_pro_date_field'] );
		$time_data = sanitize_text_field( $_REQUEST['church_pro_time_field'] );
		$cost_data = sanitize_text_field( $_REQUEST['church_pro_cost_field'] );

		//* Update the meta field in the database.
		if ( isset( $_REQUEST['church_pro_venue_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_venue_field', $venue_data );
		}
		if ( isset( $_REQUEST['church_pro_address_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_address_field', $address_data );
		}
		if ( isset( $_REQUEST['church_pro_date_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_date_field', $date_data );
		}
		if ( isset( $_REQUEST['church_pro_time_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_time_field', $time_data );
		}
		if ( isset( $_REQUEST['church_pro_cost_field'] ) ) {
			update_post_meta( $post_id, '_church_pro_cost_field', $cost_data );
		}
	}
}