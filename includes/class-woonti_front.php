<?php
/**
 * WooNti Front
 *
 * @class    WooNti_Front
 * @author   Ziscod
 * @category Admin
 * @package  WooNti/Includes
 * @version  1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * WooNti_Front class.
 */
class WooNti_Front {

	// Stored all WP options
	private $options;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->options = get_option( 'woonti_options' );

		$status = isset( $this->options['status_woonti'] ) ? $this->options['status_woonti'] : '';


		// Check WooNti status Disable/Enable
		if ( 'enable' === $status ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
			add_filter( 'script_loader_tag', array( $this, 'add_defer_attr' ), 10, 2 );
			add_action( 'woocommerce_init', array( $this, 'woo_handlers' ), 9990 );

			// Fixed infinity messages/re-add to cart after press F5
			if ( apply_filters( 'woonti_card_redirect_fix', true ) ) {
				add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'woo_cart_redirect' ) );
			}
		}
	}

	/**
	 * Disable re-add goods to cart after F5
	 */
	public function woo_cart_redirect() {
		return isset( $_SERVER['REQUEST_URI'] ) ? home_url( strtok( $_SERVER['REQUEST_URI'], '?' ) ) : get_permalink( wc_get_page_id( 'shop' ) );
	}

	/**
	 * Init WooCommerce Hooks
	 */
	public function woo_handlers() {
		// Street Magic here
		add_filter( 'woocommerce_notice_types', array( $this, 'woo_notice_types' ), 9991 );
		add_filter( 'wc_get_template', array( $this, 'woo_template_override' ), 9991, 5 );


		// Image templates
		add_filter ( 'wc_add_to_cart_message_html', array( $this, 'woo_filtrate_add_to_cart'), 9991, 2 );
		add_filter('woocommerce_cart_item_removed_title', array( $this, 'woo_filtrate_remove_from_cart'), 9991 );
		if ( apply_filters( 'woonti_user_notice', true ) ) {
			// User notices
			add_filter( 'woocommerce_add_error', array( $this, 'woo_account_notices' ), 9991 );
		}
	}


	/**
	* Returns the main product URL image.
	*
	* @param string $size (default: 'woocommerce_thumbnail').
	* @param array  $attr Image attributes.
	* @param bool   $placeholder True to return $placeholder if no image is found, or false to return an empty string.
	* @return string
	*/
	private function get_image_url( $product_id = null, $size = 'woocommerce_thumbnail', $placeholder = true ) {
		if ( has_post_thumbnail( $product_id ) ) {
			$image = get_the_post_thumbnail_url( $product_id, $size );
		} elseif ( ( $parent_id = wp_get_post_parent_id( $product_id ) ) && has_post_thumbnail( $parent_id ) ) {
			$image = get_the_post_thumbnail_url( $parent_id, $size );
		} elseif ( $placeholder ) {
			$image = wc_placeholder_img_src();
		} else {
			$image = '';
		}
		return apply_filters( 'woocommerce_product_get_image_src',$image );
	}

	/**
	 * Change account notices for `Images` template
	 *
	 * @param $message
	 *
	 * @return string
	 */
	public function woo_account_notices($message) {
		$template_slug = isset($this->options['templates_woonti']) ? $this->options['templates_woonti'] : '';

		$user_id = get_current_user_id();

		if ( $user_id <= 0 ) {
			return $message;
		}

		if(is_account_page() &&  isset($_POST['action']) && 'save_account_details' === $_POST['action']) {
			$avatar = get_avatar( $user_id, 90, 'http://2.gravatar.com/avatar/?s=90&d=mm&r=g' );
			switch ($template_slug) {
				case 'images' :
						$message = '<div class="woonti-image">'.$avatar.'</div>' . $message;
					break;
			}
		}

		return $message;
	}


	/**
	 * Change Add to cart notice for `Images` template
	 *
	 * @param $message
	 * @param $products
	 *
	 * @return string
	 */
	public function woo_filtrate_add_to_cart($message, $products) {

		$template_slug = isset($this->options['templates_woonti']) ? $this->options['templates_woonti'] : '';
		switch ($template_slug) {
			case 'images' :
				if($products) {
					foreach ( $products as $product_id => $quantity ) {
						$message = '<div class="woonti-image"><img src="' . esc_url( $this->get_image_url( $product_id ) ) . '" alt=""></div>' . $message;
					}
				}
				break;
		}
		return $message;
	}

	/**
	 * Change Remove from cart notice for `Images` template
	 *
	 * @param $message
	 *
	 * @return string
	 */
	public function woo_filtrate_remove_from_cart( $message ) {
		$template_slug = isset($this->options['templates_woonti']) ? $this->options['templates_woonti'] : '';

		$product = get_page_by_title( str_replace(array('"','&ldquo;','&rdquo;'), '', $message), OBJECT , 'product' );

		if(null !== $product && isset($product->ID )) {
			$product_id = $product->ID;
			switch ($template_slug) {
				case 'images' :
					$message = '<div class="woonti-image"><img src="' . esc_url( $this->get_image_url( $product_id ) ) . '" alt=""></div>' . $message;
					break;
			}
		}

		return  $message;
	}

	/**
	 * Reset default WooCommerce notifications
	 *
	 * @return array
	 */
	public function woo_notice_types() {
		return array( 'error', 'success', 'notice' );
	}

	/**
	 * Override default WooCommerce notifications templates
	 *
	 * @param $located
	 * @param $template_name
	 * @param $args
	 * @param $template_path
	 * @param $default_path
	 *
	 * @return string
	 */
	public function woo_template_override( $located, $template_name, $args, $template_path, $default_path ) {
		if ( strpos( $template_name, 'notices/' ) !== false ) {
			// Get template from theme (if not exist - from plugin /templates)
			$template = get_theme_file_path( woonti()->template_path() . basename( $located ) );
			$template = file_exists( $template ) ? $template : woonti()->plugin_path() . '/templates/' . basename($located);
			$located  = file_exists( $template ) ? $template : $located;
		}

		return $located;
	}

	/**
	 * defer="defer" tag for WooNti script
	 *
	 * @param $tag
	 * @param $handle
	 *
	 * @return mixed
	 */
	public function add_defer_attr( $tag, $handle ) {
		// add script handles to the array below
		$scripts_to_defer = array( 'woonti_js' );

		foreach ( $scripts_to_defer as $defer_script ) {
			if ( $defer_script === $handle ) {
				return str_replace( ' src', ' defer="defer" src', $tag );
			}
		}

		return $tag;
	}


	/**
	 * Load main core Front End assets
	 */
	public function load_assets() {
		$suffix = '.min';


		$params = array();

		// JS params
		if ( ! empty( $this->options ) && is_array( $this->options ) ) {
			foreach ( $this->options as $option_name => $option_value ) {
				if ( strpos( $option_name, 'woonti' ) !== false ) continue;

				// Replace ALL `yes` or `no` strings to BOOL type
				if ( 'yes' === $option_value ) {
					$option_value = true;
				} elseif ( 'no' === $option_value ) {
					$option_value = false;
				} elseif ( is_numeric( $option_value ) ) {
					$option_value = absint( $option_value );
				}


				if('sounds' === $option_name) {
					if(empty($option_value['info']) ) {
						$option_value['info'] = woonti()->plugin_url() . '/assets/sounds/info.mp3';
					}
					if(empty($option_value['success']) ) {
						$option_value['success'] = woonti()->plugin_url() . '/assets/sounds/success.mp3';
					}
					if(empty($option_value['error']) ) {
						$option_value['error'] = woonti()->plugin_url() . '/assets/sounds/error.mp3';
					}
				}

				$params[ $option_name ] = $option_value;
			}
		}

		// Get ready params for using in WooNti JS Core
		$params = apply_filters('woonti_ready_params', $params);


		wp_enqueue_script( 'woonti_js', woonti()->plugin_url() . '/assets/js/woonti' . $suffix . '.js', array( 'jquery' ), WN_VERSION, true );
		wp_enqueue_style( 'woonti_css', woonti()->plugin_url() . '/assets/css/woonti' . $suffix . '.css', false, WN_VERSION );

		if ( ! empty( $params ) && is_array( $params ) ) {
			$params = wp_json_encode( $params, JSON_FORCE_OBJECT );
			wp_localize_script( 'woonti_js', 'woonti_data', array(
				'params' => $params
			) );




			// Handlers for WooNti Messages
			$onShow = !empty($this->options['onShow_woonti']) ? "\n\rvar woonti_onshow = function (type) {\n\r{$this->options['onShow_woonti']}\n\r}\n\r" : "\n\rvar woonti_onshow = function (type) {\n\r}\n\r";
			$onHide = !empty($this->options['onHide_woonti']) ? "\n\rvar woonti_onhide = function (type) {\n\r{$this->options['onHide_woonti']}\n\r}\n\r" : "\n\rvar woonti_onhide = function (type) {\n\r}\n\r";

			wp_add_inline_script('woonti_js', '/* <![CDATA[ */' . $onShow . ' ' . $onHide . '/* ]]> */');
		}

	}

}

return new WooNti_Front();
