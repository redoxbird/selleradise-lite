<?php
  wp_nav_menu(array(
      'theme_location' => 'primary',
      'container' => 'nav',
      'menu_class' => 'selleradise_menu__list',
      'container_class' => 'selleradise_menu',
      'container_aria_label' => 'Main',
      'fallback_cb' => false,
      'walker' => new \Selleradise_Lite\Core\WalkerNav(),
  ));
?>