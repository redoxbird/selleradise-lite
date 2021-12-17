<?php
/**
 * Single Product Sale Flash
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() && $product->get_sale_price() && $product->get_regular_price()) : 
	$percentage = (int) round(($product->get_regular_price() - (float) $product->get_sale_price()) / (float) $product->get_regular_price() * 100);
	?>
	<span class="selleradise_chip--onsale">
		<?php echo sprintf(esc_html__('%s%% OFF', 'selleradise-lite'), $percentage); ?>
	</span>
<?php
endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
