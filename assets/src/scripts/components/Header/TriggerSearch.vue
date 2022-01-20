<template>
  <button
    :class="`selleradiseHeader__trigger selleradiseHeader__trigger--search`"
    :aria-label="trans('header-button-search')"
    v-tippy="trans('header-button-search')"
    v-on:click.prevent="openSearhForm()"
  >
    <slot name="icon"></slot>
  </button>
</template>

<script>
import { nextTick } from "@vue/runtime-core";
import { device, trans } from "../../helpers";
import { useSearchService } from "../../machines/search";

export default {
  props: ["headerType"],
  setup(props) {
    const { send: searchSend } = useSearchService();

    function openSearhForm() {
      searchSend("START");

      nextTick(() => {
        const searchField = document.querySelector(".searchField");
        searchField.focus();
      });
    }

    return {
      ...props,
      device,
      openSearhForm,
      trans,
    };
  },
};
</script>
