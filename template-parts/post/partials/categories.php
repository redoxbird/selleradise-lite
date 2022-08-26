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

if(empty($categories)) {
    return;
}

$categories = array_slice($categories, 0, 4, true);

?>

<ul class="flex justify-start flex-wrap items-center gap-2 w-full mt-4">
    <?php 
        foreach ($categories as $index => $category): 
            
        if ($category->slug === 'uncategorized') {
            continue;
        }
    ?>

    <li>
        <a class="selleradise_chip--base" href="<?php echo esc_attr( get_term_link($category) ) ?>">
            <?php echo esc_html($category->name); ?>
        </a>
    </li>

    <?php endforeach; ?>
</ul>