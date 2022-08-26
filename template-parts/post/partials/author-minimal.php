<?php // phpcs:ignore WPThemeReview.Templates.ReservedFileNamePrefix.ReservedTemplatePrefixFound

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if ('post' !== get_post_type()) {
    return;
}

$author_id = get_the_author_meta('ID');

?>

<div class="w-full mt-auto pt-6">
    <span class="entry-meta flex justify-start items-center gap-2 text-xs font-medium opacity-75">
      <?php echo THEME_NAMESPACE\Core\Tags::posted_on(); ?>
      <span class="author vcard">
        <a class="url fn n flex justify-start items-center hover:underline" href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
            <span class="flex justify-center items-center w-3 mr-1 h-auto"><?php echo selleradise_svg('tabler-icons/user-circle'); ?></span>
            <?php echo esc_html(get_the_author()); ?>
        </a>
      </span>
    </span>
</div>