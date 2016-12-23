<?php
/*
 * Plugin Name: StorePage Pro: WooCommerce Store Front
 * Plugin URI: http://www.wpdevhq.com/plugins/storepage
 * Description: A Premium custom WooCommerce StorePage for any theme (almost). Its like a child theme but for multiple themes!
 * Version: 1.0.0
 * Author: WPDevHQ
 * Author URI: http://www.wpdevhq.com/
 * Requires at least:   4.4
 * Tested up to:        4.6
 */

/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

/* Set plugin version constant. */
define( 'SP_VERSION', '1.0.0' );

/* Set constant path to the plugin directory. */
define( 'SP_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );

/* Set the constant path to the plugin directory URI. */
define( 'SP_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/* StorePage Class */
require_once( SP_PATH . 'storepage-class.php' );

/* Components placement control */
require_once( SP_PATH . 'storepage-control.php' );

/* Template Functions */
require_once( SP_PATH . 'inc/storepage-template-functions.php' );

/* Template Hooks */
require_once( SP_PATH . 'inc/storepage-template-hooks.php' );