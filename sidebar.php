<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package selleradise
 */

function selleradise_is_blog()
{
    return (is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}


if (!is_active_sidebar( 'selleradise-sidebar' ) || !selleradise_is_blog()) {
	return;
} 


if ( is_customize_preview() ) {
	echo '<div id="selleradise-sidebar-control"></div>';
}

?>

<div class="selleradise_blog__sidebar w-1/3">
	<aside id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'selleradise-sidebar' ); ?>
	</aside>
</div>

