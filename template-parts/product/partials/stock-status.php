<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!isset($product->id)) {
    global $product;
}

if (!$product) {
    return;
}


if($product->managing_stock() || $product->is_in_stock()) {
    return;
}
?>

<span class="outOfStock"><?php esc_html_e('Out Of Stock', 'selleradise-lite'); ?></span>