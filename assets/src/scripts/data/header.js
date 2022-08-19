import { throttle } from "lodash-es";

export default () => ({
  scroll: {
    x: 0,
    y: 0,
  },
  pin: false,
  notTop: false,
  init() {
    this.update(this.scroll);

    window.addEventListener(
      "scroll",
      throttle(() => {
        this.update(this.scroll);
      }, 250)
    );
  },

  update(prev) {
    this.scroll = {
      y: window.pageYOffset || document.documentElement.scrollTop,
      x: window.pageXOffset || document.documentElement.scrollLeft,
    };

    if (this.scroll.y > 0) {
      this.notTop = true;
    } else {
      this.notTop = false;
    }

    if (this.scroll.y > 100) {
      this.pin = true;
    }

    if (this.scroll.y < prev.y) {
      this.pin = false;
    }
  },
});
