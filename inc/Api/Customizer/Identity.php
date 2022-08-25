<?php
/**
 * Theme Customizer - Identity
 *
 * @package Selleradise
 */

namespace Selleradise_Lite\Api\Customizer;

use Kirki;
use Selleradise_Lite\Api\Customizer;

/**
 * Identity class
 */
class Identity
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
       

        Kirki::add_field('TEXT_DOMAIN', [
            'type' => 'image',
            'settings' => 'custom_logo_dark_mode',
            'label' => __('Logo (Dark Mode)', 'TEXT_DOMAIN'),
            'description' => esc_html__('Select a light header logo to be used with dark background.', 'TEXT_DOMAIN'),
            'section' => 'title_tagline',
            'default' => '',
            'priority' => 9,
            'transport' => 'refresh',
            'choices' => [
                'save_as' => 'id',
            ],
        ]);

    }

}
