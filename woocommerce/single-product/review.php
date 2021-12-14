<?php
/**
 * Review Comments Template
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">


	<div class="selleradise_productReview__container">
		<div class="selleradise_productReview__profile">
		 <div class="selleradise_productReview__profile-picture">
			<?php 
				/**
				 * The woocommerce_review_before hook
				 *
				 * @hooked woocommerce_review_display_gravatar - 10
				 */

				do_action( 'woocommerce_review_before', $comment ); 
			?>
		 </div>

		 <div class="selleradise_productReview__profile-info">
			 <?php 
				/**
				 * The woocommerce_review_meta hook.
				 *
				 * @hooked woocommerce_review_display_meta - 10
				 */
					do_action( 'woocommerce_review_meta', $comment ); 
				?>
		 </div>


			<div class="selleradise_productReview__rating">
				<?php do_action( 'woocommerce_review_before_comment_meta', $comment );?>
				<?php do_action('woocommerce_review_before_comment_text', $comment);?>
			</div>
		</div>


		<div class="selleradise_productReview__comment">
			<?php do_action('woocommerce_review_comment_text', $comment);?>

			<?php do_action('woocommerce_review_after_comment_text', $comment);?>
		</div>
	</div>