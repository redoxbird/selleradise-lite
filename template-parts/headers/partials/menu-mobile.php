<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

<mobile-menu>
  <template #icon-close>
    <?php echo selleradise_svg('unicons-line/multiply'); ?>
  </template>
  <template #icon-menu>
    <?php echo selleradise_svg('unicons-line/bars'); ?>
  </template>
  <template #icon-account>
    <?php echo selleradise_svg('unicons-line/user-circle'); ?>
  </template>
  <template #icon-settings>
    <?php echo selleradise_svg('unicons-line/setting'); ?>
  </template>
  <template #icon-categories>
    <?php echo selleradise_svg('unicons-line/apps'); ?>
  </template>
  <template #account-links>
    <?php get_template_part('template-parts/headers/partials/account', 'links'); ?>
  </template>
  <template #account-info>
    <?php get_template_part('template-parts/headers/partials/account', 'info'); ?>
  </template>
</mobile-menu>