<?php

namespace Selleradise_Lite\Setup;

class Setup
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        add_action('after_setup_theme', [$this, 'setup'], 0);
        add_action('tgmpa_register', [$this, 'register_required_plugins']);
        add_action('admin_menu', [$this, 'admin_pages']);

        add_filter('body_class', [$this, 'add_class_to_body']);
        add_filter('terms_clauses', [$this, 'filter_terms_clauses'], 10, 3);
        add_filter('posts_clauses', [$this, 'filter_posts_clauses'], 10, 2);
        add_filter('excerpt_length', [$this, 'excerpt_length'], 999);
        add_filter('the_content', [$this, 'update_post_views']);

        add_action("edited_product_cat", [$this, 'delete_product_category_transient'], 10, 1);
        add_action("created_product_cat", [$this, 'delete_product_category_transient'], 10, 1);
        add_action("deleted_product_cat", [$this, 'delete_product_category_transient'], 10, 1);
        add_action("woocommerce_update_product", [$this, 'delete_product_transient'], 10, 1);
    }

    public function setup()
    {
        /*
         * Default Theme Support options better have
         */
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
        add_theme_support('post-thumbnails');
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('editor-styles');
        add_theme_support('wp-block-styles');

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /**
         * Add woocommerce support and woocommerce override
         */

        add_theme_support('woocommerce', array(
            'thumbnail_image_width' => 300,
            'single_image_width' => 1024,
            'product_grid' => array(
                'default_rows' => 3,
                'min_rows' => 3,
                'max_rows' => 3,
                'default_columns' => 4,
                'min_columns' => 4,
                'max_columns' => 4,
            ),
        ));

        $GLOBALS['content_width'] = apply_filters('content_width', 1920);

        load_theme_textdomain('selleradise-lite', get_template_directory() . '/languages');

    }

    public function register_required_plugins()
    {

        $plugins = array(
            array(
                'name' => esc_html__('WooCommerce', 'selleradise-lite'),
                'slug' => 'woocommerce',
                'required' => true,
            ),
            array(
                'name' => esc_html__('Kirki', 'selleradise-lite'),
                'slug' => 'kirki',
                'required' => true,
            ),
            array(
                'name' => esc_html__('Elementor', 'selleradise-lite'),
                'slug' => 'elementor',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Selleradise Widgets', 'selleradise-lite'),
                'slug' => 'selleradise-widgets',
                'required' => false,
            ),
        );

        $config = array(
            'id' => 'selleradise-lite',
            'default_path' => get_template_directory() . '/plugins/',
            'menu' => 'tgmpa-install-plugins',
            'has_notices' => true,
            'dismissable' => true,
            'dismiss_msg' => '',
            'is_automatic' => false,
            'message' => '',
        );

        tgmpa($plugins, $config);
    }

    public function add_class_to_body($classes)
    {
        $classes[] = 'selleradise-lite';

        if (!class_exists('WooCommerce')) {
            return $classes;
        }

        if (class_exists('WPMultiStepCheckout') && is_checkout()) {
            $classes[] = 'woocommerce-multi-step-checkout';
        }

        if (wc()->cart->is_empty() && is_cart()) {
            $classes[] = 'woocommerce-cart-is-empty';
        }

        return $classes;
    }

    public function excerpt_length($length)
    {
        if (is_admin()) {
            return $length;
        }

        return 20;
    }

    public function filter_terms_clauses($pieces, $taxonomies, $args)
    {
        $starts__with = (isset($args['starts__with'])) ? trim(sanitize_text_field($args['starts__with'])) : '';

        global $wpdb;

        if (!empty($starts__with)) {
            $pieces['where'] .= " AND t.name LIKE %s";
            $pieces['where'] = $wpdb->prepare($pieces['where'], "{$wpdb->esc_like($starts__with)}%");

            return $pieces;
        }

        $sounds__like = (isset($args['sounds__like'])) ? trim(sanitize_text_field($args['sounds__like'])) : '';

        if (!empty($sounds__like)) {
            $like = $wpdb->esc_like($sounds__like);
            $pieces['where'] .= " AND ((t.name LIKE %s OR t.slug LIKE %s) OR t.name SOUNDS LIKE %s)";
            $pieces['where'] = $wpdb->prepare($pieces['where'], "%$like%", "%$like%", "$like");
        }

        return $pieces;
    }

    public function filter_posts_clauses($pieces, $query)
    {
        $starts_with = (isset($query->query['starts_with'])) ? trim(sanitize_text_field($query->query['starts_with'])) : '';

        if (empty($starts_with)) {
            return $pieces;
        }

        global $wpdb;

        $pieces['where'] .= " AND wp_posts.post_title LIKE %s";
        $pieces['where'] = $wpdb->prepare($pieces['where'], "{$wpdb->esc_like($starts_with)}%");

        return $pieces;
    }

    public function update_post_views($content)
    {
        if (current_user_can('edit_posts') || !is_single() || get_post_type() !== 'post') {
            return $content;
        }

        $current_time = time();
        $reset_time = selleradise_trending_posts_reset_time();

        $id = get_the_ID();

        $meta_key = [
            'selleradise_trending_post_views',
            'selleradise_trending_post_views_updated_on',
        ];

        $meta_value_new = [
            "selleradise_trending_post_views" => 0,
            "selleradise_trending_post_views_updated_on" => $current_time,
        ];

        $meta_value = [];
        $meta_check = [];

        foreach ($meta_key as $index => $key) {
            $meta_check[$key] = metadata_exists('post', $id, $key);

            if (false === $meta_check[$key]) {
                $meta_value[$key] = $meta_value_new[$key];
                delete_post_meta($id, $key);
                add_post_meta($id, $key, $meta_value[$key]);
                continue;
            }

            $meta_value[$key] = get_post_meta($id, $key, true);
        }

        if ($reset_time->format('U') <= $current_time && $reset_time->format('U') > $meta_value[$meta_key[1]]) {
            $meta_value = $meta_value_new;
        } else {
            $meta_value[$meta_key[0]]++;
        }

        foreach ($meta_key as $index => $key) {
            update_post_meta($id, $key, $meta_value[$key]);
        }

        return $content;
    }

    public function admin_pages()
    {
        $admin_page = add_submenu_page(
            'themes.php', 
            'Selleradise Information', 
            'Selleradise', 
            'manage_options', 
            'selleradise_lite_info', 
            [$this, 'selleradise_lite_info_page']
        );

        add_action('load-'.$admin_page, [$this, 'load_admin_css']);

    }

    public function load_admin_css()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_css']);
    }

    public function enqueue_admin_css()
    {
        wp_enqueue_style('admin', selleradise_assets('css/admin.css'), array(), '1.0.0', 'all');
    }

    public function selleradise_lite_info_page()
    {
        get_template_part("template-parts/admin/info");
    }

    public function delete_product_category_transient($term_id)
    {
        delete_transient('selleradise_categories_tree');
    }

    public function delete_product_transient($post_id)
    {
        delete_transient('selleradise_categories_tree');
        delete_transient('selleradise_get_shop_max_price');
    }

}
