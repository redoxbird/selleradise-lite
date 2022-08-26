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


$class = 'selleradise_productCard selleradise_productCard--minimal ';

if (isset($classes) && $classes) {
    $class .= $classes;
}


?>

<li
  x-data="productCard"
  x-bind:style="{'--width': width + 'px'}"
  class="<?php echo esc_attr($class); ?> flex flex-col justify-start items-start rounded-2xl bg-background-50 text-text-900 border-1 border-gray-200 hover:border-gray-300 pt-2 px-2 overflow-hidden transition-all">

    <?php do_action('woocommerce_before_shop_loop_item');?>
    <?php get_template_part('template-parts/product/partials/sale', 'chip', ["product" => $product, "classes" => "bg-text-900 rounded-full px-4 py-2 text-xs z-50 text-background-50 font-semibold absolute left-4 top-4"]); ?>
    <?php get_template_part('template-parts/product/partials/image', null, ["product" => $product, "classes" => $class]);?>


    <div class="text-md flex px-4 py-5 flex-grow relative justify-between items-center w-full">
      <?php do_action('woocommerce_before_shop_loop_item_title');?>

      <h3 class="text-sm m-0 flex-grow w-3/5 leading-normal">
          <a class="flex-grow text-inherit hover:text-main-900 hover:underline"  href="<?php echo esc_url($product->get_permalink()); ?>">
              <?php echo esc_attr( $product->get_name() ) ?>
          </a>
      </h3>

      <?php do_action('woocommerce_after_shop_loop_item_title');?>

      <div class="selleradise_productCard__price text-medium">
          <?php echo wp_kses_post( $product->get_price_html() ); ?>
      </div>
    </div>

    <?php do_action('woocommerce_after_shop_loop_item');?>

</li>