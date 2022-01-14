<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!$_product) {
    return;
}


if ($_product->get_type() !== 'variation') {
    return;
}

?>

<ul class="selleradise_page-cart__item-variations">
    <?php foreach($_product->get_variation_attributes(false) as $variation_taxonomy => $value): ?>

        <li>
            <span class="label"><?php echo esc_html( wc_attribute_label($variation_taxonomy, $_product) ); ?></span>
            <span class="value"><?php echo esc_html( $_product->get_attribute($variation_taxonomy) ); ?></span>
        </li>

    <?php endforeach; ?>
</ul>