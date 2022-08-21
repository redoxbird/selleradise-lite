<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!isset($product->id)) {
    global $product;
}

if (!$product) {
    return;
}


if (!wc_review_ratings_enabled() || !$product->get_average_rating()) {
    return;
}

// :style="{ width: (ratingPercent / 5) * 100 + '%' }"

?>

<div class="selleradise_productRating--normal">
    <div class="back-stars">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php echo selleradise_svg('fontawesome/star-solid'); ?>
        <?php endfor; ?>

        <div class="front-stars" style="width: <?php echo esc_attr($product->get_average_rating() / 5) * 100; ?>%;">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php echo selleradise_svg('fontawesome/star-solid'); ?>
            <?php endfor; ?>
        </div>
    </div>
    <span class="reviewCount">
        (<?php echo esc_html($product->get_review_count()); ?>)
    </span>
</div>