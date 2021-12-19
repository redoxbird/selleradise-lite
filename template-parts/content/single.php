<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Selleradise
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> v-pre>

	<?php if (has_post_thumbnail()): ?>
		<div class="selleradise_single_post__image">
			<?php echo get_the_post_thumbnail(); ?>
		</div>
	<?php endif;?>

	<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
	?>

	<?php get_template_part('template-parts/content/partials/categories'); ?>
	
	<div class="entry-content selleradise_prose">
		<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. */
						__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'selleradise-lite' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'selleradise-lite' ),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->


	<?php get_template_part('template-parts/content/partials/tags');?>

	<?php get_template_part('template-parts/post/partials/author', null, ["type" => "post"]); ?>
	
</article><!-- #post-## -->
