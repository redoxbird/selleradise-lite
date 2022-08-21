<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package selleradise/woocommerce
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$shop_page_display = get_option('woocommerce_shop_page_display', false);
$category_archive_display = get_option( 'woocommerce_category_archive_display', false );

?>

<div 
	class="selleradise_shop selleradise_shop--default grid grid-cols-4" 
	data-selleradise-image-cropping="<?php echo esc_attr( get_option('woocommerce_thumbnail_cropping') ); ?>"
	data-selleradise-sidebar-type="<?php echo esc_attr( get_theme_mod( 'filters_location', 'sidebar' ) ); ?>"
	data-selleradise-card-type="default"
	data-selleradise-category-card-type="default"
	data-selleradise-shop-display="<?php echo esc_attr( $shop_page_display ); ?>"
	data-selleradise-category-display="<?php echo esc_attr( $category_archive_display ); ?>">

	<div class="selleradise_shop__head pr-4 text-md col-span-full">

		<?php 
			/**
			 * Hook: woocommerce_before_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked WC_Structured_Data::generate_website_data() - 30
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

		<?php 
			/**
			 * Hook: woocommerce_before_main_content.
			 *
			 * @hooked selleradise_get_breadcrumb - 10
			 */
			do_action( 'selleradise_before_shop_title' );
		?>

		<div class="selleradise_shop__title">
			<?php if (apply_filters('woocommerce_show_page_title', true)): ?>
				<h1 class="woocommerce-products-header__title page-title relative w-full mt-4 text-2xl"><?php woocommerce_page_title();?></h1>
			<?php endif;?>
			
			<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action('woocommerce_archive_description');
			?>
		</div>

	</div>

	<?php
		get_template_part('woocommerce/loop/products');

	?>
	
</div>

<?php

get_footer( 'shop' );
