<template>
  <button
    v-if="selleradiseData.isWooCommerce"
    name="account"
    class="selleradiseHeader__trigger selleradiseHeader__trigger--account"
    v-tippy="trans('mobile-menu-button-account')"
    :aria-label="trans('mobile-menu-button-account')"
    v-on:click.prevent="
      activeSidebar = 'account';
      mobileMenuSend('OPEN');
    "
  >
    <slot name="icon"></slot>
  </button>
</template>

<script>
import { activeSidebar } from "../../store/menu";
import { useMobileMenuService } from "../../machines/mobile-menu.js";
import { trans } from "../../helpers";

export default {
  props: ["headerType"],

  setup(props) {
    const { send: mobileMenuSend } = useMobileMenuService();

    return {
      ...props,
      selleradiseData,
      mobileMenuSend,
      activeSidebar,
      trans,
    };
  },
};
</script>
