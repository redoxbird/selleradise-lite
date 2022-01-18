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

$post_tags = get_the_terms(get_the_ID(), 'post_tag');

if (!$post_tags) {
    return;
}

?>

<ul class="selleradise_single_post__tags">

    <?php
        foreach ($post_tags as $index => $post_tag):

        if ($post_tag->slug === 'uncategorized' && $index > 0) {
            continue;
        }
    ?>

	    <li>
	        <a href="<?php echo esc_attr(get_term_link($post_tag)) ?>">
                #<?php echo esc_html($post_tag->name); ?>
            </a>
	    </li>

    <?php 
        endforeach;
    ?>
</ul>