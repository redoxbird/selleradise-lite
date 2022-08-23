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


<div x-data>
  <div x-show="$store.mobileMenu.isOpen()" class="overlay z-[1499]" x-on:click="$store.mobileMenu.close()" x-transition.opacity></div>

  <div 
    class="selleradise__mobile-menu" 
    x-show="$store.mobileMenu.isOpen()" 
    x-trap="$store.mobileMenu.isOpen()" 
    x-transition:enter="transition ease-out-expo duration-400"
    x-transition:enter-start="opacity-0 translate-x-16"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-out-expo duration-500"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-16">
    <button class="selleradise__mobile-menu-button--close" x-on:click="$store.mobileMenu.close()" aria-label="Close Mobile Menu">
      <?php echo selleradise_svg('tabler-icons/x'); ?>
    </button>

    <nav
      class="absolute top-20 left-0 right-20 bottom-0 z-10 px-10 pt-10"
      role="navigation"
      aria-label="Primary"
      x-show="$store.mobileMenu.activeSidebar === 'menu'"
      x-transition:enter="transition ease-out-expo duration-500"
      x-transition:enter-start="opacity-0 translate-y-16"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-out-expo duration-300"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-16">
      <?php
      if ($menu && !empty($menu)) :
        get_template_part("template-parts/headers/partials/nav", "mobile", ["items" => $menu, "level" => 1, "parent" => []]);
      endif;
      ?>
    </nav>

    <div
      class="selleradise_sidebar__account absolute top-20 left-0 right-20 bottom-0 z-10 px-6 pt-10"
      x-show="$store.mobileMenu.activeSidebar === 'account'"
      x-transition:enter="transition ease-out-expo duration-500"
      x-transition:enter-start="opacity-0 translate-y-16"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-out-expo duration-300"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-16">
      <?php get_template_part('template-parts/headers/partials/account', 'info'); ?>
      <?php get_template_part('template-parts/headers/partials/account', 'links'); ?>
    </div>

    <div
      class="absolute top-20 left-0 right-20 bottom-0 z-10 px-10 pt-10"
      role="navigation"
      x-show="$store.mobileMenu.activeSidebar === 'categories'"
      x-transition:enter="transition ease-out-expo duration-500"
      x-transition:enter-start="opacity-0 translate-y-16"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-out-expo duration-300"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-16">
      <?php
      if ($categories && !empty($categories)) :
        get_template_part("template-parts/headers/partials/categories", null, ["items" => $categories, "level" => 1, "parent" => []]);
      endif;
      ?>
    </div>

    <div class="selleradise__mobile-menu__toggles">
      <button class="selleradise__mobile-menu__toggle" data-tooltip-placement="left" x-tooltip="mobileMenuBarsTooltip" x-bind:class="{
          active: $store.mobileMenu.activeSidebar === 'menu',
        }" x-on:click="$store.mobileMenu.activeSidebar = 'menu'">

        <span id="mobileMenuBarsTooltip" role="tooltip" class="selleradise_tooltip">
          <?php echo esc_html_e('Menu', 'selleradise-lite') ?>
        </span>

        <span class="selleradise__mobile-menu__toggle-icon">
          <?php echo selleradise_svg('tabler-icons/menu-2'); ?>
        </span>
      </button>

      <?php if (class_exists('WooCommerce')) : ?>
        <button class="selleradise__mobile-menu__toggle" data-tooltip-placement="left" x-tooltip="mobileMenuAccountTooltip" x-bind:class="{
          active: $store.mobileMenu.activeSidebar === 'account',
        }" x-on:click="$store.mobileMenu.activeSidebar = 'account'">
          <span id="mobileMenuAccountTooltip" role="tooltip" class="selleradise_tooltip">
            <?php echo esc_html_e('Account', 'selleradise-lite') ?>
          </span>

          <span class="selleradise__mobile-menu__toggle-icon">
            <?php echo selleradise_svg('tabler-icons/user-circle'); ?>
          </span>
        </button>

        <button class="selleradise__mobile-menu__toggle" data-tooltip-placement="left" x-tooltip="mobileMenuCategoriesTooltip" x-bind:class="{
            active: $store.mobileMenu.activeSidebar === 'categories',
          }" x-on:click=" $store.mobileMenu.activeSidebar = 'categories'">
          <span id="mobileMenuCategoriesTooltip" role="tooltip" class="selleradise_tooltip">
            <?php echo esc_html_e('Categories', 'selleradise-lite') ?>
          </span>
          <span class="selleradise__mobile-menu__toggle-icon">
            <?php echo selleradise_svg('tabler-icons/category-2'); ?>
          </span>
        </button>
      <?php endif; ?>
    </div>
  </div>
</div>