<script>
import { trans } from "../helpers";
import { cart, cartIsEmpty } from "../store/cart";
import replace from "lodash/replace";
import debounce from "lodash/debounce";
import { useCartService } from "../machines/cart";
import {
  nextTick,
  onMounted,
  onUnmounted,
  ref,
  unref,
  watch,
} from "@vue/runtime-core";
import { focusIn, Focus } from "../utils/focus-management";

export default {
  setup() {
    const cartService = useCartService();
    const miniCart = ref(null);
    const closeBtn = ref(null);

    function canIncreaseQauntity(index) {
      if (
        cart.value.items[index].product.stock_quantity != null &&
        cart.value.items[index].product.stock_quantity != -1 &&
        cart.value.items[index].quantity >=
          cart.value.items[index].product.stock_quantity
      ) {
        return false;
      }

      return true;
    }

    function increaseQuantity(index) {
      if (canIncreaseQauntity(index) === false) {
        return;
      }

      cart.value.items[index].quantity++;

      const debouncedUpdateQuantity = debounce(async function () {
        updateQuantity(index, cart.value.items[index].key);
      }, 300);

      debouncedUpdateQuantity();
    }

    function decreaseQuantity(index) {
      if (cart.value.items[index].quantity <= 1) {
        removeItemFromCart(index, cart.value.items[index].key);
        return;
      }
      cart.value.items[index].quantity--;

      const debouncedUpdateQuantity = debounce(async function () {
        updateQuantity(index, cart.value.items[index].key);
      }, 300);

      debouncedUpdateQuantity();
    }

    async function removeItemFromCart(index, key) {
      cartService.send("UPDATE");

      try {
        const response = await axios({
          method: "get",
          url: selleradiseData.ajaxURL,
          params: {
            action: "selleradise_remove_item_from_cart",
            key: key,
            _wpnonce: selleradiseData["_wpnonce"],
          },
        });
        delete cart.value.items[index];
        cart.value = response.data.data;
        cartService.send("DONE");
      } catch (error) {
        cartService.send("DONE");
      }
    }

    async function updateQuantity(index, key) {
      cartService.send("UPDATE");

      try {
        const response = await axios({
          method: "get",
          url: selleradiseData.ajaxURL,
          params: {
            action: "selleradise_set_cart_item_quantity",
            key: key,
            quantity: cart.value.items[index].quantity,
            _wpnonce: selleradiseData["_wpnonce"],
          },
        });
        cart.value = response.data.data;
        cartService.send("DONE");
      } catch (error) {
        cartService.send("DONE");
      }
    }

    function handleKeydown(e) {
      if (!miniCart.value) {
        return;
      }

      switch (e.code) {
        case "Escape":
          e.preventDefault();
          e.stopPropagation();
          return cartService.send("CLOSE");

        case "Home":
        case "PageUp":
          e.preventDefault();
          e.stopPropagation();
          return focusIn(miniCart.value, Focus.First);

        case "End":
        case "PageDown":
          e.preventDefault();
          e.stopPropagation();
          return focusIn(miniCart.value, Focus.Last);

        case "ArrowDown":
          e.preventDefault();
          return focusIn(miniCart.value, Focus.Next | Focus.WrapAround);

        case "ArrowUp":
          e.preventDefault();
          return focusIn(miniCart.value, Focus.Previous | Focus.WrapAround);

        case "Tab":
          e.preventDefault();
          if (e.shiftKey) {
            return focusIn(miniCart.value, Focus.Previous | Focus.WrapAround);
          }
          return focusIn(miniCart.value, Focus.Next | Focus.WrapAround);
      }
    }

    watch(cartService.state, (to, from) => {
      if (unref(to).matches("visible")) {
        nextTick(() => {
          if (!unref(closeBtn)) {
            return;
          }

          unref(closeBtn).focus();
        });
      }
    });

    onMounted(() => {
      miniCart.value.addEventListener("keydown", handleKeydown);
    });

    onUnmounted(() => {
      miniCart.value.removeEventListener("keydown", handleKeydown);
    });

    return {
      ...cartService,
      cart,
      cartIsEmpty,
      trans,
      removeItemFromCart,
      increaseQuantity,
      decreaseQuantity,
      selleradiseData,
      replace,
      miniCart,
      closeBtn,
    };
  },
};
</script>
<template>
  <div class="selleradise_MiniCart" ref="miniCart">
    <transition name="selleradise_MiniCart__inner">
      <div
        class="selleradise_MiniCart__inner"
        v-if="
          selleradiseData.isWooCommerce &&
          ['hidden'].some(state.matches) === false
        "
        v-cloak
      >
        <div class="selleradise_MiniCart__head">
          <p
            class="selleradise_MiniCart__headCount"
            v-if="cart && cart.count > 0"
            v-html="
              replace(
                trans(
                  cart && cart.count > 1
                    ? 'mini-cart-items-text'
                    : 'mini-cart-item-text'
                ),
                '%d',
                `<b>${cart && cart.count}</b>`
              )
            "
          ></p>
          <button
            class="button--close buttonIcon--secondary-outline"
            v-on:click="send('CLOSE')"
            ref="closeBtn"
          >
            <slot name="icon-close"></slot>
          </button>
        </div>

        <div class="selleradise_emptyCart--message" v-if="cartIsEmpty">
          <div class="selleradise_empty-state__svg">
            <slot name="nothing-found"></slot>
          </div>

          <h2>
            <b>{{ trans("Your cart is empty.") }}</b>
          </h2>
          <p>
            {{
              trans(
                "Looks like you have not added any product to your cart yet."
              )
            }}
          </p>
        </div>

        <ul class="selleradise_MiniCart__items" v-else>
          <li
            class="selleradise_MiniCart__item"
            v-for="(item, index) of cart.items"
            :key="item.key"
          >
            <a
              :href="item.product.link"
              class="selleradise_MiniCart__itemImage"
              v-html="item.product.image ? item.product.image : false"
            ></a>

            <div class="selleradise_MiniCart__itemContent">
              <p class="selleradise_MiniCart__itemName">
                <a :href="item.product.link" v-html="item.product.name"></a>
              </p>

              <p
                class="selleradise_MiniCart__itemPrice"
                v-html="item.product.price"
              ></p>

              <div class="selleradise_MiniCart__itemQuantity">
                <button
                  v-bind:class="
                    item.quantity > 1
                      ? 'selleradise_MiniCart__decreaseQuantity'
                      : 'selleradise_MiniCart__removeItem'
                  "
                  v-on:click="decreaseQuantity(index)"
                >
                  <span
                    class="inlineSVGIcon"
                    v-html="
                      require(`!svg-inline-loader!../../../dist/svg/unicons-line/minus.svg`)
                    "
                    v-if="item.quantity > 1"
                  ></span>
                  <span
                    class="inlineSVGIcon"
                    v-html="
                      require(`!svg-inline-loader!../../../dist/svg/unicons-line/trash.svg`)
                    "
                    v-else
                  ></span>
                </button>

                <span class="selleradise_MiniCart__itemQuantityCount">
                  {{ item.quantity }}</span
                >

                <button
                  class="selleradise_MiniCart__increaseQuantity"
                  v-on:click="increaseQuantity(index)"
                >
                  <span
                    class="inlineSVGIcon"
                    v-html="
                      require(`!svg-inline-loader!../../../dist/svg/unicons-line/plus.svg`)
                    "
                  ></span>
                </button>
              </div>
            </div>
          </li>
        </ul>

        <div class="selleradise_MiniCart__foot" v-if="!cartIsEmpty">
          <div class="selleradise_MiniCart__footActions">
            <a
              :href="selleradiseData.cartURL"
              class="selleradise_button--secondary-outline"
            >
              {{ trans("Edit Cart") }}
            </a>
            <a
              :href="selleradiseData.checkoutURL"
              class="selleradise_button--primary"
            >
              {{ trans("Checkout") }}
              <span
                class="selleradise_MiniCart__footCartTotal"
                v-html="cart.total"
              ></span>
            </a>
          </div>
        </div>

        <div
          class="selleradise_MiniCart__loader"
          v-if="state.matches('updating')"
        >
          <span
            class="inlineSVGIcon"
            v-html="
              require(`!svg-inline-loader!../../../dist/svg/loader/simple.svg`)
            "
            v-if="state.matches('updating')"
          ></span>
        </div>
      </div>
    </transition>

    <transition name="overlay">
      <div
        class="overlay"
        v-if="['hidden'].some(state.matches) === false"
        v-on:click="send('CLOSE')"
      ></div>
    </transition>
  </div>
</template>
