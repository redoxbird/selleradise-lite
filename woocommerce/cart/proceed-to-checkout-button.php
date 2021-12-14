<?php
/**
 * Proceed to checkout button
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="selleradise_button--primary alt wc-forward">
	<?php esc_html_e( 'Proceed to checkout', 'selleradise-lite' ); ?>
</a>
