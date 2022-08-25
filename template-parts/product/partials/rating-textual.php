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
  $count_text = __('review', 'TEXT_DOMAIN');
} else {
  $count_text = __('reviews', 'TEXT_DOMAIN');
}

?>

<div class="flex justify-start items-center text-sm whitespace-nowrap">
    <span class="w-3 h-auto mr-0.5 text-amber-400 children:fill-current">
      <?php echo selleradise_svg('fontawesome/star-solid'); ?>
    </span>

    <span class="font-semibold mr-1">
      <?php echo esc_html( $product->get_average_rating() ); ?>
    </span>
    
    <span class="opacity-75">
      <?php echo esc_html(sprintf('(%s %s)', $product->get_review_count(), $count_text)); ?>
    </span>
</div>