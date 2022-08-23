import * as colors from "twind/colors";

export default {
  target: document.querySelector("body"),
  variants: {
    "is-parent-active": ".is-active &",
    "is-active": "&.is-active",
  },
  theme: {
    extend: {
      borderWidth: {
        1: "0.1rem",
      },
      colors: {
        ...colors,
        accent: {
          500: "var(--selleradise-color-accent-light)",
          900: "var(--selleradise-color-accent-light-text)",
        },
        background: {
          50: "var(--selleradise-color-background)",
          100: "rgba(var(--selleradise-color-background-rgb), 0.1)",
          200: "rgba(var(--selleradise-color-background-rgb), 0.2)",
        },
        main: {
          500: "var(--selleradise-color-main)",
        },
        text: {
          100: "rgba(var(--selleradise-color-text-rgb), 0.1)",
          200: "rgba(var(--selleradise-color-text-rgb), 0.2)",
          300: "rgba(var(--selleradise-color-text-rgb), 0.3)",
          700: "rgba(var(--selleradise-color-text-rgb), 0.7)",
          900: "var(--selleradise-color-text)",
        },
      },
      transitionDuration: {
        400: "400ms",
      },
      transitionTimingFunction: {
        "out-expo": "cubic-bezier(0.19, 1, 0.22, 1)",
      },
      fontSize: {
        md: "1rem",
        "10xl": "10rem",
      },
      padding: {
        page: "var(--page-padding)",
      },
      gridTemplateRows: {
        8: "repeat(8, minmax(0, 1fr))",
      },
      spacing: {
        128: "32rem",
        144: "36rem",
        160: "40rem",
        168: "42rem",
      },
      height: {
        ratio: "calc(var(--width) * var(--product-image-ratio))",
        "ratio-padded":
          "calc((var(--width) - 1rem) * var(--product-image-ratio))",
      },
      minHeight: {
        "screen-adjusted": "var(--hero-height)",
      },
      boxShadow: {
        "3xl": "0 3.6em 3.6em -2.7em var(--selleradise-color-shadow)",
      },
      zIndex: {
        1000: "1000",
        1001: "1001",
      },
    },
  },
};
