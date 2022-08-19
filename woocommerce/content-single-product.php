<?php
/**
 * The template for displaying product content in the single-product.php template
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

?>

<?php
if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div x-data="productPage" id="product-<?php the_ID(); ?>" <?php wc_product_class( 'selleradise_single_product', $product ); ?>>

	<div class="selleradise_single_product__content" id="selleradise_single_product__content">
		
		<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * It is not used for anything other than to provide compatibility for third party plugins.
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary">

			<?php
			/**
			 * Hook: selleradise_single_product_title.
			 *
			 * @hooked selleradise_get_breadcrumb - 5
			 * @hooked woocommerce_template_single_title - 10
			 */
				do_action('selleradise_single_product_title');
			?>

			<?php
			/**
			 * Hook: selleradise_single_product_after_title.
			 *
			 * @hooked woocommerce_template_single_rating - 5
			 */
				do_action('selleradise_single_product_after_title');
			?>

			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */

				do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
	</div>

	

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>