import { interpret, Machine } from "xstate";

export const mobileMenuMachine = Machine(
  {
    id: "mobileMenu",
    initial: "hidden",
    context: {
      showingSubMenu: false,
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
          CHANGE: "changing",
        },
      },
      changing: {
        on: {
          DONE: "visible",
        },
      },
    },
  },
  {
    actions: {
      addHash: (context, event) => {
        window.location.hash = "#mobile-menu";

        context.hashChangeListener = function name(e) {
          if (!location.hash) {
            mobileMenuService.send("CLOSE");
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

export const mobileMenuService = interpret(mobileMenuMachine).start();
