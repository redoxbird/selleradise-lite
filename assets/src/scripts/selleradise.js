import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
import { calculateContrastRatioLuminance, device, luminance } from "./helpers";
import { menu } from "./main/menu";
import { lazyLoad } from "./main/lazyload";
import Bricks from "bricks.js";
import { el, setChildren } from "redom";

export function selleradise() {
  /**
   * Variables.
   */

  const masonryInstance = {
    shop: null,
  };

  function onWindowLoad() {
    document.addEventListener("DOMContentLoaded", menu);
  }

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
   * A custom input number field with (+) and (-) buttons.
   */
  function selleradiseNumberInput() {
    const inputs = document.querySelectorAll("input[type='number']");

    const upButtonOriginal = document.querySelector(
      ".selleradise__input--number-icon--up"
    );

    const downButtonOriginal = document.querySelector(
      ".selleradise__input--number-icon--down"
    );

    if (inputs.length < 1 || !upButtonOriginal || !downButtonOriginal) {
      return;
    }

    for (const input of inputs) {
      input.classList.add("customInput--number");
      const upButton = upButtonOriginal.cloneNode(true);
      const downButton = downButtonOriginal.cloneNode(true);
      const min = input.getAttribute("min");
      const max = input.getAttribute("max");
      const step = input.getAttribute("step")
        ? parseInt(input.getAttribute("step"))
        : 1;
      const inputRef = ref(parseInt(input.value) || 0);

      upButtonOriginal.remove();
      downButtonOriginal.remove();

      upButton.removeAttribute("style");
      downButton.removeAttribute("style");

      input.insertAdjacentElement("afterend", upButton);
      input.insertAdjacentElement("beforebegin", downButton);

      if (input.value >= parseInt(max)) {
        upButton.setAttribute("disabled", true);
      }

      if (input.value <= parseInt(min)) {
        downButton.setAttribute("disabled", true);
      }

      watch(inputRef, (to, from) => {
        input.value = inputRef.value;
        input.dispatchEvent(new Event("change", { bubbles: true }));

        if (to >= parseInt(max)) {
          upButton.setAttribute("disabled", true);
        } else {
          upButton.removeAttribute("disabled");
        }

        if (to <= parseInt(min)) {
          downButton.setAttribute("disabled", true);
        } else {
          downButton.removeAttribute("disabled");
        }
      });

      upButton.addEventListener("click", (e) => {
        e.preventDefault();
        let currentValue = parseInt(input.value) || 0;
        if (!max || currentValue < parseInt(max)) {
          inputRef.value = currentValue + step;
        }
      });

      downButton.addEventListener("click", (e) => {
        e.preventDefault();
        let currentValue = parseInt(input.value);
        if (currentValue > parseInt(min)) {
          inputRef.value = currentValue - step;
        }
      });
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

  /**
   * This will extract color palette from image of elements.
   */

  function adaptiveColors() {
    const elements = document.querySelectorAll(".selleradise_adaptive_colors");

    if (elements.length < 1) {
      return;
    }

    const observer = scrollama();

    observer
      .setup({
        step: elements,
        offset: 0.9,
        once: true,
      })
      .onStepEnter((response) => {
        const { element, index, direction } = response;
        setAdaptiveColors(element);
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
    onWindowLoad,
    lazyLoad,
    smoothScroll,
    selleradiseNumberInput,
    categoriesInProductPageLoop,
    menu,
    productPageTabs,
    scrollTrigger,
    adaptiveColors,
    initiateMasonryLayout,
  };
}
