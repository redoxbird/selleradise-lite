export default {
  message: "",
  type: "info",
  isShowing: false,
  zIndex: 1000,
  timeout: null,

  show(message, type = "info", zIndex = 1000) {
    if (!message) {
      return;
    }

    this.isShowing = true;
    this.message = message;
    this.type = type;
    this.zIndex = zIndex;

    this.timeout = setTimeout(() => {
      this.hide();
    }, 10000);
  },

  hide() {
    this.isShowing = false;
    this.message = "";
    clearTimeout(this.timeout);
  },
};
