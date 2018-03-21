<?php
/**
 * Installation related functions and actions.
 *
 * @package  WooNti
 * @since    1.0.0
 */

defined( 'ABSPATH' ) || exit;


/**
 * WooNti_Install class.
 */
class WooNti_Install {


	public static function init() {
		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
	}


	/**
	 * Show row meta on the plugin screen.
	 *
	 * @param $links
	 * @param $file
	 *
	 * @return array
	 */
	public static function plugin_row_meta( $links, $file ) {
		if ( WN_PLUGIN_BASENAME === $file ) {
			$row_meta = array(
				'settings' => '<a href="' . esc_url( apply_filters( 'woonti_settings_url', admin_url( 'admin.php?page=woonti' ) ) ) . '" aria-label="' . esc_attr__( 'Visit WooNti settings', 'woonti' ) . '">' . esc_html__( 'Settings', 'woonti' ) . '</a>',
				'donate' => '<a href="' . esc_url( apply_filters( 'woonti_donate_url', 'https://www.paypal.me/al5dy/5usd' ) ) . '" target="_blank" aria-label="' . esc_attr__( 'Send money to me', 'woonti' ) . '"><strong style="color:red;">' . esc_html__( 'Donate', 'woonti' ) . '</strong></a>'
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}


}

WooNti_Install::init();
