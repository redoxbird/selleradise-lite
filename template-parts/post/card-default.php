<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--default ';

if(isset($classes) && $classes) {
    $class .= $classes;
}

if(get_theme_mod('post_card_adaptive_colors', false)) {
    $class .= " selleradise_adaptive_colors";
}

?>

<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?> >
    <?php get_template_part('template-parts/post/partials/image', null, ["type" => "default"]);?>
    
    <div class="selleradise_postCard--default__content">        
        <?php get_template_part('template-parts/post/partials/title', null, ["type" => "default"]);?>
        <?php get_template_part('template-parts/post/partials/categories', null, ["type" => "default"]);?>
        <?php get_template_part('template-parts/post/partials/author', 'minimal', ["type" => "default"]); ?>
    </div>
</div><!-- #post-## -->
