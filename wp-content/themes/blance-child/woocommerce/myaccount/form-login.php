<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="form_login">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-sm hidden-xs">
        <div class="form-separator">
            <span>
                Iniciá sesión con
            </span>
        </div>
        <?php echo do_shortcode ('[userpro_social_connect width="400px"]') ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php echo do_shortcode ('[userpro template=login]') ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-lg hidden-md">
        <?php echo do_shortcode ('[userpro_social_connect width="400px"]') ?>
    </div>
</div>