<template>
  <button
    v-if="haveSettings"
    name="settings"
    class="selleradiseHeader__trigger selleradiseHeader__trigger--settings"
    v-on:click.prevent="
      activeSidebar = 'settings';
      mobileMenuSend('OPEN');
    "
  >
    <slot name="icon"></slot>
  </button>
</template>

<script>
import { activeSidebar, haveSettings } from "../../store/menu";
import { useMobileMenuService } from "../../machines/mobile-menu.js";

export default {
  props: ["headerType"],

  setup(props) {
    const { send: mobileMenuSend } = useMobileMenuService();

    return {
      ...selleradiseData,
      ...props,
      haveSettings,
      mobileMenuSend,
      activeSidebar,
    };
  },
};
</script>
