<template>
  <transition name="selleradiseHeader__searchForm">
    <form
      role="search"
      :action="selleradiseData.homeURL"
      method="get"
      class="selleradiseHeader__searchForm"
      ref="searchForm"
      v-if="
        condition
          ? ['initiated', 'found', 'not_found', 'searching'].some(state.matches)
          : true
      "
    >
      <label>
        <span class="sr-only"> {{ trans("header-search-form-label") }}</span>
        <input
          type="text"
          :value="keyword"
          v-on:input="(e) => (keyword = e.target.value)"
          v-on:focus="send('START')"
          v-on:keydown.tab.shift="send('STOP')"
          v-on:keydown.enter="onPressEnter"
          class="searchField"
          ref="searchField"
          name="s"
          autocomplete="off"
          maxlength="50"
          minlength="2"
          :placeholder="trans('header-search-form-label')"
        />

        <button
          ref="searchClearButton"
          v-on:click.prevent="
            keyword = '';
            searchField.focus();
          "
          class="clear"
          v-show="keyword"
          aria-label="Clear"
          v-tippy="'Clear'"
        >
          <slot name="icon-close"></slot>
        </button>
      </label>

      <SelectCategory v-if="categoriesTree" />

      <button
        type="submit"
        ref="searchSubmitButton"
        v-on:blur="
          ['not_found', 'initiated'].some(state.matches) ? send('STOP') : false
        "
        v-on:keydown.tab.exact="send('STOP')"
        v-on:click="onPressEnter"
        aria-label="Submit"
        v-tippy="'Submit'"
      >
        <span class="inlineSVGIcon" v-if="state.matches('searching')">
          <slot name="icon-loader"></slot>
        </span>
        <span class="inlineSVGIcon" v-else>
          <slot name="icon-search"></slot>
        </span>
      </button>

      <div
        class="selleradiseHeader__searchResults"
        ref="selleradiseHeader__searchResults"
        v-show="['found', 'not_found', 'searching'].some(state.matches)"
        v-cloak
      >
        <ul class="selleradiseHeader__searchResults-inner">
          <li v-show="foundSuggestions">
            <ul
              class="selleradiseHeader__searchResults-suggestions--categories"
            >
              <li
                v-for="(category, i) in suggestions"
                :key="category.slug"
                :ref="
                  (el) => {
                    if (el) {
                      items['categories'][i] = el;
                    }
                  }
                "
              >
                <a
                  :href="category.link"
                  v-html="
                    category.is_duplicate_name && category.parent_term
                      ? `${category.name} (${category.parent_term.name})`
                      : category.name
                  "
                ></a>
              </li>
            </ul>
          </li>

          <li v-show="foundProducts">
            <ul class="selleradiseHeader__searchResults-suggestions--products">
              <li class="selleradiseHeader__searchResults-title">
                <h2 v-text="trans('Products')"></h2>
              </li>

              <li
                v-for="(product, i) in products"
                :key="product.guid"
                class="productItem"
                :ref="
                  (el) => {
                    if (el) {
                      items['products'][i] = el;
                    }
                  }
                "
              >
                <a :href="product.guid">
                  <div
                    class="image"
                    :style="{ backgroundImage: `url(${product.image_url})` }"
                  ></div>

                  <div class="content">
                    <h3
                      class="title"
                      :href="product.guid"
                      v-html="
                        highlightedSuggestion(product.post_title, keyword)
                      "
                    ></h3>
                    <span class="price" v-html="product.price"></span>
                  </div>
                </a>
              </li>
            </ul>
          </li>

          <li v-show="foundPosts">
            <ul class="selleradiseHeader__searchResults-suggestions--posts">
              <li class="selleradiseHeader__searchResults-title">
                <h2 v-text="trans('Other')"></h2>
              </li>
              <li
                v-for="(post, i) in posts"
                :key="post.link"
                :ref="
                  (el) => {
                    if (el) {
                      items['posts'][i] = el;
                    }
                  }
                "
              >
                <div class="content">
                  <a class="title" :href="post.link" v-text="post.title"></a>
                </div>
              </li>
            </ul>
          </li>

          <div class="nothingFound" v-if="state.matches('not_found')">
            <span
              class="inlineSVGIcon"
              v-html="
                require(`!svg-inline-loader!../../../dist/svg/misc/empty-state.svg`)
              "
            ></span>
            <p v-text="trans('Nothing Found')"></p>
          </div>
        </ul>
      </div>
    </form>
  </transition>
</template>

<script>
import debounce from "lodash/debounce";
import { trans, device } from "../helpers";
import { useSearchService } from "../machines/search";
import SelectCategory from "./SelectCategory";
import { computed, reactive, ref, toRefs } from "@vue/reactivity";
import {
  nextTick,
  onBeforeUpdate,
  onMounted,
  provide,
  watch,
} from "@vue/runtime-core";

import { showToast } from "../store/toast";
import { categoriesTree } from "../store/menu";

export default {
  props: ["hidden"],
  components: {
    SelectCategory,
  },
  setup(props) {
    const searchMachine = useSearchService();

    const keyword = ref("");
    const selectedCategory = ref({
      name: trans("header-search-dropdown"),
      term_id: 0,
      slug: false,
    });

    const searchField = ref(null);
    const searchForm = ref(null);
    const searchSubmitButton = ref(null);
    const searchClearButton = ref(null);
    const items = ref({
      products: [],
      categories: [],
      posts: [],
    });

    const isMobileAndTablet = ref(device("mobileAndTablet"));

    window.addEventListener(
      "resize",
      debounce(function () {
        isMobileAndTablet.value = device("mobileAndTablet");
      }, 300)
    );

    const condition = computed(() => {
      if (props.hidden === "true") {
        return true;
      }

      if (isMobileAndTablet.value) {
        return true;
      }
    });

    provide("category", selectedCategory);

    const searchState = reactive({
      suggestions: [],
      products: [],
      posts: [],

      foundSuggestions: computed(() => {
        return searchState.suggestions.length > 0;
      }),

      foundProducts: computed(() => {
        return searchState.products.length > 0;
      }),

      foundPosts: computed(() => {
        return searchState.posts.length > 0;
      }),
    });

    watch(keyword, (to, from) => {
      searchMachine.send("SEARCH");
      getResultsDebounced();
    });

    watch(selectedCategory, (to, from) => {
      searchMachine.send("SEARCH");
      getResults();
    });

    const getResultsDebounced = debounce(getResults, 500);

    function getResults() {
      axios
        .all([
          axios({
            method: "get",
            url: selleradiseData.ajaxURL,
            params: {
              action: "selleradise_search_terms",
              keyword: keyword.value,
              category: selectedCategory.value.term_id
                ? selectedCategory.value.term_id
                : 0,
              _wpnonce: selleradiseData["_wpnonce"],
            },
          }).then((responseSuggestion) => {
            searchState.suggestions = responseSuggestion.data.terms;
            searchState.products = responseSuggestion.data.products;
          }),

          axios({
            method: "get",
            url: selleradiseData.ajaxURL,
            params: {
              action: "selleradise_search_products",
              keyword: keyword.value,
              category: selectedCategory.value.slug
                ? selectedCategory.value.slug
                : 0,
              _wpnonce: selleradiseData["_wpnonce"],
            },
          }).then((responseProducts) => {
            addProductsToState(responseProducts.data);
          }),

          axios({
            method: "get",
            url: selleradiseData.ajaxURL,
            params: {
              action: "selleradise_search_posts",
              keyword: keyword.value,
              _wpnonce: selleradiseData["_wpnonce"],
            },
          }).then((responsePosts) => {
            searchState.posts = responsePosts.data;
          }),
        ])
        .then(() => {
          if (
            searchState.suggestions.length > 0 ||
            searchState.products.length > 0 ||
            searchState.posts.length > 0
          ) {
            searchMachine.send("FOUND");
            nextTick(() => {
              enableArrowNavigation();
            });
          } else {
            searchMachine.send("NOT_FOUND");
          }
        })
        .catch((error) => {
          searchMachine.send("NOT_FOUND");
        });
    }

    function addProductsToState(products) {
      searchState.products = [...products, ...searchState.products];
      searchState.products = searchState.products.filter(
        (product, index, self) =>
          index === self.findIndex((t) => t.id === product.id)
      );
    }

    function highlightedSuggestion(suggestion, keyword) {
      if (!keyword) {
        return suggestion;
      }

      let reKeyword;

      try {
        reKeyword = new RegExp(keyword, "gi");
      } catch {}

      if (reKeyword) {
        return suggestion.toString().replace(reKeyword, (matchedText) => {
          return `<em>${matchedText}</em>`;
        });
      }
      return;
    }

    function enableArrowNavigation() {
      const searchResultItems = document.querySelectorAll(
        ".searchField, .selleradiseHeader__searchResults li a, .selleradiseHeader__searchResults li button"
      );

      if (searchResultItems.length < 1) {
        return;
      }

      let currentIndex = 0;

      function gotoIndex(index) {
        if (index == searchResultItems.length) {
          index = 0;
        } else if (index < 0) {
          index = searchResultItems.length - 1;
        }
        searchResultItems[index].focus();
        currentIndex = index;
      }

      Array.prototype.forEach.call(searchResultItems, function (el) {
        el.addEventListener("keydown", function (event) {
          let preventDefault = false;
          switch (event.code) {
            case "ArrowDown":
              gotoIndex(currentIndex + 1);
              preventDefault = true;
              break;
            case "ArrowUp":
              gotoIndex(currentIndex - 1);
              preventDefault = true;
              break;
            case "Tab":
              if (event.shiftKey === false) {
                if (keyword.value) {
                  searchClearButton && searchClearButton.value.focus();
                } else {
                  searchSubmitButton && searchSubmitButton.value.focus();
                }
                preventDefault = true;
              } else {
                preventDefault = false;
              }
              break;
            case "Escape":
              gotoIndex(0);
              preventDefault = true;
              break;
          }
          if (preventDefault) {
            event.preventDefault();
          }
        });
      });
    }

    function onPressEnter(e) {
      if (keyword.value.length <= 2) {
        e.preventDefault();
        showToast(trans("header-search-from-error-digits"), "error", 1500);
      } else {
        searchForm.value.submit();
      }
    }

    onBeforeUpdate(() => {
      items.value = {
        products: [],
        categories: [],
        posts: [],
      };
    });

    onMounted(() => {
      window.addEventListener("keydown", function (e) {
        if (e.ctrlKey === true && e.code == "KeyK") {
          e.preventDefault();

          searchMachine.send("START");

          nextTick(() => {
            searchField.value.focus();
          });
        }

        if (e.code == "Escape") {
          searchMachine.send("STOP");
        }
      });
    });

    return {
      ...props,
      ...toRefs(searchState),
      ...searchMachine,
      trans,
      device,
      keyword,
      highlightedSuggestion,
      searchField,
      searchForm,
      searchSubmitButton,
      searchClearButton,
      items,
      selleradiseData,
      condition,
      selectedCategory,
      getResultsDebounced,
      categoriesTree,
      onPressEnter,
    };
  },
};
</script>
