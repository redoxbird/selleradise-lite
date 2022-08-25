<?php if (class_exists('WooCommerce')) : ?>
  <button class="selleradiseHeader__trigger selleradiseHeader__trigger--account" x-tooltip="triggerAccountTooltip" x-on:click.prevent="$store.mobileMenu.open('account')">
    <span id="triggerAccountTooltip" role="tooltip" class="selleradise_tooltip">
      <?php esc_html_e('Account', 'TEXT_DOMAIN'); ?>
    </span>
    <?php echo selleradise_svg('tabler-icons/user-circle') ?>
  </button>
<?php endif; ?>