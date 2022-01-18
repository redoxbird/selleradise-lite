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

$author_id = get_the_author_meta('ID');

$byline = sprintf(
    esc_html_x('by %s', 'post author', 'selleradise-lite'),
    '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url($author_id)) . '">' . esc_html(get_the_author()) . '</a></span>'
);
?>

<div class="selleradise_postCard__author">

  <?php if(get_avatar_url($author_id)): ?>
    <div class="selleradise_postCard__author-image">
      <img 
        src="<?php echo get_avatar_url($author_id); ?>" 
        alt="<?php echo esc_attr(get_the_author()); ?>"
      >
    </div>
  <?php endif; ?>

  <div class="selleradise_postCard__author-info">
    <a class="selleradise_postCard__author-name" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
      <?php echo esc_html(get_the_author()); ?>
    </a>
    <span class="selleradise_postCard__author-date entry-meta">
      <?php Selleradise_Lite\Core\Tags::posted_on(); ?>
    </span>
  </div>

</div>