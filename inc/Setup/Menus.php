<?php

namespace Selleradise_Lite\Setup;

/**
 * Menus
 */
class Menus
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action('after_setup_theme', [$this, 'menus']);
        add_action('wp_update_nav_menu', [$this, 'delete_menu_transient']);
    }

    public function menus()
    {
        /*
        Register all your menus here
         */
        
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'selleradise-lite'),
            'mobile' => esc_html__('Mobile & Sidebar', 'selleradise-lite'),
            'footer' => esc_html__('Footer', 'selleradise-lite'),
        ));

    }

    public function delete_menu_transient() {
        delete_transient('selleradise_mobile_menu_tree');
    }
}
