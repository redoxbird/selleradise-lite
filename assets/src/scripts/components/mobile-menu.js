import { mobileMenuService } from "../machines/mobile-menu";

export default {
  state: "",
  activeSidebar: "menu",

  async init() {
    mobileMenuService.onTransition((state) => {
      this.state = state.value;
    });
  },

  isOpen() {
    return ["visible", "changing"].includes(this.state);
  },

  open(active) {
    this.activeSidebar = active;
    mobileMenuService.send("OPEN");
  },

  close() {
    mobileMenuService.send("CLOSE");
  },
};
