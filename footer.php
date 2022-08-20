<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package selleradise
 */

?>


<div x-data class="selleradiseToast" x-bind:class="`selleradiseToast--${$store.toast.type}`" x-show="$store.toast.isShowing" role="alert" x-bind:style="{ zIndex: $store.toast.zIndex }">
	<span x-html="$store.toast.message"></span>
	<button class="button--icon" x-on:click="$store.toast.hide()">
		<?php echo selleradise_svg('tabler-icons/x') ?>
	</button>
</div>


</div><!-- #content -->

<?php get_template_part('template-parts/footers/footer', "default"); ?>


</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>