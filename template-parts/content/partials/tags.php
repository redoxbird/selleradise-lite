<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if ('post' !== get_post_type()) {
    return;
}

$selleradise_tags = get_the_terms(get_the_ID(), 'post_tag');

if (!$selleradise_tags) {
    return;
}

?>

<ul class="selleradise_single_post__tags">

    <?php
        foreach ($selleradise_tags as $index => $selleradise_tag):

        if ($selleradise_tag->slug === 'uncategorized' && $index > 0) {
            continue;
        }
    ?>

	    <li>
	        <a href="<?php echo esc_attr(get_term_link($selleradise_tag)) ?>">
                #<?php echo esc_html($selleradise_tag->name); ?>
            </a>
	    </li>

    <?php 
        endforeach;
    ?>
</ul>