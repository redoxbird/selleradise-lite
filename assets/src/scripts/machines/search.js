import { interpret, Machine } from "xstate";

export const searchMachine = Machine(
  {
    id: "searchForm",
    initial: "idle",
    context: {
      keyword: null,
      hashChangeListener: null,
    },
    states: {
      idle: {
        on: {
          START: {
            target: "initiated",
            actions: ["addHash"],
          },
        },
      },
      initiated: {
        on: {
          SEARCH: "searching",
        },
      },
      searching: {
        on: {
          FOUND: "found",
          NOT_FOUND: "not_found",
          FAILED: "error",
        },
      },
      found: {},
      not_found: {},
      error: {},
    },

    on: {
      SEARCH: "searching",
      STOP: {
        target: "idle",
        actions: ["removeHash"],
      },
    },
  },
  {
    actions: {
      addHash: (context, event) => {
        window.location.hash = "#search-form";

        context.hashChangeListener = function name(e) {
          if (!location.hash) {
            searchService.send("STOP");
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

export const searchService = interpret(searchMachine).start();
