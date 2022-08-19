import { computePosition, flip, shift, offset } from "@floating-ui/dom";

export default (el, { expression }, { evaluate, effect }) => {
  const tooltip = document.getElementById(expression);

  if (!tooltip) {
    return;
  }

  function update() {
    computePosition(el, tooltip, {
      placement: el.dataset.tooltipPlacement || "top",
      middleware: [flip(), shift({ padding: 5 }), offset(6)],
    }).then(({ x, y }) => {
      Object.assign(tooltip.style, {
        left: `${x}px`,
        top: `${y}px`,
      });
    });
  }

  function showTooltip() {
    tooltip.style.display = "block";
    update();
  }

  function hideTooltip() {
    tooltip.style.display = "";
  }

  [
    ["mouseenter", showTooltip],
    ["mouseleave", hideTooltip],
    ["focus", showTooltip],
    ["blur", hideTooltip],
  ].forEach(([event, listener]) => {
    el.addEventListener(event, listener);
  });

  effect(() => {});
};
