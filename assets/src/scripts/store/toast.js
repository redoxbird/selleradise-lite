import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";

export const isToastShowing = ref(false);
export const toastMessage = ref("");
export const toastType = ref("info");
export const toastZIndex = ref(1000);

let timeout = null;

export function showToast(message, type = "info", index = 1000) {
  if (!message) {
    return;
  }

  isToastShowing.value = true;
  toastMessage.value = message;
  toastType.value = type;
  toastZIndex.value = index;

  timeout = setTimeout(() => {
    isToastShowing.value = false;
  }, 10000);
}

export function hideToast() {
  isToastShowing.value = false;
}

watch(isToastShowing, (to, from) => {
  if (to === false) {
    clearTimeout(timeout);
  }
});
