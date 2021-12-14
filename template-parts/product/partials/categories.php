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


$categories = get_the_terms($product->get_ID(), 'product_cat');

?>

<ul class="selleradise_productCard__categories">
    <li class="selleradise_productCard__categories-icon">
        <?php echo selleradise_svg('unicons-line/apps'); ?>
    </li>
    
    <?php foreach ($categories as $key => $category): ?>
        <li>
            <a href="<?php echo esc_url(get_term_link($category)) ?>">
                <?php echo esc_html( $category->name ) ?>
            </a>
        </li>
    <?php endforeach;?>
</ul>