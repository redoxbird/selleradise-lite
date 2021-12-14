<?php

/**
 * Cart Page
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */


defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<?php get_template_part('template-parts/components/breadcrumb');?>

<div class="selleradise_page-cart">

	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<ul class="selleradise_page-cart__items cart woocommerce-cart-form__contents">
			<?php do_action('woocommerce_before_cart_contents'); ?>

			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
					$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ):
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>

				
				<li class="selleradise_page-cart__item cart_item">
					<div class="selleradise_page-cart__item-image">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo wp_kses_post( $thumbnail ); // PHPCS: XSS ok.
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							}
						?>

						<div class="selleradise_page-cart__item-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</div>
					</div>

					<div class="selleradise_page-cart__item-info">
						<h2 class="selleradise_page-cart__item-name">
							<?php
								if ( ! $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								}

								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

								// Backorder notification.
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'selleradise-lite' ) . '</p>', $product_id ) );
								}
							?>
						</h2>

						<?php get_template_part('woocommerce/cart/variation-info', null, ['_product' => $_product]);?>

					
						<div class="selleradise_page-cart__item-price">

							<div class="selleradise_page-cart__item-quantity product-quantity">
								
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '0',
												'product_name' => $_product->get_name(),
											),
											$_product,
											false
										);
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
							</div>

							<span class="closeIcon">
								<?php echo selleradise_svg('unicons-line/multiply'); ?>
							</span>

							<span class="selleradise_page-cart__item-price-single">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</span>

							<div class="selleradise_page-cart__item-remove">
								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'selleradise-lite' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() ),
											esc_html__( 'Remove', 'selleradise-lite' )
										),
										$cart_item_key
									);
								?>
							</div>
						</div>
						
					</div>
				</li>

				<?php do_action('woocommerce_cart_contents');?>

				<tr>

				</tr>

				<?php do_action('woocommerce_after_cart_contents');?>

			
			<?php endif; endforeach; ?>
		</ul>

		<div class="actions">
			<div class="update-action-wrap">
				<button type="submit" class="selleradise_button--primary" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'selleradise-lite' ); ?>"><?php esc_html_e( 'Update cart', 'selleradise-lite' ); ?></button>
			</div>

			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="coupon">
					<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'selleradise-lite' ); ?></label> 
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'selleradise-lite' ); ?>" /> 
					<button type="submit" class="selleradise_button--secondary" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'selleradise-lite' ); ?>">
						<?php esc_attr_e( 'Apply coupon', 'selleradise-lite' ); ?>
					</button>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			<?php } ?>

			<?php do_action( 'woocommerce_cart_actions' ); ?>

			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
		</div>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>

	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<div class="cart-collaterals">
		<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>

	<?php do_action( 'woocommerce_after_cart' ); ?>

</div>

