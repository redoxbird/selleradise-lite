<?php

/**
 * Theme Customizer - Header
 *
 * @package Selleradise
 */

namespace Selleradise_Lite\Api\Customizer;

use Kirki;
use Selleradise_Lite\Api\Customizer;

/**
 * Customizer class
 */
class Footer
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        if (!class_exists('Kirki')) {
            return;
        }

        if (!is_customize_preview()) {
            return;
        }

        Kirki::add_section('selleradise_footer', array(
            'title' => esc_html__('Footer', 'selleradise-lite'),
            'description' => esc_html__('Settings for footer section.', 'selleradise-lite'),
            'priority' => 30,
        ));

        Kirki::add_field('selleradise-lite', [
            'type' => 'text',
            'settings' => 'copyright_notice',
            'label' => esc_html__('Copyright notice', 'selleradise-lite'),
            'section' => 'selleradise_footer',
            'default' => sprintf(esc_html__( 'Copyright © %1$s | All rights reserved by %2$s', 'selleradise-lite' ), date("Y"), get_bloginfo("name")),
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'checkbox',
            'settings' => 'disable_back_to_top',
            'label' => esc_html__('Disable back to top button?', 'selleradise-lite'),
            'section' => 'selleradise_footer',
            'default' => false,
        ]);

    }
}
