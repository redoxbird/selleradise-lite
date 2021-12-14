<template>
  <transition name="selleradise_sidebar">
    <div
      class="selleradise_sidebar__account"
      v-show="activeSidebar === 'account'"
    >
      <slot name="info"></slot>
      <slot name="links"></slot>
    </div>
  </transition>
</template>

<script>
import { activeSidebar } from "../../store/menu";

export default {
  setup() {
    return {
      activeSidebar,
    };
  },
};
</script>
