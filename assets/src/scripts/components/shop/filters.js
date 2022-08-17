import wNumb from "wnumb";

export default (props) => ({
  priceFilterSlider: null,
  currencySymbol: selleradiseData.currencySymbol,
  fields: {
    categories: [],
    categories_selected: [],
    tags: [],
    min_price: props.min_price || 0,
    max_price: props.max_price || props.highestPrice,
    attributes: props.productAttributesKeys,
  },

  init() {
    console.log(this.$refs.priceSlider);
    this.initializeRangeSlider();
  },

  initializeRangeSlider() {
    this.priceFilterSlider = noUiSlider.create(this.$refs.priceSlider, {
      connect: true,
      step: 1,
      animate: true,
      animationDuration: 300,
      start: [
        this.fields.min_price ? this.fields.min_price : 0,
        this.fields.max_price ? this.fields.max_price : props.highestPrice,
      ],
      range: {
        min: [0],
        max: [props.highestPrice],
      },
      tooltips: [
        wNumb({ decimals: 0, prefix: this.currencySymbol }),
        wNumb({ decimals: 0, prefix: this.currencySymbol }),
      ],
    });

    this.priceFilterSlider.on("change", (values, handle) => {
      var value = values[handle];

      if (handle) {
        this.fields.max_price = Math.round(value);
      } else {
        this.fields.min_price = Math.round(value);
      }
    });
  },
});
