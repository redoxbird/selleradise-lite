export default (props) => ({
  total: props.total || 0,
  visible: props.pageSize || 4,

  more() {
    if (this.exhausted()) {
      return;
    }

    this.visible = this.visible + props.pageSize;
  },

  exhausted() {
    return this.total <= this.visible;
  },
});
