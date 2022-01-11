<template>
  <transition
    name="selleradise_shop__filters"
    :data-selleradise-sidebar-type="props.type"
  >
    <div
      v-show="show"
      :class="[
        'selleradise_shop__filters',
        sidebarType == 'offscreen'
          ? 'selleradise_shop__filters--offscreen'
          : null,
      ]"
    >
      <form method="get" ref="form" :action="selleradiseData.shopURL">
        <div
          class="selleradise_shop__filters-actions"
          v-if="formHaveSelectedValues"
          v-cloak
        >
          <button
            type="submit"
            class="selleradise_shop__filters-action-apply"
            v-text="trans('shop-filter-apply')"
          ></button>
          <a
            :href="selleradiseData.shopURL"
            class="selleradise_shop__filters-action-clear"
          >
            <slot name="icon-close"></slot>
            {{ trans("shop-filter-clear") }}
          </a>
        </div>

        <input
          type="hidden"
          name="product_cat"
          v-if="categoriesJoined"
          :value="categoriesJoined"
        />

        <input
          type="hidden"
          name="product_tag"
          v-if="tagsJoined"
          :value="tagsJoined"
        />

        <input
          type="hidden"
          name="min_price"
          v-if="minPrice"
          :value="minPrice"
        />

        <input
          type="hidden"
          name="max_price"
          v-if="maxPrice"
          :value="maxPrice"
        />
        <input
          type="hidden"
          name="selleradise_product_cat"
          v-if="categoriesSelectedJoined"
          :value="categoriesSelectedJoined"
        />
        <div
          class="hiddenAttributeInput"
          v-for="(attribute, key) in formRef.attributes"
          :key="key"
        >
          <input
            type="hidden"
            v-if="attribute.length > 0"
            :name="key"
            :value="attribute"
          />
        </div>

        <div class="selleradise_shop__filters-price">
          <div class="selleradise_shop__filters-price-head">
            <h3 class="selleradise_shop__filters-title">
              {{ trans("shop-filter-price") }}
            </h3>
            <div class="selleradise_shop__filters-price-values">
              <span v-text="currencySymbol + minPrice"></span>
              <span
                class="selleradise_shop__filters-price-values-divider"
              ></span>
              <span v-text="currencySymbol + maxPrice"></span>
            </div>
          </div>

          <div
            class="selleradise_shop__filters-price-slider"
            id="selleradise_shop__filters-price-slider"
          ></div>
        </div>

        <transition-group
          tag="div"
          class="categories"
          v-if="hasCategories"
          name="selleradise_shop__filters-categories-input"
        >
          <h3
            class="selleradise_shop__filters-title"
            key="selleradise_shop__filters-categories-title"
          >
            {{ trans("shop-filter-categories") }}
          </h3>

          <div
            class="inputWrap selleradise_shop__filters-categories-input"
            v-for="category in categories"
            :key="category.term_id"
            v-show="category.term_id != 0"
            :class="[
              formRef.categories_selected.includes(category.term_id) &&
                'highlight',
              category.parent != 0 && 'is-child',
            ]"
          >
            <input
              type="checkbox"
              v-bind:id="category.slug"
              v-model="formRef.categories"
              v-bind:value="category.slug"
              v-on:change="
                insertChildCategories(category, $event.target.checked)
              "
            />
            <label :for="category.slug" v-html="category.name"></label>
          </div>
        </transition-group>

        <div
          class="attributes"
          v-for="attribute in attributes"
          :key="attribute.attribute_id"
        >
          <h3 class="selleradise_shop__filters-title">
            {{ attribute.attribute_label }}
          </h3>

          <div
            class="inputWrap"
            v-for="value in attribute.attribute_values"
            :class="[value.color ? 'inputWrap--color' : undefined]"
            :key="value.term_id"
            :style="{
              '--swatch-color': value.color
                ? value.color
                : 'rgba(color(text-rgb), 0.05)',
            }"
          >
            <input
              type="checkbox"
              v-bind:id="value.slug"
              v-bind:value="value.slug"
              v-model="formRef.attributes[`filter_${attribute.attribute_name}`]"
            />
            <label
              :class="[value.color ? 'color' : undefined]"
              :for="value.slug"
              >{{ value.name }}</label
            >
          </div>
        </div>

        <div class="tags" v-if="hasTags">
          <h3 class="selleradise_shop__filters-title">{{ trans("Tags") }}</h3>

          <div class="inputWrap" v-for="tag in tags" :key="tag.term_id">
            <input
              type="checkbox"
              v-bind:id="tag.slug"
              v-model="formRef.tags"
              v-bind:value="tag.slug"
            />
            <label :for="tag.slug" v-html="tag.name"></label>
          </div>

          <button
            class="button--showAll"
            v-on:click.prevent="showAllTags()"
            v-if="!isShowingAllTags"
          >
            Show All {{ trans("Tags") }}
          </button>
        </div>

        <div class="selleradise_shop__filters-actions">
          <button
            type="submit"
            class="selleradise_shop__filters-action-apply"
            v-text="trans('shop-filter-apply')"
            v-if="formHaveSelectedValues"
            v-cloak
          ></button>
          <a
            :href="selleradiseData.shopURL"
            class="selleradise_shop__filters-action-clear"
            v-if="formHaveSelectedValues"
            v-cloak
          >
            <slot name="icon-close"></slot>
            {{ trans("shop-filter-clear") }}
          </a>
        </div>
      </form>
    </div>
  </transition>
</template>

<script>
import { trans, device } from "../../helpers";
import isEmpty from "lodash/isEmpty";
import isNumber from "lodash/isNumber";
import flatten from "lodash/flatten";
import take from "lodash/take";

import wNumb from "wnumb";
import { reactive, ref, toRefs, unref } from "@vue/reactivity";
import {
  computed,
  nextTick,
  onMounted,
  watch,
  watchEffect,
} from "@vue/runtime-core";

import * as overlay from "../../store/overlay";
import { categoriesTree } from "../../store/menu";

export default {
  props: [
    "productTags",
    "productAttributes",
    "productAttributesKeys",
    "highestPrice",
    "type",
    "currentCategory",
  ],
  setup(props) {
    const formRef = ref({
      categories: [],
      categories_selected: [],
      tags: [],
      min_price: "",
      max_price: "",
      attributes: props.productAttributesKeys,
    });

    const sidebarType = computed(() => {
      if (props.type === "offscreen" || device("mobileAndTablet")) {
        return "offscreen";
      }

      return props.type;
    });

    const state = reactive({
      categories: [],
      tags: take(props.productTags, 10),
      attributes: props.productAttributes,
      pageURL: null,
      priceFilterSlider: null,
      currencySymbol: selleradiseData.currencySymbol,
      categoriesJoined: computed(() => {
        return formRef.value.categories.join();
      }),
      categoriesSelectedJoined: computed(() => {
        return formRef.value.categories_selected.join();
      }),
      tagsJoined: computed(() => {
        return formRef.value.tags.join();
      }),
      minPrice: computed(() => {
        return formRef.value.min_price ? formRef.value.min_price.toString() : 0;
      }),
      maxPrice: computed(() => {
        return formRef.value.max_price
          ? formRef.value.max_price.toString()
          : props.highestPrice;
      }),
      hasTags: computed(() => {
        return !isEmpty(state.tags);
      }),
      hasCategories: computed(() => {
        return !isEmpty(state.categories);
      }),

      isShowingAllTags: computed(() => {
        return (
          state.tags.length > 0 &&
          state.tags.length === props.productTags.length
        );
      }),
      formHaveSelectedValues: computed(() => {
        return (
          !isEmpty(formRef.value.categories) ||
          !isEmpty(formRef.value.tags) ||
          !isEmpty(flatten(Object.values(formRef.value.attributes))) ||
          !isEmpty(formRef.value.min_price) ||
          isNumber(formRef.value.min_price) ||
          !isEmpty(formRef.value.max_price) ||
          isNumber(formRef.value.max_price)
        );
      }),
      show: sidebarType.value === "offscreen" ? false : true,
    });

    watchEffect(() => {
      if (categoriesTree && categoriesTree.value.length) {
        state.categories = [...unref(categoriesTree)];
        updateCheckedCategories();
      }
    });

    function updateFormValues() {
      state.pageURL = `${window.location.origin}${window.location.pathname}`;
      const urlParams = new URLSearchParams(window.location.search);

      if (!window.location.search) {
        return;
      }

      const formRefParamKeys = {
        product_cat: "categories",
        product_tag: "tags",
        selleradise_product_cat: "categories_selected",
      };

      for (const param of urlParams.entries()) {
        let paramRef = formRefParamKeys[param[0]];

        if (formRef.value.attributes.hasOwnProperty(param[0])) {
          formRef.value.attributes[param[0]] = param[1].split(",");
        } else if (formRef.value.hasOwnProperty(paramRef)) {
          formRef.value[paramRef] = param[1].split(",");
        } else if (formRef.value.hasOwnProperty(param[0])) {
          formRef.value[param[0]] = param[1].split(",");
        }
      }
    }

    function initializeRangeSlider() {
      var priceSlider = document.getElementById(
        "selleradise_shop__filters-price-slider"
      );

      state.priceFilterSlider = noUiSlider.create(priceSlider, {
        start: [
          formRef.value.min_price ? formRef.value.min_price : 0,
          formRef.value.max_price
            ? formRef.value.max_price
            : props.highestPrice,
        ],
        connect: true,
        step: 1,
        animate: true,
        animationDuration: 300,
        range: {
          min: [0],
          max: [props.highestPrice],
        },
        tooltips: [
          wNumb({ decimals: 0, prefix: state.currencySymbol }),
          wNumb({ decimals: 0, prefix: state.currencySymbol }),
        ],
      });
      changePriceFilterSlider();
    }

    function changePriceFilterSlider() {
      state.priceFilterSlider.on("change", (values, handle) => {
        var value = values[handle];

        if (handle) {
          formRef.value.max_price = Math.round(value);
        } else {
          formRef.value.min_price = Math.round(value);
        }
      });
    }

    function showAllTags() {
      state.tags = props.productTags;
    }

    function updateCheckedCategories() {
      for (const index in formRef.value.categories_selected) {
        if (
          formRef.value.categories_selected.hasOwnProperty.call(
            formRef.value.categories_selected,
            index
          )
        ) {
          const selected = state.categories.find(
            (x) =>
              x.term_id === parseInt(formRef.value.categories_selected[index])
          );

          if (!selected) {
            continue;
          }

          insertChildCategories(selected, true);
        }
      }
    }

    function insertChildCategories(selected, checked) {
      if (
        !checked &&
        formRef.value.categories_selected.includes(selected.term_id)
      ) {
        formRef.value.categories_selected =
          formRef.value.categories_selected.filter((item) => {
            return item !== selected.term_id;
          });
        return;
      }
      const currentIDs = state.categories.map((x) => x["term_id"]);

      if (!formRef.value.categories_selected.includes(selected.term_id)) {
        formRef.value.categories_selected.push(selected.term_id);
      }

      if (selected.children && selected.children.length < 1) {
        return;
      }

      const term_index = state.categories.findIndex(
        (x) => x.term_id === selected.term_id
      );
      const parent_index = state.categories.findIndex(
        (x) => x.term_id === selected.parent
      );

      if (parent_index >= 0) {
        formRef.value.categories = formRef.value.categories.filter((item) => {
          return item !== state.categories[parent_index].slug;
        });

        state.categories[parent_index]["highlight"] = true;
      }

      for (const index in selected.children) {
        if (selected.children.hasOwnProperty.call(selected.children, index)) {
          const category = selected.children[index];

          if (currentIDs.includes(category.term_id)) {
            continue;
          }
          state.categories.splice(term_index + 1, 0, category);
        }
      }
    }

    watch(
      () => state.show,
      (to, from) => {
        overlay.show.value = to;

        if (to) {
          window.addEventListener("keydown", function (e) {
            if (e.code === "Escape") {
              state.show = false;
            }
          });
        }
      }
    );

    function toggleFilters() {
      const triggers = document.querySelectorAll(
        ".selleradise_shop--default__sort-filtersTrigger, .selleradise_shop__orderby--dropdown-filters-trigger"
      );
      const target = document.querySelector(".selleradise_shop__filters");

      if (triggers.length < 1 || !target) {
        return;
      }

      for (const trigger of triggers) {
        if (sidebarType.value === "offscreen") {
          trigger.classList.add("showing");
        }

        trigger.addEventListener("click", function (e) {
          e.preventDefault();
          state.show = !state.show;

          overlay.index.value = 1350;

          overlay.onClick.value = () => {
            state.show = false;
          };

          target.setAttribute("tabindex", 0);

          nextTick(() => {
            target.focus();
            target.removeAttribute("tabindex");
          });
        });
      }
    }

    onMounted(() => {
      updateFormValues();
      initializeRangeSlider();
      toggleFilters();
    });

    return {
      ...toRefs(state),
      selleradiseData,
      props,
      formRef,
      sidebarType,
      trans,
      showAllTags,
      insertChildCategories,
    };
  },
};
</script>
