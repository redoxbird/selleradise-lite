<template>
  <a
    v-if="isWooCommerce"
    aria-haspopup="true"
    :class="`selleradiseHeader__trigger selleradiseHeader__trigger--miniCart`"
    :href="cartURL"
    :aria-label="trans('header-button-cart')"
    :data-count="cart.count"
    :aria-expanded="cartState.matches('hidden') ? null : true"
    v-on:click.prevent="
      cartState.matches('hidden') ? cartSend('OPEN') : cartSend('CLOSE')
    "
  >
    <slot name="icon"></slot>

    <span> {{ cart.count || 0 }} </span>
  </a>
</template>

<script>
import { onMounted } from "@vue/runtime-core";
import { device, trans } from "../../helpers";
import { useCartService } from "../../machines/cart";
import { cart, updateCart } from "../../store/cart";

export default {
  props: ["headerType"],
  setup(props) {
    const { state: cartState, send: cartSend } = useCartService();

    onMounted(() => {
      updateCart();
    });

    return {
      ...selleradiseData,
      ...props,
      device,
      cart,
      cartState,
      cartSend,
      trans,
    };
  },
};
</script>
