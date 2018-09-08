<?php

if( !class_exists( 'up_layout_switcher' ) ){
	
	class up_layout_switcher{
		
		function __construct(){
		}
		
		function load_layout( $layout, $user_id, $args, $template, $i ){
			global $userpro;
			$profile_thumb_size = $args['profile_thumb_size'];
			/* Dequeue userpro default style before adding new */
			wp_dequeue_style('userpro_skin_min');
			
			foreach (glob(userpro_path.'profile-layouts/layout'.$layout.'/css/*.css') as $filename) { 
				$filename = basename($filename);
				wp_enqueue_style( "up_layout_style_$filename", userpro_url.'profile-layouts/layout'.$layout.'/css/'.$filename );
			}
			
			foreach (glob(userpro_path.'profile-layouts/layout'.$layout.'/js/*.js') as $filename) {
				$filename = basename($filename);
				wp_enqueue_script("up_layout_script_$filename",userpro_url.'profile-layouts/layout'.$layout.'/js/'.$filename,'','',true);
			}
			
			include_once userpro_path.'profile-layouts/layout'.$layout.'/layout.php';
		}
		
	}
}