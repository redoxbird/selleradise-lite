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

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

$prefix = 'selleradise_productCard--default';

$class = "selleradise_productCard $prefix ";

if (isset($classes) && $classes) {
    $class .= $classes;
}

?>


<li class="<?php echo esc_attr($class); ?>">
    <?php do_action('woocommerce_before_shop_loop_item');?>

    <?php get_template_part('template-parts/product/partials/sale', 'chip', ["product" => $product]); ?>

    <?php get_template_part('template-parts/product/partials/image', null, ["product" => $product, "classes" => $class]); ?>

    <div class="<?php echo esc_attr($prefix); ?>__content">
        
        <div class="<?php echo esc_attr($prefix); ?>__title-outer">

            <?php do_action('woocommerce_before_shop_loop_item_title');?>

            <h3 class="<?php echo esc_attr($prefix); ?>__title">
                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                    <?php echo esc_html( $product->get_name() ); ?>
                </a>
            </h3>

            <?php do_action('woocommerce_after_shop_loop_item_title');?>

            <?php get_template_part('template-parts/product/partials/rating', 'textual', ["product" => $product]); ?>
        </div>
                
        <?php get_template_part('template-parts/product/partials/categories', null, ["product" => $product]);?>
        
        <?php get_template_part('template-parts/product/partials/sale-timer', null, ["product" => $product]);?>

        <div class="<?php echo esc_attr($prefix); ?>__bottom">
            <div class="<?php echo esc_attr($prefix); ?>__price selleradise_productCard__price">
                <?php echo wp_kses_post( $product->get_price_html()); ?>
            </div>
        
            <?php get_template_part('template-parts/product/partials/add-to-cart', 'default', ["product" => $product]);?>
            
        </div>

    </div>

    <?php do_action('woocommerce_after_shop_loop_item');?>
</li>
