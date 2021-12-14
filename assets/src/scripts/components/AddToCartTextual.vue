<template>
  <AddToCart
    :productData="props.productData"
    :class="[
      isInCart
        ? 'selleradise_button--secondary'
        : 'selleradise_button--primary',
    ]"
  >
    <template v-slot:in-cart>{{ trans("product-card-view-cart") }}</template>
    <template v-slot:loading>{{
      trans("product-card-adding-to-cart")
    }}</template>
    <template v-slot:main>{{ trans("product-card-add-to-cart") }}</template>
  </AddToCart>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { cardProductIDs } from "../store/cart";
import AddToCart from "./AddToCart.vue";
import { trans } from "../helpers";

export default {
  components: {
    AddToCart,
  },
  props: ["productData"],
  setup(props) {
    const isInCart = computed(() => {
      const products = cardProductIDs();

      return products.includes(props.productData.id);
    });

    return {
      props,
      trans,
      isInCart,
    };
  },
};
</script>
