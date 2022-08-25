import { throttle } from "lodash-es";

export default () => ({
  width: 0,

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

    window.addEventListener("selleradise-widget-initialized", (e) => {
      if (!e.detail?.isEdit || !e.detail?.element?.contains(this.$el)) {
        return;
      }

      this.setWidth();
    });
  },

  setWidth() {
    this.width = this.$el.offsetWidth;
  },
});
