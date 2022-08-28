<?php

/**
 * Show options for ordering
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

$orderby_options = [];
$selected_option = [];
$orderby_request = $_GET['orderby'] ?? 'menu_order';


foreach ($catalog_orderby_options as $options_id => $options_name) {
	$option = [
		'id' => esc_attr($options_id),
		'name' => esc_attr($options_name),
	];

	if ($orderby_request && $options_id == $orderby_request) {
		$selected_option = $option;
	}

	$orderby_options[] = $option;
}

$labels = [
	'menu_order' => __( 'Default', 'TEXT_DOMAIN' ),
	'popularity' => __( 'Popularity', 'TEXT_DOMAIN' ),
	'rating'     => __( 'Average rating', 'TEXT_DOMAIN' ),
	'date'       => __( 'Latest', 'TEXT_DOMAIN' ),
	'price'      => __( 'Price: low to high', 'TEXT_DOMAIN' ),
	'price-desc' => __( 'Price: high to low', 'TEXT_DOMAIN' ),
	'relevance'  => __( 'Relevance', 'TEXT_DOMAIN' )
];

?>


<input type="hidden" name="paged" value="1" />


<div x-data class="flex justify-between items-center mb-4 lg:hidden">
	<form x-ref="form" class="selleradise_shop--default__sortForm--default" method="get">
		<span class="screen-reader-text">
			<?php esc_html_e( "Sort By", 'TEXT_DOMAIN' ); ?>
		</span>

		<select 
			name="orderby"
			class="selleradise_select" 
			x-on:change="$refs.form.submit()">
			<?php foreach ($catalog_orderby_options as $options_id => $name): ?>
				<option value="<?php echo esc_attr($options_id); ?>" <?php selected($orderby, $options_id);?>>
						<span><?php echo esc_html($labels[$options_id] ?? ''); ?></span>
				</option>
			<?php endforeach;?>
		</select>

		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</form>

	<button x-data x-on:click="$dispatch('open-shop-filters');" class="selleradise_shop__orderby--dropdown-filters-trigger">
		<?php echo selleradise_svg('tabler-icons/adjustments');
		esc_html_e('Filter', 'TEXT_DOMAIN'); ?>
	</button>
</div>