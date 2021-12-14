<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$fonts = selleradise_get_fonts();

?>

<style>
  body {
    <?php 
      foreach ($fonts['primary'] as $property => $value) {
        echo esc_html(sprintf('%s:%s;', $property, $value)); 
      };
    ?>
  }
  
  h1,h2,h3,h4,h5,h6 {
    <?php 
      foreach ($fonts['heading'] as $property => $value) {
        echo esc_html(sprintf('%s:%s;', $property, $value)); 
      };
    ?>
  }
</style>