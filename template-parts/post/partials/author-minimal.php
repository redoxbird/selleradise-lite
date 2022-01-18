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

<div class="selleradise_postCard__author--minimal">
    <span class="selleradise_postCard__author-date entry-meta">
      <?php echo Selleradise_Lite\Core\Tags::posted_on(); ?>
      <span class="author vcard">
        <a class="url fn n" href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
        <?php echo selleradise_svg('unicons-line/user'); ?>
            <?php echo esc_html(get_the_author()); ?>
        </a>
      </span>
    </span>
</div>