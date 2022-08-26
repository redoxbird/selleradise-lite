<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 *
 * @package THEME_NAMESPACE
 */

define('SELLERADISE_VERSION', '1.2.7');

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;


if ( class_exists( 'THEME_NAMESPACE\\Init' ) ) :
	THEME_NAMESPACE\Init::register_services();
endif;
