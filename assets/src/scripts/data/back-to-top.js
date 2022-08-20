import { throttle } from "lodash-es";
import scrollama from "scrollama";

export default () => ({
  dashArray: 0,
  dashOffset: 0,
  observer: null,
  resize: null,
  setDashOffset: null,

  init() {
    window.addEventListener("DOMContentLoaded", () => {
      this.dashArray = this.$refs.stroke?.getTotalLength();
      this.observer = scrollama();
      this.observe();
    });
  },

  observe() {
    if (!this.observer) {
      return;
    }

    this.setDashOffset = throttle((progress) => {
      this.dashOffset = this.dashArray - this.dashArray * progress;
    }, 250);

    this.observer
      .setup({
        step: document.body,
        offset: 1,
        progress: true,
      })
      .onStepProgress((response) => {
        const { progress } = response;

        if (!this.setDashOffset) {
          return;
        }

        this.setDashOffset(progress);
      });
  },
});
