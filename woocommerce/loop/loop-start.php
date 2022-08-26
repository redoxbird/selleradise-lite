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

$cols = [
	"default" => [
		"sm" => 1,
		"md" => 3,
		"lg" => 3
	],
	"minimal" => [
		"sm" => 1,
		"md" => 3,
		"lg" => 3
	],
	"compact" => [
		"sm" => 2,
		"md" => 5,
		"lg" => 5
	],
	"list" => [
		"sm" => 1,
		"md" => 2,
		"lg" => 2
	]
]

?>
<ul class="selleradise_shop__products-list grid grid-cols-<?php echo esc_attr($cols[$card_type]['sm'] ); ?> gap-8 md:grid-cols-<?php echo esc_attr($cols[$card_type]['md'] )?> lg:grid-cols-<?php echo esc_attr($cols[$card_type]['lg'] )?>">
