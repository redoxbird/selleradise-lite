const selleradiseFunctions = {
  photoswipe: {
    index: 0,
    instance: null,
    element: null,
    options: {
      escKey: true,
      arrowEl: true,
      index: parseInt(0, 10),
      showAnimationDuration: 400,
      getThumbBoundsFn: function (index) {
        let pageYScroll =
          window.pageYOffset || document.documentElement.scrollTop;
        let thumbnail =
            selleradiseFunctions.photoswipe.items[
              selleradiseFunctions.photoswipe.options.index
            ].el.querySelector("img"),
          rect = thumbnail.getBoundingClientRect();

        return {
          x: rect.left,
          y: rect.top + pageYScroll,
          w: rect.width,
        };
      },
    },
    items: [],
    init: (index) => {
      selleradiseFunctions.photoswipe.options.index = parseInt(index);

      selleradiseFunctions.photoswipe.instance = new PhotoSwipe(
        selleradiseFunctions.photoswipe.element,
        PhotoSwipeUI_Default,
        selleradiseFunctions.photoswipe.items,
        selleradiseFunctions.photoswipe.options
      );

      selleradiseFunctions.photoswipe.instance.listen(
        "afterChange",
        function () {
          selleradiseFunctions.sliders.single_product_images.slideTo(
            selleradiseFunctions.photoswipe.instance.getCurrentIndex()
          );
        }
      );

      selleradiseFunctions.photoswipe.instance.init();
    },
  },
  watch_variation_update: (slider, thumbs, pagination) => {
    if (!document.querySelector(".variations_form")) {
      return;
    }

    jQuery(".variations_form").on("found_variation", function (e, variation) {
      // Check if the image already exists

      for (const index in slider.slides) {
        if (Object.hasOwnProperty.call(slider.slides, index)) {
          const slide = slider.slides[index];

          if (slide.nodeType !== 1) {
            continue;
          }

          const sameImg = slide.querySelector(
            `img[src="${variation.image.src}"]`
          );

          if (sameImg) {
            slider.slideTo(index);
            return;
          }
        }
      }

      if (!variation.image) {
        return;
      }

      // Un-hide thumbs and pagination if hidden

      thumbs.el.classList.remove("hide");
      pagination.classList.remove("hide");

      // Create new slides

      const thumbSlide = thumbs.slides[0].cloneNode(true);
      const thumbImg = thumbSlide.querySelector("img");

      thumbImg.setAttribute("src", variation.image.src);
      thumbImg.setAttribute("height", variation.image.src_h);
      thumbImg.setAttribute("width", variation.image.src_w);
      thumbImg.setAttribute("title", variation.image.title);
      thumbImg.setAttribute("alt", variation.image.alt);
      thumbImg.setAttribute("data-src", variation.image.full_src);

      thumbs.appendSlide(thumbSlide);

      const slide = slider.slides[0].cloneNode(true);
      const img = slide.querySelector("img");

      img.setAttribute("src", variation.image.src);
      img.setAttribute("title", variation.image.title);
      img.setAttribute("alt", variation.image.alt);
      img.setAttribute("data-src", variation.image.full_src);
      img.setAttribute("height", variation.image.src_h);
      img.setAttribute("width", variation.image.src_w);

      slide.setAttribute("data-size-h", variation.image.src_h);
      slide.setAttribute("data-size-w", variation.image.src_w);

      slider.appendSlide(slide);

      img.addEventListener("load", function () {
        slider.slideTo(slider.slides.length - 1);
      });

      // Show photoswipe arrow if hidden

      selleradiseFunctions.photoswipe.options.arrowEl = true;

      // Update photoswipe items

      const anchor = slide.querySelector("a");

      // include only element nodes
      if (slide.nodeType !== 1) {
        return;
      }

      let item = {
        src: variation.image.full_src,
        w: parseInt(slide.getAttribute("data-size-w"), 10),
        h: parseInt(slide.getAttribute("data-size-h"), 10),
        el: slide,
      };

      selleradiseFunctions.photoswipe.items.push(item);

      // Add event listener to the slider image for photoswipe

      anchor.addEventListener("click", function (e) {
        e.preventDefault();
        selleradiseFunctions.photoswipe.init(slider.activeIndex);
      });
    });
  },
  sliders: {
    single_product_images: null,
    single_product_thumbs: null,
  },
};

selleradiseFunctions.sliders.single_product_thumbs = new Swiper(
  ".selleradise_single_product__thumbnails-slider",
  {
    spaceBetween: 10,
    slidesPerView: 3,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    lazy: {
      loadPrevNext: false,
    },
    breakpoints: {
      768: {
        slidesPerView: 4,
      },
    },
  }
);

selleradiseFunctions.sliders.single_product_images = new Swiper(
  ".selleradise_single_product__images-slider",
  {
    lazy: {
      loadPrevNext: false,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
    autoHeight: true,
    pagination: {
      el: ".selleradise_single_product__images-slider .swiper-pagination",
      type: "fraction",
    },
    navigation: {
      nextEl: ".selleradise_slider__nav--next",
      prevEl: ".selleradise_slider__nav--previous",
    },
    thumbs: {
      swiper: selleradiseFunctions.sliders.single_product_thumbs,
    },
    on: {
      init: function () {
        selleradiseFunctions.photoswipe.element =
          document.querySelectorAll(".pswp")[0];

        this.el.setAttribute("data-pswp-uid", 1);

        for (const index in this.slides) {
          const slide = this.slides[index];

          // include only element nodes
          if (slide.nodeType !== 1) {
            continue;
          }

          if (!slide) {
            continue;
          }

          const anchor = slide.querySelector("a");
          const smallImage = slide.querySelector("img");

          let item = {
            src: slide.querySelector("a").getAttribute("href"),
            w: parseInt(slide.getAttribute("data-size-w"), 10),
            h: parseInt(slide.getAttribute("data-size-h"), 10),
            el: slide,
          };

          if (smallImage) {
            item.msrc = smallImage.getAttribute("data-src");
          }

          selleradiseFunctions.photoswipe.items.push(item);

          anchor.addEventListener("click", function (e) {
            e.preventDefault();
            selleradiseFunctions.photoswipe.init(index);
          });
        }

        const pagination = this.el.querySelector(".selleradise_slider__nav");

        const thumbs = selleradiseFunctions.sliders.single_product_thumbs.el;

        if (this.slides.length <= 1) {
          selleradiseFunctions.photoswipe.options.arrowEl = false;

          if (thumbs) {
            thumbs.classList.add("hide");
          }

          if (pagination) {
            pagination.classList.add("hide");
          }
        }

        selleradiseFunctions.watch_variation_update(
          this,
          selleradiseFunctions.sliders.single_product_thumbs,
          pagination
        );
      },
    },
  }
);

const product_card_slider = new Swiper(".selleradise_productCard__slider", {
  preloadImages: false,
  autoHeight: true,
  lazy: {
    loadPrevNext: true,
  },
  pagination: {
    el: ".swiper-pagination",
    type: "fraction",
  },
  navigation: {
    nextEl: ".selleradise_slider__nav--next",
    prevEl: ".selleradise_slider__nav--previous",
  },
  on: {
    slideChangeTransitionEnd: (e) => {
      if (Selleradise.masonryInstance.shop) {
        Selleradise.masonryInstance.shop.resize(true).update().pack();
      }
    },
  },
});
