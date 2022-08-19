<?php

namespace Selleradise_Lite\Setup;

/**
 * Enqueue.
 */

use WC_AJAX;

class Enqueue
{
    public $assets;
    public $version;
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action('wp_head', [$this, 'css_variables']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);

        if (!class_exists('Kirki') || get_theme_mod('font_load_from_google', false)) {
            add_action('wp_print_styles', [$this, 'google_fonts']);
        }
    }

    public function enqueue_scripts()
    {
        // Scripts

        if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag())) {
            wp_enqueue_script("nouislider", get_template_directory_uri() . '/assets/vendor/js/nouislider.min.js', array(), '14.6.4', true);
            wp_enqueue_style("nouislider", get_template_directory_uri() . '/assets/vendor/css/nouislider.min.css', array(), "14.6.4", 'all');
        }

        wp_enqueue_script("scrollama", get_template_directory_uri() . '/assets/vendor/js/scrollama.js', array(), '2.2.0', true);
        wp_enqueue_script("intersection-observer", get_template_directory_uri() . '/assets/vendor/js/intersection-observer.js', array(), '2.2.0', true);

        wp_enqueue_script('selleradise-main', selleradise_assets('js/app.js'), array(), $this->get_version(), true);
        wp_localize_script('selleradise-main', 'selleradiseData', $this->get_data_for_javascript());

        wp_enqueue_style('selleradise-lite', selleradise_assets('css/style.css'), array(), $this->get_version(), 'all');

        if (class_exists('Selleradise_Widgets\\Init')) {
            wp_enqueue_style('selleradise-widgets', selleradise_assets('css/elementor-widgets.css'), array(), $this->get_version(), 'all');
        }

        // Extra
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    public function get_data_for_javascript()
    {
        $data = [
            '_wpnonce' => wp_create_nonce('selleradise_ajax'),
            'homeURL' => esc_url(home_url()),
            'assetsURL' => esc_url(selleradise_assets('/')),
            'ajaxURL' => esc_url(admin_url('admin-ajax.php')),
            'wcAjaxURl' => WC_AJAX::get_endpoint(),
            "isWooCommerce" => class_exists('WooCommerce') ? true : false,
            "settings" => [
                "dark_mode_setting" => esc_html(get_theme_mod('theme_type', 'light') === 'both'),
            ],
            "theme" => [
                "type" => esc_attr(get_theme_mod('theme_type', 'light')),
                "current" => !empty($_COOKIE['darkMode']) && $_COOKIE['darkMode'] == 'true' ? 'dark' : 'light',
                "darkMode" => !empty($_COOKIE['darkMode']) && $_COOKIE['darkMode'] == 'true' ? true : false,
            ],
            'langs' => [
                'Checkout' => __('Checkout', 'selleradise-lite'),
                'Edit Cart' => __('Edit Cart', 'selleradise-lite'),
                'Go to slide' => __('Go to slide', 'selleradise-lite'),
                'header-search-dropdown' => __('All Categories', 'selleradise-lite'),
                'mini-cart-item-text' => __("%d item is in your cart", "selleradise-lite"),
                'mini-cart-items-text' => __("%d items are in your cart", "selleradise-lite"),
                'mobile-menu-toggle-dark-mode' => __('Dark Mode', 'selleradise-lite'),
                'Other' => __('Other', 'selleradise-lite'),
                'product-sale-ends-in' => __('Sale ends in', 'selleradise-lite'),
                'product-sale-starts-in' => __('Sale starts in', 'selleradise-lite'),
                'Products' => __('Products', 'selleradise-lite'),
                'Search' => __('Search', 'selleradise-lite'),
                'Settings' => __('Settings', 'selleradise-lite'),
                'shop-filter-apply' => __('Apply Filters', 'selleradise-lite'),
                'shop-filter-categories' => __('Categories', 'selleradise-lite'),
                'shop-filter-clear' => __('Clear', 'selleradise-lite'),
                'shop-filter-price' => __('Price', 'selleradise-lite'),
                'Suggestions' => __('Suggestions', 'selleradise-lite'),
                'Tags' => __('Tags', 'selleradise-lite'),
                'Theme' => __('Theme', 'selleradise-lite'),
                'Welcome to %s' => __('Welcome to %s', 'selleradise-lite'),
                'Your cart is empty.' => __('Your cart is empty.', 'selleradise-lite'),
                "%s has been added to your cart" => __("%s has been added to your cart", "selleradise-lite"),
                "An error occurred while adding %s to your cart" => __("An error occurred while adding %s to your cart", "selleradise-lite"),
                "An error occurred while updating cart" => __("An error occurred while updating cart", "selleradise-lite"),
            ],
        ];

        $woocommerce_data = [
            "currencySymbol" => function_exists("get_woocommerce_currency_symbol") ? esc_html(get_woocommerce_currency_symbol()) : "",
            "cartURL" => function_exists("wc_get_cart_url") ? esc_url(wc_get_cart_url()) : "",
            "checkoutURL" => function_exists("wc_get_checkout_url") ? esc_url(wc_get_checkout_url()) : "",
            "shopURL" => function_exists("wc_get_page_permalink") ? esc_url(wc_get_page_permalink('shop')) : "",
        ];

        return array_merge($data, $woocommerce_data);
    }

    public function css_variables()
    {
        get_template_part('template-parts/headers/css-variables');
    }

    public function google_fonts()
    {
        /**
         * Load fonts from google server when Kirki does not exist.
         *
         */

        $fonts = selleradise_get_fonts();

        $base = "//fonts.googleapis.com/css2?";

        $primary_variants = join(";", array_unique(
            [
                selleradise_get_font_weight($fonts['primary']['variant']),
                selleradise_get_font_weight($fonts['primary_bolder']['variant']),
                selleradise_get_font_weight($fonts['primary_boldest']['variant']),
            ]
        ));

        $links = [
            "primary" => sprintf(
                '%sfamily=%s:wght@%s&display=swap',
                $base,
                $fonts['primary']['font-family'],
                $primary_variants
            ),
            "heading" => sprintf(
                '%sfamily=%s:wght@%s&display=swap',
                $base,
                $fonts['heading']['font-family'],
                selleradise_get_font_weight($fonts['heading']['variant'])
            ),
        ];

        wp_register_style($fonts['primary']['font-family'], $links["primary"]);
        wp_register_style($fonts['heading']['font-family'], $links["heading"]);

        wp_enqueue_style($fonts['primary']['font-family']);
        wp_enqueue_style($fonts['heading']['font-family']);
    }


    public function admin_enqueue_scripts()
    {

        if (class_exists('Kirki') && is_customize_preview()) {
            wp_enqueue_script('selleradise-admin', get_template_directory_uri() . '/assets/dist/js/admin.js', array('jquery'), time(), true);
        }
    }

    public function get_version()
    {
        $version = SELLERADISE_VERSION;

        if (!function_exists('wp_get_environment_type')) {
            return $version;
        }

        switch (wp_get_environment_type()) {
            case 'local':
            case 'development':
                $version = time();
                break;
        }

        return $version;
    }
}
