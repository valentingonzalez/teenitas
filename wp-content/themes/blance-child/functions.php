<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION

add_action( 'wp_enqueue_scripts', 'generate_remove_scripts' );
function generate_remove_scripts() 
{
    wp_dequeue_style( 'generate-child' );
}

add_action( 'wp_enqueue_scripts', 'generate_move_scripts', 999 );
function generate_move_scripts() 
{
    if ( is_child_theme() ) :
        wp_enqueue_style( 'generate-child', get_stylesheet_uri(), true, filemtime( get_stylesheet_directory() . '/style.css' ), 'all' );
    endif;
}


// CALL SOCIALS OVERRIDE WIDGET
require_once('framework/widgets/socials.php');