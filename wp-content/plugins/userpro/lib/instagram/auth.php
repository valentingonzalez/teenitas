<?php

if ( !defined('ABSPATH') ) {
	//If wordpress isn't loaded load it up.
	$path = $_SERVER['DOCUMENT_ROOT'];
	include_once $path . '/wp-load.php';
}


if(isset($_GET['code'])){
	require_once('../../functions/socials/InstagramAuth.php');
	$code = $_GET['code'];

	$instagram = new InstagramAuth();

	$instagram->instagramUser($code);
}