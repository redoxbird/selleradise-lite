<template>
  <transition name="overlay">
    <div
      class="overlay"
      v-if="overlay.show.value"
      v-on:click="overlay.onClick.value()"
      :style="{ zIndex: overlay.index.value }"
    ></div>
  </transition>
</template>

<script>
import * as overlay from "../store/overlay";

export default {
  setup() {
    return {
      overlay,
    };
  },
};
</script>
