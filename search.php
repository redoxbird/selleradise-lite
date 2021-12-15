<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package selleradise
 */

get_header(); ?>

<div class="selleradise-container selleradise_search_page">
	<div id="primary" class="content-area">

		<?php if ( have_posts() ) : global $wp_query; ?>

		<header>
			<h1 class="selleradise_page__title">
				<?php
					printf(
						/* translators: %s: Search Term. */
						esc_html( __("Search Results for: %s", "selleradise-lite") ),
						'<em>' . get_search_query() . '</em>'
					);
				?>
			</h1>
		</header><!-- .page-header -->

		<main id="main" class="site-main" role="main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content/search');

			endwhile;
			
				
			if($wp_query->max_num_pages > 1): ?>

				<div class="selleradise_pagination">

					<?php
						$args = [
							'base'		=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'		=> $wp_query->max_num_pages,
							'current'	=> max( 1, get_query_var( 'paged' ) ),
							'format'	=> '?paged=%#%',
							'show_all'	=> false,
							'type'		=> 'list',
							'end_size'	=> 0,
							'mid_size'	=> 2,
							'prev_next'	=> true,
							'prev_text'	=> selleradise_svg('unicons-line/angle-left-b'),
							'next_text'	=> selleradise_svg('unicons-line/angle-right-b'),
							'add_args'	=> false,
							'add_fragment' => '',
							'aria_current' => "page",
						];

						echo paginate_links($args);
					?>
				</div>

			<?php endif; 

				else :

				get_template_part( 'template-parts/content/none');

				endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
get_footer();
