import Alpine from "alpinejs";
import intersect from "@alpinejs/intersect";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";
import { setup, disconnect } from "twind/shim";
import tooltip from "./directive/tooltip";

import miniCart from "./store/mini-cart";
import mobileMenu from "./store/mobile-menu";
import toast from "./store/toast";
import addToCart from "./data/add-to-cart";
import header from "./data/header";
import searchBar from "./data/search-bar";
import filters from "./data/filters";
import backToTop from "./data/back-to-top";
import loginForm from "./data/login-form";
import productCard from "./data/product-card";
import productPage from "./data/product-page";

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
Alpine.data("header", header);
Alpine.data("addToCart", addToCart);
Alpine.data("searchBar", searchBar);
Alpine.data("shopFilters", filters);
Alpine.data("backToTop", backToTop);
Alpine.data("loginForm", loginForm);
Alpine.data("productCard", productCard);
Alpine.data("productPage", productPage);

// Directives
Alpine.directive("tooltip", tooltip);

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
window.Selleradise.lazyLoad();
window.Selleradise.smoothScroll();
window.Selleradise.selleradiseNumberInput();
window.Selleradise.categoriesInProductPageLoop();
window.Selleradise.productPageTabs();
window.Selleradise.scrollTrigger();
window.Selleradise.adaptiveColors();
