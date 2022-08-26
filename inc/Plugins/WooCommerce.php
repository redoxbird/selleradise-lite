<?php
/**
 * WooCommerce
 *
 * @link https://github.com/woocommerce/woocommerce
 *
 * @package selleradise
 */

namespace THEME_NAMESPACE\Plugins;

class WooCommerce
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        if (!class_exists('WooCommerce')) {
            return;
        }

        /**
         * General
         */

        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);

        /**
         * Product Archive
         */

        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action('woocommerce_sidebar', 'woocommerce_sidebar', 10);

     
        add_action('selleradise_before_shop_title', 'selleradise_get_breadcrumb', 10);
        add_action('woocommerce_before_shop_loop', [$this, 'shop_title'], 20);
        add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
        add_action('woocommerce_after_shop_loop', [$this, 'shop_pagination_wrap_start'], 5);
        add_action('woocommerce_after_shop_loop', [$this, 'shop_pagination_wrap_end'], 50);
        add_action('woocommerce_no_products_found', [$this, 'no_products_found'], 10);

        /**
         * Single Product
         */

        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

        add_action('selleradise_single_product_title', 'selleradise_get_breadcrumb', 5);
        add_action('selleradise_single_product_title', 'woocommerce_template_single_title', 10);
        add_action('selleradise_single_product_after_title', [$this, 'single_product_after_title_wrap_start'], 5);
        add_action('selleradise_single_product_after_title', [$this, 'single_product_categories'], 15);
        add_action('selleradise_single_product_after_title', 'woocommerce_template_single_rating', 10);
        add_action('selleradise_single_product_after_title', [$this, 'single_product_after_title_wrap_end'], 100);

        add_action('woocommerce_single_product_summary', [$this, 'single_product_sale_timer'], 15);
        add_action('woocommerce_after_single_product_summary', [$this, 'single_product_tags'], 25);

        add_filter('woocommerce_product_data_store_cpt_get_products_query', [$this, 'query_onsale_products'], 10, 2);
    }

    public function single_product_tags()
    {
        get_template_part('woocommerce/single-product/tags');
    }

    public function single_product_categories()
    {
        get_template_part('woocommerce/single-product/categories');
    }

    public function single_product_sale_timer()
    {
        get_template_part('template-parts/product/partials/sale', 'timer');
    }

    public function shop_title()
    {
        get_template_part('woocommerce/loop/title');
    }

    public function shop_sidebar()
    {
        get_template_part('woocommerce/loop/sidebar');
    }

    public function no_products_found() {
        get_template_part('woocommerce/loop/empty-state');
    }

    public function shop_pagination_wrap_start()
    {
        echo '<div class="selleradise_shop__pagination">';
    }

    public function shop_pagination_wrap_end()
    {
        echo '</div>';
    }

    public function single_product_after_title_wrap_start()
    {
        echo '<div class="flex w-full mt-4 gap-4 flex-wrap">';
    }

    public function single_product_after_title_wrap_end()
    {
        echo '</div>';
    }

    public function query_onsale_products($query, $query_vars)
    {
        if (!empty($query_vars['selleradise_onsale'])) {

            $now = time();

            if ($query_vars['selleradise_onsale']) {
                $query['meta_query'][] = [
                    'relation' => 'OR',
                    [ // Simple products type
                        'relation' => 'AND',
                        [
                            'key' => '_sale_price',
                            'value' => 0,
                            'compare' => '>',
                            'type' => 'numeric',
                        ],
                        [
                            'relation' => 'OR',
                            [
                                'key' => '_sale_price_dates_to',
                                'value' => $now,
                                'compare' => '>=',
                                'type' => 'NUMERIC',
                            ],
                            [
                                'key' => '_sale_price_dates_to',
                                'compare' => 'NOT EXISTS',
                            ],
                        ],
                    ],

                    [ // Variable products type
                        'relation' => 'AND',
                        [
                            'key' => '_min_variation_sale_price',
                            'value' => 0,
                            'compare' => '>',
                            'type' => 'numeric',
                        ],
                        [
                            'relation' => 'OR',
                            [
                                'key' => '_sale_price_dates_to',
                                'value' => $now,
                                'compare' => '>=',
                                'type' => 'NUMERIC',
                            ],
                            [
                                'key' => '_sale_price_dates_to',
                                'compare' => 'NOT EXISTS',
                            ],
                        ],
                    ],
                ];
            }

        }

        return $query;
    }

}
