<?php if (class_exists('WooCommerce')) : ?>
  <button class="selleradiseHeader__trigger selleradiseHeader__trigger--account" aria-label="<?php esc_attr_e('Account', 'selleradise-lite'); ?>" x-tippy="'<?php esc_attr_e('Account', 'selleradise-lite'); ?>'" x-on:click.prevent="$store.mobileMenu.open('account')">
    <?php echo selleradise_svg('unicons-line/user-circle') ?>
  </button>
<?php endif; ?>