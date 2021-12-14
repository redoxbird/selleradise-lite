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
            'title' => esc_html__('Blog', 'selleradise-lite'),
            'description' => esc_html__('Settings related to blog.', 'selleradise-lite'),
            'priority' => 40,
        ));

        Kirki::add_field('selleradise-lite', [
            'type' => 'checkbox',
            'settings' => 'post_card_adaptive_colors',
            'label' => esc_html__('Adaptive Colors', 'selleradise-lite'),
            'section' => 'blog',
            'default' => false,
        ]);

    }
}
