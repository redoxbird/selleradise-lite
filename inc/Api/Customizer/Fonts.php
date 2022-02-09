<?php

/**
 * Theme Customizer - Fonts
 *
 * @package Selleradise
 */

namespace Selleradise_Lite\Api\Customizer;

use Kirki;
use Selleradise_Lite\Api\Customizer;

/**
 * Customizer class
 */
class Fonts
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        if (get_theme_mod('font_load_from_google', false) && !is_customize_preview()) {
            return;
        }

        Kirki::add_section('selleradise_fonts', array(
            'title' => esc_html__('Fonts', 'selleradise-lite'),
            'priority' => 25,
        ));

        Kirki::add_field('selleradise-lite', [
            'type' => 'typography',
            'settings' => 'font_heading',
            'label' => esc_html__('Heading Font', 'selleradise-lite'),
            'section' => 'selleradise_fonts',
            'default' => selleradise_get_default_fonts('heading'),
            'transport' => 'refresh',
            'output' => [
                [
                    'element' => 'h1,h2,h3,h4,h5,h6',
                ],
            ],
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'typography',
            'settings' => 'font_primary',
            'label' => esc_html__('Primary Font', 'selleradise-lite'),
            'section' => 'selleradise_fonts',
            'default' => selleradise_get_default_fonts('primary'),
            'transport' => 'refresh',
            'output' => [
                [
                    'element' => 'body',
                ],
            ],
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'custom',
            'settings' => 'title_additional_fonts',
            'section' => 'selleradise_fonts',
            'default' => selleradise_kirki_heading('Additional'),
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'typography',
            'settings' => 'font_primary_bolder',
            'label' => esc_html__('Primary Font (Bolder)', 'selleradise-lite'),
            'section' => 'selleradise_fonts',
            'default' => selleradise_get_default_fonts('primary_bolder'),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'typography',
            'settings' => 'font_primary_boldest',
            'label' => esc_html__('Primary Font (Boldest)', 'selleradise-lite'),
            'section' => 'selleradise_fonts',
            'default' => selleradise_get_default_fonts('primary_boldest'),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('selleradise-lite', [
            'type' => 'checkbox',
            'settings' => 'font_load_from_google',
            'label' => esc_html__('Load fonts from google server', 'selleradise-lite'),
            'description' => esc_html__('Check to load fonts from google server instead of local server. Can be used if fonts are not loading properly.', 'selleradise-lite'),
            'section' => 'selleradise_fonts',
            'default' => false,
        ]);

    }
}
