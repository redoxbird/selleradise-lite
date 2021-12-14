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

$tags = get_the_terms(get_the_ID(), 'post_tag');

if (!$tags) {
    return;
}

?>

<ul class="selleradise_single_post__tags">

    <?php
    foreach ($tags as $index => $tag):

        if ($tag->slug === 'uncategorized' && $index > 0) {
            continue;
        }
    ?>

	    <li>
	        <a href="<?php echo esc_attr(get_term_link($tag)) ?>">#<?php echo esc_html($tag->name); ?></a>
	    </li>

    <?php endforeach;?>
</ul>