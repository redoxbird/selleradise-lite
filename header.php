<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package selleradise
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> data-selleradise-theme-type="<?php echo esc_attr(selleradise_get_theme_type()); ?>">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	
	<?php wp_head();?>

</head>

<body <?php body_class(); ?> >

<?php wp_body_open(); ?>

<div id="page" class="site">
	
	<?php get_template_part('template-parts/headers/skip-link'); ?>
	
	<?php get_template_part('template-parts/headers/header', "default");?>

	<overlay> </overlay>

	<div id="content" class="site-content">