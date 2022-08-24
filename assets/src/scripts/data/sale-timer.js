import { intervalToDuration } from "date-fns";
import { omit } from "lodash";

export default (props) => ({
  now: new Date(),
  interval: null,
  status: "",
  duration: {},
  saleFrom: new Date(props.saleFrom),
  saleTo: new Date(props.saleTo),

  init() {
    this.interval = setInterval(() => {
      this.now = new Date();
    }, 1000);

    this.$watch("now", () => {
      let date1 = this.now;
      let date2 = false;

      if (this.now > this.saleFrom) {
        date2 = this.saleTo;
        this.status = "started";
      } else {
        date2 = this.saleFrom;
        this.status = "starting";
      }

      if (this.saleTo < this.now) {
        date2 = false;
        this.status = "ended";
      }

      if (!date2) {
        return;
      }

      const duration = intervalToDuration({
        start: date1,
        end: date2,
      });

      this.duration = duration["months"] ? duration : omit(duration, "months");
    });
  },

  getDurationByLabel(label) {
    return this.duration[label]?.toLocaleString("en-US", {
      minimumIntegerDigits: 2,
      useGrouping: false,
    });
  },
});
