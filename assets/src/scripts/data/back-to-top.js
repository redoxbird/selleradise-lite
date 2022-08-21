export default () => ({
  dashArray: 200,
  dashOffset: 0,

  init() {
    window.addEventListener("load", () => {
      this.dashArray = this.$refs.stroke?.getTotalLength();
    });
  },
});
