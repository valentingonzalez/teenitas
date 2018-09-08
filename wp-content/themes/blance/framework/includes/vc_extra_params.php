<?php
//Add extra params vc_row
vc_add_param ( "vc_row", array (
		"type" 			=> "colorpicker",
		"class" 		=> "",
		"heading" 		=> __( "Baground Overlay", 'blance' ),
		"param_name" 	=> "bt_bg_overlay",
		"value" 		=> "",
		"description" 	=> __( "Select color background in this row.", 'blance' )
) );

vc_add_param ( "vc_row", array (
		"type" 			=> "checkbox",
		"heading" 		=> __( "Baground Attachment (Fixed)", 'blance' ),
		"param_name" 	=> "bt_background_attachment_fixed",
		"value" 		=> 'false',
		"description" 	=> __( "Select background attachment fixed in this row.", 'blance' ),
		"group"	 		=> __( "Custom Row Style", 'blance' ),
) );