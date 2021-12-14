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
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'selleradise-lite' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'selleradise-lite' );
	?>

	<button class="selleradise__input--number-icon--up" aria-label="<?php esc_attr_e('Increase Product Quantity', 'selleradise-lite');?>" style="display: none;">
		<?php echo selleradise_svg('unicons-line/plus'); ?>
	</button>

	<button class="selleradise__input--number-icon--down" aria-label="<?php esc_attr_e('Decrease Product Quantity', 'selleradise-lite');?>" style="display: none;">
		<?php echo selleradise_svg('unicons-line/minus'); ?>
	</button>

	<div class="quantity">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>">
			<?php echo esc_html( $label ); ?>
		</label>
		<input
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'selleradise-lite' ); ?>"
			size="4"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>" />
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}
