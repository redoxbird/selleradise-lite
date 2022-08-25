<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Selleradise
 */

?>

<section class="flex justify-center items-center px-page py-20 lg:min-h-[var(--hero-height)]">


	<div class="page-content flex flex-col justify-center items-center">

		<h1 class="page-title text-5xl font-bold mb-4"><?php esc_html_e( 'Nothing Found', 'TEXT_DOMAIN' ); ?></h1>

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
					printf(
						wp_kses(
							/* translators: 1: link. */
							__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'TEXT_DOMAIN' ),
							array(
								'a' => array(
									'href' => array(),
									'class' => 'selleradise_button--primary mt-10'
								),
							)
						),
						esc_url( admin_url( 'post-new.php' ) )
					);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'TEXT_DOMAIN' ); ?>
			</p>
			
			<?php
				get_search_form();
				else : 
			?>

			<p>
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'TEXT_DOMAIN' ); ?>
			</p>

		<?php 
			get_search_form(); 
			endif; 
		?>

	</div><!-- .page-content -->
</section><!-- .no-results -->
