<?php

/**
 * Theme Customizer - Presets
 *
 * @package Selleradise
 */

namespace Selleradise_Lite\Api\Customizer;

use Kirki;
use Selleradise_Lite\Api\Customizer;

/**
 * Customizer class
 */
class Shop
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        if (!class_exists('Kirki') || !class_exists('WooCommerce')) {
            return;
        }

        if (!is_customize_preview()) {
            return;
        }

        Kirki::add_field('selleradise-lite', [
            'type' => 'radio',
            'settings' => 'filters_location',
            'label' => __('Shop Filter Location', 'selleradise-lite'),
            'description' => esc_html__('Where to show the filters for the product catalog?', 'selleradise-lite'),
            'section' => 'woocommerce_product_catalog',
            'default' => 'sidebar',
            'priority' => 30,
            'choices' => [
                'sidebar' => esc_html__('Right Sidebar', 'selleradise-lite'),
                'offscreen' => esc_html__('Off Screen', 'selleradise-lite'),
                'sidebar-left' => esc_html__('Left Sidebar', 'selleradise-lite'),
            ],
            'transport' => 'auto',
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'radio',
            'settings' => 'shop_page_card_type',
            'label' => __('Product Card Type', 'selleradise-lite'),
            'description' => esc_html__('Which type of card design should be used for the shop?', 'selleradise-lite'),
            'section' => 'woocommerce_product_catalog',
            'default' => 'default',
            'priority' => 40,
            'choices' => [
                'default' => esc_html__('Default', 'selleradise-lite'),
                'minimal' => esc_html__('Minimal', 'selleradise-lite'),
                'simple' => esc_html__('Simple', 'selleradise-lite'),
                'list' => esc_html__('List', 'selleradise-lite'),
                'compact' => esc_html__('Compact', 'selleradise-lite'),
            ],
            'transport' => 'auto',
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'radio',
            'settings' => 'shop_page_category_card_type',
            'label' => __('Category Card Type', 'selleradise-lite'),
            'description' => esc_html__('Which type of card design should be used for the shop categories?', 'selleradise-lite'),
            'section' => 'woocommerce_product_catalog',
            'default' => 'default',
            'priority' => 50,
            'choices' => [
                'default' => esc_html__('Default', 'selleradise-lite'),
                'icon' => esc_html__('Icon', 'selleradise-lite'),
            ],
            'transport' => 'auto',
        ]);

    }
}
