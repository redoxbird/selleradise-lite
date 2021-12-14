<template>
  <div>
    <a
      v-bind:href="productdata.cart_url"
      class="addToCart--done"
      v-if="product.quantity"
      v-html="icon.check"
    ></a>
    <a
      v-bind:href="addToCartUrl"
      class="addToCart--main"
      v-on:click.prevent="addToCart()"
      v-else
      >{{ buttonText }}</a
    >

    <ul
      v-for="(attribute, attributeKey) in product.attributes"
      :key="attributeKey"
    >
      <li>{{ attribute.name }}</li>

      <li>
        <ul>
          <li
            v-for="(option, index) in attribute.options"
            v-bind:class="{
              unavilable: !isOptionAvailable(attributeKey, option.slug),
            }"
            :key="index"
          >
            <input
              type="radio"
              v-bind:name="attributeKey"
              v-bind:id="option.slug"
              v-on:change="setSelectedAttribute(attributeKey, option.slug)"
              v-bind:disabled="!isOptionAvailable(attributeKey, option.slug)"
            />
            <label v-bind:for="option.slug">{{ option.name }}</label>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["productdata"],
  data: function () {
    return {
      added: {
        quantity: null,
      },
      product: {
        id: this.productdata.id,
        quantity: this.productdata.quantity,
        variations: this.productdata.variations,
        attributes: this.productdata.attributes,
        availableOptions: null,
        unavailableOptions: null,
        graphedOptions: {},
      },
      selected: {
        attributes: {},
        index: [],
        variation: null,
      },
      graph: null,
      siteUrl: null,
      loading: false,
      buttonText: this.productdata.add_to_cart_text,
      icon: {
        check:
          '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>',
      },
    };
  },

  watch: {
    loading: {
      handler: function (after, before) {
        if (after == true) {
          this.buttonText = this.productdata.loading_text;
        } else {
          this.buttonText = this.productdata.add_to_cart_text;
        }
      },
    },
  },

  computed: {
    addToCartUrl() {
      return `${this.productdata.add_to_cart_url}`;
    },
  },

  methods: {
    addToCart() {
      this.loading = true;
      axios
        .get(this.productdata.add_to_cart_url, { params: { quantity: 1 } })
        .then((response) => {
          this.product.quantity++;
        })
        .then(() => {
          this.loading = false;
        });
    },
  },

  filters: {},

  created() {},

  updated() {},

  mounted() {
    let url = new URL(document.URL);
    this.siteUrl = `${url.protocol}//${url.host}`;

    this.availableOptions();
  },
};
</script>
