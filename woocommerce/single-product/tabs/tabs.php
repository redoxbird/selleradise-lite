<?php
/**
 * Single Product tabs
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<ul class="selleradise_single_product__tabs" role="tablist">
		<li id="selleradise_single_product__content_tab" role="tab" aria-controls="selleradise_single_product__content">
			<a href="#selleradise_single_product__content">
				<?php esc_html_e("Overview", 'TEXT_DOMAIN'); ?>
			</a>
		</li>

		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
				<a href="#tab-<?php echo esc_attr( $key ); ?>">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
				</a>
			</li>
		<?php endforeach; ?>

		<li id="selleradise_single_product__upsells_tab" role="tab" aria-controls="selleradise_single_product__upsells">
			<a href="#selleradise_single_product__upsells">
				<?php esc_html_e("You may also like…", 'TEXT_DOMAIN'); ?>
			</a>
		</li>

		<li id="selleradise_single_product__related_tab" role="tab" aria-controls="selleradise_single_product__related">
			<a href="#selleradise_single_product__related">
				<?php esc_html_e("Related Products", 'TEXT_DOMAIN'); ?>
			</a>
		</li>
	</ul>

	<div class="selleradise_single_product__panels">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="selleradise_single_product__panel woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
