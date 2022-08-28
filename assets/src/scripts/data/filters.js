import wNumb from "wnumb";
import { device } from "../helpers";

export default (props) => ({
  priceFilterSlider: null,
  currencySymbol: selleradiseData.currencySymbol,
  params: new URLSearchParams(props.searchParams || ""),
  type: props.type,
  data: {
    attributes: [],
    categories: [],
  },
  fields: {
    product_cat: [],
    min_price: 0,
    max_price: props.highestPrice,
    attributes: {},
  },
  formData: {},
  isChanged: false,
  isShowing: false,
  isSmall: device("mobileAndTablet"),

  init() {
    this.updateFormData();
    this.setValues();
    this.initializeRangeSlider();
    this.getAttributes();
  },

  async getAttributes() {
    const params = new URLSearchParams({
      action: "selleradise_get_shop_filter_attributes",
      _wpnonce: selleradiseData["_wpnonce"],
    });

    const response = await fetch(
      `${selleradiseData.ajaxURL}?${params.toString()}`
    );

    this.data.attributes = await response.json();
  },

  show() {
    if (device("mobileAndTablet") || this.type === "offscreen") {
      return this.isShowing;
    }

    return true;
  },

  open() {
    this.isShowing = true;
  },

  close() {
    this.isShowing = false;
  },

  className() {
    if (device("mobileAndTablet") || this.type === "offscreen") {
      return "selleradise_shop__filters--offscreen";
    }
  },

  updateFormData() {
    const formData = new FormData(this.$refs.form);
    this.formData = formData;
  },

  setValues() {
    this.fields.min_price = parseFloat(this.formData.get("min_price")) || 0;
    this.fields.max_price =
      parseFloat(this.formData.get("max_price")) || props.highestPrice;
  },

  handleCategoryChange(e) {
    const value = e.target.value;

    const existingIndex = this.fields.product_cat.findIndex(
      (slug) => slug === value
    );

    if (e.target.checked && existingIndex < 0) {
      this.fields.product_cat.push(value);
    } else if (!e.target.checked && existingIndex >= 0) {
      this.fields.product_cat.splice(existingIndex, 1);
    }

    this.isChanged = true;
  },

  handleAttributeChange(e, attribute, value) {
    console.log(attribute, value);
    let field = this.fields.attributes[attribute.attribute_name];

    if (!field) {
      field = this.fields.attributes[attribute.attribute_name] = [];
    }

    const existingIndex = field.findIndex((slug) => slug === value.slug);

    if (e.target.checked && existingIndex < 0) {
      field.push(value.slug);
    } else if (!e.target.checked && existingIndex >= 0) {
      field.splice(existingIndex, 1);
    }

    this.isChanged = true;
  },

  productCatString() {
    return this.fields.product_cat.join(",");
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

      this.isChanged = true;
      this.$nextTick(() => this.updateFormData());
    });
  },

  isCategoryChecked(slug) {
    const product_cat = this.params.get("product_cat");

    if (!product_cat) {
      return false;
    }

    const selected = product_cat.split(",");
    const isSelected = selected.includes(slug);

    if (isSelected) {
      this.fields.product_cat.push(slug);
    }

    return isSelected;
  },

  isAttributeChecked(attribute_name, slug) {
    const attribute = this.params.get("filter_" + attribute_name);

    if (!attribute) {
      return false;
    }

    const selected = attribute.split(",");
    const isSelected = selected.includes(slug);

    if (isSelected) {
      if (!this.fields.attributes[attribute_name]) {
        this.fields.attributes[attribute_name] = [];
      }

      this.fields.attributes[attribute_name].push(slug);
    }

    console.log(this.fields);

    return isSelected;
  },
});
