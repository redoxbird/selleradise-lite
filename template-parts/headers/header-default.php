<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>

<header x-data="header" role="banner" class="selleradiseHeader selleradiseHeader--default" x-bind:class="{'headroom--unpinned': !pin, 'headroom--not-top': notTop}">
  <?php get_template_part('template-parts/headers/partials/logo'); ?>
  <?php get_template_part('template-parts/headers/partials/menu'); ?>
  <?php get_template_part('template-parts/headers/partials/search', null, [
    "type" => class_exists('DGWT_WC_Ajax_Search') ? "fibosearch" : "native"
  ]);
  ?>
  <div class="flex justify-end items-center lg:mx-4 ml-auto">
    <?php get_template_part('template-parts/headers/partials/trigger', "search"); ?>
    <?php get_template_part('template-parts/headers/partials/trigger', "account"); ?>
    <?php get_template_part('template-parts/headers/partials/trigger', 'cart'); ?>
    <?php get_template_part('template-parts/headers/partials/trigger', 'menu'); ?>
  </div>

</header>

<?php get_template_part('template-parts/headers/partials/mini-cart'); ?>
<?php get_template_part('template-parts/headers/partials/menu', 'mobile'); ?>