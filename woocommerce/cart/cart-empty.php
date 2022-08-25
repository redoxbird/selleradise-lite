<?php
/**
 * Empty cart page
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

?>

<div class="flex justify-center items-center flex-col py-20">
	<div class="w-20 h-auto mb-8 flex justify-center items-center children:w-full children:h-auto">
		<?php echo selleradise_svg('misc/empty-state');?>
	</div>

	<h1 role="status" class="text-xl mb-2"><?php esc_html_e( 'Your cart is empty.', 'TEXT_DOMAIN' ); ?></h1>
	<p><?php esc_html_e( 'Looks like you have not added any product to your cart yet.', 'TEXT_DOMAIN' ); ?></p>

	<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
		<a class="selleradise_button--primary mt-8" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'TEXT_DOMAIN' ) ) ); ?>
		</a>
	<?php endif; ?>
</div>

