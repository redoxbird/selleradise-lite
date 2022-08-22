export default (el) => {
  return (src) => {
    el.setAttribute("src", src);

    el.addEventListener("load", () => {
      el.setAttribute("data-selleradise-status", "loaded");
    });
  };
};
