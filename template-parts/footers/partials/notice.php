<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

echo esc_html(get_theme_mod('copyright_notice', 'Copyright © 2021 | Selleradise by RedOxbird'));