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

$average_rating = $product->get_average_rating();
$color_class = '';

if ($average_rating < 2.5) {
    $color_class = 'productRating--minimal-bad';
} else {
    $color_class = 'productRating--minimal-good';
}

?>

<div class="productRating--minimal <?php echo esc_attr($color_class); ?>">
    <?php echo selleradise_svg('fontawesome/star-solid'); ?>
    <span><?php echo esc_html( $average_rating ); ?></span>
</div>