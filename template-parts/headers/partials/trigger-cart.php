<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (!class_exists('WooCommerce')) {
  return;
}

if ($args) {
  extract($args);
}

?>

<button x-data aria-haspopup="true" class="selleradiseHeader__trigger selleradiseHeader__trigger--miniCart" x-tooltip="triggerMiniCartTooltip" x-on:click.prevent="$store.miniCart.open()">
  <span id="triggerMiniCartTooltip" role="tooltip" class="selleradise_tooltip">
    <?php esc_html_e('Cart', 'selleradise-lite'); ?>
  </span>
  <?php echo selleradise_svg('unicons-line/shopping-bag') ?>
  <span x-text="$store.miniCart.count || 0"></span>
</button>