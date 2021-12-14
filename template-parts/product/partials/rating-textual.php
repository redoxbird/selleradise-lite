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

$count_text;

if($product->get_review_count() <= 1) {
  $count_text = __('review', 'selleradise-lite');
} else {
  $count_text = __('reviews', 'selleradise-lite');
}

?>

<div class="selleradise_productRating--textual">
    <?php echo selleradise_svg('unicons-solid/star'); ?>

    <span class="selleradise_productRating--textual__average">
      <?php echo esc_html( $product->get_average_rating() ); ?>
    </span>
    
    <span class="selleradise_productRating--textual__count">
      <?php echo esc_html(sprintf('(%s %s)', $product->get_review_count(), $count_text)); ?>
    </span>
</div>