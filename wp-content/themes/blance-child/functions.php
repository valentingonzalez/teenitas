<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION

//register Lookbook post type
require_once('lookbook-type.php');
// add a skin in a plugin/theme
add_filter('tg_add_item_skin', function($skins) {
    $PATH = get_stylesheet_directory();
    // register a skin and add it to the main skins array
    $skins['lookbook-skin'] = array(
        'type'   => 'grid',
        'filter' => 'Custom Teenitas',
        'slug'   => 'lookbook-skin',
        'name'   => 'Lookbook',
        'php'    => $PATH . '/the-grid/grid/lookbook-skin.php',
        'css'    => $PATH . '/the-grid/grid/lookbook-skin.css',
        'col'    => 1, // col number in preview skin mode
        'row'    => 1  // row number in preview skin mode
    );
    // return the skins array + the new one you added (in this example 2 new skins was added)
    return $skins;
});

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

add_filter( 'the_password_form', 'custom_password_form' );
function custom_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form class="protected-post-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <h2 class="title">' . __( "Acceso Mayoristas" ) . '</h2>
    <label class="pass-label" for="' . $label . '">' . __( "Contraseña" ) . ' </label>
    <input name="post_password" id="' . $label . '" type="password" />
    <input type="submit" name="Submit" class="button" value="' . esc_attr__( "Enviar" ) . '" />
    </form>
    ';
    return $o;
}

// CALL SOCIALS OVERRIDE WIDGET
require_once('framework/widgets/socials.php');
