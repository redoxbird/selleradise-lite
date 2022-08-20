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

<ul class="flex justify-start items-start gap-2 mt-3 text-sm">
    <?php foreach($_product->get_variation_attributes(false) as $variation_taxonomy => $value): ?>

        <li class="flex justify-start items-center gap-0.5">
            <span><?php echo esc_html( wc_attribute_label($variation_taxonomy, $_product) ); ?></span>
            <span>:</span>
            <span class="font-semibold"><?php echo esc_html( $_product->get_attribute($variation_taxonomy) ); ?></span>
        </li>

    <?php endforeach; ?>
</ul>