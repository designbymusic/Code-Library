<?php
/*
Plugin Name: WooTumblog
Plugin URI: http://wordpress.org/extend/plugins/woo-tumblog/
Description: Create a tumblr style blog using this plugin.
Version: 2.1.3
Author: Jeffikus of WooThemes
Author URI: http://www.woothemes.com
License: GPL2
*/

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Include Classes and Functions
- Initiate the plugin
-- WooTumblogInit()

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Include Classes and Functions */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('WooTumblogInit')) {

	define( 'WOOTUMBLOG_ACTIVE', true ); // Define a constant for use in our theme's templating engine.

	// Main Tumblog Plugin Class
	require_once( 'classes/wootumblog.class.php' );
	// Test for Post Formats
	if (get_option('woo_tumblog_content_method') == 'taxonomy') {
		// Tumblog Custom Taxonomy Class
		require_once( 'classes/wootumblog_taxonomy.class.php' );
	} else {
		// Tumblog Post Format Class
		require_once( 'classes/wootumblog_postformat.class.php' );
	}
	// Dashboard Widget Output Functions
	require_once( 'functions/wootumblog_dashboard_functions.php' );
	// Test for Post Formats
	if (get_option('woo_tumblog_content_method') == 'taxonomy') {
		// Express iPhone app Functions
		require_once( 'functions/wootumblog_express_app_functions_deprecated.php' );
	} else {
		// Don't use the iPhone app functions - TEMPORARY UNTIL EXPRESS APP UPGRADES
		require_once( 'functions/wootumblog_express_app_functions.php' );
	}
	// Woo Helper Functions
	require_once( 'functions/wootumblog_helper_functions.php' );
	// Template Output Functions
	require_once( 'functions/wootumblog_template_functions.php' );

	/*-----------------------------------------------------------------------------------*/
	/* Initiate the plugin */
	/*-----------------------------------------------------------------------------------*/

	add_action("init", "WooTumblogInit");
	function WooTumblogInit() { 
	
		$pluginpath = dirname( __FILE__ );
		$pluginurl = WP_PLUGIN_URL . '/' . plugin_basename( $pluginpath );
	 		
		//Main Tumblog Object
		global $woo_tumblog; 
		$woo_tumblog = new WooTumblog(); 
		
		// Test for Post Formats
		if (get_option('woo_tumblog_content_method') == 'taxonomy') {
			//Tumblog Custom Taxonomy
			global $woo_tumblog_taxonomy; 
			$woo_tumblog_taxonomy = new WooTumblogTaxonomy(); 
			$woo_tumblog_taxonomy->woo_tumblog_create_initial_taxonomy_terms();
		} else {
			//Tumblog Post Formats
			global $woo_tumblog_post_format; 
			$woo_tumblog_post_format = new WooTumblogPostFormat(); 
			if ( $woo_tumblog_post_format->woo_tumblog_upgrade_existing_taxonomy_posts_to_post_formats()) {
				update_option('woo_tumblog_post_formats_upgraded','true');
			}
			// Set content method
			if ( get_option('woo_tumblog_content_method') != 'post_format' ) {
				update_option('woo_tumblog_content_method', 'post_format'); 
			}
		}
	
	}
}

register_activation_hook(__FILE__,'woo_tumblog_on_activation');

function woo_tumblog_on_activation() {


}

add_action('after_setup_theme', 'woo_tumblog_after_theme_setup');

function woo_tumblog_after_theme_setup() {
	
	// Set Output Functions
	if ( defined('WOO_TUMBLOG_THEME') && constant('WOO_TUMBLOG_THEME') ) {
		define('WOO_IMAGE_FUNCTION','woo_image');
		define('WOO_VIDEO_FUNCTION','woo_embed');
	} else {
		define('WOO_IMAGE_FUNCTION','woo_tumblog_image');
		define('WOO_VIDEO_FUNCTION','woo_tumblog_embed');
	}
}

?>