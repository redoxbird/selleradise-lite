<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div x-data id="post-<?php the_ID();?>" <?php post_class("selleradise_postCard--default h-auto bg-background-50 text-text-900 self-stretch flex justify-start item-start flex-col flex-wrap rounded-2xl border-1 border-gray-200 p-2 overflow-hidden hover:border-gray-300 transition-all");?> >
    <?php get_template_part('template-parts/post/partials/image', null);?>

    <div class="pt-4 px-3 pb-1 w-full flex-1 flex justify-start items-start flex-col flex-wrap">
      <?php get_template_part('template-parts/post/partials/title', null);?>
    </div>
</div><!-- #post-## -->
