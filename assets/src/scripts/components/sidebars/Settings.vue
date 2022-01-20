<template>
  <transition name="selleradise_sidebar">
    <div name="settings" v-if="selleradiseData.haveSettings">
      <ul>
        <li
          class="themeToggle"
          v-if="selleradiseData.settings.dark_mode_setting"
        >
          <span>{{ trans("Theme") }}</span>
          <dark-mode-toggle-btn> </dark-mode-toggle-btn>
        </li>
      </ul>
    </div>
  </transition>
</template>

<script>
import DarkModeToggleBtn from "../DarkModeToggleBtn";
import { darkMode } from "../../store/dark-mode";
import Dropdown from "./Dropdown";
import { trans } from "../../helpers";
import { haveSettings } from "../../store/menu";

export default {
  components: {
    "dark-mode-toggle-btn": DarkModeToggleBtn,
    Dropdown,
  },
  setup() {
    return {
      selleradiseData,
      darkMode,
      haveSettings,
      localStorage,
      trans,
    };
  },
};
</script>
