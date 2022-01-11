<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Selleradise
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="selleradise_page__title">
		<?php the_title( '<h1 class="title">', '</h1>' ); ?>
	</div>
		
	<div class="entry-content <?php echo esc_attr(selleradise_is_woocommerce_page() ? '' : 'selleradise_prose') ?>">
		<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'selleradise-lite' ),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
