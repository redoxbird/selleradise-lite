import EmblaCarousel from "embla-carousel";

export default () => ({
  embla: null,
  emblaInitCount: 0,
  emblaThumbs: null,
  activeIndex: 0,

  init() {
    this.initEmbla();
  },

  initEmbla() {
    if (!this.$refs.images || !this.$refs.thumbs) {
      return;
    }

    this.embla = EmblaCarousel(this.$refs.images, { loop: false });
    this.emblaThumbs = EmblaCarousel(this.$refs.thumbs, {
      selectedClass: "",
      containScroll: "keepSnaps",
      dragFree: true,
    });

    this.embla.on("select", () => {
      this.setActiveIndex();
    });
  },

  onThumbClick(index) {
    if (!this.emblaThumbs.clickAllowed()) return;

    if (this.emblaInitCount < 1) {
      this.embla.reInit();
      this.emblaInitCount++;
    }

    this.embla.scrollTo(index);
  },

  setActiveIndex() {
    this.activeIndex = this.embla.internalEngine().index.get();
  },

  isInView(index) {
    return this.activeIndex === index;
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
