<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>
<div
  x-cloak
  class="selleradise__mobile-menu"
  <!-- x-if="['visible', 'changing'].some(mobileMenuState.matches)" -->

  x-ref="elements.menu"
>
  <button
    class="selleradise__mobile-menu-button--close"
    x-on:click="closeMenu()"
    aria-label="Close Mobile Menu"
    r-ref="elements.closeButton"
  >
    <?php echo selleradise_svg('unicons-line/multiply'); ?>
  </button>

  <nav
    class="selleradise_sidebar__navigation"
    role="navigation"
    aria-label="Primary"
    x-show="activeSidebar === 'menu'"
  >
    <menu-tree-mobile
      x-bind:items="mobileMenuItems"
      x-bind:level="1"
      x-bind:breadcrumb="[]"
      x-if="mobileMenuItems && mobileMenuItems.length > 0"
    ></menu-tree-mobile>
  </transition>


  <div
    class="selleradise_sidebar__account"
    x-show="activeSidebar === 'account'"
  >
    <?php get_template_part('template-parts/headers/partials/account', 'info'); ?>
    <?php get_template_part('template-parts/headers/partials/account', 'links'); ?>
  </div>

  <Categories v-if="selleradiseData.isWooCommerce"> </Categories>

  <div
    class="selleradise_sidebar__settings"
    x-if="
      Object.values(selleradiseData.settings).includes('1') &&
      activeSidebar === 'settings'
    "
  >
    <ul>
      <li
        class="selleradise_sidebar__settings-toggle"
        v-if="selleradiseData.settings.dark_mode_setting == '1'"
      >
        <DarkModeToggleBtn />
      </li>
    </ul>
  </div>

  <div class="selleradise__mobile-menu__toggles">
    <button
      class="selleradise__mobile-menu__toggle"
      data-tippy-placement="left"
      v-tippy="trans('mobile-menu-button-menu')"
      :class="{
        active: activeSidebar === 'menu',
      }"
      v-on:click="activeSidebar = 'menu'"
    >
      <span class="selleradise__mobile-menu__toggle-icon">
        <?php echo selleradise_svg('unicons-line/bars'); ?>
      </span>
    </button>
    <button
      v-if="selleradiseData.isWooCommerce"
      class="selleradise__mobile-menu__toggle"
      data-tippy-placement="left"
      v-tippy="trans('mobile-menu-button-account')"
      :class="{
        active: activeSidebar === 'account',
      }"
      v-on:click="activeSidebar = 'account'"
    >
      <span class="selleradise__mobile-menu__toggle-icon">
        <?php echo selleradise_svg('unicons-line/user-circle'); ?>
      </span>
    </button>
    <button
      class="selleradise__mobile-menu__toggle"
      data-tippy-placement="left"
      v-if="Object.values(selleradiseData.settings).includes('1')"
      v-tippy="trans('mobile-menu-button-settings')"
      v-on:click="activeSidebar = 'settings'"
      :class="{
        active: activeSidebar === 'settings',
      }"
    >
      <span class="selleradise__mobile-menu__toggle-icon">
        <?php echo selleradise_svg('unicons-line/setting'); ?>
      </span>
    </button>
    <button
      v-if="showTrigger.category()"
      class="selleradise__mobile-menu__toggle"
      data-tippy-placement="left"
      v-tippy="trans('mobile-menu-button-categories')"
      :class="{
        active: activeSidebar === 'categories',
      }"
      v-on:click="activeSidebar = 'categories'"
    >
      <span class="selleradise__mobile-menu__toggle-icon">
        <?php echo selleradise_svg('unicons-line/apps'); ?>
      </span>
    </button>
  </div>
</div>
