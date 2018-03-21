<?php
/**
 * WooNti Admin
 *
 * @class    WooNti_Admin
 * @author   Ziscod
 * @category Admin
 * @package  WooNti/Includes
 * @version  1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * WooNti_Admin class.
 */
class WooNti_Admin {

	private $settings;

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}


	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {

		// Init main settings
		$this->settings = apply_filters( 'woonti_init_settings', array(
			'tab_main'      => array(
				'title'    => __( 'Main', 'woonti' ),
				'active'   => true,
				'settings' => array(
					'status_woonti' => array(
						'label' => __( 'Status', 'woonti' ),
						'data'  => array(
							'description' => __( 'Enable or disable WooNti notifications.', 'woonti' ),
							'field'       => 'select',
							'value'       => 'disable',
							'values'      => array(
								'enable'  => __( 'Enable', 'woonti' ),
								'disable' => __( 'Disable', 'woonti' )
							)
						)
					),
					'transition'    => array(
						'label' => __( 'Transition', 'woonti' ),
						'data'  => array(
							'description' => __( 'Name of the CSS transition that will be used to show and hide the notifications.', 'woonti' ),
							'field'       => 'select',
							'value'       => 'fade',
							'values'      => array(
								'fade'               => __( 'Fade', 'woonti' ),
								'slideLeftFade'      => __( 'Slide and Left Fade', 'woonti' ),
								'slideLeftRightFade' => __( 'Slide and Left Right Fade', 'woonti' ),
								'slideRightFade'     => __( 'Slide and Right Fade', 'woonti' ),
								'slideRightLeftFade' => __( 'Slide and Right-Left Fade', 'woonti' ),
								'slideUpFade'        => __( 'Slide and Up Fade', 'woonti' ),
								'slideUpDownFade'    => __( 'Slide and Up-Down Fade', 'woonti' ),
								'slideDownFade'      => __( 'Slide and Down Fade', 'woonti' ),
								'slideDownUpFade'    => __( 'Slide and Down-Up Fade', 'woonti' ),
								'pinItUp'            => __( 'Pin It Up', 'woonti' ),
								'pinItDown'          => __( 'Pin It Down', 'woonti' ),
							)
						)
					),
					'duration'      => array(
						'label' => __( 'Duration', 'woonti' ),
						'data'  => array(
							'description' => __( 'Duration that the messages will be displayed in milliseconds. Default value is set to 4000 (4 seconds). If it set to 0, the duration for each message is calculated by message length.', 'woonti' ),
							'field'       => 'number',
							'value'       => '4000',
							'min'         => '0',
							'step'        => '1',
							'placeholder' => ''
						)
					),
					'enableSounds'  => array(
						'label' => __( 'Sounds', 'woonti' ),
						'data'  => array(
							'description' => __( 'Enable or disable sounds.', 'woonti' ),
							'field'       => 'select',
							'value'       => 'no',
							'values'      => array(
								'yes' => __( 'Yes', 'woonti' ),
								'no'  => __( 'No', 'woonti' )
							),
							'sounds'      => array(
								'info'    => array(
									'label'       => __( 'Info:', 'woonti' ),
									'field'       => 'upload',
									'value'       => '',
									'button'      => __( 'Choose mp3 file', 'woonti' ),
									'description' => __( 'Path to sound for informational message.', 'woonti' )
								),
								'success' => array(
									'label'       => __( 'Success:', 'woonti' ),
									'field'       => 'upload',
									'value'       => '',
									'button'      => __( 'Choose mp3 file', 'woonti' ),
									'description' => __( 'Path to sound for successfull message.', 'woonti' )
								),
								'error'   => array(
									'label'       => __( 'Error:', 'woonti' ),
									'field'       => 'upload',
									'value'       => '',
									'button'      => __( 'Choose mp3 file', 'woonti' ),
									'description' => __( 'Path to sound for error message.', 'woonti' )
								)
							)
						)
					),
					'autoClose'     => array(
						'label' => __( 'Auto Close', 'woonti' ),
						'data'  => array(
							'description' => __( 'Enable or disable auto hiding on messages.', 'woonti' ),
							'field'       => 'select',
							'value'       => 'yes',
							'values'      => array(
								'yes' => __( 'Yes', 'woonti' ),
								'no'  => __( 'No', 'woonti' )
							)
						)
					),
					'progressBar'   => array(
						'label' => __( 'Progress Bar', 'woonti' ),
						'data'  => array(
							'description' => __( 'Enable or disable the progressbar.', 'woonti' ),
							'field'       => 'select',
							'value'       => 'no',
							'values'      => array(
								'yes' => __( 'Yes', 'woonti' ),
								'no'  => __( 'No', 'woonti' )
							)
						)
					),
					'insertBefore'  => array(
						'label' => __( 'Insert Before...', 'woonti' ),
						'data'  => array(
							'description' => __( 'Specifies the way in which the notification will be inserted in the html code. Yes - and the messages will be inserted before those already generated message, No - otherwise.', 'woonti' ),
							'field'       => 'select',
							'value'       => 'yes',
							'values'      => array(
								'yes' => __( 'Yes', 'woonti' ),
								'no'  => __( 'No', 'woonti' )
							)
						)
					),
					'classname'     => array(
						'label' => __( 'Class Name', 'woonti' ),
						'data'  => array(
							'description' => __( 'Main class name used to styling each message with CSS. If you change this, the configuration consider that you´re re-stylized the plugin and default styles, including css3 transitions are lost.', 'woonti' ),
							'field'       => 'text',
							'value'       => 'woonti',
							'placeholder' => ''
						)
					),
				)
			),
			'tab_templates' => array(
				'title'    => __( 'Templates', 'woonti' ),
				'active'   => false,
				'settings' => array(
					'templates_woonti' => array(
						'label' => __( 'Choose a template for the messages', 'woonti' ),
						'data'  => array(
							'description' => __( 'Sets different message styles. You can also customize any Message template by just copying it from the woonti/templates/*.php directory to your theme - yourtheme/woonti/*.php.', 'woonti' ),
							'field'       => 'list',
							'value'       => 'default',
							'values'      => array(
								'default' => __( 'Default', 'woonti' ),
								'icons'   => __( 'Icons', 'woonti' ),
								'images'  => __( 'Images', 'woonti' ),
								'newyear'  => __( 'New Year', 'woonti' )
							)
						)
					)
				)
			),
			'tab_events'    => array(
				'title'    => __( 'Events', 'woonti' ),
				'active'   => false,
				'alert'    => __( 'Please, do not change anything here if you do not know the JavaScript language.', 'woonti' ),
				'settings' => array(
					'onShow_woonti' => array(
						'label' => __( 'onShow', 'woonti' ),
						'data'  => array(
							'description' => __( '`... onShow : function (type) {YOUR_CODE_HERE} ...` - onShow function will be fired when a message appears.', 'woonti' ),
							'field'       => 'code',
							'value'       => '//console.log(\'' . __( 'Hi!, type - ', 'woonti' ) . '\', type);'
						)
					),
					'onHide_woonti' => array(
						'label' => __( 'onHide', 'woonti' ),
						'data'  => array(
							'description' => __( '`... onHide : function (type) {YOUR_CODE_HERE} ...` - onHide function  will be fired when a message disappears.', 'woonti' ),
							'field'       => 'code',
							'value'       => '//console.log(\'' . __( 'Bye Bye!, type - ', 'woonti' ) . '\', type);'
						)
					)
				)
			),
		) );

		// Add menus & settings.
		add_action( 'admin_menu', array( $this, 'notifications_menu' ), 9 );
		add_action( 'admin_init', array( $this, 'notifications_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
	}


	/**
	 * Enqueue scripts & styles.
	 */
	public function admin_assets( $page ) {

		// Disable load WooNti assets for other wp-admin pages
		if ( $page !== 'woocommerce_page_woonti' ) {
			return;
		}

	
		$suffix = '.min';

		wp_register_style( 'woonti_admin_css', woonti()->plugin_url() . '/assets/css/woonti-admin' . $suffix . '.css', array(), WN_VERSION );
		wp_enqueue_style( 'woonti_admin_css' );

		wp_enqueue_media();
		wp_register_script( 'woonti_admin_js', woonti()->plugin_url() . '/assets/js/woonti-admin' . $suffix . '.js', array( 'jquery' ), WN_VERSION, true );
		wp_enqueue_script( 'woonti_admin_js' );
		wp_deregister_style( 'debug-bar-codemirror' ); // Disable debug bar scripts
	}

	/**
	 * Add menu items.
	 */
	public function notifications_menu() {
		add_submenu_page( 'woocommerce',
			__( 'Notifications', 'woonti' ),
			__( 'Notifications', 'woonti' ),
			'edit_posts',
			'woonti',
			array( $this, 'render_settings' )
		);
	}

	/**
	 * Output WooNti tabs settings
	 *
	 * @param $page
	 */
	public function do_settings_sections( $page ) {
		global $wp_settings_sections, $wp_settings_fields;

		if ( ! isset( $wp_settings_sections[ $page ] ) ) {
			return;
		}

		echo '<div class="nav-tab-wrapper nav" role="tablist">';

		foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

			$id     = isset( $section['id'] ) ? $section['id'] : '';
			$title  = isset( $section['title'] ) ? $section['title'] : '';
			$status = ! empty( $this->settings[ $id ]['active'] ) ? 'nav-tab-active' : '';

			?>
            <a href="#<?php echo esc_attr( $id ); ?>" data-toggle="tab" class="nav-tab <?php echo esc_attr( $status ); ?>" role="tab" aria-controls="xml" aria-expanded="true"><?php echo esc_html( $title ); ?></a>
			<?php
		}
		echo '</div>';


		echo '<div class="tab-content">';
		foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

			if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
				continue;
			}

			$id     = isset( $section['id'] ) ? $section['id'] : '';
			$status = ! empty( $this->settings[ $id ]['active'] ) ? 'nav-tab-active' : '';

			echo '<div class="tab-pane ' . esc_attr( $status ) . '" id="' . esc_attr( $id ) . '" role="tabpanel"><table class="form-table">';

			if ( $section['callback'] ) {
				call_user_func( $section['callback'], $section );
			}

			do_settings_fields( $page, $section['id'] );
			echo '</table></div>';
		}
		echo '</div>';
	}

	/**
	 * Main Notification settings
	 */
	public function notifications_settings() {

		register_setting( 'woonti', 'woonti_options' );

		if ( ! empty( $this->settings ) && is_array( $this->settings ) ) {
			foreach ( $this->settings as $tab_id => $tab_params ) {

				$tab_title = isset( $tab_params['title'] ) ? $tab_params['title'] : '';
				$settings  = isset( $tab_params['settings'] ) ? $tab_params['settings'] : '';
				add_settings_section(
					$tab_id,
					$tab_title,
					array( $this, 'render_settings_messages' ),
					'woonti'
				);

				if ( $settings && is_array( $settings ) ) {
					foreach ( $settings as $setting_id => $setting_params ) {
						$label = isset( $setting_params['label'] ) ? $setting_params['label'] : '';
						$data  = isset( $setting_params['data'] ) ? $setting_params['data'] : array();
						if ( ! empty( $data ) && is_array( $data ) ) {
							add_settings_field(
								$setting_id,
								$label,
								array( $this, 'settings_fields_render' ),
								'woonti',
								$tab_id,
								array_merge( array(
									'name' => $setting_id,
								), $data )
							);
						}
					}
				}

			}
		}
	}

	/**
	 * Informational message
	 *
	 * @param $args
	 */
	public function render_settings_messages( $args ) {
		$id = isset( $args['id'] ) ? $args['id'] : '';
		if ( ! empty( $this->settings[ $id ]['alert'] ) ) {
			?>
            <p><?php echo $this->settings[ $id ]['alert']; ?></p>
			<?php
		}
	}


	/**
	 * Render Notifications settings fields
	 *
	 * @param $args
	 */
	public function settings_fields_render( $args ) {

		$options = get_option( 'woonti_options' );

		$name        = isset( $args['name'] ) ? $args['name'] : '';
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$field       = isset( $args['field'] ) ? $args['field'] : '';
		$value       = isset( $args['value'] ) ? $args['value'] : '';
		$values      = isset( $args['values'] ) ? $args['values'] : '';
		$min         = isset( $args['min'] ) ? $args['min'] : '';
		$step        = isset( $args['step'] ) ? $args['step'] : '';
		$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';

		$subdata = isset( $args['sounds'] ) ? $args['sounds'] : '';

		$field_atts    = 'id="' . esc_attr( $name ) . '" name="woonti_options[' . esc_attr( $name ) . ']"';
		$current_value = isset( $options[ $name ] ) ? $options[ $name ] : $value;


		if ( 'select' === $field ) { ?>
            <select <?php printf( '%s', $field_atts ); ?>>
				<?php if ( ! empty( $values ) && is_array( $values ) ) {
					foreach ( $values as $value => $title ) { ?>
                        <option value="<?php echo esc_attr( $value ) ?>" <?php selected( $current_value, $value ); ?> ><?php echo esc_html( $title ); ?></option>
						<?php
					}
				} ?>
            </select>
		<?php } elseif ( 'text' === $field ) { ?>
            <input type="text" <?php printf( '%s', $field_atts ); ?> placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $current_value ); ?>">
		<?php } elseif ( 'number' === $field ) { ?>
            <input type="number" min="<?php echo esc_attr( $min ); ?>" step="<?php echo esc_attr( $step ); ?>" <?php printf( '%s', $field_atts ); ?> placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $current_value ); ?>">
		<?php } elseif ( 'code' === $field ) { ?>
            <textarea placeholder="<?php echo esc_attr( $placeholder ); ?>" <?php printf( '%s', $field_atts ); ?> class="js-woonti-editor" cols="30" rows="10"><?php echo esc_attr( $current_value ); ?></textarea>
		<?php } elseif ( 'list' === $field ) { ?>
            <div class="woonti-templates">

				<?php if ( ! empty( $values ) && is_array( $values ) ) {
					foreach ( $values as $value => $title ) {


						if ( (string) $current_value === (string) $value ) {
							$current_template = 'woonti-templates__thumb--checked';
						} else {
							$current_template = '';
						}
						?>
                        <div class="woonti-templates__item">
                            <label>
                                <div class="woonti-templates__thumb <?php echo $current_template; ?> woonti-templates__thumb--<?php echo esc_attr( $value ) ?>">
                                    <input class="js-woonti-template-choose" type="radio" <?php printf( '%s', $field_atts ); ?> value="<?php echo esc_attr( $value ) ?>" <?php checked( $current_value, $value ); ?> >
                                </div>
								<?php echo esc_attr( $title ) ?>
                            </label>
                        </div>
						<?php
					}
				} ?>
            </div>
		<?php } ?>

        <p class="description"><?php echo esc_html( $description ); ?></p>


		<?php if ( ! empty( $subdata ) && is_array( $subdata ) ) {
			foreach ( $subdata as $subdata_id => $subdata_params ) {

				$subname        = ! empty( $subdata_id ) ? $subdata_id : '';
				$sublabel       = isset( $subdata_params['label'] ) ? $subdata_params['label'] : '';
				$subfield       = isset( $subdata_params['field'] ) ? $subdata_params['field'] : '';
				$subvalue       = isset( $subdata_params['value'] ) ? $subdata_params['value'] : '';
				$subbutton      = isset( $subdata_params['button'] ) ? $subdata_params['button'] : '';
				$subdescription = isset( $subdata_params['description'] ) ? $subdata_params['description'] : '';


				$subfield_atts    = 'id="' . esc_attr( $subname ) . '" name="woonti_options[sounds][' . esc_attr( $subname ) . ']"';
				$subcurrent_value = isset( $options['sounds'][ $subname ] ) ? $options['sounds'][ $subname ] : $subvalue;
				if ( 'upload' === $subfield ) { ?>
                    <div class="woonti-settings__subfield"><label for="<?php echo esc_attr( $subname ); ?>"><?php echo esc_html( $sublabel ); ?></label>
                        <input type="url" <?php printf( '%s', $subfield_atts ); ?> value="<?php echo esc_attr( $subcurrent_value ); ?>">

                        <input type="button" data-target-input="#<?php echo esc_attr( $subname ); ?>" class="button js-woonti-mp3" value="<?php echo esc_attr( $subbutton ); ?>">
                        <p class="description"><?php echo esc_html( $subdescription ); ?></p>
                    </div>
					<?php
				}
			}
		} ?>
		<?php
	}

	/**
	 * Render Notification settings
	 */
	public function render_settings() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'woonti_messages', 'woonti_message', __( 'Settings Saved', 'woonti' ), 'updated' );
		}

		settings_errors( 'woonti_messages' );
		?>

        <div class="wrap woonti-settings">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
				<?php settings_fields( 'woonti' ); // nonce secure fields ?>

                <div class="woonti-intro-container">
                    

                    <div class="woonti-intro">
                        <h2><?php echo __( 'Settings', 'woonti' ); ?></h2>
                        <p><?php esc_html_e( 'Deep customizations of pop-up notifications.', 'woonti' ); ?></p>
                    </div>
                    <?php echo '<a class="woonti-donate" href="' . esc_url( apply_filters( 'woonti_donate_url', 'https://www.paypal.me/al5dy/5usd' ) ) . '" target="_blank" aria-label="' . esc_attr__( 'Send money to me', 'woonti' ) . '"></a>'; ?>
                </div>
				<?php $this->do_settings_sections( 'woonti' ); ?>

				<?php submit_button( __('Save Settings','woonti') ); ?>
            </form>
        </div>

		<?php
	}
}

return new WooNti_Admin();
