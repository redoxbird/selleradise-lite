<?php
/**
 * The main template file
 * 
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Selleradise
 */

get_header();
?>

<div id="primary" class="content-area <?php echo selleradise_blog_page_classes(); ?>">
	
	<?php if (is_home() && !is_front_page()): ?>
		<div class="selleradise_page__title text-3xl">
			<h1><?php single_post_title();?></h1>
		</div>
	<?php endif; ?>
	
	<?php get_template_part('template-parts/pages/blog/partials/main');?>

	<?php get_sidebar(); ?>

</div><!-- #primary -->


<?php
get_footer();
