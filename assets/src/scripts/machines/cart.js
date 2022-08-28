import { createMachine, interpret } from "xstate";

export const cartMachine = createMachine(
  {
    id: "miniCart",
    initial: "hidden",
    context: {
      hashChangeListener: null,
    },
    states: {
      hidden: {
        on: {
          OPEN: {
            target: "visible",
            actions: ["addHash"],
          },
        },
      },
      visible: {
        on: {
          CLOSE: {
            target: "hidden",
            actions: ["removeHash"],
          },
          UPDATE: "updating",
        },
      },
      updating: {
        on: {
          DONE: "visible",
        },
      },
    },
  },
  {
    actions: {
      addHash: (context, event) => {
        window.location.hash = "#mini-cart";

        context.hashChangeListener = function name(e) {
          if (!location.hash) {
            cartService.send("CLOSE");
          }
        };

        window.addEventListener("hashchange", context.hashChangeListener);
      },
      removeHash: (context, event) => {
        history.replaceState(null, null, " ");

        if (context.hashChangeListener) {
          window.removeEventListener("hashchange", context.hashChangeListener);
        }
      },
    },
  }
);

export const cartService = interpret(cartMachine).start();
