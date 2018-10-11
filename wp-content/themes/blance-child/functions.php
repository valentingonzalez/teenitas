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

// LOADING CUSTOM JS
function hook_js() {
    echo '<script src="'.get_site_url().'/wp-content/themes/blance-child/assets/js/custom.js" type="text/javascript"></script>';
}
add_action('wp_head', 'hook_js');

// CALL SOCIALS OVERRIDE WIDGET
require_once('framework/widgets/socials.php');


// ADD MODALS
function sizes_modal() {
    ?>
    <div class="modal-wrapper">
        <div id="tabla-de-talles" class="modal" tabindex="-1" role="dialog">
            <a href="javascript:void(0)" class="close-btn">
                <span class="pe-7s-close"></span>
            </a>
            <!--<img src="<?php echo content_url(); ?>/uploads/2018/10/Tabla-de-talles-TEENITAS-web.jpg" />-->
            <table>
                <tbody>
                    <tr>
                        <th class="title" rowspan="5"><span>REMERAS</span></td>
                        <th>TALLE</th>
                        <th>LARGO</th>
                        <th>ANCHO</th>
                        <th>MANGA</th>
                    </tr>
                    <tr>
                        <td><span class="label-xs"></span>10</td>
                        <td>42</td>
                        <td>50</td>
                        <td>13</td>
                    </tr>
                    <tr>
                        <td><span class="label-s"></span>12</td>
                        <td>44</td>
                        <td>52</td>
                        <td>13,5</td>
                    </tr>
                    <tr>
                        <td><span class="label-m"></span>14</td>
                        <td>46</td>
                        <td>54</td>
                        <td>14</td>
                    </tr>
                    <tr>
                        <td><span class="label-l"></span>16</td>
                        <td>48</td>
                        <td>56</td>
                        <td>14,5</td>
                    </tr>
                    <tr>
                        <th class="title" rowspan="5"><span>BUZOS Y ABRIGOS</span></td>
                        <th>TALLE</th>
                        <th>LARGO</th>
                        <th>ANCHO</th>
                        <th>MANGA</th>
                    </tr>
                    <tr>
                        <td><span class="label-xs"></span>10</td>
                        <td>53</td>
                        <td>36</td>
                        <td>52,5</td>
                    </tr>
                    <tr>
                        <td><span class="label-s"></span>12</td>
                        <td>55</td>
                        <td>38</td>
                        <td>54</td>
                    </tr>
                    <tr>
                        <td><span class="label-m"></span>14</td>
                        <td>57</td>
                        <td>40</td>
                        <td>55,5</td>
                    </tr>
                    <tr>
                        <td><span class="label-l"></span>16</td>
                        <td>59</td>
                        <td>42</td>
                        <td>57</td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th class="title" rowspan="5"><span>JEANS Y PANTALONES</span></td>
                        <th>TALLE</th>
                        <th>CINTURA</th>
                        <th>TIRO</th>
                        <th>LARGO</th>
                    </tr>
                    <tr>
                        <td><span class="label-xs"></span>10</td>
                        <td>31</td>
                        <td>22</td>
                        <td>90</td>
                    </tr>
                    <tr>
                        <td><span class="label-s"></span>12</td>
                        <td>33</td>
                        <td>23</td>
                        <td>90,5</td>
                    </tr>
                    <tr>
                        <td><span class="label-m"></span>14</td>
                        <td>35</td>
                        <td>24</td>
                        <td>91</td>
                    </tr>
                    <tr>
                        <td><span class="label-l"></span>16</td>
                        <td>37</td>
                        <td>25</td>
                        <td>91,5</td>
                    </tr>
                    <tr>
                        <th class="title" rowspan="5"><span>VESTIDOS</span></td>
                        <th>TALLE</th>
                        <th>ANCHO</th>
                        <th>LARGO</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><span class="label-xs"></span>10</td>
                        <td>34</td>
                        <td>66</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span class="label-s"></span>12</td>
                        <td>36</td>
                        <td>71</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span class="label-m"></span>14</td>
                        <td>38</td>
                        <td>76</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span class="label-l"></span>16</td>
                        <td>40</td>
                        <td>81</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
	<?php
}
add_action( 'wp_footer', 'sizes_modal' );