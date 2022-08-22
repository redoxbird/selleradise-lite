<?php

/**
 * Single Product Image
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

global $product;

$post_thumbnail_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids() ?? [];

array_unshift($gallery_image_ids, $post_thumbnail_id);

?>


<div class="selleradise_single_product__images">

	<div x-ref="images" class="selleradise_single_product__images-slider embla">
		<ul class="embla__container">
			<?php
			foreach ($gallery_image_ids as $image_id) :
				$image = wp_get_attachment_image_src($image_id, 'large');
				$image_full = wp_get_attachment_image_src($image_id, 'full');
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				$image_ratio = (int) $image[2] / (int) $image[1];

				if (!$image_full) {
					continue;
				}
			?>

				<li class="selleradise_single_product__images-slide embla__slide" data-size-w="<?php echo esc_attr($image[1]); ?>" data-size-h="<?php echo esc_attr($image[2]); ?>" <?php if (get_option('woocommerce_thumbnail_cropping') == 'uncropped') : ?> style="--product-image-ratio: <?php echo esc_attr($image_ratio); ?>;" <?php endif; ?>>
					<img
					  class="w-full h-full object-cover"
					  src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
						x-intersect.once="$setSrc('<?php echo esc_url($image[0]); ?>')"
					  alt="<?php echo esc_attr($image_alt); ?>">
					<a href="<?php echo esc_url($image_full[0]); ?>"></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="flex justify-center items-center absolute bottom-2 left-1/2 -translate-x-1/2 bg-white border-1 border-gray-300 rounded-full text-gray-600">
			<button class="selleradise_slider__nav--previous" x-on:click.prevent="emblaPrev()"><?php echo selleradise_svg('tabler-icons/chevron-left') ?></button>
			<button class="selleradise_slider__nav--next" x-on:click.prevent="emblaNext()"><?php echo selleradise_svg('tabler-icons/chevron-right') ?></button>
		</div>
	</div>

	<div x-ref="thumbs" class="embla w-[40rem] my-4">
		<div class="embla__container gap-4">
			<?php
			foreach ($gallery_image_ids as $index => $image_id) :
				$thumbnail = wp_get_attachment_image_src($image_id, 'thumbnail');

				if (!$thumbnail) {
					continue;
				}

			?>
				<button class="w-40 h-40 rounded-lg overflow-hidden" x-bind:class="{'border-gray-900 border-2 transition-all': isInView(<?php echo esc_attr($index); ?>) }" x-on:click.prevent="onThumbClick(<?php echo esc_attr($index); ?>)">
					<img
					  class="w-full h-full object-cover"
						x-intersect.once="$setSrc('<?php echo esc_attr($thumbnail[0]); ?>')"
						src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
					  alt="">
				</button>
			<?php endforeach; ?>
		</div>
	</div>

</div>