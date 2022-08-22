<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (isset($args)) {
  extract($args);
}

?>

<ul 
  <?php if ($parent) : ?> 
    x-show="activeChild == true" 
    x-collapse 
    class="m-0 p-0 pl-3 w-full text-sm font-medium border-0 border-l-1 border-solid border-l-gray-300" 
  <?php else : ?> 
    class="m-0 pb-12 w-full text-md min-h-[30rem]" 
  <?php endif; ?>
  >
  <?php foreach ($items as $item) : ?>
    <li class="list-none flex justify-between flex-wrap items-center w-full" x-data="{activeChild: '<?php echo $item->activeAncestor ? true : false ?>'}">
      <a href="<?php echo $item->url; ?>" class="block flex-1 py-2 my-2 font-primary font-semibold focus-within:text-primary rounded-full <?php echo $item->active ? 'bg-gray-100' : ''; ?>">
        <?php echo $item->label; ?>
      </a>

      <?php if ($item->children) : ?>
        <button class="w-8 h-8 flex justify-center items-center py-2 bg-gray-50 border-1 border-gray-300 rounded-full" x-on:click="activeChild = !activeChild" aria-label="<?php echo esc_html(__("Open", "charlesrwood") . ' ' . $item->label); ?>">
          <template x-if="!activeChild">
            <span class="w-5 flex justify-center items-center h-auto">
              <?php echo selleradise_svg("tabler-icons/chevron-down"); ?>
            </span>
          </template>
          <template x-if="activeChild">
            <span class="w-5 flex justify-center items-center h-auto">
              <?php echo selleradise_svg("tabler-icons/chevron-up"); ?>
            </span>
          </template>
        </button>

        <?php
        get_template_part(
          "template-parts/headers/partials/nav",
          "mobile",
          ["items" => $item->children, "level" => $level + 1, "parent" => $item]
        );
        ?>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>