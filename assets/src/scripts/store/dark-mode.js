import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";

export const darkMode = ref(selleradiseData.theme.darkMode);

watch(darkMode, (to, from) => {
  if (to) {
    setDarkMode();
  } else {
    setLightMode();
  }
});

window.addEventListener("load", (e) => {
  if (localStorage.getItem("darkMode") === "true") {
    darkMode.value = true;
  } else {
    darkMode.value = false;
  }
});

export function setDarkMode() {
  if (selleradiseData.theme.type != "both") {
    return;
  }

  document.documentElement.setAttribute("data-selleradise-theme-type", "dark");

  darkMode.value = true;
  localStorage.setItem("darkMode", true);
  document.cookie = "darkMode=" + true;
}

export function setLightMode() {
  if (selleradiseData.theme.type != "both") {
    return;
  }

  document.documentElement.setAttribute("data-selleradise-theme-type", "light");

  darkMode.value = false;
  localStorage.setItem("darkMode", false);
  document.cookie = "darkMode=" + false;
}
