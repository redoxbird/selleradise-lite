import EmblaCarousel from "embla-carousel";

export default () => ({
  embla: null,
  emblaInitCount: 0,

  init() {
    this.initEmbla();
  },

  initEmbla() {
    if (!this.$refs.images) {
      return;
    }
    const options = { loop: false };

    this.embla = EmblaCarousel(this.$refs.images, options);
  },

  emblaPrev() {
    this.embla?.scrollPrev();
  },

  emblaNext() {
    if (this.emblaInitCount < 1) {
      this.embla.reInit();
      this.emblaInitCount++;
    }

    this.embla?.scrollNext();
  },
});
