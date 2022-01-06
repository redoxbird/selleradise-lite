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
class Header
{

    public $palette = [];
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

        Kirki::add_section('selleradise_header', array(
            'title' => esc_html__('Header', 'selleradise-lite'),
            'description' => esc_html__('Settings for header section.', 'selleradise-lite'),
            'priority' => 25,
        ));

        Kirki::add_field('selleradise-lite', [
            'type' => 'radio',
            'settings' => 'quick_search_type',
            'label' => esc_html__('Quick Search Type', 'selleradise-lite'),
            'description' => esc_html__('"Fast" will only match beginning of the title.', 'selleradise-lite'),
            'section' => 'selleradise_header',
            'default' => 'accurate',
            'transport' => 'refresh',
            'choices' => [
                'fast' => esc_html__('Fast', 'selleradise-lite'),
                'accurate' => esc_html__('Accurate', 'selleradise-lite'),
            ],
        ]);

    }
}
