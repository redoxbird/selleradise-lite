<?php

namespace Selleradise_Lite\Setup;

/**
 * Enqueue.
 */
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

        $this->assets = [
            "js" => [
                [
                    "name" => "swiper",
                    "file_name" => "swiper.min.js",
                    "version" => "5.3.6",
                    "condition" => true,
                ],
                [
                    "name" => "headroom.js",
                    "file_name" => "headroom.min.js",
                    "version" => "0.12.0",
                    "condition" => true,
                ],
                [
                    "name" => "popperjs/core",
                    "file_name" => "popper.min.js",
                    "version" => "2.9.1",
                    "condition" => true,
                ],
                [
                    "name" => "tippy.js",
                    "file_name" => "tippy-bundle.umd.min.js",
                    "version" => "6.3.1",
                    "condition" => true,
                ],
                [
                    "name" => "anime.js",
                    "file_name" => "anime.min.js",
                    "version" => "3.2.1",
                    "condition" => true,
                ],
                [
                    "name" => "axios",
                    "file_name" => "axios.min.js",
                    "version" => "0.21.1",
                    "condition" => true,
                ],
                [
                    "name" => "nouislider",
                    "file_name" => "nouislider.min.js",
                    "version" => "14.6.4",
                    "condition" => class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag()) ? true : false,
                ],
                [
                    "name" => "redom",
                    "file_name" => "redom.min.js",
                    "version" => "3.27.1",
                    "condition" => true,
                ],
                [
                    "name" => "colorthief",
                    "file_name" => "color-thief.min.js",
                    "version" => "2.3.2",
                    "condition" => true,
                ],
                [
                    "name" => "scrollama",
                    "file_name" => "scrollama.js",
                    "version" => "2.2.0",
                    "condition" => true,
                ],
                [
                    "name" => "intersection-observer",
                    "file_name" => "intersection-observer.js",
                    "version" => "2.2.0",
                    "condition" => true,
                ],
            ],
            "css" => [
                [
                    "name" => "swiper",
                    "file_name" => "swiper-bundle.min.css",
                    "version" => "7.0.9",
                    "condition" => true,
                ],
                [
                    "name" => "tippy",
                    "file_name" => "tippy.css",
                    "version" => "6.3.1",
                    "condition" => true,
                ],
                [
                    "name" => "tippy-swift-away",
                    "file_name" => "shift-away.css",
                    "version" => "6.3.1",
                    "condition" => true,
                ],
                [
                    "name" => "nouislider",
                    "file_name" => "nouislider.min.css",
                    "version" => "14.6.4",
                    "condition" => class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag()) ? true : false,
                ],
            ],
        ];

        // Scripts

        wp_enqueue_script("photoswipe");
        wp_enqueue_script("photoswipe-ui-default");
        wp_enqueue_script("jquery");

        foreach ($this->assets['js'] as $index => $javascript_asset) {
            if ($javascript_asset["condition"] !== true) {
                continue;
            }

            wp_enqueue_script(
                $javascript_asset['name'],
                get_template_directory_uri() . '/assets/vendor/js/' . $javascript_asset['file_name'],
                array(),
                $javascript_asset['version'],
                true
            );
        };

        wp_enqueue_script('selleradise-header', selleradise_assets('js/header.js'), array(), $this->get_version(), false);
        wp_enqueue_script('selleradise-main', selleradise_assets('js/app.js'), array(), $this->get_version(), true);
        wp_enqueue_script('selleradise-sliders', selleradise_assets('js/sliders.js'), array('swiper'), $this->get_version(), true);

        wp_localize_script('selleradise-header', 'selleradiseData', [
            "theme" => $this->get_data_for_javascript()["theme"],
        ]);

        wp_localize_script('selleradise-main', 'selleradiseData', $this->get_data_for_javascript());

        // Styles

        wp_enqueue_style("photoswipe");
        wp_enqueue_style("photoswipe-default-skin");

        foreach ($this->assets['css'] as $index => $css_asset) {
            if ($css_asset["condition"] !== true) {
                continue;
            };

            wp_enqueue_style(
                $css_asset['name'],
                get_template_directory_uri() . '/assets/vendor/css/' . $css_asset['file_name'],
                array(),
                $css_asset['version'],
                'all'
            );
        };

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
                'header-button-cart' => __('Cart', 'selleradise-lite'),
                'header-button-search' => __('Search', 'selleradise-lite'),
                'header-search-dropdown' => __('All Categories', 'selleradise-lite'),
                'header-search-form-label' => __("Search for products here...", "selleradise-lite"),
                'header-search-from-error-digits' => __('Please enter at least 2 characters', 'selleradise-lite'),
                'Learn More' => __('Learn More', 'selleradise-lite'),
                'Login or create a new account' => __('Login or create a new account', 'selleradise-lite'),
                'Login/Register' => __('Login/Register', 'selleradise-lite'),
                'Looks like you have not added any product to your cart yet.' => __('Looks like you have not added any product to your cart yet.', 'selleradise-lite'),
                'mini-cart-item-text' => __("%d item is in your cart", "selleradise-lite"),
                'mini-cart-items-text' => __("%d items are in your cart", "selleradise-lite"),
                'mobile-menu-button-account' => __('Account', 'selleradise-lite'),
                'mobile-menu-button-categories' => __('Categories', 'selleradise-lite'),
                'mobile-menu-button-menu' => __('Menu', 'selleradise-lite'),
                'mobile-menu-button-settings' => __('Settings', 'selleradise-lite'),
                'mobile-menu-toggle-dark-mode' => __('Dark Mode', 'selleradise-lite'),
                'Nothing Found' => __('Nothing Found', 'selleradise-lite'),
                'Other' => __('Other', 'selleradise-lite'),
                'product-card-add-to-cart' => __('Add To Cart', 'selleradise-lite'),
                'product-card-adding-to-cart' => __('Adding To Cart', 'selleradise-lite'),
                'product-card-view-cart' => __('View Cart', 'selleradise-lite'),
                'product-sale-ended' => __('Sale has ended', 'selleradise-lite'),
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
