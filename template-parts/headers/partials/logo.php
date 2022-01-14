<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$custom_logo_id = get_theme_mod('custom_logo');
$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

$custom_logo_dark_mode_id = get_theme_mod('custom_logo_dark_mode');
$logo_dark_mode = wp_get_attachment_image_src($custom_logo_dark_mode_id, 'full');

?>

 <a 
    href="<?php echo esc_url( home_url() ); ?>" 
    aria-label="<?php echo esc_attr(sprintf(__('%s Logo', 'selleradise-lite'), get_bloginfo('name'))); ?>" 
    class="selleradiseHeader__logo-outer">

  <?php if(has_custom_logo()): ?>
    <img
      class="selleradiseHeader__logo--dark"
      src="<?php echo has_custom_logo() ? $logo[0] : selleradise_assets('images/selleradise-logo.svg'); ?>"
      alt="<?php echo esc_attr(sprintf(__('%s Logo', 'selleradise-lite'), get_bloginfo('name'))); ?>"
      width="<?php echo esc_attr($logo[1]); ?>"
      height="<?php echo esc_attr($logo[2]); ?>"
    />
  <?php else: ?>
    <span class="selleradiseHeader__logo--dark">
      <?php get_template_part('template-parts/headers/partials/logo', 'placeholder'); ?>
    </span>
  <?php endif; ?>

  <?php if($custom_logo_dark_mode_id): ?>
    <img
      class="selleradiseHeader__logo--light"
      src="<?php echo esc_url( $custom_logo_dark_mode_id ? $logo_dark_mode[0] : selleradise_assets('images/selleradise-logo.svg') ); ?>"
      alt="<?php echo esc_attr(sprintf(__('%s Logo', 'selleradise-lite'), get_bloginfo('name'))); ?>"
    />
  <?php else: ?>
    <span class="selleradiseHeader__logo--light">
      <?php get_template_part('template-parts/headers/partials/logo', 'placeholder');?>
    </span>
  <?php endif; ?>
</a>