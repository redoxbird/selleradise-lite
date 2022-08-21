import { throttle } from "lodash-es";

export default {
  direction: null,
  end: false,
  start: true,
  pin: false,
  progress: 0,
  height: 0,
  scroll: {
    y: 0,
    x: 0,
  },

  init() {
    this.update(this.scroll);

    window.addEventListener(
      "scroll",
      throttle(() => {
        this.update(this.scroll);
      }, 150)
    );
  },

  update(scroll) {
    this.scroll = {
      y: window.pageYOffset || document.documentElement.scrollTop,
      x: window.pageXOffset || document.documentElement.scrollLeft,
    };

    this.height =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;

    this.progress = this.scroll.y / this.height;

    this.start = this.scroll.y <= 0;
    this.direction = this.scroll.y < scroll.y ? "up" : "down";
    this.pin = this.scroll.y > 100 && this.direction === "up";
    this.end = this.scroll.y >= this.height;
  },
};
