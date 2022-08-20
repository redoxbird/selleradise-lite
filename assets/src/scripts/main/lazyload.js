import scrollama from "scrollama";

/**
 * Lazy load images.
 */

export function lazyLoad(context = document) {
  const images = context.querySelectorAll(
    "[data-src]:not(.loading):not(.loaded):not(.selleradise_skip-lazy-load):not(.swiper-lazy)"
  );

  const backgroundImages = context.querySelectorAll(
    "[data-image-src]:not(.loading):not(.loaded)"
  );

  const observer = scrollama();

  if (images.length > 0) {
    observer
      .setup({
        step: images,
        once: true,
        offset: 0.45,
      })
      .onStepEnter((response) => {
        const { element, index, direction } = response;
        const dataSrc = element.getAttribute("data-src");

        if (!dataSrc) {
          return;
        }

        element.classList.add("loading");
        element.setAttribute("src", dataSrc);

        element.onload = function () {
          element.classList.remove("loading");
          element.classList.add("loaded");
          element.setAttribute("data-selleradise-status", "loaded");
        };
      });
  }

  const observerBack = scrollama();

  if (backgroundImages.length > 0) {
    observerBack
      .setup({
        step: backgroundImages,
        once: true,
        offset: 0.45,
      })
      .onStepEnter((response) => {
        const { element, index, direction } = response;
        const dataUrl = element.getAttribute("data-image-src");

        if (!dataUrl) {
          return;
        }

        element.classList.add("loading");

        if (dataUrl) {
          element.style.backgroundImage = `url(${dataUrl})`;
        }

        element.classList.add("loaded");
        element.classList.remove("loading");
      });
  }
}
