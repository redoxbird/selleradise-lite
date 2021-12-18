<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('WooCommerce')) {
    return;
}

if ($args) {
  extract($args);
}

?>

<?php if(is_user_logged_in()): ?>

<ul>
  <?php foreach (wc_get_account_menu_items() as $key => $menu_item): ?>
    <li>
      <a href="<?php echo wc_get_account_endpoint_url($key); ?>">
        <?php echo selleradise_svg(selleradise_get_icon($key)); ?>
        <?php echo esc_html( $menu_item ); ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<?php else: ?>
  <ul>
    <li>
      <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>">
        <?php echo selleradise_svg("unicons-line/sign-in-alt"); ?>
        <?php _e("Login", 'selleradise-lite'); ?>
      </a>
    </li>

    <?php if(get_option( 'woocommerce_enable_myaccount_registration', false) == 'yes'): ?>
      <li>
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>#register">
          <?php echo selleradise_svg("unicons-line/user-plus"); ?>
          <?php _e("Register", 'selleradise-lite'); ?>
        </a>
      </li>
    <?php endif; ?>
  </ul>

<?php endif; ?>