export default (
  el,
  { value, modifiers, expression },
  { Alpine, effect, cleanup }
) => {
  if (!value) return;
  else if (value === "src") handleSrc(el, Alpine, expression);
};

function handleSrc(el, Alpine, expression) {
  Alpine.bind(el, {
    "x-intersect.once"(e) {
      el.setAttribute("src", expression);

      el.addEventListener("load", () => {
        el.setAttribute("data-selleradise-status", "loaded");
      });
    },
  });
}
