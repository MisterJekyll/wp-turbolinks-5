<?php
/*
Plugin Name: MJ WP Turbolinks 5
Plugin URI: http://misterjekyll.be
Description: Make your WordPress Website fast with Turbolinks 5!
Version: 0.4
Author: Mister Jekyll
*/

define('WPTURBOLINKS5_VERSION'    , '0.4');
define('WPTURBOLINKS5_PLUGIN_NAME', 'MJ WP Turbolinks 5');
define('WPTURBOLINKS5_FILE'       , __FILE__);
define('WPTURBOLINKS5_PATH'       , realpath(plugin_dir_path(WPTURBOLINKS5_FILE)) . '/');
define('WPTURBOLINKS5_URL'        , plugin_dir_url(WPTURBOLINKS5_FILE));
define('WPTURBOLINKS5_LIB_URL', WPTURBOLINKS5_URL . 'js/turbolinks.min.js');
define('WPTURBOLINKS5_MEDIAELEMENT_URL', WPTURBOLINKS5_URL . 'js/mj_wp_mediaelement.min.js');

/*
 * Init the Turbolinks script and fix the mediaelement not loading issues that may occur
 */
function mj_turbolinks_init() {
	// TURBOLINKS 5 doenst like the Adminbar so we will have a peek if it exists
	if(!is_admin() && !is_admin_bar_showing()) {

		// Register and enqueue Turbolinks
		wp_register_script('turbolinks', WPTURBOLINKS5_LIB_URL);
		wp_enqueue_script('turbolinks', WPTURBOLINKS5_LIB_URL , [], WPTURBOLINKS5_VERSION, false);

		// Override wp-mediaelement.js file to work with turbolinks (avoid the annoying error that sometimes happens)
		wp_deregister_script('wp-mediaelement');
		wp_register_script('wp-mediaelement', WPTURBOLINKS5_MEDIAELEMENT_URL, ['mediaelement', 'jquery'], WPTURBOLINKS5_VERSION, true);

		// Add wp-mediaelement and its dependencies to every page
		wp_enqueue_style('wp-mediaelement');
		wp_enqueue_script('wp-mediaelement');
	}
}

add_action('init', 'mj_turbolinks_init');
