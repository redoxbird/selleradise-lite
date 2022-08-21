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

$gallery_image_ids = $product->get_gallery_image_ids();
$image = $product->get_image_id();

if ($gallery_image_ids) {
    array_unshift($gallery_image_ids, $image);
}

?>


<a href="<?php echo esc_url($product->get_permalink()); ?>" class="selleradise_productCard__image-outer w-full">
    <?php 
      if (!empty($gallery_image_ids) && false === (isset($classes) && $classes && strpos($classes, 'swiper-slide'))): 
        
        get_template_part('template-parts/product/partials/image', 'slider', ["gallery_image_ids" => $gallery_image_ids]);
        
      else:

        get_template_part(
            'template-parts/product/partials/image', 
            'single',
            ["image" => $image, "product_id" => $product->get_id()]
        );
      endif;
    ?>
</a>