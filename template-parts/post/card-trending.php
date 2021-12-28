<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$trending = new WP_Query(
    [
        'post_type' => 'post',
        'posts_per_page' => 5,
        'orderby' => 'meta_value_num',
        'meta_key' => 'selleradise_trending_post_views',
        'order' => 'DESC',
        'post__not_in' => [get_the_ID()],
        'meta_query' => array(
            array(
                'key' => 'selleradise_trending_post_views_updated_on',
                'value' => selleradise_trending_posts_reset_time('U'),
                'compare' => '>=',
            ),
        ),
    ]
);

?>

<div class="selleradise_post_widget--trending">
  <h2><?php echo __('Trending Posts', 'selleradise-lite'); ?></h2>

  <?php if ($trending && $trending->have_posts()): while ($trending->have_posts()): $trending->the_post();?>
    <div class="selleradise_postCard--trending">
        <?php
            $image_id = get_post_thumbnail_id();
            $image = wp_get_attachment_image_src($image_id, 'thumbnail');
            $image_src = $image ? $image[0] : selleradise_get_image_placeholder();
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: get_the_title()." Thumbnail";
            $image_height = isset($image[1]) && $image[1] ? $image[1] : 0;
            $image_width = isset($image[2]) && $image[2] ? $image[2] : 0;
        ?>

        <a 
            href="<?php echo esc_attr(get_the_permalink()); ?>" 
            class="selleradise_postCard--trending__image">
            <img
                src="<?php echo esc_attr($image_src); ?>"
                width="<?php echo esc_attr($image_height); ?>"
                height="<?php echo esc_attr($image_width); ?>"
                alt="<?php echo esc_attr($image_alt); ?>"
                loading=lazy
            >
        </a>

        <div class="selleradise_postCard--trending__content">
            <a href="<?php echo esc_attr(get_the_permalink()); ?>">
                <?php the_title('<h3 class="selleradise_postCard--widget__entry-title">', '</h3>');?>
            </a>

            <?php get_template_part('template-parts/post/partials/author', 'minimal', ["type" => "default"]);?>
        </div>
    </div>

    <?php
        endwhile;
            wp_reset_postdata();
        else:
            get_template_part("template-parts/content/empty", "state", ["title" => __("No trending posts found", "selleradise-lite")]);
        endif;
    ?>

</div>

<?php