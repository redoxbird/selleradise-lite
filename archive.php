<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package selleradise
 */

get_header(); ?>

<div id="primary" class="content-area <?php echo selleradise_blog_page_classes(); ?>">

	<div class="selleradise_page__title">
		<?php
			the_archive_title( '<h1 class="page-title text-3xl mb-4">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
		?>
	</div>

	<?php get_template_part('template-parts/pages/blog/partials/main'); ?>

	<?php get_sidebar(); ?>

</div><!-- #primary -->

<?php
get_footer();
