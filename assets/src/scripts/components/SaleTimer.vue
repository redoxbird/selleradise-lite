<template>
  <div class="selleradise_onsale--timer" v-if="startDate && endDate">
    <span class="selleradise_onsale--timer__dot"></span>
    <p class="selleradise_onsale--timer__title">{{ labels.period }} :</p>

    <div class="selleradise_onsale--timer__duration-outer">
      <div
        class="selleradise_onsale--timer__duration"
        v-for="(label, index) in ['days', 'hours', 'minutes', 'seconds']"
        :key="index"
      >
        <span class="selleradise_onsale--timer__time">{{
          duration[label].toLocaleString("en-US", {
            minimumIntegerDigits: 2,
            useGrouping: false,
          })
        }}</span>
        <span class="selleradise_onsale--timer__label">{{ label[0] }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import { onUnmounted, reactive, ref, watch } from "@vue/runtime-core";
import { intervalToDuration } from "date-fns";
import { trans } from "../helpers";

export default {
  props: ["endDate", "startDate"],
  setup(props) {
    const now = ref(Date.now());

    const startDate = ref(new Date(props.startDate));
    const endDate = ref(new Date(props.endDate));

    const duration = reactive({
      days: 0,
      hours: 0,
      minutes: 0,
      seconds: 0,
    });

    const labels = reactive({
      period: "",
    });

    let interval = setInterval(() => {
      now.value = Date.now();
    }, 1000);

    watch(now, (to, from) => {
      let date1 = now.value;
      let date2 = false;

      if (now.value > startDate.value) {
        date2 = endDate.value;
        labels.period = trans("product-sale-ends-in");
      } else {
        date2 = startDate.value;
        labels.period = trans("product-sale-starts-in");
      }

      if (endDate.value < now.value) {
        date2 = false;
        labels.period = trans("sale_has_ended");
      }

      if (!date2) {
        return;
      }

      const interval = intervalToDuration({
        start: date1,
        end: date2,
      });

      duration.days = interval.days;
      duration.hours = interval.hours;
      duration.minutes = interval.minutes;
      duration.seconds = interval.seconds;
    });

    onUnmounted(() => {
      clearInterval(interval);
    });

    return {
      ...props,
      labels,
      duration,
    };
  },
};
</script>
