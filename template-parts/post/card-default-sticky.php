<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--default-sticky';

if (get_theme_mod('post_card_adaptive_colors', false)) {
    $class .= " selleradise_adaptive_colors";
}

?>

<div id="post-<?php the_ID();?>" <?php post_class($class);?>>

    <div class="selleradise_postCard--default__content">
        <?php get_template_part('template-parts/post/partials/title', null, ["type" => "default"]);?>
        
        <?php get_template_part('template-parts/post/partials/categories', null, ["type" => "default"]);?>

        <div class="selleradise_postCard--default__excerpt">
            <?php echo get_the_excerpt(); ?>
        </div>
      
        <?php get_template_part('template-parts/post/partials/author', 'minimal', ["type" => "default"]);?>
    </div>

    <?php get_template_part('template-parts/post/partials/image', null, ["type" => "default"]);?>

</div><!-- #post-## -->
