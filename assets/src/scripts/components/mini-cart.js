import { cartService } from "../machines/cart";
import { replace, debounce } from "lodash-es";
import { trans } from "../helpers";

export default {
  state: "hidden",
  items: [],
  count: 0,
  total: 0,
  title: "",
  product_ids: [],

  async init() {
    cartService.onTransition((state) => {
      this.state = state.value;
    });

    await this.fetch();
  },

  async fetch() {
    let response;

    try {
      response = await axios({
        method: "get",
        url: selleradiseData.ajaxURL,
        params: {
          action: "selleradise_get_cart_contents",
          _wpnonce: selleradiseData["_wpnonce"],
        },
      });
    } catch (error) {
      console.error(error);
    }

    if (response.status === 200) {
      this.setCartValues(response.data);
    }
  },

  setCartValues(data) {
    this.count = data.count;
    this.total = data.total;
    this.items = Object.values(data.items);

    this.title = replace(
      trans(data.count > 1 ? "mini-cart-items-text" : "mini-cart-item-text"),
      "%d",
      `<b>${data.count}</b>`
    );

    this.product_ids = this.items.map((item) => item.product_id);
  },

  canIncreaseQuantity(index) {
    if (
      this.items[index].product.stock_quantity != null &&
      this.items[index].product.stock_quantity != -1 &&
      this.items[index].quantity >= this.items[index].product.stock_quantity
    ) {
      return false;
    }

    return true;
  },

  increaseQuantity(index) {
    if (this.canIncreaseQuantity(index) === false) {
      return;
    }

    this.items[index].quantity++;

    const debouncedUpdateQuantity = debounce(async () => {
      this.updateQuantity(index, this.items[index].key);
    }, 300);

    debouncedUpdateQuantity();
  },

  decreaseQuantity(index) {
    if (this.items[index].quantity <= 1) {
      this.removeItemFromCart(index, this.items[index].key);
      return;
    }
    this.items[index].quantity--;

    const debouncedUpdateQuantity = debounce(async () => {
      this.updateQuantity(index, this.items[index].key);
    }, 300);

    debouncedUpdateQuantity();
  },

  async removeItemFromCart(index, key) {
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
      delete this.items[index];
      this.setCartValues(response.data.data);
    } catch (error) {}

    cartService.send("DONE");
  },

  async updateQuantity(index, key) {
    cartService.send("UPDATE");

    try {
      const response = await axios({
        method: "get",
        url: selleradiseData.ajaxURL,
        params: {
          action: "selleradise_set_cart_item_quantity",
          key: key,
          quantity: this.items[index].quantity,
          _wpnonce: selleradiseData["_wpnonce"],
        },
      });

      this.setCartValues(response.data.data);
    } catch (error) {}

    cartService.send("DONE");
  },

  isEmpty() {
    return this.items.length <= 0;
  },

  isNotEmpty() {
    return this.items.length > 0;
  },

  open() {
    cartService.send("OPEN");
  },

  close() {
    cartService.send("CLOSE");
  },
};
