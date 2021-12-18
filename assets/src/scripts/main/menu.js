import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";

/**
 * Adds functionality to desktop menu.
 */

export function menu() {
  const menu = document.querySelector(
    "header.selleradiseHeader .selleradise_menu"
  );

  if (!menu) {
    return;
  }

  const root = menu.querySelector(".selleradise_menu__list");

  if (!root) {
    return;
  }

  const rootItems = menu.querySelectorAll(".selleradise_menu__list > li");

  if (rootItems.length < 1) {
    return;
  }

  let activeRootSubMenu = ref(null);

  watch(activeRootSubMenu, (to, from) => {
    if (from) {
      rootItems[from].classList.remove("opened");
      rootItems[from].querySelector("a").setAttribute("aria-expanded", false);
    }

    if (to) {
      rootItems[to].classList.add("opened");
      rootItems[to].querySelector("a").setAttribute("aria-expanded", true);
    }
  });

  for (const index in rootItems) {
    if (rootItems.hasOwnProperty.call(rootItems, index)) {
      const item = rootItems[index];
      const anchor = item.querySelector("a");
      const subMenu = item.querySelector(".selleradise_menu__sub-menu");

      if (!item.classList.contains("menu-item-has-children") || !subMenu) {
        continue;
      }

      subMenu.style.setProperty("--width", subMenu.offsetWidth + "px");

      redom.setAttr(anchor, {
        "aria-haspopup": true,
        "aria-expanded": true,
      });

      item.addEventListener("keydown", (e) => {
        switch (e.code) {
          case "ArrowDown":
            e.preventDefault();
            e.stopPropagation();
            activeRootSubMenu.value = index;
            return;

          case "ArrowUp":
            e.preventDefault();
            e.stopPropagation();
            activeRootSubMenu.value = null;
            item.classList.remove("opened");
            return anchor.focus();
        }
      });
    }
  }

  const subMenus = document.querySelectorAll(".selleradise_menu__sub-menu");

  if (subMenus.length < 1) {
    return;
  }

  for (const index in subMenus) {
    if (subMenus.hasOwnProperty.call(subMenus, index)) {
      const subMenu = subMenus[index];

      const subItems = subMenu.querySelectorAll("li.menu-item-has-children");

      if (subItems.length < 1) {
        continue;
      }

      for (const index in subItems) {
        if (subItems.hasOwnProperty.call(subItems, index)) {
          const item = subItems[index];
          const anchor = item.querySelector("a");

          item.addEventListener("mouseenter", function () {
            item.parentElement.classList.add("showing--sub-menu");
          });

          item.addEventListener("mouseleave", function () {
            item.parentElement.classList.remove("showing--sub-menu");
          });

          item.addEventListener("keydown", (e) => {
            switch (e.code) {
              case "ArrowRight":
                e.preventDefault();
                e.stopPropagation();
                item.classList.add("opened");
                item.parentElement.classList.add("showing--sub-menu");
                return;

              case "ArrowLeft":
                e.preventDefault();
                e.stopPropagation();
                item.classList.remove("opened");
                item.parentElement.classList.remove("showing--sub-menu");
                return anchor.focus();
            }
          });
        }
      }
    }
  }
}
