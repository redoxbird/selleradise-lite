<?php
/**
 * Product quantity inputs
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'TEXT_DOMAIN' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'TEXT_DOMAIN' );
	?>


	<div 
		x-data="quantityInput" 
		class="quantity overflow-hidden rounded-full h-12 w-auto border-gray-200 border-1 flex justify-center items-center"
		>
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>

		<button x-on:click.prevent="decrease($event)" x-bind:disabled="!canDecrease" class="w-12 h-12 p-4 flex justify-center items-center disabled:opacity-50" aria-label="<?php esc_attr_e('Increase Product Quantity', 'TEXT_DOMAIN');?>">
			<?php echo selleradise_svg('tabler-icons/minus'); ?>
		</button>

		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>">
			<?php echo esc_html( $label ); ?>
		</label>

		<input
			x-ref="input"
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?> !shadow-none h-full flex justify-center items-center"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'TEXT_DOMAIN' ); ?>"
			size="4"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>" />
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>

		<button x-on:click.prevent="increase($event)" x-bind:disabled="!canIncrease"  class="w-12 h-12 p-4 flex justify-center items-center disabled:opacity-50" aria-label="<?php esc_attr_e('Decrease Product Quantity', 'TEXT_DOMAIN');?>">
			<?php echo selleradise_svg('tabler-icons/plus'); ?>
		</button>
	</div>


	<?php
}
