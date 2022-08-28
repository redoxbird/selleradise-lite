<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!$gallery_image_ids) {
    return;
}

?>

<div x-embla class="selleradise_productCard__slider rounded-2xl embla h-ratio-padded">
    <div class="embla__container !h-full">
        <?php
        foreach ($gallery_image_ids as $image_id) :
            $image_src = wp_get_attachment_image_src($image_id, 'large');
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $image_ratio = (int) $image_src[2] / (int) $image_src[1];
        ?>
            <div class="group embla__slide !h-full" <?php if (get_option('woocommerce_thumbnail_cropping') == 'uncropped') : ?> style="--product-image-ratio: <?php echo esc_attr($image_ratio); ?>;" <?php endif; ?>>
                <img
                    <?php echo selleradise_lazy_src($image_id ? $image_src[0] : wc_placeholder_img_src()); ?>
                    class="w-full !h-full object-cover group-hover:scale-105 duration-700 ease-out-expo"
                    alt="<?php echo esc_attr($image_alt); ?>"
                    width="<?php echo esc_attr($image_src[1]); ?>"
                    height="<?php echo esc_attr($image_src[2]); ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="flex justify-center items-center absolute bottom-2 left-1/2 -translate-x-1/2 bg-white border-1 border-gray-300 rounded-full text-gray-600">
        <button x-embla:prev class="selleradise_slider__nav--previous"><?php echo selleradise_svg('tabler-icons/chevron-left') ?></button>
        <button x-embla:next class="selleradise_slider__nav--next"><?php echo selleradise_svg('tabler-icons/chevron-right') ?></button>
    </div>
</div>