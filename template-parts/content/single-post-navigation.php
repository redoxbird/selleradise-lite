<?php

$prev_link = get_previous_post_link('%link');
$next_link = get_next_post_link('%link');

?>

<ul class="selleradise_single_post__navLinks">
    <?php if($prev_link): ?>
        <li class="previous">
            <p><?php echo selleradise_svg('unicons-line/arrow-left'); ?> <?php esc_html_e( 'Previous', 'selleradise-lite' ); ?></p>
            <?php echo previous_post_link('%link'); ?>
        </li>
    <?php endif; ?>

    <?php if($next_link): ?>
        <li class="next">
            <p><?php esc_html_e('Next', 'selleradise-lite');?> <?php echo selleradise_svg('unicons-line/arrow-right'); ?> </p>
            <?php next_post_link('%link') ?>            
        </li>
    <?php endif; ?>
</ul>
