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
import backToTop from "./components/back-to-top";

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
Alpine.data("backToTop", backToTop);

// Directives
Alpine.directive("tippy", tippy);

// Initiate
Alpine.start();

// twind
setup({
  target: document.querySelector("body"),
});

disconnect();

window.Selleradise = selleradise();
window.Selleradise.focusSource();
window.Selleradise.onWindowLoad();
window.Selleradise.initializeTippy();
window.Selleradise.initializeHeadroom();
window.Selleradise.lazyLoad();
window.Selleradise.smoothScroll();
window.Selleradise.loginFormSwitcher();
window.Selleradise.selleradiseNumberInput();
window.Selleradise.categoriesInProductPageLoop();
window.Selleradise.wooCommerceEvents();
window.Selleradise.productPageTabs();
window.Selleradise.scrollTrigger();
window.Selleradise.adaptiveColors();
