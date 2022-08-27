<?php
/**
 * Theme Customizer - Presets
 *
 * @package Selleradise
 */

namespace THEME_NAMESPACE\Api\Customizer;

use Kirki;
use THEME_NAMESPACE\Api\Customizer;

/**
 * Customizer class
 */
class Blog
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

        Kirki::add_section('blog', array(
            'title' => esc_html__('Blog', 'TEXT_DOMAIN'),
            'description' => esc_html__('Settings related to blog.', 'TEXT_DOMAIN'),
            'priority' => 40,
        ));

        Kirki::add_field('TEXT_DOMAIN', [
            'type' => 'radio',
            'settings' => 'blog_card_type',
            'label' => __('Card Type', 'TEXT_DOMAIN'),
            'description' => esc_html__('Select a type of blog card.', 'TEXT_DOMAIN'),
            'section' => 'blog',
            'default' => 'default',
            'choices' => [
                'default' => esc_html__('Default', 'TEXT_DOMAIN'),
                'popular' => esc_html__('Popular', 'TEXT_DOMAIN'),
                'minimal' => esc_html__('Minimal', 'TEXT_DOMAIN'),
                'text' => esc_html__('Text Only', 'TEXT_DOMAIN'),
                'list' => esc_html__('List', 'TEXT_DOMAIN'),
            ],
            'transport' => 'refresh',
        ]);

    }
}
