import Alpine from "alpinejs";
import intersect from "@alpinejs/intersect";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";
import { setup, disconnect } from "twind/shim";
import tippy from "./directive/tippy";

import miniCart from "./components/mini-cart";
import addToCart from "./components/add-to-cart";
import mobileMenu from "./components/mobile-menu";
import searchBar from "./components/search-bar";
import toast from "./components/toast";
import filters from "./components/shop/filters";

import { selleradise } from "./selleradise";

window.Alpine = Alpine;

// Plugins
Alpine.plugin(intersect);
Alpine.plugin(collapse);
Alpine.plugin(focus);

// Store
Alpine.store("miniCart", miniCart);
Alpine.store("mobileMenu", mobileMenu);
Alpine.store("toast", toast);

// Data
Alpine.data("addToCart", addToCart);
Alpine.data("searchBar", searchBar);
Alpine.data("shopFilters", filters);

// Directives
Alpine.directive("tippy", tippy);

// Initiate
Alpine.start();

// twind
setup({
  target: document.querySelector("body"),
});

disconnect();

// Old

// import { createApp } from "@vue/runtime-dom";

window.Selleradise = selleradise();

//Header
// import Header from "./components/Header";
// import TriggerSearch from "./components/Header/TriggerSearch";
// import TriggerAccount from "./components/Header/TriggerAccount";
// import TriggerSettings from "./components/Header/TriggerSettings";
// import TriggerCart from "./components/Header/TriggerCart";
// import TriggerMobileMenu from "./components/Header/TriggerMobileMenu";
// import TriggerCategories from "./components/Header/TriggerCategories";
// import HeaderSearch from "./components/HeaderSearch";
// import MobileMenu from "./components/MobileMenu";
// import MiniCart from "./components/MiniCart";

//Core
// import AddToCart from "./components/AddToCartTextual.vue";
// import AddToCartIcon from "./components/AddToCartIcon.vue";
// import SaleTimer from "./components/SaleTimer.vue";
// import Toast from "./components/Toast.vue";
// import Filters from "./components/shop/Filters.vue";
// import Overlay from "./components/Overlay.vue";
// import SelectOrder from "./components/SelectOrder.vue";

// Create App
// const RootComponent = {};
// const app = createApp(RootComponent);

// Header
// app.component("selleradise-header", Header);
// app.component("header-search", HeaderSearch);
// app.component("mobile-menu", MobileMenu);
// app.component("mini-cart", MiniCart);
// app.component("trigger-search", TriggerSearch);
// app.component("trigger-account", TriggerAccount);
// app.component("trigger-settings", TriggerSettings);
// app.component("trigger-cart", TriggerCart);
// app.component("trigger-mobile-menu", TriggerMobileMenu);
// app.component("trigger-categories", TriggerCategories);

// app.component("add-to-cart-icon", AddToCartIcon);
// app.component("add-to-cart", AddToCart);
// app.component("shop-filters", Filters);
// app.component("sale-timer", SaleTimer);
// app.component("selleradise-toast", Toast);
// app.component("overlay", Overlay);
// app.component("shop-select-order", SelectOrder);

// app.directive("tippy", {
//   beforeMount(el, binding, vnode) {
//     tippy(el, {
//       animation: "shift-away",
//       theme: "primary",
//       trigger: "mouseenter focus",
//       touch: ["hold", 300],
//       content: function () {
//         return binding.value;
//       },
//     });
//   },
// });

// app.config.isCustomElement = (tag) => {
//   return ["acronym", "big", "strike", "tt"].includes(tag);
// };

window.Selleradise.relocateInlineScriptAndStyle();

// const vm = app.mount("#page");

window.Selleradise.focusSource();
window.Selleradise.onWindowLoad();
window.Selleradise.initializeTippy();
window.Selleradise.initializeHeadroom();
window.Selleradise.lazyLoad();
window.Selleradise.scrollProgress();
window.Selleradise.smoothScroll();
window.Selleradise.loginFormSwitcher();
window.Selleradise.selleradiseNumberInput();
window.Selleradise.categoriesInProductPageLoop();
window.Selleradise.wooCommerceEvents();
window.Selleradise.productPageTabs();
window.Selleradise.scrollTrigger();
window.Selleradise.adaptiveColors();
