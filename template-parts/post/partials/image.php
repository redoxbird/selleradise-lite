<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if ('post' !== get_post_type()) {
    return;
}

$image_id = get_post_thumbnail_id();
$image = wp_get_attachment_image_src($image_id, 'large');
$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: get_the_title()." Thumbnail";

?>

<a href="<?php echo esc_attr( get_the_permalink() ); ?>" class="<?php echo esc_attr(isset($classes) ? $classes : 'w-full h-80 rounded-2xl overflow-hidden') ?>">
    <img 
        <?php echo selleradise_lazy_src($image ? $image[0] : selleradise_get_image_placeholder()); ?>
        class="w-full h-full object-cover"
        width="<?php echo esc_attr($image[1] ?? 0); ?>"
        height="<?php echo esc_attr($image[2] ?? 0); ?>"
        alt="<?php echo esc_attr( $image_alt ); ?>"
    >
</a>