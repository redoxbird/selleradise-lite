<template>
  <AddToCart
    :productData="props.productData"
    :class="[isInCart ? 'buttonIcon--secondary' : 'buttonIcon--primary']"
  >
    <template v-slot:main
      ><span
        class="inlineSVGIcon"
        :aria-label="trans('product-card-add-to-cart')"
        v-html="
          require(`!svg-inline-loader!../../../dist/svg/unicons-line/plus.svg`)
        "
      ></span
    ></template>
    <template v-slot:loading
      ><span
        class="inlineSVGIcon"
        :aria-label="trans('product-card-adding-to-cart')"
        v-html="
          require(`!svg-inline-loader!../../../dist/svg/loader/simple.svg`)
        "
      >
      </span
    ></template>
    <template v-slot:in-cart>
      <span
        class="inlineSVGIcon"
        :aria-label="trans('product-card-view-cart')"
        v-html="
          require(`!svg-inline-loader!../../../dist/svg/unicons-line/shopping-bag.svg`)
        "
      >
      </span
    ></template>
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
      isInCart,
      trans,
    };
  },
};
</script>
