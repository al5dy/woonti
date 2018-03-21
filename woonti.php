<?php
/**
 * Plugin Name: WooNti
 * Plugin URI: https://woonti.ziscod.com/
 * Description: Improves notifications for your WooCommerce store.
 * Version: 1.0.0
 * Author: al5dy
 * Author URI: https://ziscod.com
 *
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 
 * Text Domain: woonti
 * Domain Path: /languages/
 *
 * @package WooNti
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WN_PLUGIN_FILE.
if ( ! defined( 'WN_PLUGIN_FILE' ) ) {
	define( 'WN_PLUGIN_FILE', __FILE__ );
}

// Include the main WooNti class.
if ( ! class_exists( 'WooNti' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-woonti.php';
}

/**
 * Main instance of WooNti.
 *
 * Returns the main instance of WooNti to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return WooNti
 */
if ( ! function_exists( 'woonti' ) ) {
	function woonti() {
		return WooNti::instance();
	}

	// Global for backwards compatibility.
	$GLOBALS['woonti'] = woonti();
}
