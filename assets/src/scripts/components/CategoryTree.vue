<script>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { linkedIds, openChildren, elements, active } from "../store/menu";
import { trans } from "../helpers";

export default {
  props: ["items", "level", "parent"],
  setup(props, { emit }) {
    const tabindex = computed(() => {
      if (!props.parent && !active.subcategoryID.value) {
        return null;
      }

      if (
        props.parent &&
        active.subcategoryID.value &&
        props.parent.term_id === active.subcategoryID.value
      ) {
        return null;
      }

      return -1;
    });

    onUnmounted(() => {
      if (elements.category.backButton.value) {
        elements.category.backButton.value.focus();
      }
    });

    onMounted(() => {
      if (elements.category.backButton.value) {
        elements.category.backButton.value.focus();
      }
    });

    return {
      openChildren,
      linkedIds,
      trans,
      elements,
      tabindex,
    };
  },
};
</script>

<template>
  <ul
    class="selleradise_sidebar__navigation-list"
    :class="[`level-${level}`]"
    :ref="elements.category.list"
    :tabindex="tabindex"
  >
    <li>
      <button
        class="selleradise_sidebar__navigation-button--back"
        aria-label="Go To Previous List"
        v-if="
          level > 1 && linkedIds.category && linkedIds.category.value.length > 0
        "
        v-on:click="linkedIds.category.value.pop()"
        v-on:keydown.arrow-left.prevent="linkedIds.category.value.pop()"
        :ref="elements.category.backButton"
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
        v-html="parent ? parent.name : trans('mobile-menu-button-categories')"
      ></h2>
    </li>

    <li v-for="category in items" :key="category.term_id">
      <a
        :href="category.url"
        :tabindex="tabindex"
        v-on:keydown.arrow-right.prevent="
          openChildren(
            category,
            'category',
            elements.category.list.value,
            category.term_id
          )
        "
      >
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
        v-on:click.prevent="
          openChildren(
            category,
            'category',
            elements.category.list.value,
            category.term_id
          )
        "
        v-on:keydown.arrow-right.prevent="
          openChildren(
            category,
            'category',
            elements.category.list.value,
            category.term_id
          )
        "
        :aria-haspopup="
          category.children && category.children.length > 0 ? true : undefined
        "
        :aria-expanded="
          linkedIds.category.value.includes(category.term_id) ? true : false
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
        <category-tree
          v-if="
            category.children &&
            category.children.length > 0 &&
            linkedIds.category.value.includes(category.term_id)
          "
          v-bind:items="category.children"
          v-bind:parent="category"
          v-bind:level="level + 1"
        ></category-tree>
      </transition>
    </li>
  </ul>
</template>
