export default () => ({
  active: "all",

  isActive(slugs) {
    return slugs.split(",").includes(this.active) || this.active === "all";
  },

  setActive(slug) {
    if (!slug) {
      return;
    }

    this.active = slug;
  },
});
