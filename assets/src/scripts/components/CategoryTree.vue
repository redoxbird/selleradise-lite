<template>
  <ul
    class="selleradise_sidebar__navigation-list"
    ref="list"
    :class="[`level-${level}`]"
  >
    <li>
      <button
        class="selleradise_sidebar__navigation-button--back"
        ref="backBtn"
        aria-label="Go To Previous List"
        v-if="level > 1 && categorySubMenuIds && categorySubMenuIds.length > 0"
        v-on:click="categorySubMenuIds.pop()"
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
        v-html="parent ? parent.name : trans('mobile-menu-button-categories')"
      ></h2>
    </li>

    <li v-for="category in items" :key="category.term_id">
      <a :href="category.url">
        <div
          class="selleradise_sidebar__navigation-list-image"
          v-if="category.image.thumbnail"
        >
          <img :src="category.image.thumbnail[0]" :alt="category.image.alt" />
        </div>
        <span v-html="category.name"></span>
      </a>

      <button
        class="selleradise_sidebar__navigation-button--more"
        v-if="category.children && category.children.length > 0"
        v-on:click.prevent="openChildMenu(category)"
        :aria-haspopup="
          category.children && category.children.length > 0 ? true : undefined
        "
        :aria-expanded="
          categorySubMenuIds.includes(category.term_id) ? true : false
        "
      >
        <span
          class="inlineSVGIcon"
          v-html="
            require(`!svg-inline-loader!../../../dist/svg/unicons-line/angle-right.svg`)
          "
        ></span>
      </button>

      <transition name="selleradise_sidebar__navigation">
        <category-tree
          v-if="
            category.children &&
            category.children.length > 0 &&
            categorySubMenuIds.includes(category.term_id)
          "
          v-bind:items="category.children"
          v-bind:parent="category"
          v-bind:level="level + 1"
        ></category-tree>
      </transition>
    </li>
  </ul>
</template>

<script>
import { ref } from "@vue/reactivity";
import { categorySubMenuIds } from "../store/menu";
import { trans } from "../helpers";

export default {
  props: ["items", "level", "parent"],
  setup(props, { emit }) {
    const list = ref(null);

    function openChildMenu(item) {
      if (!item.children) {
        return;
      }

      if (!categorySubMenuIds.value.includes(item.term_id)) {
        categorySubMenuIds.value.push(item.term_id);
        list.value.scrollIntoView({
          behavior: "smooth",
          block: "start",
          inline: "nearest",
        });
      }
    }

    return {
      openChildMenu,
      categorySubMenuIds,
      list,
      trans,
    };
  },
};
</script>
