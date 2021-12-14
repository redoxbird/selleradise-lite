<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if(function_exists('is_product') && is_product()) {
    return;
}

if(get_theme_mod('disable_back_to_top', false) === true) {
    return;
}

?>


<a 
    href="#page" 
    aria-label="<?php esc_attr_e( 'Go back to top', 'selleradise-lite' ); ?>" 
    class="selleradise_back-to-top selleradise_trigger_smoothscroll" 
    data-smoothscroll-y="0" 
    role="button">
    <svg class="progress">
        <circle class="stroke" />
    </svg>
    <?php echo selleradise_svg('unicons-line/arrow-up');?>
</a>