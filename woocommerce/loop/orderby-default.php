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

$labels = [
	'menu_order' => __( 'Default', 'selleradise-lite' ),
	'popularity' => __( 'Popularity', 'selleradise-lite' ),
	'rating'     => __( 'Average rating', 'selleradise-lite' ),
	'date'       => __( 'Latest', 'selleradise-lite' ),
	'price'      => __( 'Price: low to high', 'selleradise-lite' ),
	'price-desc' => __( 'Price: high to low', 'selleradise-lite' ),
	'relevance'  => __( 'Relevance', 'selleradise-lite' )
];

foreach ( $catalog_orderby_options as $options_id => $options_name )  {
	$option = [
		'id' => $options_id,
		'name' => $options_name,
	];

	if($orderby_request && $options_id == $orderby_request) {
		$selected_option = $option;
	}

	$orderby_options[] = $option;
}

?>

<div class="selleradise_shop--default__sort">
	<form class="selleradise_shop--default__sortForm--default" method="get">

		<span class="screen-reader-text">
			<?php esc_html_e( "Sort By", "selleradise-lite" ); ?>
		</span>

		<ul class="selleradise_tablist">
			<?php foreach ($catalog_orderby_options as $options_id => $name): ?>
				<li>
					<input
					type="radio"
					name="orderby"
					id="orderby-<?php echo esc_attr($options_id); ?>"
					value="<?php echo esc_attr($options_id); ?>"
					onChange="this.form.submit()"
					<?php checked($orderby, $options_id);?>
					>
					<label for="orderby-<?php echo esc_attr($options_id); ?>" class="selleradise_tablist__button">
						<?php echo selleradise_svg(selleradise_get_icon($options_id)); ?>
						<span><?php echo esc_html($labels[$options_id] ?? ''); ?></span>
					</label>
				</li>
			<?php endforeach;?>
		</ul>
		

	<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</form>

	<button class="selleradise_shop--default__sort-filtersTrigger">
		<?php echo selleradise_svg('unicons-line/sliders-v-alt'); esc_html_e( 'Filter', 'selleradise-lite' ); ?>
	</button>

</div>