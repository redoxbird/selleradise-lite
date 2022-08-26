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


<li
    x-data="productCard"
    class="<?php echo esc_attr($class); ?> flex justify-start items-stretch rounded-2xl bg-background-50 text-text-900 border-1 border-gray-200 hover:border-gray-300 p-2 overflow-hidden transition-all">
    <?php do_action('woocommerce_before_shop_loop_item'); ?>

    <?php get_template_part('template-parts/product/partials/sale', 'chip', ["product" => $product, "classes" => "bg-text-900 rounded-full px-4 py-2 text-xs z-50 text-background-50 font-semibold absolute left-4 top-4"]); ?>
    
    <div class="w-2/5 h-full">
      <?php get_template_part('template-parts/product/partials/image', null, ["product" => $product, "classes" => $class]); ?>
    </div>

    <div class="w-3/5 text-md flex flex-col items-start justify-start flex-wrap flex-grow pt-6 px-4 pb-4 relative">
        <div class="flex flex-wrap justify-between items-start w-full">
            <?php do_action('woocommerce_before_shop_loop_item_title'); ?>

            <h3 class="text-md m-0 flex-grow w-3/5 leading-normal">
                <a class="flex-grow text-inherit hover:text-main-900 hover:underline" href="<?php echo esc_url($product->get_permalink()); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h3>
            
            <?php do_action('woocommerce_after_shop_loop_item_title'); ?>

            <?php get_template_part('template-parts/product/partials/rating', 'textual', ["product" => $product]); ?>
        </div>

        <?php get_template_part('template-parts/product/partials/categories', null, ["product" => $product, "classes" => "mt-1 mr-2"]); ?>
        <?php get_template_part('template-parts/product/partials/sale-timer', null, ["product" => $product]); ?>

        <?php if(!$product->is_on_sale()): ?>
          <div class="text-sm mt-4 selleradise_prose hidden lg:block">
              <?php echo wp_kses_post(selleradise_truncate($product->get_short_description(), 100)); ?>
          </div>
        <?php endif; ?>

        <div class="flex justify-between items-center mt-auto pt-4 w-full">
            <div class="selleradise_productCard__price">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>
            
            <?php get_template_part('template-parts/product/partials/add-to-cart', 'default', ["product" => $product]); ?>
        </div>
    </div>

    <?php do_action('woocommerce_after_shop_loop_item'); ?>
</li>