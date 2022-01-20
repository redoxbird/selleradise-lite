<template>
  <button
    :class="`selleradiseHeader__trigger selleradiseHeader__trigger--mobileMenu`"
    :data-selleradise-header-type="headerType"
    v-on:click.prevent="
      activeSidebar = 'menu';
      mobileMenuState.matches('hidden')
        ? mobileMenuSend('OPEN')
        : mobileMenuSend('CLOSE');
    "
  >
    <slot name="icon"></slot>
    <span class="selleradiseHeader__trigger--mobileMenu-text">
      <slot name="text"></slot>
    </span>
  </button>
</template>

<script>
import { activeSidebar } from "../../store/menu";
import { device } from "../../helpers";
import { useMobileMenuService } from "../../machines/mobile-menu.js";

export default {
  props: ["headerType"],

  setup(props) {
    const { state: mobileMenuState, send: mobileMenuSend } =
      useMobileMenuService();

    return {
      ...props,
      device,
      mobileMenuState,
      mobileMenuSend,
      activeSidebar,
    };
  },
};
</script>
