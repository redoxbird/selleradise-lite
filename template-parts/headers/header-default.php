<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<selleradise-header class="selleradiseHeader selleradiseHeader--default">
  <?php get_template_part('template-parts/headers/partials/logo'); ?>
  
  <?php get_template_part('template-parts/headers/partials/menu'); ?>

  <header-search>
    <template v-slot:icon-close>
      <?php echo selleradise_svg('unicons-line/multiply') ?>
    </template>
    <template v-slot:icon-loader>
      <?php echo selleradise_svg('loader/simple') ?>
    </template>
    <template v-slot:icon-search>
      <?php echo selleradise_svg('unicons-line/search') ?>
    </template>
  </header-search>

  <?php get_template_part('template-parts/headers/partials/menu', 'mobile'); ?>

  <div class="selleradiseHeader__triggers">
    <trigger-search header-type="default">
      <template v-slot:icon>
        <?php echo selleradise_svg('unicons-line/search') ?>
      </template>
    </trigger-search>

    <trigger-account header-type="default">
      <template v-slot:icon>
        <?php echo selleradise_svg('unicons-line/user-circle') ?>
      </template>
    </trigger-account>
    
    <trigger-cart header-type="default">
      <template v-slot:icon>
        <?php echo selleradise_svg('unicons-line/shopping-bag') ?>
      </template>
    </trigger-cart>

    <trigger-mobile-menu header-type="default">
      <template #icon>
        <?php echo selleradise_svg('unicons-line/bars') ?>
      </template>
      <template #text>
        <?php esc_attr_e('Menu', 'selleradise-lite'); ?>
      </template>
    </trigger-mobile-menu>
  </div>

  <mini-cart>
    <template v-slot:icon-close>
      <?php echo selleradise_svg('unicons-line/multiply') ?>
    </template>
    <template v-slot:nothing-found>
      <?php echo selleradise_svg('misc/empty-state') ?>
    </template>
  </mini-cart>

</selleradise-header>