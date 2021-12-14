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

if (!$product->get_date_on_sale_to() || !$product->get_date_on_sale_from() || $product->get_type() !== 'simple') {
    return;
}

?>

<sale-timer
    v-bind:end-date='<?php echo wp_json_encode(esc_attr($product->get_date_on_sale_to())) ?>'
    v-bind:start-date='<?php echo wp_json_encode(esc_attr($product->get_date_on_sale_from())) ?>'>
</sale-timer>