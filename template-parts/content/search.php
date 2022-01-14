<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package selleradise
 */

$post_type_slug = get_post_type(get_the_ID());
$post_type_link = get_post_type_archive_link( $post_type_slug );
$selleradise_post_type_object = get_post_type_object($post_type_slug);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('selleradise_search_page__article'); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<a href="<?php echo esc_url( $post_type_link ?: get_the_permalink() ); ?>" class="selleradise_search_page__article-type">
			<?php echo esc_html( $selleradise_post_type_object->labels->singular_name ); ?>
		</a>
	</header><!-- .entry-header -->

	<div class="selleradise_search_page__article-excerpt">
			<?php echo get_the_excerpt(); ?>
	</div>
</article><!-- #post-## -->
