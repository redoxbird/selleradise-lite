import { computed, ref } from "@vue/runtime-core";
import isEmpty from "lodash/isEmpty";
import { trans } from "../helpers";
import { showToast } from "./toast";

export const cart = ref({
  items: [],
  count: 0,
  total: 0,
});

export function cardProductIDs() {
  let ids = [];
  for (const key in cart.value.items) {
    if (cart.value.items.hasOwnProperty.call(cart.value.items, key)) {
      const element = cart.value.items[key];
      ids.push(element.product_id);
    }
  }
  return ids;
}

export const cartIsEmpty = computed(() => {
  return isEmpty(cart.value.items);
});

export async function updateCart() {
  try {
    const response = await axios({
      method: "get",
      url: selleradiseData.ajaxURL,
      params: {
        action: "selleradise_get_cart_contents",
        _wpnonce: selleradiseData["_wpnonce"],
      },
    });

    const responseData = response.data;
    cart.value = responseData;
  } catch (error) {
    showToast(messages.update_cart_error, "error");
  }
}

export const messages = {
  add_to_cart_success: trans("%s has been added to your cart"),
  add_to_cart_error: trans("An error occurred while adding %s to your cart"),
  update_cart_error: trans("An error occurred while updating cart"),
};
