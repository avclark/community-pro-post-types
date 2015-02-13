<?php
/*
    Plugin Name: Church Pro Custom Post Types
    Plugin URI: http://www.calvinmakes.com
    Description: The official custom post types for the Church Pro Theme
    Author: Calvin Makes
    Version: 1.0
    Author URI: http://www.calvinmakes.com
*/

defined('ABSPATH') or die("No script kiddies please!");

require_once("lib/post-types/church-pro-sermons.php");
require_once("lib/post-types/church-pro-staff.php");
require_once("lib/taxonomies/church-pro-cpt-taxonomies.php");

/**
  *
  * Register Custom Taxonomies
  * @author Calvin Koepke
  * @version 1.0.0
  *
  */

add_action( 'genesis_setup', 'church_pro_staff_taxonomies' );
add_action( 'genesis_setup', 'church_pro_sermon_taxonomies' );

/**
  *
  * Fire Custom Post Type Functions
  * @author Calvin Koepke
  * @version 1.0.0
  *
  */

//* Church Pro Sermons
add_action( 'genesis_setup', 'church_pro_sermons' );
add_action( 'admin_init', 'church_pro_sermons_meta_admin' );
add_action( 'init', 'church_pro_remove_subtitles_support' );
function church_pro_remove_subtitles_support() {
  remove_post_type_support( 'church-pro-sermons', 'subtitles' );
}

//* Church Pro Staff
add_action( 'genesis_setup', 'church_pro_staff' );
add_action( 'init', 'church_pro_add_subtitles_support' );
function church_pro_add_subtitles_support() {
    add_post_type_support( 'church-pro-staff', 'subtitles' );
}


/**
  *
  * Register Custom Post Type Widgets
  * @author StudioPress
  * @author Jo Waltham
  * @author Pete Favelle
  * @author Robin Cornett
  * @author Calvin Koepke
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
	echo '<div class="error"><p><strong>Church Pro Widgets</strong> only work with the Genesis Framework. It has been <strong>deactivated</strong>.</p></div>';
}

// Register the widget
add_action( 'widgets_init', 'gfcptw_register_widget' );
function gfcptw_register_widget() {
  register_widget( 'Church_Pro_Sermon_Widget' );
  register_widget( 'Church_Pro_Featured_Post');
  register_widget( 'Church_Pro_Simple_CTA_Widget');
}

require plugin_dir_path( __FILE__ ) . 'lib/widgets/church-pro-sermons-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/church-pro-featured-post-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/church-pro-simple-cta-widget.php';