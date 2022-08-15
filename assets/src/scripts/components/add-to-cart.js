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

    try {
      const response = await axios({
        method: "post",
        url: this.product.ajax_add_to_cart_endpoint,
        data: data,
      });

      this.loading = false;

      // if (response.data.error) {
      //   showToast(errorMsg, "error");
      // } else {
      //   showToast(successMsg, "message");
      // }
      this.$store.miniCart.fetch();
    } catch (error) {
      this.loading = false;
      console.error(error);
      // showToast(errorMsg, "error");
    }
  },
});
