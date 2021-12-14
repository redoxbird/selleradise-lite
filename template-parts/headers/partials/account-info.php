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

$user = [];

$user['display_name'] = __('Guest', 'selleradise-lite');
$user['user_email'] = __('Login or create a new account', 'selleradise-lite');

$user = (object) $user;

if(is_user_logged_in()) {
   $user = wp_get_current_user();
}
?>

<a class="selleradise_sidebar__account-profile" href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>">
  <div class="selleradise_sidebar__account-profile-image">
    <?php echo esc_html( $user->display_name[0] ); ?>
  </div>

  <div class="selleradise_sidebar__account-profile-content">
    <p class="selleradise_sidebar__account-profile-name"><?php echo esc_html($user->display_name); ?></p>
    <p class="selleradise_sidebar__account-profile-email"><?php echo esc_html( $user->user_email ); ?></p>
  </div>
</a>