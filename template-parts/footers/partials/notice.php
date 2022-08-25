<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

echo esc_html(get_theme_mod('copyright_notice', sprintf(__('Copyright © %1$s | All rights reserved by %2$s', 'TEXT_DOMAIN'), date("Y"), get_bloginfo("name"))));