<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package selleradise
 */

get_header(); ?>

<div class="flex justify-center items-center px-page py-20 min-h-[var(--hero-height)]">
	<div class="flex flex-col justify-center items-center">
		<h1 class="text-10xl m-0 text-center leading-none">
			<?php esc_html_e('404', 'TEXT_DOMAIN'); ?>
		</h1>

		<p class="text-2xl text-text-900 opacity-75 m-0">
			<?php esc_html_e('Page not found', 'TEXT_DOMAIN'); ?>
		</p>
		
		<a href="<?php echo esc_url( home_url() ); ?>" class="selleradise_button--primary mt-10">
			<?php esc_html_e('Go to homepage', 'TEXT_DOMAIN'); ?>
		</a>
	</div>
</div>

<?php
get_footer();
