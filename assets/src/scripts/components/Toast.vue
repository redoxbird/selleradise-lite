<template>
  <transition name="selleradiseToast">
    <div
      class="selleradiseToast"
      :class="`selleradiseToast--${toastType}`"
      v-if="isToastShowing"
      role="alert"
      :style="{ zIndex: toastZIndex }"
    >
      <span v-html="toastMessage"></span>
      <button class="button--icon" v-on:click="hideToast()" ref="closeBtn">
        <slot name="icon-close"></slot>
      </button>
    </div>
  </transition>
</template>

<script>
import { nextTick, ref, watch } from "vue";
import {
  isToastShowing,
  toastMessage,
  toastType,
  hideToast,
  toastZIndex,
} from "../store/toast";

export default {
  setup(props) {
    const closeBtn = ref(null);

    // watch(isToastShowing, (to, from) => {
    //   if (isToastShowing) {
    //     nextTick(() => {
    //       closeBtn.value.focus();
    //     });
    //   }
    // });

    return {
      isToastShowing,
      toastMessage,
      toastType,
      hideToast,
      closeBtn,
      toastZIndex,
    };
  },
};
</script>
