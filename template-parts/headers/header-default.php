<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<header x-data role="banner" class="selleradiseHeader selleradiseHeader--default">
  <?php get_template_part('template-parts/headers/partials/logo');?>
  
  <?php get_template_part('template-parts/headers/partials/menu');?>

  <div class="selleradiseHeader__triggers ml-auto">
    <button
      class="selleradiseHeader__trigger selleradiseHeader__trigger--search"
      aria-label="<?php esc_attr_e('Search', 'selleradise-lite'); ?>"
      v-tippy="<?php esc_attr_e('Search', 'selleradise-lite'); ?>"
      v-on:click.prevent="openSearhForm()"
    >
      <?php echo selleradise_svg('unicons-line/search') ?>
    </button>

    <?php if(class_exists('WooCommerce')): ?>
      <button
        class="selleradiseHeader__trigger selleradiseHeader__trigger--account"
        aria-label="<?php esc_attr_e('Account', 'selleradise-lite'); ?>"
        x-tippy="'<?php esc_attr_e('Account', 'selleradise-lite'); ?>'"
        x-on:click.prevent="$store.mobileMenu.open('account')"
      >
        <?php echo selleradise_svg('unicons-line/user-circle') ?>
      </button>
    <?php endif; ?>

    <?php get_template_part('template-parts/headers/partials/trigger', 'cart');?>

    <button
      class="selleradiseHeader__trigger selleradiseHeader__trigger--mobileMenu"
      data-selleradise-header-type="headerType"
      v-on:click.prevent="
        activeSidebar = 'menu';
        mobileMenuState.matches('hidden')
          ? mobileMenuSend('OPEN')
          : mobileMenuSend('CLOSE');
      "
    >
      <?php echo selleradise_svg('unicons-line/bars') ?>
      <span class="selleradiseHeader__trigger--mobileMenu-text">
        <?php esc_attr_e('Menu', 'selleradise-lite'); ?>
      </span>
    </button>
  </div>

</header>

<?php get_template_part('template-parts/headers/partials/mini-cart');?>

<?php get_template_part('template-parts/headers/partials/menu', 'mobile');?>



