<script>
import MenuTreeMobile from "./MenuTreeMobile.vue";
import {
  mobileMenuItems,
  updateMenuItems,
  categoriesTree,
} from "../store/menu";
import { linkedIds } from "../store/menu";
import { useMobileMenuService } from "../machines/mobile-menu.js";
import Account from "../components/sidebars/Account";
import Categories from "../components/sidebars/Categories";
import DarkModeToggleBtn from "../components/DarkModeToggleBtn";
import { trans } from "../helpers";
import { activeSidebar, haveSettings } from "../store/menu";
import {
  onMounted,
  ref,
  onUnmounted,
  watchEffect,
  nextTick,
  watch,
  unref,
} from "vue";
import { focusIn, Focus } from "../utils/focus-management";

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

    const elements = {
      menu: ref(null),
      closeButton: ref(null),
    };

    const showTrigger = {
      category: () => {
        if (!selleradiseData.isWooCommerce) {
          return false;
        }

        if (categoriesTree.value.length <= 0) {
          return false;
        }

        return true;
      },
    };

    function closeMenu() {
      mobileMenuSend("CLOSE");
      linkedIds.mobileMenu.value = [];
    }

    function enableTriggers() {
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

    function handleKeydown(e) {
      if (!elements.menu.value) {
        return;
      }

      switch (e.code) {
        case "Escape":
          e.preventDefault();
          e.stopPropagation();
          return mobileMenuSend("CLOSE");

        case "Home":
        case "PageUp":
          e.preventDefault();
          e.stopPropagation();
          return focusIn(elements.menu.value, Focus.First);

        case "End":
        case "PageDown":
          e.preventDefault();
          e.stopPropagation();
          return focusIn(elements.menu.value, Focus.Last);

        case "ArrowDown":
          e.preventDefault();
          return focusIn(elements.menu.value, Focus.Next | Focus.WrapAround);

        case "ArrowUp":
          e.preventDefault();
          return focusIn(
            elements.menu.value,
            Focus.Previous | Focus.WrapAround
          );

        case "Tab":
          e.preventDefault();
          if (e.shiftKey) {
            return focusIn(
              elements.menu.value,
              Focus.Previous | Focus.WrapAround
            );
          }
          return focusIn(elements.menu.value, Focus.Next | Focus.WrapAround);
      }
    }

    watch(mobileMenuState, (to, from) => {
      if (unref(to).matches("visible")) {
        nextTick(() => {
          if (!unref(elements.closeButton)) {
            return;
          }

          unref(elements.closeButton).focus();
        });
      }
    });

    const eventListeners = {
      add: () => {
        elements.menu.value.addEventListener("keydown", handleKeydown);
      },

      remove: () => {
        elements.menu.value.removeEventListener("keydown", handleKeydown);
      },

      update: () => {
        elements.menu.value.removeEventListener("keydown", handleKeydown);
        elements.menu.value.addEventListener("keydown", handleKeydown);
      },
    };

    watchEffect(() => {
      if (elements.menu.value) {
        eventListeners.add();
      }
    });

    onMounted(() => {
      enableTriggers();
      updateMenuItems();
    });

    onUnmounted(() => {
      if (elements.menu.value) {
        eventListeners.remove();
      }
    });

    return {
      selleradiseData,
      mobileMenuItems,
      mobileMenuState,
      haveSettings,
      activeSidebar,
      mobileMenuSend,
      closeMenu,
      trans,
      elements,
      showTrigger,
    };
  },
};
</script>

<template>
  <transition name="selleradise__mobile-menu">
    <div
      v-cloak
      class="selleradise__mobile-menu"
      v-if="['visible', 'changing'].some(mobileMenuState.matches)"
      :ref="elements.menu"
    >
      <button
        class="selleradise__mobile-menu-button--close"
        v-on:click="closeMenu()"
        aria-label="Close Mobile Menu"
        :ref="elements.closeButton"
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

      <transition
        name="selleradise_sidebar"
        v-if="selleradiseData.isWooCommerce"
      >
        <div
          class="selleradise_sidebar__account"
          v-show="activeSidebar === 'account'"
        >
          <slot name="account-info"></slot>
          <slot name="account-links"></slot>
        </div>
      </transition>

      <Categories v-if="selleradiseData.isWooCommerce"> </Categories>

      <transition name="selleradise_sidebar">
        <div
          class="selleradise_sidebar__settings"
          v-if="
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
            <slot name="icon-account"></slot>
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
            <slot name="icon-settings"></slot>
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
            <slot name="icon-categories"></slot>
          </span>
        </button>
      </div>
    </div>
  </transition>
</template>
