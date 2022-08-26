<?php

defined('ABSPATH') || exit;


/**
 * Hook: selleradise_before_shop_products.
 *
 * @hooked THEME_NAMESPACE\plugins::shop_sidebar() - 10
 */

do_action('selleradise_before_shop_products');

$filters_location = get_theme_mod('filters_location', 'sidebar');

if ($filters_location === 'sidebar-left') {
    get_template_part('woocommerce/loop/sidebar');
}

?>

<div 
    class="selleradise_shop__products"
	data-selleradise-sidebar-type="<?php echo esc_attr( get_theme_mod( 'filters_location', 'sidebar' ) ); ?>"
    data-selleradise-card-type="<?php echo esc_attr( get_theme_mod('shop_page_card_type', 'default') ); ?>">
    <?php
    
        if ( woocommerce_product_loop() ):

            /**
			 * Hook: woocommerce_before_shop_loop.
			 *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
			 * @hooked THEME_NAMESPACE\Plugins\WooCommerce::shop_sidebar - 40
			 */

			do_action( 'woocommerce_before_shop_loop' );

            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();
                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action( 'woocommerce_shop_loop' );

                    get_template_part( 'template-parts/product/card', get_theme_mod('shop_page_card_type', 'default') );

                }
            }

            woocommerce_product_loop_end();

            /**
             * Hook: woocommerce_after_shop_loop.
             *
			 * @hooked THEME_NAMESPACE\Plugins\WooCommerce::shop_sidebar - 4
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
        else: 
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
        
        endif;

        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );

    ?>

</div>

<?php

/**
 * Hook: selleradise_before_shop_products.
 *
 * @hooked THEME_NAMESPACE\plugins::shop_sidebar() - 10
 */

do_action('selleradise_after_shop_products');


if ($filters_location !== 'sidebar-left') {
    get_template_part('woocommerce/loop/sidebar');
}
