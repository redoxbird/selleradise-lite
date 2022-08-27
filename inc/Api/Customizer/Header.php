<?php

/**
 * Theme Customizer - Header
 *
 * @package Selleradise
 */

namespace THEME_NAMESPACE\Api\Customizer;

use Kirki;
use THEME_NAMESPACE\Api\Customizer;

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
            'title' => esc_html__('Header', 'TEXT_DOMAIN'),
            'description' => esc_html__('Settings for header section.', 'TEXT_DOMAIN'),
            'priority' => 25,
        ));


    }
}
