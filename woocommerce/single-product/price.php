<?php
/**
 * Single Product Price
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'selleradise_single_product__price' ) ); ?>">
	<?php echo wp_kses_post($product->get_price_html()); ?>
</p>
