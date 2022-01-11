<template>
  <header
    role="banner"
    :data-selleradise-search-state="searchState.value"
    :data-selleradise-mobile-menu-state="mobileMenuState.value"
    :data-selleradise-mini-cart-state="cartState.value"
  >
    <slot> </slot>

    <transition name="overlay">
      <div
        class="overlay"
        v-if="
          ['found', 'not_found', 'searching', 'initiated'].some(
            searchState.matches
          )
        "
        v-on:click="searchSend('STOP')"
      ></div>
    </transition>

    <transition name="overlay">
      <div
        class="overlay selleradise_overlay--mobile"
        v-if="['visible', 'changing'].some(mobileMenuState.matches)"
        v-on:click="closeMenu()"
      ></div>
    </transition>
  </header>
</template>

<script>
import { useSearchService } from "../machines/search";
import { useMobileMenuService } from "../machines/mobile-menu.js";
import { useCartService } from "../machines/cart.js";
import { linkedIds, updateCategories } from "../store/menu";
import { onMounted } from "@vue/runtime-core";

export default {
  props: ["data"],

  setup() {
    const { state: searchState, send: searchSend } = useSearchService();
    const { state: mobileMenuState, send: mobileMenuSend } =
      useMobileMenuService();
    const { state: cartState } = useCartService();

    function closeMenu() {
      mobileMenuSend("CLOSE");
      linkedIds.mobileMenu.value = [];
    }

    onMounted(() => {
      updateCategories();
    });

    return {
      searchState,
      searchSend,
      mobileMenuState,
      mobileMenuSend,
      cartState,
      closeMenu,
    };
  },
};
</script>
