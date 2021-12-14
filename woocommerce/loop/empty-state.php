<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (isset($args)) {
    extract($args);
}

?>

<section class="selleradise_empty_state">
  <div class="selleradise_empty_state__svg">
    <?php echo selleradise_svg('misc/empty-state'); ?>
  </div>

  <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>" class="selleradise_button--primary">
    <?php esc_html_e('Refresh', 'selleradise-lite'); ?>
  </a>
</section>