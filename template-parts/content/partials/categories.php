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

$categories = get_the_terms(get_the_ID(), 'category');

if(!$categories) {
    return;
}


?>

<ul class="selleradise_single_post__categories">

    <?php 
        foreach ($categories as $index => $category): 
            
        if ($category->slug === 'uncategorized') {
            continue;
        }
    ?>

    <li>
        <a href="<?php echo esc_attr( get_term_link($category) ) ?>"><?php echo esc_html($category->name); ?></a>
    </li>

    <?php endforeach; ?>
</ul>