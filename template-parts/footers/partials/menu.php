<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

wp_nav_menu(array(
    'theme_location' => 'footer',
    'container' => 'nav',
    'menu_class' => 'selleradise_menu--footer__list',
    'menu_id' => 'selleradise_menu--footer',
    'fallback_cb' => false,
    'container_aria_label' => 'Footer',
));

