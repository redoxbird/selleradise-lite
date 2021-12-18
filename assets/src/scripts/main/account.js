import { ref } from "@vue/reactivity";
import { watch } from "vue";

/**
 * Allows smooth transition between login adn register forms.
 */

export function loginFormSwitcher() {
  const accountForms = document.querySelectorAll(".selleradise_account-forms");

  if (accountForms.length < 1) {
    return;
  }

  for (const accountForm of accountForms) {
    const login = accountForm.querySelector(".selleradise_account-form--login");
    const register = accountForm.querySelector(
      ".selleradise_account-form--register"
    );

    if (!login || !register) {
      return;
    }

    const loginSwitcher = register.querySelector(
      ".selleradise_account-form__option button"
    );
    const registerSwitcher = login.querySelector(
      ".selleradise_account-form__option button"
    );

    if (!loginSwitcher || !registerSwitcher) {
      return;
    }

    const animations = {
      register: {
        targets: register,
        opacity: [0, 1],
        translateY: [100, 0],
        duration: 500,
        easing: "easeOutExpo",
        begin: () => {
          login.classList.add("hidden");
          register.classList.remove("hidden");
        },
      },
      login: {
        targets: login,
        opacity: [0, 1],
        translateY: [-100, 0],
        duration: 500,
        easing: "easeOutExpo",
        begin: () => {
          login.classList.remove("hidden");
          register.classList.add("hidden");
        },
      },
    };

    const hashToValues = {
      "#login": "login",
      "#register": "register",
    };

    let activeForm = ref("login");

    if (window.location.hash && hashToValues[window.location.hash]) {
      activeForm.value = hashToValues[window.location.hash];
      anime(animations[activeForm.value]);
    }

    watch(activeForm, (current, previous) => {
      window.location.hash = `#${current}`;
      anime(animations[current]);
    });

    registerSwitcher.addEventListener("click", function () {
      activeForm.value = "register";
    });

    loginSwitcher.addEventListener("click", function () {
      activeForm.value = "login";
    });
  }
}
