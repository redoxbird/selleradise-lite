import { device } from "./helpers";
import { lazyLoad } from "./main/lazyload";
import Bricks from "bricks.js";
import { el, setChildren } from "redom";
import scrollama from "scrollama";

export function selleradise() {
  /**
   * Variables.
   */

  const masonryInstance = {
    shop: null,
  };

  function focusSource() {
    const keys = ["Tab", "ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"];

    document.documentElement.setAttribute("data-focus-source", "initial");

    window.addEventListener("keyup", function (e) {
      if (keys.includes(e.code)) {
        document.documentElement.setAttribute("data-focus-source", "key");
      }
    });

    window.addEventListener("click", function (e) {
      document.documentElement.setAttribute("data-focus-source", "mouse");
    });
  }

  /**
   * Displays scroll progress on back to button.
   *
   * Button is located in @module views/footers/footer-default.php
   */

  /**
   * Enables smooth scroll on click on any element containing the class.
   */

  function smoothScroll(selector = ".selleradise_trigger_smoothscroll") {
    const triggers = document.querySelectorAll(selector);

    if (triggers.length < 1) {
      return;
    }

    for (const index in triggers) {
      if (triggers.hasOwnProperty.call(triggers, index)) {
        const button = triggers[index];
        let xPos = 0;
        let yPos = 0;
        let sectionSelector = null;

        if (button.getAttribute("data-smoothscroll-x")) {
          xPos = parseInt(button.getAttribute("data-smoothscroll-x"));

          if (isNaN(xPos)) {
            continue;
          }
        } else if (button.getAttribute("data-smoothscroll-y")) {
          yPos = parseInt(button.getAttribute("data-smoothscroll-y"));

          if (isNaN(yPos)) {
            continue;
          }
        } else {
          if (!button.href) {
            continue;
          }

          if (button.href.includes("#")) {
            sectionSelector = `#${button.href.split("#")[1]}`;
          } else if (button.href.includes(".")) {
            sectionSelector = `.${button.href.split(".")[1]}`;
          } else {
            continue;
          }

          const scrollToSection = document.querySelector(sectionSelector);

          if (!scrollToSection) {
            continue;
          }

          xPos = scrollToSection.offsetLeft;
          yPos = scrollToSection.offsetTop;
        }

        button.addEventListener("click", function (e) {
          e.preventDefault();

          window.scrollTo({
            left: xPos,
            top: yPos,
            behavior: "smooth",
          });
        });
      }
    }
  }

  /**
   * modify category tag in product loop
   */

  function categoriesInProductPageLoop() {
    let productsList = document.querySelector(
      ".selleradise_shop__products-list"
    );
    let shopHead = document.querySelector(".selleradise_shop__head");
    let categories = document.querySelectorAll(".product-category");

    if (!productsList || !shopHead || categories.length <= 0) {
      return;
    }

    for (const index in categories) {
      if (categories.hasOwnProperty.call(categories, index)) {
        const category = categories[index];

        category.style.setProperty("--data-selleradise-item-index", index);
      }
    }

    let ul = el("ul.selleradise_shop__categories");

    setChildren(ul, categories);

    shopHead.insertAdjacentElement("beforeend", ul);
  }

  /**
   * Initialize woocommerce events.
   */

  // function wooCommerceEvents() {
  //   if (!jQuery) {
  //     return;
  //   }

  //   const $ = jQuery;

  //   function update(e) {
  //     selleradiseNumberInput();

  //     const bodyElement = document.querySelector("body");
  //   }

  //   $("body").on("updated_wc_div", update);

  //   $(document).on("added_to_cart", update);
  // }

  /**
   * Add functionality to tabs in product page.
   */

  function productPageTabs() {
    let wrapper = document.querySelector(".selleradise_single_product__tabs");

    if (!wrapper) {
      return;
    }

    let tabs = wrapper.querySelectorAll("li");
    let activeTab = null;

    if (tabs.length < 1) {
      return;
    }

    let panels = [];

    for (const tab of tabs) {
      const anchor = tab.querySelector("a");
      const panel = document.querySelector(
        `#${tab.getAttribute("aria-controls")}`
      );

      if (!anchor) {
        continue;
      }

      if (!panel) {
        tab.classList.add("hide");
        continue;
      }

      anchor.addEventListener("click", function (e) {
        e.preventDefault();

        const rect = panel.getBoundingClientRect();
        const rectBody = document.body.getBoundingClientRect();

        window.scrollTo({
          left: 0,
          top: rect.top - rectBody.top,
          behavior: "smooth",
        });
      });

      panels.push(panel);
    }

    const observer = scrollama();
    observer
      .setup({
        step: panels,
        offset: 0.25,
      })
      .onStepEnter((response) => {
        const { element, index, direction } = response;

        if (index > 0) {
          wrapper.classList.add("selleradise_single_product__tabs--show");
        } else {
          wrapper.classList.remove("selleradise_single_product__tabs--show");
        }

        activeTab = wrapper.querySelector(`li[aria-controls="${element.id}"]`);

        activeTab.classList.add("active");
        activeTab.setAttribute("aria-selected", true);

        wrapper.scrollTo({
          left: activeTab.offsetLeft,
          behavior: "smooth",
        });
      })
      .onStepExit((response) => {
        const { element, index, direction } = response;

        activeTab = wrapper.querySelector(`li[aria-controls="${element.id}"]`);

        activeTab.classList.remove("active");
        activeTab.setAttribute("aria-selected", false);
      });

    window.addEventListener("resize", observer.resize);
  }

  /**
   * Add attribute and event to any element containing the given class when it comes in view port.
   */

  function scrollTrigger(selector = ".selleradise_scroll_animate") {
    const elements = document.querySelectorAll(selector);

    if (elements.length < 1) {
      return;
    }

    var isVisible = new CustomEvent("selleradise-scroll-entered");

    const observer = scrollama();

    observer
      .setup({
        step: elements,
        offset: 0.9,
        once: true,
      })
      .onStepEnter((response) => {
        const { element, index, direction } = response;

        element.setAttribute("data-scroll-direction", direction);
        element.setAttribute("data-scroll-entered", true);
        element.dispatchEvent(isVisible);
      });

    window.addEventListener("resize", observer.resize);
  }

  function initiateMasonryLayout() {
    if (device("mobile")) {
      return;
    }

    const shop = document.querySelector(
      '.selleradise_shop[data-selleradise-image-cropping="uncropped"]'
    );

    if (!shop) {
      return;
    }

    if (
      ["robust", "robust-alt", "list"].includes(
        shop.dataset.selleradiseCardType
      )
    ) {
      return;
    }

    const container = shop.querySelector(".selleradise_shop__products-list");

    if (!container) {
      return;
    }

    const sizes = {
      default: [
        { columns: 1, gutter: 10 },
        { mq: "768px", columns: 2, gutter: 25 },
        { mq: "1024px", columns: 3, gutter: 50 },
      ],
      compact: [
        { columns: 2, gutter: 10 },
        { mq: "768px", columns: 3, gutter: 25 },
        { mq: "1024px", columns: 5, gutter: 40 },
      ],
      offscreen: [
        { columns: 1, gutter: 10 },
        { mq: "768px", columns: 2, gutter: 25 },
        { mq: "1024px", columns: 4, gutter: 50 },
      ],
    };

    let sizeToUse = "default";

    if (shop.dataset.selleradiseSidebarType === "offscreen") {
      sizeToUse = "offscreen";
    }

    if (shop.dataset.selleradiseCardType === "compact") {
      sizeToUse = "compact";
    }

    masonryInstance.shop = Bricks({
      container: container,
      packed: "data-packed",
      position: false,
      sizes: sizes[sizeToUse],
    });

    document.addEventListener("DOMContentLoaded", (e) => {
      masonryInstance.shop.resize(true).pack();
    });
  }

  return {
    masonryInstance,
    focusSource,
    lazyLoad,
    smoothScroll,
    categoriesInProductPageLoop,
    productPageTabs,
    scrollTrigger,
    initiateMasonryLayout,
  };
}
