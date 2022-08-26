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
            'type' => 'checkbox',
            'settings' => 'post_card_adaptive_colors',
            'label' => esc_html__('Adaptive Colors', 'TEXT_DOMAIN'),
            'section' => 'blog',
            'default' => false,
        ]);

    }
}
