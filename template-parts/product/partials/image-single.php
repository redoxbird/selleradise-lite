<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!$image) {
    return;
}

$image_src = wp_get_attachment_image_src($image, 'large');
$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
$image_ratio = (int) $image_src[2] / (int) $image_src[1];
?>

<div class="group rounded-2xl flex justify-center items-center overflow-hidden h-ratio-padded"
    <?php if(get_option('woocommerce_thumbnail_cropping') == 'uncropped'): ?>
        style="--product-image-ratio: <?php echo esc_attr($image_ratio); ?>;"
    <?php endif; ?>
    >

    <img 
        <?php echo selleradise_lazy_src($image ? $image_src[0] : wc_placeholder_img_src()); ?>
        class="group-hover:scale-105 duration-700 ease-out-expo"
        alt="<?php echo esc_attr( $image_alt ); ?>"
        width="<?php echo esc_attr($image_src[1]); ?>"
        height="<?php echo esc_attr($image_src[2]); ?>"
    >
</div>
