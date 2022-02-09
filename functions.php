<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 *
 * @package Selleradise_Lite
 */

define('SELLERADISE_VERSION', '1.2.7');

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;


if ( class_exists( 'Selleradise_Lite\\Init' ) ) :
	Selleradise_Lite\Init::register_services();
endif;
