<?php
/**
 * My Account navigation
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation text-text-900 py-20 overflow-hidden">
	<ul class="text-md flex justify-start items-start flex-col m-0 border-1 border-gray-200 shadow-3xl p-10 rounded-lg">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> relative w-full">
				<a class="flex justify-start items-center font-medium px-2 py-4 rounded-full opacity-75 hover:opacity-100 hover:underline is-parent-active:opacity-100 is-parent-active:font-semibold is-parent-active:underline" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
					<span class="flex justify-center items-center w-4 h-4 mr-4"><?php echo selleradise_svg(selleradise_get_icon($endpoint)); ?></span>
					<?php echo esc_html( $label ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
