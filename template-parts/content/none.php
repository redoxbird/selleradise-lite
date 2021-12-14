<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Selleradise
 */

?>

<section class="selleradise_page__nothing">


	<div class="page-content">

		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'selleradise-lite' ); ?></h1>

		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
		?>


			<p>
				<?php
				printf(
					wp_kses(
						/* translators: 1: link. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'selleradise-lite' ),
						array(
							'a' => array(
								'href' => array(),
								'class' => 'selleradise_button--primary'
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'selleradise-lite' ); ?></p>
			
			<?php
				get_search_form();
				else : 
			?>

			<p>
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'selleradise-lite' ); ?>
			</p>

		<?php 
			get_search_form(); 
			endif; 
		?>

	</div><!-- .page-content -->
</section><!-- .no-results -->
