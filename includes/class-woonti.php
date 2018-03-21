<?php
/**
 * WooNti setup
 *
 * @package  WooNti
 * @since    1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main WooNti Class.
 *
 * @class WooNti
 */
final class WooNti {

	/**
	 * WooNti version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The single instance of the class.
	 *
	 * @var WooNti
	 * @since 1.0.0
	 */
	protected static $_instance = null;


	/**
	 * Main WooNti Instance.
	 *
	 * Ensures only one instance of WooNti is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see   \woonti()
	 * @return WooNti - Main instance.
	 */
	public static function instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	/**
	 * WooNti Constructor.
	 */
	public function __construct() {
		// Main Constants
		if ( ! defined( 'WN_ABSPATH' ) ) {
			define( 'WN_ABSPATH', dirname( WN_PLUGIN_FILE ) . '/' );
		}
		if ( ! defined( 'WN_VERSION' ) ) {
			define( 'WN_VERSION', $this->version );
		}
		if ( ! defined( 'WN_PLUGIN_BASENAME' ) ) {
			define( 'WN_PLUGIN_BASENAME', plugin_basename( WN_PLUGIN_FILE ) );
		}

		// Main Install WooNti Class
		include_once( WN_ABSPATH . 'includes/class-woonti_install.php' );


		// Require Front-End settings
		if ( $this->is_request( 'frontend' ) ) {
			include_once( WN_ABSPATH . 'includes/class-woonti_front.php' );
		}

		// Require Wp-Admin settings
		if ( $this->is_request( 'admin' ) ) {
			include_once( WN_ABSPATH . 'includes/class-woonti_admin.php' );
		}

		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Init WooNti when WordPress Initialises.
	 */
	public function init() {
		// Set up localisation.
		$this->load_plugin_textdomain();
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/woonti/woonti-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/woonti-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'woonti' );

		unload_textdomain( 'woonti' );
		load_textdomain( 'woonti', WP_LANG_DIR . '/woonti/woonti-' . $locale . '.mo' );
		load_plugin_textdomain( 'woonti', false, plugin_basename( dirname( WN_PLUGIN_FILE ) ) . '/languages' );
	}


	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}


	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', WN_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( WN_PLUGIN_FILE ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'woonti_template_path', 'woonti/' );
	}
}
