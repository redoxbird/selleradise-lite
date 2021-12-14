import { Machine, interpret } from "xstate";
import { useService } from "@xstate/vue";

export const cartMachine = Machine(
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
            actions: ["focusOpenButton", "removeHash"],
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
      focusOpenButton: (context, event) => {
        const trigger = document.querySelector(
          ".selleradiseHeader__trigger--miniCart"
        );

        if (!trigger) {
          return;
        }

        trigger.focus();
      },
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

export function useCartService() {
  return useService(cartService);
}
