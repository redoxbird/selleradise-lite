<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (isset($args)) {
  extract($args);
}



?>

<ul x-transition <?php if ($parent) : ?> x-show="activeChild == true" <?php endif; ?> class="<?php echo esc_attr(selleradise_nav_classes("ul", $level)); ?>">
  <?php foreach ($items as $item) : ?>
    <li x-on:mouseenter="activeChild = true" x-on:mouseleave="activeChild = false" x-data="{activeChild: false}" class="<?php echo esc_attr(selleradise_nav_classes("li", $level)); ?>">
      <a
        href="<?php echo $item->url; ?>"
        x-on:keyup.prevent.down="activeChild = true"
        x-on:keyup.prevent.up="activeChild = false"
        class="<?php echo esc_attr(selleradise_nav_classes("a", $level)); ?> <?php echo $item->active ? 'bg-gray-100' : ''; ?>">

        <span class="<?php echo esc_attr($item->children && $level === 1 ? 'mr-1' : null) ?>">
           <?php echo $item->label; ?>
        </span>

        <?php if ($item->children && $level === 1) : ?>
          <span x-cloak x-show="!activeChild" class="w-5 h-auto ml-auto flex justify-center items-center">
            <?php echo selleradise_svg("tabler-icons/chevron-down"); ?>
          </span>
          <span x-cloak x-show="activeChild" class="w-5 h-auto ml-auto flex justify-center items-center">
            <?php echo selleradise_svg("tabler-icons/chevron-up"); ?>
          </span>
        <?php endif; ?>

        <?php if ($item->children && $level > 1) : ?>
          <span x-cloak x-show="!activeChild"  class="shrink-0 w-5 h-auto ml-auto flex justify-center items-center">
            <?php echo selleradise_svg("tabler-icons/chevron-right"); ?>
          </span>
          <span x-cloak x-show="activeChild" class="w-5 h-auto ml-auto flex justify-center items-center">
            <?php echo selleradise_svg("tabler-icons/chevron-left"); ?>
          </span>
        <?php endif; ?>
      </a>

      <?php if ($item->children) : ?>

        <?php
          get_template_part(
          "template-parts/headers/partials/nav",
          null,
          ["items" => $item->children, "level" => $level + 1, "parent" => $item]
        );
        ?>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>