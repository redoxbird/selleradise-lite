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
    <li x-on:mouseenter="activeChild = true" x-on:mouseleave="activeChild = false" x-data="{activeChild: '<?php echo $item->activeAncestor ? true : false ?>'}" class="<?php echo esc_attr(selleradise_nav_classes("li", $level)); ?>">
      <a href="<?php echo $item->url; ?>" x-on:keyup.prevent.down="activeChild = true" x-on:keyup.prevent.up="activeChild = false" class="<?php echo esc_attr(selleradise_nav_classes("a", $level)); ?> <?php echo $item->active ? 'bg-gray-100' : ''; ?>">
        <?php echo $item->label; ?>

        <?php if ($item->children && $level === 1) : ?>
          <template x-if="!activeChild">
            <span class="w-5 h-auto ml-auto">
              <?php echo selleradise_svg("unicons-line/angle-down"); ?>
            </span>
          </template>
          <template x-if="activeChild">
            <span class="w-5 h-auto ml-auto">
              <?php echo selleradise_svg("unicons-line/angle-up"); ?>
            </span>
          </template>
        <?php endif; ?>

        <?php if ($item->children && $level > 1) : ?>
          <template x-if="!activeChild">
            <span class="w-5 h-auto ml-auto">
              <?php echo selleradise_svg("unicons-line/angle-right"); ?>
            </span>
          </template>
          <template x-if="activeChild">
            <span class="w-5 h-auto ml-auto">
              <?php echo selleradise_svg("unicons-line/angle-left"); ?>
            </span>
          </template>
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