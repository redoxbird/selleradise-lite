<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (isset($args)) {
  extract($args);
}

?>

<ul <?php if ($parent) : ?> x-show="activeChild == true" class="m-0 p-0 pl-3 w-full text-sm font-medium border-0 border-l-1 border-solid border-l-zinc-200" x-collapse <?php else : ?> class="m-0 px-page w-full text-md" <?php endif; ?>>

  <?php foreach ($items as $item) : ?>
    <li class="list-none flex justify-between flex-wrap items-center w-full" x-data="{activeChild: false}">

      <label class="flex justify-start items-center flex-1 py-2 my-2 font-primary font-semibold focus-within:text-primary rounded-full" for="<?php echo $item['slug']; ?>">
        <input type="checkbox" id="<?php echo $item['slug']; ?>" value="<?php echo $item['slug']; ?>" x-bind:checked="isCategoryChecked('<?php echo esc_attr($item['slug']); ?>')" x-on:change="handleCategoryChange($event)" />
        <span><?php echo $item['name']; ?></span>
      </label>

      <?php if (isset($item['children']) && !empty($item['children'])) : ?>
        <button class="w-8 h-8 flex justify-center items-center py-2 bg-gray-50 border-1 border-gray-300 border-0 rounded-full" x-on:click.prevent="activeChild = !activeChild" aria-label="<?php echo esc_html(__("Open", "charlesrwood") . ' ' . $item['name']); ?>">
          <template x-if="!activeChild">
            <span class="w-5 h-auto">
              <?php echo selleradise_svg("unicons-line/angle-down"); ?>
            </span>
          </template>
          <template x-if="activeChild">
            <span class="w-5 h-auto">
              <?php echo selleradise_svg("unicons-line/angle-up"); ?>
            </span>
          </template>
        </button>

        <?php
        get_template_part(
          "template-parts/pages/shop/partials/categories-checkbox-tree",
          null,
          ["items" => $item['children'], "level" => $level + 1, "parent" => $item]
        );
        ?>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>