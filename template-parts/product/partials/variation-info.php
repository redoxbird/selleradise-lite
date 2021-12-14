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



$variations = selleradise_get_options($product);


?>


<?php if($variations): ?>

<ul class="variations">
    <?php foreach ($variations as $key => $variation): ?>
        <li>
            <b class="variationName"><?php echo esc_html(  $variation['name'] ); ?></b>

            <?php if(!empty($variation['options'])): ?>

                <ul>
                    <?php foreach ($variation['options'] as $key => $option): ?>

                        <li><?php echo esc_html( $option['name'] ); ?></li>

                    <?php endforeach; ?>
                </ul>

            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php endif; ?>