<template>
  <button
    v-if="selleradiseData.isWooCommerce"
    class="selleradiseHeader__trigger selleradiseHeader__trigger--categories"
    :data-selleradise-position="labelPosition"
    v-on:click.prevent="
      activeSidebar = 'categories';
      mobileMenuSend('OPEN');
    "
  >
    <span
      class="selleradiseHeader__trigger--categories-label"
      v-if="labelPosition === 'left'"
      v-text="label"
    >
    </span>

    <slot name="icon"></slot>

    <span
      class="selleradiseHeader__trigger--categories-label"
      v-if="labelPosition === 'right'"
      v-text="label"
    >
    </span>
  </button>
</template>

<script>
import { activeSidebar } from "../../store/menu";
import { useMobileMenuService } from "../../machines/mobile-menu.js";
import { trans } from "../../helpers";

export default {
  props: ["headerType", "label", "labelPosition"],

  setup(props) {
    const { send: mobileMenuSend } = useMobileMenuService();

    return {
      ...props,
      selleradiseData,
      activeSidebar,
      mobileMenuSend,
      trans,
    };
  },
};
</script>
