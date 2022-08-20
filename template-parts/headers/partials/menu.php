<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$menu = selleradise_get_menu_tree("mobile");

?>
<nav role="navigation" aria-label="Primary" class="hidden lg:block pr-4">
  <?php
  if ($menu && !empty($menu)) :
    get_template_part("template-parts/headers/partials/nav", null, ["items" => $menu, "level" => 1, "parent" => []]);
  endif;
  ?>
</nav>