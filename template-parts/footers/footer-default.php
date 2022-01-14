<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<footer id="colophon" class="selleradise_footer--default" role="contentinfo">

    <div class="selleradise_footer--default__top">
        <?php get_template_part('template-parts/headers/partials/logo'); ?>

        <?php get_template_part('template-parts/footers/partials/menu');?>

        <?php get_template_part('template-parts/footers/partials/form');?>
    </div>

    <div class="selleradise_footer--default__bottom">
        <p class="selleradise_footer--default__statement">
            <?php get_template_part('template-parts/footers/partials/notice'); ?>
        </p>
    </div>


    <?php get_template_part('template-parts/footers/partials/back-to-top'); ?>

</footer><!-- #colophon -->
