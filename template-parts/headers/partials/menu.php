<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$menu = selleradise_get_menu_tree("mobile");

?>
<nav role="navigation" aria-label="Primary" x-show="$store.mobileMenu.activeSidebar === 'menu'" x-transition>
  <?php
  if ($menu && !empty($menu)) :
    get_template_part("template-parts/headers/partials/nav", null, ["items" => $menu, "level" => 1, "parent" => []]);
  endif;
  ?>
</nav>