<template>
  <div class="selleradiseHeader__searchForm-category">
    <Listbox v-model="category">
      <ListboxButton class="selleradiseHeader__searchForm-category-button">
        <span v-html="category.name"> </span>
        <span
          class="inlineSVGIcon"
          v-html="
            require(`!svg-inline-loader!../../../dist/svg/unicons-line/angle-down.svg`)
          "
        ></span>
      </ListboxButton>

      <transition name="selleradiseHeader__searchForm-category-options">
        <ListboxOptions class="selleradiseHeader__searchForm-category-options">
          <ListboxOption
            v-for="category in categories"
            v-slot="{ active, selected }"
            :key="category"
            :value="category"
            as="template"
          >
            <li
              :class="[active && 'active', selected && 'selected']"
              :aria-label="category.name"
            >
              <span
                v-html="
                  truncate(category.name, {
                    length: 25,
                    separator: '...',
                  })
                "
              >
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </Listbox>
  </div>
</template>

<script>
import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
import truncate from "lodash/truncate";
import { categoriesTree } from "../store/menu";
import { trans } from "../helpers";
import { inject, ref, unref, watch, watchEffect } from "@vue/runtime-core";

export default {
  components: {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
  },

  setup() {
    const categories = ref([]);

    watchEffect(() => {
      if (categoriesTree && categoriesTree.value.length) {
        categories.value = [...unref(categoriesTree)];
        categories.value.unshift({
          name: trans("header-search-dropdown"),
          term_id: 0,
          slug: false,
        });
      }
    });

    const category = inject("category");

    return {
      selleradiseData,
      categories,
      category,
      truncate,
    };
  },
};
</script>
