import { createApp } from "@vue/runtime-dom";
import { selleradise } from "./selleradise";

window.Selleradise = selleradise();

//Header
import Header from "./components/Header";
import TriggerSearch from "./components/Header/TriggerSearch";
import TriggerAccount from "./components/Header/TriggerAccount";
import TriggerSettings from "./components/Header/TriggerSettings";
import TriggerCart from "./components/Header/TriggerCart";
import TriggerMobileMenu from "./components/Header/TriggerMobileMenu";
import TriggerCategories from "./components/Header/TriggerCategories";
import HeaderSearch from "./components/HeaderSearch";
import MobileMenu from "./components/MobileMenu";
import MiniCart from "./components/MiniCart";

//Core
import AddToCart from "./components/AddToCartTextual.vue";
import AddToCartIcon from "./components/AddToCartIcon.vue";
import SaleTimer from "./components/SaleTimer.vue";
import Toast from "./components/Toast.vue";
import Filters from "./components/shop/Filters.vue";
import Overlay from "./components/Overlay.vue";
import SelectOrder from "./components/SelectOrder.vue";

// Create App
const RootComponent = {};
const app = createApp(RootComponent);

// Header
app.component("selleradise-header", Header);
app.component("header-search", HeaderSearch);
app.component("mobile-menu", MobileMenu);
app.component("mini-cart", MiniCart);
app.component("trigger-search", TriggerSearch);
app.component("trigger-account", TriggerAccount);
app.component("trigger-settings", TriggerSettings);
app.component("trigger-cart", TriggerCart);
app.component("trigger-mobile-menu", TriggerMobileMenu);
app.component("trigger-categories", TriggerCategories);

app.component("add-to-cart-icon", AddToCartIcon);
app.component("add-to-cart", AddToCart);
app.component("shop-filters", Filters);
app.component("sale-timer", SaleTimer);
app.component("selleradise-toast", Toast);
app.component("overlay", Overlay);
app.component("shop-select-order", SelectOrder);

app.directive("tippy", {
  beforeMount(el, binding, vnode) {
    tippy(el, {
      animation: "shift-away",
      theme: "primary",
      trigger: "mouseenter focus",
      touch: ["hold", 300],
      content: function () {
        return binding.value;
      },
    });
  },
});

app.config.isCustomElement = (tag) => {
  return ["acronym", "big", "strike", "tt"].includes(tag);
};

Selleradise.relocateInlineScriptAndStyle();

const vm = app.mount("#page");

Selleradise.focusSource();
Selleradise.onWindowLoad();
Selleradise.initializeTippy();
Selleradise.initializeHeadroom();
Selleradise.lazyLoad();
Selleradise.scrollProgress();
Selleradise.smoothScroll();
Selleradise.loginFormSwitcher();
Selleradise.selleradiseNumberInput();
Selleradise.categoriesInProductPageLoop();
Selleradise.wooCommerceEvents();
Selleradise.productPageTabs();
Selleradise.scrollTrigger();
Selleradise.adaptiveColors();
