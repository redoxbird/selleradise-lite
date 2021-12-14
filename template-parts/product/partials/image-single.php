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

<div class="selleradise_productCard__image-single"
    <?php if(get_option('woocommerce_thumbnail_cropping') == 'uncropped'): ?>
        style="--product-image-ratio: <?php echo esc_attr($image_ratio); ?>;"
    <?php endif; ?>
    >
    <?php if( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ): ?>
        <img src="<?php echo esc_url($image ? $image_src[0] : wc_placeholder_img_src()); ?>" alt="">
    <?php else: ?>
        <img 
            src="<?php echo wc_placeholder_img_src(); ?>" 
            data-src="<?php echo esc_url($image ? $image_src[0] : wc_placeholder_img_src()); ?>" 
            alt="<?php echo esc_attr( $image_alt ); ?>"
            width="<?php echo esc_attr($image_src[1]); ?>"
            height="<?php echo esc_attr($image_src[2]); ?>"
        >
    <?php endif; ?>
</div>
