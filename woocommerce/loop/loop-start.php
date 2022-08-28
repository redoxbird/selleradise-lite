<?php
/**
 * Product Loop Start
 * 
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$card_type = get_theme_mod('shop_page_card_type', 'default');
$filters_location = get_theme_mod('filters_location', 'sidebar');

?>
<ul class="selleradise_shop__products-list items-start grid gap-8 <?php echo esc_attr(selleradise_products_classes($card_type, $filters_location === "offscreen")) ?>">
