<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

	<section 
		class="selleradise_single_product__upsells"
		id="selleradise_single_product__upsells"
		data-selleradise-card-type="<?php echo esc_attr( get_theme_mod('shop_page_card_type', 'default') ); ?>">
		
		<?php

		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __("You may also like…", "selleradise-lite") );

		if ( $heading ) : ?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		
		<?php 
		
		endif;
		
			woocommerce_product_loop_start();
				foreach ( $upsells as $upsell ) :
						$post_object = get_post( $upsell->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						get_template_part('template-parts/product/card', get_theme_mod('shop_page_card_type', 'default'));

				endforeach; 
			woocommerce_product_loop_end();
		
		?>

	</section>

	<?php
endif;

wp_reset_postdata();
