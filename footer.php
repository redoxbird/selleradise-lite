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

<!-- This is to make alpine transition work with twind, looking for better solution. -->
<span class="hidden transition ease-out ease-out-expo duration-400 duration-500 translate-y-16 -translate-y-16 translate-y-0 translate-x-16 translate-x-0 opacity-0 scale-90 opacity-100 scale-100"></span>

</div><!-- #content -->

<?php get_template_part('template-parts/footers/footer', "default"); ?>


</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>