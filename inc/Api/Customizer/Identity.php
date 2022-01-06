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
       

        Kirki::add_field('selleradise-lite', [
            'type' => 'image',
            'settings' => 'custom_logo_dark_mode',
            'label' => __('Logo (Dark Mode)', 'selleradise-lite'),
            'description' => esc_html__('Select a light header logo to be used with dark background.', 'selleradise-lite'),
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
