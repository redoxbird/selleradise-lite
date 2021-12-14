<template>
  <transition name="selleradise_sidebar">
    <div
      class="selleradise_sidebar__categories"
      v-show="activeSidebar === 'categories'"
    >
      <category-tree
        v-bind:items="categories"
        v-bind:level="1"
        v-if="true"
      ></category-tree>
    </div>
  </transition>
</template>

<script>
import { ref, unref } from "@vue/reactivity";
import { activeSidebar, categoriesTree } from "../../store/menu";
import CategoryTree from "../CategoryTree.vue";
import { watchEffect } from "@vue/runtime-core";

export default {
  components: {
    "category-tree": CategoryTree,
  },
  setup() {
    const categories = ref([]);

    watchEffect(() => {
      if (categoriesTree && categoriesTree.value.length) {
        categories.value = [...unref(categoriesTree)];
      }
    });

    return {
      activeSidebar,
      categories,
    };
  },
};
</script>
