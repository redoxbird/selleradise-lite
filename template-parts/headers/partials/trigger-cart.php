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

<button
  x-data
  aria-haspopup="true"
  class="selleradiseHeader__trigger selleradiseHeader__trigger--miniCart"
  aria-label="<?php esc_attr_e('Search', 'selleradise-lite'); ?>"
  v-tippy="<?php esc_attr_e('Search', 'selleradise-lite'); ?>"
  x-on:click.prevent="$store.miniCart.open()"
>
  <?php echo selleradise_svg('unicons-line/shopping-bag') ?>
    <span x-text="$store.miniCart.count || 0"></span>
</button>