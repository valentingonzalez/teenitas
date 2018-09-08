<?php
/* Load Shortcodes */
require_once ABS_PATH_FR . '/shortcodes/shortcodes.php';
require_once ABS_PATH_FR . '/shortcodes/vc_config.php';
require_once ABS_PATH_FR . '/woocommerce-function.php';
require_once ABS_PATH_FR . '/megamenu/mega-menu.php';
require_once ABS_PATH_FR . '/css_inline.php';
/* Load Mega menu admin */
/* Vc extra Fields */
if (class_exists('Vc_Manager')) {
    function vc_add_extra_field( $name, $form_field_callback, $script_url = null ) {
            return WpbakeryShortcodeParams::addField( $name, $form_field_callback, $script_url );
    }
}
/* Vc extra field */
if (function_exists("vc_add_extra_field")){
	require_once ABS_PATH_FR.'/includes/vc_extra_fields.php';
}