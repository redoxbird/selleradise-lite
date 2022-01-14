<?php
/**
 * Single Product Tags
 * 
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>

<?php 
	echo wc_get_product_tag_list(
		$product->get_id(), 
		' ', 
		'<div class="selleradise_single_product__tags">', 
		'</div>' 
	); 
?>
