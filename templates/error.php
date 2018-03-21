<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woonti/error.php.
 *
 * @author        Ziscod
 * @package       WooNti/Templates
 * @version       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ) {
	return;
}

// Get current WooNti template
$woonti_options  = get_option( 'woonti_options' );
$woonti_template = isset( $woonti_options['templates_woonti'] ) ? $woonti_options['templates_woonti'] : '';


$woonti_template_class = '';
$woonti_template_icon  = '';

if ( isset( $woonti_template ) ) {
	switch ( $woonti_template ) {
		case 'icons' :
			$woonti_template_icon = '<div class="woonti-icon"><i class="fa fa-ban fa-lg" aria-hidden="true"></i></div>';
			break;
		case 'newyear' :
			$woonti_template_class = 'woonti-newyear';
			$woonti_template_icon  = '<img src="' . woonti()->plugin_url() . '/assets/images/newyearbell.png" alt="">';
			break;
	}
}

?>
<div class="woocommerce-error woonti-error " role="alert">
    <div class="woonti-wrap-body <?php echo esc_attr( $woonti_template_class ); ?>">
		<?php echo sprintf( '%s', $woonti_template_icon ); ?>
        <div class="woonti-body">
			<?php foreach ( $messages as $message ) : ?>
                <div class="woonti-body__line"><?php echo wp_kses_post( $message ); ?></div>
			<?php endforeach; ?>
        </div>
    </div>
</div>
