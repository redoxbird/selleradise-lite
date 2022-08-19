import { replace } from "lodash-es";
import { trans } from "../helpers";

export const messages = {
  add_to_cart_success: trans("%s has been added to your cart"),
  add_to_cart_error: trans("An error occurred while adding %s to your cart"),
  update_cart_error: trans("An error occurred while updating cart"),
};

export default (props = {}) => ({
  state: "hidden",
  product: props?.product,
  loading: false,

  async init() {
    this.$store.miniCart.state;
  },

  isInCart() {
    return this.$store.miniCart.product_ids.includes(this.product.id);
  },

  async addToCart(e) {
    e.preventDefault();

    if (this.isInCart()) {
      this.$store.miniCart.open();
      return;
    }

    this.loading = true;

    let data = new FormData();

    data.append("product_id", this.product.id);
    data.append("quantity", 1);

    const successMsg = replace(
      messages.add_to_cart_success,
      "%s",
      `<b> "${this.product.name}" </b>`
    );

    const errorMsg = replace(
      messages.add_to_cart_error,
      "%s",
      `<b> "${this.product.name}" </b>`
    );

    try {
      const response = await fetch(this.product.ajax_add_to_cart_endpoint, {
        method: "post",
        body: data,
      });

      this.loading = false;

      if (!response.ok) {
        this.$store.toast.show(errorMsg, "error");
      } else {
        this.$store.toast.show(successMsg, "message");
      }
      this.$store.miniCart.fetch();
    } catch (error) {
      this.loading = false;
      this.$store.toast.show(errorMsg, "error");
    }
  },
});
