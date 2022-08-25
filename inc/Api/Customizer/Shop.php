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

        Kirki::add_field('TEXT_DOMAIN', [
            'type' => 'radio',
            'settings' => 'filters_location',
            'label' => __('Shop Filter Location', 'TEXT_DOMAIN'),
            'description' => esc_html__('Where to show the filters for the product catalog?', 'TEXT_DOMAIN'),
            'section' => 'woocommerce_product_catalog',
            'default' => 'sidebar',
            'priority' => 30,
            'choices' => [
                'sidebar' => esc_html__('Right Sidebar', 'TEXT_DOMAIN'),
                'offscreen' => esc_html__('Off Screen', 'TEXT_DOMAIN'),
                'sidebar-left' => esc_html__('Left Sidebar', 'TEXT_DOMAIN'),
            ],
            'transport' => 'refresh',
        ]);

    }
}
