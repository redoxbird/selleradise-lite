import embla from "../data/embla";

export default (
  el,
  { value, modifiers, expression },
  { Alpine, effect, cleanup }
) => {
  if (!value) handleRoot(el, Alpine);
  else if (value === "next") handleNext(el, Alpine);
  else if (value === "prev") handlePrev(el, Alpine);
};

function handleRoot(el, Alpine) {
  Alpine.bind(el, {
    "x-data": embla,
  });
}

function handleNext(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.embla?.scrollNext();
    },
  });
}

function handlePrev(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.embla?.scrollPrev();
    },
  });
}
