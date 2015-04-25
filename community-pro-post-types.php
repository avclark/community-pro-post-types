<?php
/*
    Plugin Name:       Community Pro Custom Post Types
    Plugin URI:        https://github.com/calvinmakes/community-pro-post-types
    Description:       The official custom post types for the Community Pro Theme
    Author:            Calvin Makes
    Version:           1.1
    Author URI:        http://www.calvinmakes.com
    Text Domain:       community-pro-post-types
    Domain Path:       /languages/
    GitHub Plugin URI: https://github.com/calvinmakes/community-pro-post-types
    GitHub Branch:     master
*/

defined('ABSPATH') or die("No script kiddies please!");


add_action( 'plugins_loaded', 'community_pro_load_translations' );
/**
 * Load translations.
 */
function community_pro_load_translations() {

  /** Set unique textdomain string */
  $cppt_textdomain = 'community-pro-post-types';

  /** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
  $locale = apply_filters( 'plugin_locale', get_locale(), $cppt_textdomain );

  /** Set filter for WordPress languages directory */
  $cppt_wp_lang_dir = apply_filters(
    'cppt_filter_wp_lang_dir',
    trailingslashit( WP_LANG_DIR ) . trailingslashit( $cppt_textdomain ) . $cppt_textdomain . '-' . $locale . '.mo'
  );

  /** Translations: First, look in WordPress' "languages" folder = custom & update-safe! */
  load_textdomain( $cppt_textdomain, $cppt_wp_lang_dir );

  /** Translations: Secondly, look in plugin's "languages" folder = default */
  load_plugin_textdomain(
    $cppt_textdomain,
    FALSE,
    trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages'
  );

}


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
add_action( 'init', 'community_pro_widgets_init' );
function community_pro_widgets_init() {
	if ( 'genesis' !== basename( get_template_directory() ) ) {
		add_action( 'admin_init', 'community_pro_deactivate' );
		add_action( 'admin_notices', 'community_pro_notice' );
		return;
	}

}

function community_pro_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

function community_pro_notice() {

  $notice = sprintf(
    __( '%s only work with the Genesis Framework. It has been <strong>deactivated</strong>.', 'community-pro-post-types' ),
    '<strong>' . __( 'Community Pro Widgets', 'community-pro-post-types' ) . '</strong>'
  );

	printf(
    '<div class="error"><p>%s</p></div>',
    $notice

  );

}

// Register the widget
add_action( 'widgets_init', 'community_pro_register_widget' );
function community_pro_register_widget() {
  register_widget( 'Community_Pro_Sermon_Widget' );
  register_widget( 'Community_Pro_Featured_Post');
  register_widget( 'Community_Pro_Simple_CTA_Widget');
}

require plugin_dir_path( __FILE__ ) . 'lib/widgets/community-pro-sermons-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/community-pro-featured-post-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/community-pro-simple-cta-widget.php';