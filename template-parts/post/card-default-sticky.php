<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--default-sticky col-span-full flex justify-start flex-wrap flex-col-reverse md:flex-row rounded-2xl border-1 border-gray-200 p-3 overflow-hidden';


?>

<div id="post-<?php the_ID();?>" <?php post_class($class);?>>

    <div class="md:p-8 pt-8 px-4 pb-4 flex-1 flex justify-start items-start flex-col flex-wrap w-full md:w-3/5">
        <div class="text-2xl w-full">
            <?php get_template_part('template-parts/post/partials/title', null, ["type" => "default"]);?>
        </div>
        
        <?php get_template_part('template-parts/post/partials/categories', null, ["type" => "default"]);?>

        <div class="text-md my-4 selleradise_prose">
            <?php echo get_the_excerpt(); ?>
        </div>
      
        <?php get_template_part('template-parts/post/partials/author', 'minimal', ["type" => "default"]);?>
    </div>

    <?php get_template_part('template-parts/post/partials/image', null, ["classes" => "w-full md:w-2/5 h-80 md:h-96 rounded-2xl overflow-hidden"]);?>

</div><!-- #post-## -->
