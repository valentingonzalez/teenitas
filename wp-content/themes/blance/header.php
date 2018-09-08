<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
    $favicon = wp_get_attachment_image_src( cs_get_option( 'favicon' ), 'full', true );

	if ( !empty($favicon) ):
	?>
	<link rel="shortcut icon" href="<?php echo esc_url( $favicon[0] ); ?>" />
    <?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="jws-main"> 
		<?php jws_blance_header(); ?>
