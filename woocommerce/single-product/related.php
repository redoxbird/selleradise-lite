<?php
/**
 * Related Products
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section 
		class="selleradise_single_product__related"
		id="selleradise_single_product__related"
		data-selleradise-card-type="<?php echo esc_attr( get_theme_mod('shop_page_card_type', 'default') ); ?>">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __("Related Products", "selleradise-lite") );

		if ( $heading ) : ?>

			<h2><?php echo esc_html( $heading ); ?></h2>
		
		<?php 
		
		endif;
		
			woocommerce_product_loop_start();
				foreach ( $related_products as $related_product ) :
						$post_object = get_post( $related_product->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						get_template_part('template-parts/product/card', get_theme_mod('shop_page_card_type', 'default'));

				endforeach; 
			woocommerce_product_loop_end();
		
		?>

	</section>
	<?php
endif;

wp_reset_postdata();
