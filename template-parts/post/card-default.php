<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--default h-auto bg-background-50 text-text-900 self-stretch flex justify-start item-start flex-col flex-wrap rounded-2xl border-1 border-gray-200 p-2 overflow-hidden';

if(isset($classes) && $classes) {
    $class .= $classes;
}

?>

<div x-data id="post-<?php the_ID(); ?>" <?php post_class($class); ?> >
    <?php get_template_part('template-parts/post/partials/image', null);?>
    
    <div class="pt-8 px-4 pb-4 w-full flex-1 flex justify-start items-start flex-col flex-wrap">
        <div class="text-xl w-full">
            <?php get_template_part('template-parts/post/partials/title', null);?>
        </div> 
        <?php get_template_part('template-parts/post/partials/categories', null);?>
        <?php get_template_part('template-parts/post/partials/author', 'minimal'); ?>
    </div>
</div><!-- #post-## -->
