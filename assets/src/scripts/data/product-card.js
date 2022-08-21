import EmblaCarousel from "embla-carousel";
import { throttle } from "lodash-es";

export default () => ({
  embla: null,
  width: 300,

  init() {
    this.initEmbla();

    this.$nextTick(() => {
      this.setWidth();
    });

    window.addEventListener(
      "resize",
      throttle(() => {
        this.setWidth();
      }, 500)
    );
  },

  initEmbla() {
    if (!this.$refs.images) {
      return;
    }
    const options = { loop: false };

    window.addEventListener("load", () => {
      this.embla = EmblaCarousel(this.$refs.images, options);
    });
  },

  emblaPrev() {
    this.embla?.scrollPrev();
  },

  emblaNext() {
    this.embla?.scrollNext();
  },

  setWidth() {
    this.width = this.$el.offsetWidth;
  },
});
