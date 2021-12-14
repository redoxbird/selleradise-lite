<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}


if(!function_exists('mc4wp_show_form')) {
  return;
}

?>

<div class="selleradise_footer__form">
  <h2><?php esc_html_e( 'Join to receive regular updates', 'selleradise-lite' ); ?></h2>
  <?php mc4wp_show_form(); ?>
</div>
