<?php
/*
    Plugin Name: Community Pro Custom Post Types
    Plugin URI: https://github.com/calvinmakes/community-pro-post-types
    Description: The official custom post types for the Community Pro Theme
    Author: Calvin Makes
    Version: 1.1
    Author URI: http://www.calvinmakes.com
*/

defined('ABSPATH') or die("No script kiddies please!");

require_once("lib/post-types/community-pro-sermons.php");
require_once("lib/post-types/community-pro-staff.php");
require_once("lib/taxonomies/community-pro-cpt-taxonomies.php");

/**
  *
  * Register Custom Taxonomies
  * @author Calvin Makes
  * @version 1.0.0
  *
  */

add_action( 'genesis_setup', 'community_pro_staff_taxonomies' );
add_action( 'genesis_setup', 'community_pro_sermon_taxonomies' );

/**
  *
  * Fire Custom Post Type Functions
  * @author Calvin Makes
  * @version 1.0.0
  *
  */

//* Community Pro Sermons
add_action( 'genesis_setup', 'community_pro_sermons' );
add_action( 'admin_init', 'community_pro_sermons_meta_admin' );
add_action( 'init', 'community_pro_remove_subtitles_support' );
function community_pro_remove_subtitles_support() {
  remove_post_type_support( 'community-pro-sermons', 'subtitles' );
}

//* Community Pro Staff
add_action( 'genesis_setup', 'community_pro_staff' );
add_action( 'init', 'community_pro_add_subtitles_support' );
function community_pro_add_subtitles_support() {
    add_post_type_support( 'community-pro-staff', 'subtitles' );
}


/**
  *
  * Register Custom Post Type Widgets
  * @author StudioPress
  * @author Jo Waltham
  * @author Pete Favelle
  * @author Robin Cornett
  * @author Calvin Makes
  * @version 1.0.0
  *
  */
add_action( 'init', 'gfcptw_init' );
function gfcptw_init() {
	if ( 'genesis' !== basename( get_template_directory() ) ) {
		add_action( 'admin_init', 'gfcptw_deactivate' );
		add_action( 'admin_notices', 'gfcptw_notice' );
		return;
	}

}

function gfcptw_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

function gfcptw_notice() {
	echo '<div class="error"><p><strong>Community Pro Widgets</strong> only work with the Genesis Framework. It has been <strong>deactivated</strong>.</p></div>';
}

// Register the widget
add_action( 'widgets_init', 'gfcptw_register_widget' );
function gfcptw_register_widget() {
  register_widget( 'Community_Pro_Sermon_Widget' );
  register_widget( 'Community_Pro_Featured_Post');
  register_widget( 'Community_Pro_Simple_CTA_Widget');
}

require plugin_dir_path( __FILE__ ) . 'lib/widgets/community-pro-sermons-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/community-pro-featured-post-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/community-pro-simple-cta-widget.php';