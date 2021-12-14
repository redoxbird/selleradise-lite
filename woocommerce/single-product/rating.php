<?php
/**
 * Single Product Rating
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $product;

if (!wc_review_ratings_enabled()) {
    return;
}
if (!wc_review_ratings_enabled() || !$product->get_average_rating()) {
    return;
}

$count_text;

if ($product->get_review_count() <= 1) {
    $count_text = __('review', 'selleradise-lite');
} else {
    $count_text = __("reviews", 'selleradise-lite');
}

?>

<a href="#tab-reviews" class="selleradise_productRating--textual selleradise_trigger_smoothscroll">
	<?php echo selleradise_svg('unicons-solid/star'); ?>

	<span class="selleradise_productRating--textual__average">
		<?php echo wp_kses_post($product->get_average_rating()); ?>
	</span>

	<span class="selleradise_productRating--textual__count">
		<?php echo esc_html(sprintf('(%s %s)', $product->get_review_count(), $count_text)); ?>
	</span>
</a>

