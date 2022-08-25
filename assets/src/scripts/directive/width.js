export default (
  el,
  { value, modifiers, expression },
  { Alpine, effect, cleanup }
) => {
  window.addEventListener("load", () => {
    setWidth();
  });

  window.addEventListener(
    "resize",
    Alpine.throttle(() => {
      setWidth();
    }, 500)
  );

  window.addEventListener("selleradise-widget-initialized", (e) => {
    if (!e.detail?.isEdit || !e.detail?.element?.contains(el)) {
      return;
    }

    setWidth();
  });

  function setWidth() {
    el.style.setProperty("--width", el.offsetWidth);
  }
};
