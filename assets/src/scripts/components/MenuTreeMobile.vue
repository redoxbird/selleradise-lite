<script>
import { linkedIds, elements, active } from "../store/menu";
import { useMobileMenuService } from "../machines/mobile-menu.js";
import { computed } from "@vue/reactivity";
import { trans } from "../helpers";
import { onMounted, onUnmounted } from "@vue/runtime-core";

export default {
  props: ["items", "level", "parent"],

  setup(props) {
    const { state: mobileMenuState, send: mobileMenuSend } =
      useMobileMenuService();

    const nonLinkCharacters = ["#", " ", ""];

    function openChildMenu(item) {
      if (!item.children) {
        return;
      }

      if (!linkedIds.mobileMenu.value.includes(item.ID)) {
        linkedIds.mobileMenu.value.push(item.ID);
        elements.list.value.scrollIntoView({
          behavior: "smooth",
          block: "start",
          inline: "nearest",
        });
      }
    }

    function shouldShowChildMenu(item) {
      if (!item.children) {
        return false;
      }
      if (item.children.length <= 0) {
        return false;
      }
      return linkedIds.mobileMenu.value.includes(item.ID);
    }

    function openChildMenuLink(e, item) {
      const href = e.target.getAttribute("href");

      if (e.code != "ArrowRight" && href && !nonLinkCharacters.includes(href)) {
        return;
      }

      e.preventDefault();
      openChildMenu(item);
    }

    const tabindex = computed(() => {
      if (!props.parent && !active.submenuID.value) {
        return null;
      }

      if (
        props.parent &&
        active.submenuID.value &&
        props.parent.ID === active.submenuID.value
      ) {
        return null;
      }

      return -1;
    });

    onUnmounted(() => {
      if (elements.backButton.value) {
        elements.backButton.value.focus();
      }
    });

    onMounted(() => {
      if (elements.backButton.value) {
        elements.backButton.value.focus();
      }
    });

    return {
      ...props,
      openChildMenu,
      shouldShowChildMenu,
      openChildMenuLink,
      mobileMenuSend,
      trans,
      elements,
      active,
      tabindex,
      linkedIds,
    };
  },
};
</script>

<template>
  <ul
    class="selleradise_sidebar__navigation-list"
    :class="`level-${level}`"
    :ref="elements.list"
  >
    <li>
      <button
        class="selleradise_sidebar__navigation-button--back"
        v-on:click="linkedIds.mobileMenu.value.pop()"
        v-on:keydown.arrow-left.prevent="linkedIds.mobileMenu.value.pop()"
        :ref="elements.backButton"
        aria-label="Go To Previous List"
        v-if="level > 1"
        :tabindex="tabindex"
      >
        <span
          class="inlineSVGIcon"
          v-html="
            require(`!svg-inline-loader!../../../dist/svg/unicons-line/arrow-left.svg`)
          "
        ></span>
      </button>
    </li>

    <li class="selleradise_sidebar__navigation-title">
      <h2
        v-html="parent ? parent.title : trans('mobile-menu-button-menu')"
      ></h2>
    </li>

    <li
      v-for="menuItem in items"
      class="menutItem"
      :key="menuItem.ID"
      :class="[
        menuItem.children && menuItem.children.length > 0 ? 'hasChildren' : '',
        menuItem.classes && ` ${menuItem.classes} `,
      ]"
      :title="menuItem.attr_title ? menuItem.attr_title : null"
      :data-id="menuItem.ID"
    >
      <a
        class="menuItemLink"
        :href="menuItem.url"
        :target="menuItem.target ? menuItem.target : null"
        v-on:click="openChildMenuLink($event, menuItem)"
        v-on:keydown.arrow-right.prevent="openChildMenuLink($event, menuItem)"
        :tabindex="tabindex"
      >
        <span>{{ menuItem.title }}</span>
      </a>

      <button
        class="selleradise_sidebar__navigation-button--more"
        v-on:click.prevent="openChildMenu(menuItem)"
        v-on:keydown.arrow-right.prevent="openChildMenuLink($event, menuItem)"
        v-if="menuItem.children && menuItem.children.length > 0"
        :aria-haspopup="
          menuItem.children && menuItem.children.length > 0 ? true : undefined
        "
        :aria-expanded="
          linkedIds.mobileMenu.value.includes(menuItem.ID) ? true : false
        "
        :tabindex="tabindex"
      >
        <span
          class="inlineSVGIcon"
          v-html="
            require(`!svg-inline-loader!../../../dist/svg/unicons-line/angle-right.svg`)
          "
        ></span>
      </button>

      <transition name="selleradise_sidebar__navigation">
        <menu-tree-mobile
          v-if="shouldShowChildMenu(menuItem)"
          v-bind:items="menuItem.children"
          v-bind:level="level + 1"
          v-bind:parent="menuItem"
        ></menu-tree-mobile>
      </transition>
    </li>
  </ul>
</template>
