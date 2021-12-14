<template>
  <transition name="selleradise__mobile-menu">
    <div
      v-cloak
      class="selleradise__mobile-menu"
      v-if="['visible', 'changing'].some(mobileMenuState.matches)"
    >
      <button
        class="selleradise__mobile-menu-button--close"
        v-on:click="closeMenu()"
        aria-label="Close Mobile Menu"
      >
        <slot name="icon-close"></slot>
      </button>

      <transition name="selleradise_sidebar">
        <nav
          class="selleradise_sidebar__navigation"
          role="navigation"
          aria-label="Primary"
          v-show="activeSidebar === 'menu'"
        >
          <menu-tree-mobile
            v-bind:items="mobileMenuItems"
            v-bind:level="1"
            v-bind:breadcrumb="[]"
            v-if="mobileMenuItems && mobileMenuItems.length > 0"
          ></menu-tree-mobile>
        </nav>
      </transition>

      <transition name="selleradise_sidebar" v-if="isWooCommerce">
        <div
          class="selleradise_sidebar__account"
          v-show="activeSidebar === 'account'"
        >
          <slot name="account-info"></slot>
          <slot name="account-links"></slot>
        </div>
      </transition>

      <Categories v-if="isWooCommerce"> </Categories>

      <transition name="selleradise_sidebar">
        <div
          class="selleradise_sidebar__settings"
          v-if="haveSettings && activeSidebar === 'settings'"
        >
          <ul>
            <li
              class="selleradise_sidebar__settings-toggle"
              v-if="settings.dark_mode_setting"
            >
              <DarkModeToggleBtn />
            </li>
          </ul>
        </div>
      </transition>

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
            <slot name="icon-menu"></slot>
          </span>
          <span class="selleradise__mobile-menu__toggle-label">
            {{ trans("mobile-menu-button-menu") }}
          </span>
        </button>
        <button
          v-if="isWooCommerce"
          class="selleradise__mobile-menu__toggle"
          data-tippy-placement="left"
          v-tippy="trans('mobile-menu-button-account')"
          :class="{
            active: activeSidebar === 'account',
          }"
          v-on:click="activeSidebar = 'account'"
        >
          <span class="selleradise__mobile-menu__toggle-icon">
            <slot name="icon-account"></slot>
          </span>
          <span class="selleradise__mobile-menu__toggle-label">
            {{ trans("mobile-menu-button-account") }}
          </span>
        </button>
        <button
          class="selleradise__mobile-menu__toggle"
          data-tippy-placement="left"
          v-if="Object.values(settings).includes(true)"
          v-tippy="trans('mobile-menu-button-settings')"
          v-on:click="activeSidebar = 'settings'"
          :class="{
            active: activeSidebar === 'settings',
          }"
        >
          <span class="selleradise__mobile-menu__toggle-icon">
            <slot name="icon-settings"></slot>
          </span>
          <span class="selleradise__mobile-menu__toggle-label">
            {{ trans("mobile-menu-button-settings") }}
          </span>
        </button>
        <button
          v-if="isWooCommerce"
          class="selleradise__mobile-menu__toggle"
          data-tippy-placement="left"
          v-tippy="trans('mobile-menu-button-categories')"
          :class="{
            active: activeSidebar === 'categories',
          }"
          v-on:click="activeSidebar = 'categories'"
        >
          <span class="selleradise__mobile-menu__toggle-icon">
            <slot name="icon-categories"></slot>
          </span>
          <span class="selleradise__mobile-menu__toggle-label">
            {{ trans("mobile-menu-button-categories") }}
          </span>
        </button>
      </div>
    </div>
  </transition>
</template>

<script>
import MenuTreeMobile from "./MenuTreeMobile.vue";
import {
  mobileMenuItems,
  updateCategories,
  updateMenuItems,
} from "../store/menu";
import { childMenuIds } from "../store/menu";
import { useMobileMenuService } from "../machines/mobile-menu.js";
import Account from "../components/sidebars/Account";
import Categories from "../components/sidebars/Categories";
import DarkModeToggleBtn from "../components/DarkModeToggleBtn";
import { trans } from "../helpers";
import { activeSidebar, haveSettings } from "../store/menu";
import { onMounted } from "@vue/runtime-core";

export default {
  components: {
    "menu-tree-mobile": MenuTreeMobile,
    Account,
    Categories,
    DarkModeToggleBtn,
  },

  setup() {
    const { state: mobileMenuState, send: mobileMenuSend } =
      useMobileMenuService();

    function closeMenu() {
      mobileMenuSend("CLOSE");
      childMenuIds.value = [];
    }

    function triggers() {
      const links = document.querySelectorAll(
        'a[href^="#selleradise_sidebar__"]'
      );

      if (links.length < 1) {
        return;
      }

      for (const index in links) {
        if (links.hasOwnProperty.call(links, index)) {
          const link = links[index];
          const type = link.href.split("__")[1];

          if (!type) {
            continue;
          }

          link.addEventListener("click", function (e) {
            e.preventDefault();
            mobileMenuSend("OPEN");
            activeSidebar.value = type;
          });
        }
      }
    }

    onMounted(() => {
      triggers();
      updateMenuItems();
    });

    return {
      ...selleradiseData,
      mobileMenuItems,
      mobileMenuState,
      haveSettings,
      activeSidebar,
      mobileMenuSend,
      closeMenu,
      trans,
    };
  },
};
</script>
