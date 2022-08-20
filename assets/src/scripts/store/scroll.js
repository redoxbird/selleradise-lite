import scrollama from "scrollama";

export default {
  direction: null,
  end: false,
  start: true,
  pin: false,
  progress: 0,
  scroll: {
    y: 0,
    x: 0,
  },

  init() {
    window.addEventListener("DOMContentLoaded", () => {
      this.observer = scrollama();
      this.observe();
    });
  },

  observe() {
    if (!this.observer) {
      return;
    }

    this.observer
      .setup({
        step: document.body,
        progress: true,
      })
      .onStepProgress((data) => {
        this.scroll = {
          y: window.pageYOffset || document.documentElement.scrollTop,
          x: window.pageXOffset || document.documentElement.scrollLeft,
        };

        this.end = data.progress >= 0.9;
        this.start = this.scroll.y <= 0;
        this.direction = data.direction;
        this.pin = this.scroll.y > 100 && data.direction === "up";
        this.progress = data.progress;
      });
  },
};
