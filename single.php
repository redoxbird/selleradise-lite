<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package selleradise
 */

get_header(); ?>

<div class="selleradise-container">

	<div id="primary" class="content-area selleradise_single_post">
		
		<?php selleradise_get_breadcrumb(); ?>

		<main id="main" class="site-main" role="main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/single', get_post_format() );

				get_template_part( 'template-parts/content/single-post-navigation');

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;

			
			?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div><!-- #primary -->

</div><!-- .container -->

<?php

get_footer();
