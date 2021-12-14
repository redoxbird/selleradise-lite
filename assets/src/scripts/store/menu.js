import { ref, shallowRef } from "@vue/reactivity";

export let haveSettings = false;
export const mobileMenuItems = shallowRef([]);
export const categoriesTree = shallowRef([]);
export const menuItemsLoaded = ref(false);
export const categoriesLoaded = ref(false);
export const childMenuIds = ref([]);
export const categorySubMenuIds = ref([]);
export const activeSidebar = ref("menu");

export async function updateMenuItems() {
  try {
    const response = await axios({
      method: "get",
      url: selleradiseData.ajaxURL,
      params: {
        action: "selleradise_get_menu_items",
        nonce: selleradiseData.nonce,
      },
    });

    if (response.data && response.data.length > 0) {
      mobileMenuItems.value = response.data;
      menuItemsLoaded.value = true;
    }
  } catch (error) {
    console.error(error);
  }
}

export async function updateCategories() {
  try {
    const response = await axios({
      method: "get",
      url: selleradiseData.ajaxURL,
      params: {
        action: "selleradise_get_categories",
        nonce: selleradiseData.nonce,
      },
    });

    if (response.data && response.data.length > 0) {
      categoriesTree.value = response.data;
      categoriesLoaded.value = true;
    }
  } catch (error) {
    console.error(error);
  }
}

if (Object.values(selleradiseData.settings).includes(true)) {
  haveSettings = true;
}
