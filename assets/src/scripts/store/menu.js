import { computed, ref, shallowRef } from "vue";

export let haveSettings = false;
export const mobileMenuItems = shallowRef([]);
export const categoriesTree = shallowRef([]);
export const activeSidebar = ref("menu");

export const loaded = {
  categories: ref(false),
  mobileMenuItems: ref(false),
};

export const linkedIds = {
  category: ref([]),
  mobileMenu: ref([]),
};

export const active = {
  subcategoryID: computed(() => {
    return (
      linkedIds.category.value[linkedIds.category.value.length - 1] || null
    );
  }),
  submenuID: computed(() => {
    return (
      linkedIds.mobileMenu.value[linkedIds.mobileMenu.value.length - 1] || null
    );
  }),
};

export const elements = {
  list: ref(null),
  backButton: ref(null),
  category: {
    list: ref(null),
    backButton: ref(null),
  },
};

export function openChildren(item, key, element, ID) {
  if (!item.children) {
    return;
  }

  if (!linkedIds[key].value.includes(ID)) {
    linkedIds[key].value.push(ID);
    element.scrollIntoView({
      behavior: "smooth",
      block: "start",
      inline: "nearest",
    });
  }
}

export async function updateMenuItems() {
  try {
    const response = await axios({
      method: "get",
      url: selleradiseData.ajaxURL,
      params: {
        action: "selleradise_get_menu_items",
        _wpnonce: selleradiseData["_wpnonce"],
      },
    });

    if (response.data && response.data.length > 0) {
      mobileMenuItems.value = response.data;
      loaded.mobileMenuItems.value = true;
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
        _wpnonce: selleradiseData["_wpnonce"],
      },
    });

    if (response.data && response.data.length > 0) {
      categoriesTree.value = response.data;
      loaded.categories.value = true;
    }
  } catch (error) {
    console.error(error);
  }
}

if (Object.values(selleradiseData.settings).includes(true)) {
  haveSettings = true;
}
