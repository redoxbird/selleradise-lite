<template>
  <SwitchGroup>
    <div class="selleradise_switch">
      <SwitchLabel class="selleradise_switch__label">{{
        trans("mobile-menu-toggle-dark-mode")
      }}</SwitchLabel>
      <Switch v-model="darkMode"> </Switch>
    </div>
  </SwitchGroup>
</template>

<script>
import { darkMode } from "../store/dark-mode";
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue";
import { trans } from "../helpers";
export default {
  components: { Switch, SwitchGroup, SwitchLabel },
  setup() {
    return {
      darkMode,
      trans,
    };
  },
};
</script>
