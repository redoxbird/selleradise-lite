<template>
  <form class="selleradise_shop__orderby--dropdown" ref="form" method="get">
    <Listbox v-model="selectedOption">
      <ListboxButton class="selleradise_shop__orderby--dropdown-button"
        ><span v-html="selectedOption.name"></span>
        <span
          class="inlineSVGIcon"
          v-html="
            require(`!svg-inline-loader!../../../dist/svg/unicons-line/sort.svg`)
          "
        ></span>
      </ListboxButton>

      <transition name="selleradise_shop__orderby--dropdown-options">
        <ListboxOptions class="selleradise_shop__orderby--dropdown-options">
          <ListboxOption
            v-for="option in options"
            v-slot="{ active }"
            :key="option"
            :value="option"
            as="template"
          >
            <li
              :class="[
                active && 'active',
                selectedOption.id === option.id && 'selected',
              ]"
            >
              <span v-html="option.name"></span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </Listbox>

    <input type="hidden" name="orderby" :value="selectedOption.id" />
    <slot> </slot>
  </form>
</template>

<script>
import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
import { ref } from "@vue/reactivity";
import { nextTick, watch } from "@vue/runtime-core";

export default {
  props: ["options", "selected"],
  components: {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
  },

  setup(props) {
    const selectedOption = ref(props.selected);
    const form = ref(null);

    watch(selectedOption, (to, from) => {
      if (to != from) {
        nextTick(() => {
          form.value.submit();
        });
      }
    });

    return {
      props,
      selectedOption,
      form,
    };
  },
};
</script>
