import { setDarkMode, setLightMode } from "./store/dark-mode";

const selleradiseHeader = {
  /**
   * set light or dark mode based on user setting.
   */

  checkDarkMode: () => {
    if (selleradiseData.theme.type == "both") {
      if (localStorage.getItem("darkMode") === "true") {
        setDarkMode();
      } else {
        setLightMode();
      }
    }
  },
};

selleradiseHeader.checkDarkMode();
