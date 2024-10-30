<?php
/**
 * Plugin Name: Clearapp
 * Plugin URI: http://clearapp.net
 * Description: Appify your Wordpress site.
 * Author: chrisjohnhoughton
 * Author URI: http://chrisjhoughton.com/
 * Version: 1.0.3
 * License: GPLv2 or later
 */


define( 'CLEARAPP_PLUGIN_PATH', plugin_dir_path(__FILE__ ));
define( 'CLEARAPP_PLUGIN_URL', plugin_dir_url( __FILE__ ));


// Main controller file
include("modules/main.php");

$your_plugin_slug = new Clearapp_Main;

// Authenticate on installation
register_activation_hook( __FILE__, array('Clearapp_Main', 'install'));

