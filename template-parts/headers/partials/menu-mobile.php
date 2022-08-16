<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$menu = selleradise_get_menu_tree("mobile");
$categories = selleradise_get_product_categories_tree();

?>


<div x-data x-show="$store.mobileMenu.isOpen()">
  <div class="fixed inset-0 bg-black opacity-75 z-[1499]"></div>

  <div class="selleradise__mobile-menu">
    <button class="selleradise__mobile-menu-button--close" x-on:click="$store.mobileMenu.close()" aria-label="Close Mobile Menu">
      <?php echo selleradise_svg('unicons-line/multiply'); ?>
    </button>

    <nav class="absolute top-20 left-0 right-20 bottom-0 z-10 px-10 pt-10" role="navigation" aria-label="Primary" x-show="$store.mobileMenu.activeSidebar === 'menu'">
      <?php
      if ($menu && !empty($menu)) :
        get_template_part("template-parts/headers/partials/nav", "mobile", ["items" => $menu, "level" => 1, "parent" => []]);
      endif;
      ?>
    </nav>

    <div class="selleradise_sidebar__account absolute top-20 left-0 right-20 bottom-0 z-10 px-6 pt-10" x-show="$store.mobileMenu.activeSidebar === 'account'">
      <?php get_template_part('template-parts/headers/partials/account', 'info'); ?>
      <?php get_template_part('template-parts/headers/partials/account', 'links'); ?>
    </div>

    <div class="absolute top-20 left-0 right-20 bottom-0 z-10 px-10 pt-10" role="navigation" x-show="$store.mobileMenu.activeSidebar === 'categories'">
      <?php
      if ($categories && !empty($categories)) :
        get_template_part("template-parts/headers/partials/categories", null, ["items" => $categories, "level" => 1, "parent" => []]);
      endif;
      ?>
    </div>


    <Categories v-if="selleradiseData.isWooCommerce"> </Categories>

    <div class="selleradise_sidebar__settings" x-if="
        Object.values(selleradiseData.settings).includes('1') &&
        $store.mobileMenu.activeSidebar === 'settings'
      ">
      <ul>
        <li class="selleradise_sidebar__settings-toggle" x-if="selleradiseData.settings.dark_mode_setting == '1'">
          <DarkModeToggleBtn />
        </li>
      </ul>
    </div>

    <div class="selleradise__mobile-menu__toggles">
      <button class="selleradise__mobile-menu__toggle" data-tippy-placement="left" x-tippy="'<?php echo __('Menu', 'selleradise-lite') ?>'" x-bind:class="{
          active: $store.mobileMenu.activeSidebar === 'menu',
        }" x-on:click="$store.mobileMenu.activeSidebar = 'menu'">
        <span class="selleradise__mobile-menu__toggle-icon">
          <?php echo selleradise_svg('unicons-line/bars'); ?>
        </span>
      </button>
      <button v-if="selleradiseData.isWooCommerce" class="selleradise__mobile-menu__toggle" data-tippy-placement="left" x-tippy="'<?php echo __('Account', 'selleradise-lite') ?>'" v-tippy="trans('mobile-menu-button-account')" x-bind:class="{
          active: $store.mobileMenu.activeSidebar === 'account',
        }" x-on:click="$store.mobileMenu.activeSidebar = 'account'">
        <span class="selleradise__mobile-menu__toggle-icon">
          <?php echo selleradise_svg('unicons-line/user-circle'); ?>
        </span>
      </button>

      <?php if (class_exists('WooCommerce')) : ?>
        <button class="selleradise__mobile-menu__toggle" data-tippy-placement="left" x-tippy="'<?php echo __('Categories', 'selleradise-lite') ?>'" x-bind:class="{
            active: $store.mobileMenu.activeSidebar === 'categories',
          }" x-on:click=" $store.mobileMenu.activeSidebar = 'categories'">
          <span class="selleradise__mobile-menu__toggle-icon">
            <?php echo selleradise_svg('unicons-line/apps'); ?>
          </span>
        </button>
      <?php endif; ?>
    </div>
  </div>
</div>