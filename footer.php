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

	<overlay> </overlay>
	
	<selleradise-toast>
		<template v-slot:icon-close>
      <?php echo selleradise_svg('unicons-line/multiply') ?>
    </template>
	</selleradise-toast>

	</div><!-- #content -->

	<?php get_template_part('template-parts/footers/footer', "default"); ?>


</div><!-- #page -->

<?php wp_footer();?>

</body>
</html>
