import { throttle } from "lodash-es";

export default () => ({
  width: 300,

  init() {
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

  setWidth() {
    this.width = this.$el.offsetWidth;
  },
});
