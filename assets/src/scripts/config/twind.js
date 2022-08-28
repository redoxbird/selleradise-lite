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
          text: "var(--selleradise-color-accent-light-text)",
          900: "var(--selleradise-color-accent-light)",
        },
        background: {
          50: "var(--selleradise-color-background)",
          100: "rgba(var(--selleradise-color-background-rgb), 0.1)",
          200: "rgba(var(--selleradise-color-background-rgb), 0.2)",
        },
        main: {
          text: "var(--selleradise-color-main-text)",
          100: "rgba(var(--selleradise-color-main-rgb), 0.1)",
          700: "rgba(var(--selleradise-color-main-rgb), 0.7)",
          800: "rgba(var(--selleradise-color-main-rgb), 0.9)",
          900: "var(--selleradise-color-main)",
        },
        text: {
          25: "rgba(var(--selleradise-color-text-rgb), 0.025)",
          50: "rgba(var(--selleradise-color-text-rgb), 0.05)",
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
        120: "30rem",
        128: "32rem",
        144: "36rem",
        160: "40rem",
        168: "42rem",
        176: "44rem",
      },
      width: {
        "1/10": "10%",
        "3/10": "30%",
        "9/20": "45%",
        "padding-adjusted": "calc(100% - (var(--page-padding) * 2))",
      },
      height: {
        ratio: "calc(var(--width) * var(--product-image-ratio))",
        "ratio-padded":
          "calc((var(--width) - 1rem) * var(--product-image-ratio))",
        "screen-adjusted": "calc(100vh - var(--header-height))",
      },
      minHeight: {
        "screen-adjusted": "calc(100vh - var(--header-height))",
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
