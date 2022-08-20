export default () => ({
  min: 1,
  step: 1,
  max: null,
  canIncrease: true,
  canDecrease: true,

  init() {
    this.min = this.$refs.input.getAttribute("min")
      ? parseInt(this.$refs.input.getAttribute("min"))
      : 1;
    this.max = this.$refs.input.getAttribute("max")
      ? parseInt(this.$refs.input.getAttribute("max"))
      : null;
    this.step = this.$refs.input.getAttribute("step")
      ? parseInt(this.$refs.input.getAttribute("step"))
      : 1;
  },

  increase(e) {
    let currentValue = parseInt(this.$refs.input.value) || 0;

    if (this.canIncrease) {
      this.$refs.input.value = currentValue + this.step;
    }

    this.$refs.input.dispatchEvent(new Event("change", { bubbles: true }));

    this.setCanIncrease();
    this.setCanDecrease();
  },

  decrease(e) {
    let currentValue = parseInt(this.$refs.input.value);

    if (this.canDecrease) {
      this.$refs.input.value = currentValue - this.step;
    }

    this.$refs.input.dispatchEvent(new Event("change", { bubbles: true }));

    this.setCanIncrease();
    this.setCanDecrease();
  },

  setCanIncrease() {
    if (!this.max) {
      this.canIncrease = true;
      return;
    }
    this.canIncrease = this.$refs.input.value < parseInt(this.max);
  },

  setCanDecrease() {
    this.canDecrease = this.$refs.input.value > parseInt(this.min) + 1;
  },
});
