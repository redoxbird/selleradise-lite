<template>
  <a
    v-bind:href="addToCartUrl"
    :class="[loading ? 'disabled' : null]"
    v-on:click.prevent="addToCart($event)"
  >
    <slot name="main" v-if="!loading && !isInCart"></slot>
    <slot name="loading" v-else-if="loading"></slot>
    <slot name="in-cart" v-else></slot>
  </a>
</template>

<script>
import { computed, reactive, toRefs } from "@vue/runtime-core";
import { trans } from "../helpers";
import { cardProductIDs, updateCart, messages } from "../store/cart";
import replace from "lodash/replace";
import { showToast } from "../store/toast";
import { useCartService } from "../machines/cart";

export default {
  props: ["productData"],
  setup(props) {
    const cartMachine = useCartService();

    const state = reactive({
      product: {
        ...props.productData,
      },
      loading: false,
      addToCartUrl: computed(() => {
        if (state.isInCart) {
          return selleradiseData.cartURL;
        }
        return `${state.product.product_add_to_cart_url}&quantity=1`;
      }),
      isInCart: computed(() => {
        const products = cardProductIDs();

        return products.includes(state.product.id);
      }),
    });

    let successMsg = replace(
      messages.add_to_cart_success,
      "%s",
      `<b> "${state.product.name}" </b>`
    );

    let errorMsg = replace(
      messages.add_to_cart_error,
      "%s",
      `<b> "${state.product.name}" </b>`
    );

    async function addToCart(e) {
      e.preventDefault();

      if (state.isInCart) {
        cartMachine.send("OPEN");
        return;
      }

      state.loading = true;

      let data = new FormData();

      data.append("product_id", state.product.id);
      data.append("quantity", 1);

      try {
        const response = await axios({
          method: "post",
          url: state.product.add_to_cart_url,
          data: data,
        });

        state.loading = false;

        if (response.data.error) {
          showToast(errorMsg, "error");
        } else {
          showToast(successMsg, "message");
        }

        updateCart();
      } catch (error) {
        state.loading = false;
        showToast(errorMsg, "error");
      }
    }

    return {
      ...toRefs(state),
      ...props,
      addToCart,
      cardProductIDs,
      trans,
    };
  },
};
</script>
