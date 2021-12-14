<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if ('post' !== get_post_type()) {
    return;
}

if (is_single()):
    the_title('<h1 class="selleradise_postCard--'.$type.'__entry-title">', '</h1>');
else:
    the_title('<h2 class="selleradise_postCard--'.$type.'__entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
endif;
