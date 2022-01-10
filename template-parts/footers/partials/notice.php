<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

echo esc_html(get_theme_mod('copyright_notice', sprintf(__('Copyright © %s | All rights reserved by %s', 'selleradise-lite'), date("Y"), get_bloginfo("name"))));