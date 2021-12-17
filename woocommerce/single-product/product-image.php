<?php
/**
 * Single Product Image
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

$post_thumbnail_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids() ?? [];

array_unshift($gallery_image_ids, $post_thumbnail_id);

?>


<div class="selleradise_single_product__images">
	
	<div class="selleradise_single_product__images-slider">
		<ul class="swiper-wrapper">
			<?php 
				foreach($gallery_image_ids as $image_id): 
				$image = wp_get_attachment_image_src($image_id, 'large');
				$image_full = wp_get_attachment_image_src($image_id, 'full');
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				$image_ratio = (int) $image[2] / (int) $image[1];

				if(!$image_full) {
					continue;
				}
				?>

				<li
					class="selleradise_single_product__images-slide swiper-slide" 
					data-size-w="<?php echo esc_attr($image[1]); ?>"
					data-size-h="<?php echo esc_attr($image[2]); ?>"
					<?php if (get_option('woocommerce_thumbnail_cropping') == 'uncropped'): ?>
							style="--product-image-ratio: <?php echo esc_attr($image_ratio); ?>;"
					<?php endif;?>>
					<img
						class="swiper-lazy"
						src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
						data-src="<?php echo esc_url($image[0]); ?>"
						alt="<?php echo esc_attr($image_alt); ?>"
					>
					<a href="<?php echo esc_url($image_full[0]); ?>"></a>
					<div class="swiper-lazy-preloader"></div>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="selleradise_slider__nav">
			<button class="selleradise_slider__nav--previous"> <?php echo selleradise_svg('unicons-line/angle-left') ?> </button>
			<div class="swiper-pagination"></div>
			<button class="selleradise_slider__nav--next"> <?php echo selleradise_svg('unicons-line/angle-right') ?> </button>
		</div>
	</div>

	<div class="selleradise_single_product__thumbnails-slider">
		<ul class="swiper-wrapper">
			<?php 
				foreach($gallery_image_ids as $image_id): 
				$thumbnail = wp_get_attachment_image_src($image_id, 'thumbnail');

				if(!$thumbnail) {
					continue;
				}

				?>
				<li class="swiper-slide">
					<img class="swiper-lazy" data-src="<?php echo esc_attr($thumbnail[0]); ?>" alt="">
					<div class="swiper-lazy-preloader"></div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

</div>
