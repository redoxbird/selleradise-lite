<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$name = get_bloginfo( "name" ) ?: "";

?>

<div class="selleradiseHeader__logo-placeholder">
  <span class="selleradiseHeader__logo-placeholder__icon">
    <?php echo esc_html( $name[0] ); ?>
  </span>
  <div class="selleradiseHeader__logo-placeholder__text">
    <p>
      <b class="selleradiseHeader__logo-placeholder__name">
        <?php echo esc_html(selleradise_truncate($name, 8)); ?>
      </b>
    </p>
    
    <p class="selleradiseHeader__logo-placeholder__tagline">
      <?php echo esc_html(selleradise_truncate(get_bloginfo( "description" ), 22)); ?>
    </p>
  </div>
</div>