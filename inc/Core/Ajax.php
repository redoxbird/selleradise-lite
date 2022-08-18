<?php

namespace Selleradise_Lite\Core;

use WC_Product_Query;
use WP_Query;

/**
 * Ajax.
 */
class Ajax
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public $ajax_events_nopriv = [
        'search_products',
        'search_terms',
        'search_posts',
        'get_cart_contents',
        'get_cart_total',
        'remove_item_from_cart',
        'set_cart_item_quantity',
        'get_menu_items',
        'get_categories',
        'get_shop_filter_attributes'
    ];

    public function register()
    {

        foreach ($this->ajax_events_nopriv as $ajax_event) {
            add_action('wp_ajax_selleradise_' . $ajax_event, [$this, $ajax_event]);
            add_action('wp_ajax_nopriv_selleradise_' . $ajax_event, [$this, $ajax_event]);
        }
    }

    public function search_products()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $keyword = sanitize_text_field($_GET['keyword']);
        $category = sanitize_text_field($_GET['category']);

        if (!class_exists('WooCommerce')) {
            return wp_send_json([]);

            wp_die();
        }

        $args = [
            'orderby' => 'relevance',
            'order' => 'ASC',
            'return' => 'object',
            'limit' => 5,
            'visibility' => 'search',
        ];

        if ($keyword) {
            if (get_theme_mod('quick_search_type', 'accurate') === 'fast') {
                $args['starts__with'] = $keyword;
            } else {
                $args['s'] = $keyword;
            }
        }

        if ($category) {
            $args['category'] = [$category];
        }

        $query = new WC_Product_Query($args);

        $products = $query->get_products();

        $data = $this->prepare_product_data_for_search_results($products);

        wp_send_json($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function search_terms()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $data = [
            "terms" => [],
            "products" => [],
        ];

        if (!class_exists('WooCommerce')) {
            return wp_send_json($data);

            wp_die();
        }

        $keyword = sanitize_text_field($_GET['keyword']);

        $term_args = [
            'orderby' => 'count',
            'order' => 'DESC',
            'hide_empty' => false,
            'number' => 5,
            'taxonomy' => ['product_cat', 'product_tag']
        ];

        $product_args = [
            'orderby' => 'relevance',
            'order' => 'ASC',
            'return' => 'object',
            'limit' => 5,
            'visibility' => 'search',
        ];

        if ($keyword) {
            if (get_theme_mod('quick_search_type', 'accurate') === 'fast') {
                $term_args['starts__with'] = $keyword;
                $product_args['starts__with'] = $keyword;
            } else {
                $term_args['sounds__like'] = $keyword;
                $product_args['s'] = $keyword;
            }
        }

        $product_query = new WC_Product_Query($product_args);
        $products = $product_query->get_products();
        $terms = get_terms($term_args);

        $data["products"] = $this->prepare_product_data_for_search_results($products);
        $data["terms"] = $this->prepare_term_data_for_search_results($terms);

        wp_send_json($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    private function prepare_term_data_for_search_results($terms)
    {
        $data = [];

        if (!$terms || empty($terms)) {
            return $data;
        }

        $term_names = array_column($terms, "name");
        $duplicate_names = array_unique(array_diff_assoc($term_names, array_unique($term_names)));

        foreach ($terms as $term) {
            $term_data = [
                "slug" => esc_attr($term->slug),
                "name" => esc_html($term->name),
                "link" => esc_url(get_term_link($term)),
            ];

            if ($term->taxonomy === 'product_cat') {
                $term_product_args['category'][] = $term->slug;
            }

            if ($term->taxonomy === 'product_tag') {
                $term_product_args['tag'][] = $term->slug;
            }

            if (in_array($term->name, $duplicate_names)) {
                $term_data["is_duplicate_name"] = true;
            }

            if ($term->parent) {
                $parent = get_term($term->parent, $term->taxonomy);
                $term_data["parent_term"] = $parent;
            }

            $data[] = $term_data;
        }

        return $data;
    }

    private function prepare_product_data_for_search_results($products)
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $data = [];

        foreach ($products as $product) {
            $product_data = [
                "post_title" => esc_html($product->get_name()),
                "guid" => esc_url(get_permalink($product->get_id())),
                "price" => wp_kses_post($product->get_price_html()),
                "id" => $product->get_id(),
            ];

            $image = $product->get_image_id();

            if (!$image) {
                $product_data["image_url"] = esc_url(wc_placeholder_img_src());
            } else {
                $image_src = wp_get_attachment_image_src($image, 'thumbnail');
                $product_data["image_url"] = esc_url($image_src[0]);
            }

            $data[] = $product_data;
        }

        return $data;
    }

    public function search_posts()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $keyword = sanitize_text_field($_GET['keyword']);

        $args = [
            'post_type' => ['post', 'page'],
            'posts_per_page' => 5,
        ];

        if ($keyword) {
            if (get_theme_mod('quick_search_type', 'accurate') === 'fast') {
                $args['starts__with'] = $keyword;
            } else {
                $args['s'] = $keyword;
            }
        }

        $posts = new WP_Query($args);

        $data = [];

        while ($posts->have_posts()) {
            $posts->the_post();

            $data[] = [
                "title" => esc_html(get_the_title()),
                "link" => esc_url(get_the_permalink()),
            ];

            wp_reset_postdata();
        }

        wp_send_json($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    private function get_cart()
    {

        $cart = [
            "items" => selleradise_get_cart_items_with_product(),
            "count" => function_exists("wc") ? wc()->cart->get_cart_contents_count() : 0,
            "total" => function_exists("wc") ? wc()->cart->get_cart_total() : 0,
        ];

        return $cart;
    }

    public function get_cart_contents()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        wp_send_json($this->get_cart());

        wp_die();
    }

    public function get_cart_total()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };


        wp_send_json_success(wc()->cart->get_cart_total());

        wp_die();
    }

    public function remove_item_from_cart()
    {

        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $key = sanitize_text_field($_GET['key']);

        $remove_item = wc()->cart->remove_cart_item($key);

        if (!$remove_item) {
            wp_send_json_error([
                'message' => 'Error occurred while removing product from cart',
            ]);

            wp_die();
        }

        wp_send_json_success($this->get_cart());

        wp_die();
    }

    public function set_cart_item_quantity()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $key = sanitize_text_field($_GET['key']);
        $quantity = sanitize_text_field($_GET['quantity']);

        $set_quantity = wc()->cart->set_quantity($key, $quantity);

        if (!$set_quantity) {
            wp_send_json_error([
                'message' => __('Error occurred while updating product in cart', 'selleradise-lite'),
            ]);

            wp_die();
        }

        wp_send_json_success($this->get_cart());

        wp_die();
    }

    public function get_menu_items()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $mobile_menu = get_transient('selleradise_mobile_menu_tree');

        if (false === $mobile_menu) {
            $mobile_menu = $this->prepare_menu_items(selleradise_get_menu_items_by_registered_slug('mobile'));
            set_transient('selleradise_mobile_menu_tree', $mobile_menu, DAY_IN_SECONDS);
        }

        wp_send_json($mobile_menu);

        wp_die();
    }

    private function prepare_menu_items($items)
    {

        if (empty($items)) {
            return [];
        }

        $data = [];

        foreach ($items as $key => $item) {
            $item_data = [];
            $item_data["title"] = esc_html($item->title);
            $item_data["ID"] = (int) esc_attr($item->ID);
            $item_data["classes"] = esc_attr(implode(' ', $item->classes));
            $item_data["url"] = esc_url($item->url);
            $item_data["target"] = esc_attr($item->target);
            $item_data["attr_title"] = esc_attr($item->attr_title);
            $item_data["menu_item_parent"] = (int) esc_attr($item->menu_item_parent);

            $data[] = $item_data;
        }

        return selleradise_create_tree($data, 'menu_item_parent', 'ID');
    }

    public function get_categories()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $categories_tree = get_transient('selleradise_categories_tree');

        if (false === $categories_tree) {
            $categories_tree = $this->prepare_categories(selleradise_get_product_categories());
            set_transient('selleradise_categories_tree', $categories_tree, DAY_IN_SECONDS);
        }

        wp_send_json($categories_tree);

        wp_die();
    }

    private function prepare_categories($items)
    {

        if (empty($items)) {
            return [];
        }

        $data = [];

        foreach ($items as $term) {
            $image = [];
            $image["id"] = (int) esc_attr(get_term_meta($term->term_id, 'thumbnail_id', true));
            $image["thumbnail"] = wp_get_attachment_image_src($image["id"], 'thumbnail');
            $image["alt"] = esc_attr(get_post_meta($image["id"], '_wp_attachment_image_alt', true));

            $data[] = [
                'term_id' => (int) esc_attr($term->term_id),
                'slug' => esc_attr($term->slug),
                'name' => esc_html($term->name),
                'url' => esc_url(get_term_link($term)),
                'description' => esc_html($term->description),
                'parent' => (int) esc_attr($term->parent),
                'count' => (int) esc_attr($term->count),
                'image' => $image,
            ];
        }

        return selleradise_create_tree($data, 'parent', 'term_id');
    }

    public function get_shop_filter_attributes()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $attributes = wc_get_attribute_taxonomies();
        $attributes_with_values = [];

        foreach ($attributes as $key => $attribute) {

            $attribute_values = get_terms(wc_attribute_taxonomy_name($attribute->attribute_name), array(
                'hide_empty' => false,
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 100,
            ));

            foreach ($attribute_values as $key => $attribute_value) {
                $color = get_term_meta($attribute_value->term_id, 'product_attribute_color');

                if ($color) {
                    $attribute_values[$key]->color = $color[0];
                }
            }

            $attribute->attribute_values = $attribute_values;

            if (!empty($attribute_values)) {
                $attributes_with_values[] = $attribute;
            }
        }

        wp_send_json($attributes_with_values);

        wp_die();
    }
}
