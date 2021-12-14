<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package selleradise
 */

get_header(); ?>

<div class="selleradise_page_404">

		<div class="selleradise_page_404__message">
			<h1>
				<?php esc_html_e('404', 'selleradise-lite'); ?>
			</h1>

			<p>
				<?php esc_html_e('Page not found', 'selleradise-lite'); ?>
			</p>
			
			<a href="<?php echo esc_url( home_url() ); ?>" class="selleradise_button--primary">
				<?php esc_html_e('Go to homepage', 'selleradise-lite'); ?>
			</a>
		</div>

</div>

<?php
get_footer();
