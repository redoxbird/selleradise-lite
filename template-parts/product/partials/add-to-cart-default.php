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

if (!$product->managing_stock() && !$product->is_in_stock()) {
    get_template_part('template-parts/product/partials/out-of-stock', null, ["product" => $product]);
    return;
}

$props = [
    'id' => $product->get_ID(),
    'name' => esc_attr($product->get_name()),
    'quantity' => 1,
    'add_to_cart_url' => esc_url(WC_AJAX::get_endpoint('add_to_cart')),
    'add_to_cart_text' => esc_attr($product->add_to_cart_text()),
    'product_add_to_cart_url' => esc_url($product->add_to_cart_url()),
];

?>

<?php if ($product->get_type() == 'simple' && $product->is_in_stock() && (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode()) === false): ?>

    <add-to-cart v-bind:product-data='<?php echo wp_json_encode($props); ?>'></add-to-cart>

<?php else:
    
    echo apply_filters(
        'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
        sprintf(
            '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url($product->add_to_cart_url()),
            esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
            esc_attr(isset($args['class']) ? $args['class'] : 'selleradise_button--primary'),
            isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
            esc_html($product->add_to_cart_text())
        ),
        $product,
        $args
    );

    ?>

<?php endif;?>