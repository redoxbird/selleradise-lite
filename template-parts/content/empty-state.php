<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (isset($args)) {
    extract($args);
}

?>

<section class="selleradise_empty-state">
  <div class="selleradise_empty-state__svg">
    <?php echo selleradise_svg('misc/empty-state'); ?>
  </div>

  <p class="selleradise_empty-state__title" role="status">
    <?php echo esc_attr($title) ?: __('Nothing found', 'selleradise-lite'); ?>
  </p>
</section>