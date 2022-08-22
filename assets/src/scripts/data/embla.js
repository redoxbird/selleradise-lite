import EmblaCarousel from "embla-carousel";

export default (props) => ({
  embla: null,

  init() {
    this.initEmbla();
  },

  initEmbla() {
    if (!this.$el) {
      return;
    }

    const options = props || { loop: false };

    window.addEventListener("load", () => {
      this.embla = EmblaCarousel(this.$el, options);
    });
  },

  emblaPrev() {
    this.embla?.scrollPrev();
  },

  emblaNext() {
    this.embla?.scrollNext();
  },
});
