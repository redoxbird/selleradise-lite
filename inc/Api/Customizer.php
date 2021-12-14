<?php
/**
 * Theme Customizer
 *
 * @package Selleradise
 */

namespace Selleradise_Lite\Api;
use Kirki;

/**
 * Customizer class
 */
class Customizer
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

        add_action('init', array($this, 'setup'));

        Kirki::add_config('selleradise-lite', array(
            'capability' => 'edit_theme_options',
            'option_type' => 'theme_mod',
        ));

    }

    /**
     * Store all the classes inside an array
     * @return array Full list of classes
     */
    public function get_classes()
    {
        return [
            Customizer\Identity::class,
            Customizer\Colors::class,
            Customizer\Fonts::class,
            Customizer\Header::class,
            Customizer\Footer::class,
            Customizer\Shop::class,
            Customizer\Blog::class,
        ];
    }

    /**
     * Add postMessage support for site title and description for the Theme Customizer.
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
    public function setup()
    {
        foreach ($this->get_classes() as $class) {
            $service = new $class;
            if (method_exists($class, 'register')) {
                $service->register();
            }
        }
    }

}
