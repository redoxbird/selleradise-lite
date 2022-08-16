export default (el, { expression }, { evaluate, effect }) => {
  const instance = tippy(el, {
    content: evaluate(expression),
    animation: "shift-away",
    theme: "primary",
    trigger: "mouseenter focus",
    touch: ["hold", 300],
    onShow(instance) {
      el.addEventListener("keyup", (e) => {
        if (e.code === "Escape") {
          if (instance.state.isShown) {
            instance.hide();
          }
        }
      });
    },
  });

  effect(() => {
    instance.setContent(evaluate(expression));
  });
};
