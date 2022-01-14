<?php
/**
 * Show options for ordering
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$orderby_options = [];
$selected_option = [];
$orderby_request = $_GET['orderby'] ?? 'menu_order';


foreach ( $catalog_orderby_options as $options_id => $options_name )  {
	$option = [
		'id' => esc_attr($options_id),
		'name' => esc_attr($options_name),
	];

	if($orderby_request && $options_id == $orderby_request) {
		$selected_option = $option;
	}

	$orderby_options[] = $option;
}

?>

<shop-select-order 
	v-bind:options='<?php echo wp_json_encode( $orderby_options ); ?>'
	v-bind:selected='<?php echo wp_json_encode( $selected_option ); ?>'> 
	
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>

	<button class="selleradise_shop__orderby--dropdown-filters-trigger">
		<?php echo selleradise_svg('unicons-line/sliders-v'); esc_html_e( 'Filter', 'selleradise-lite' ); ?>
	</button>
</shop-select-order>