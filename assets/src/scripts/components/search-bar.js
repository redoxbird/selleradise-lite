import { searchService } from "../machines/search";

export default (props = {}) => ({
  state: "hidden",
  hidden: false,
  keyword: "",

  init() {
    searchService.onTransition((state) => {
      this.state = state.value;
    });

    console.log(this.$refs.searchForm);
  },

  startSearch() {
    searchService.send("START");
  },
  stopSearch() {
    searchService.send("STOP");
  },
  handleEnterPress(e) {
    if (this.keyword.length <= 2) {
      e.preventDefault();
    } else {
      console.log(this.$refs.searchForm);
      this.$refs.searchForm.submit();
    }
  },
  handleSubmitBlur() {
    ["not_found", "initiated"].includes(this.state) &&
      searchService.send("STOP");
  },
  isOpen() {
    return true;

    if (this.hidden === true) {
      return false;
    }

    return ["initiated", "found", "not_found", "searching"].includes(
      this.state
    );
  },
  clear() {
    this.keyword = "";
    this.$refs.searchForm.focus();
  },
});
