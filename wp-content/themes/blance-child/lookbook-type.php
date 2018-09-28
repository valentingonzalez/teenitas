<?php
    if ( function_exists( 'add_theme_support' ) ) { 
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 280, 210, true ); // Normal post thumbnails
        add_image_size( 'screen-shot', 720, 540 ); // Full size screen
    }
    add_action('init', 'lookbook_register');  
   
    function lookbook_register() {  
        $args = array(  
            'label' => __('Lookbook'),  
            'singular_label' => __('Project'),  
            'public' => true,  
            'show_ui' => true,  
            'capability_type' => 'post', 
            'hierarchical' => false,  
            'rewrite' => true,  
            'supports' => array('title', 'editor', 'thumbnail')  
        );  
    
        register_post_type('lookbook' , $args);
    }

    register_taxonomy("project-type", array("lookbook"), array("hierarchical" => true, "label" => "Project Types", "singular_label" => "Project Type", "rewrite" => true));


    // Edit Metaboxes
    add_action("admin_init", "lookbook_meta_boxes");
    function lookbook_meta_boxes() {  
        add_meta_box("projInfo-meta", "Producto relacionado", "lookbook_meta_options", "lookbook", "side", "low");  
        remove_meta_box('project-typediv', 'lookbook', 'side');
    } 
    function lookbook_meta_options() {  
        global $post;  
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $link = $custom["projLink"][0];
        echo '<br>';
        echo '<select name="projLink">';
        foreach(getProducts() as $product) {
            $s = '';
            if($product['permalink'] == $link)
                $s = 'selected="selected"';
            echo '<option '. $s .' value="'.$product['permalink'].'">'.$product['name'].'</option>';
        }
        echo '</select>';
    }
    function getProducts() {
        $loop = new WP_Query( array('post_type' => 'product'));
        $ret = array();
        foreach ($loop->posts as $p) {
            $product = array (
                "name" => $p->post_title,
                "permalink" => get_permalink($p->ID)
            );
            array_push($ret, $product);
        }
        wp_reset_query();
        return $ret;
    }

    add_action('save_post', 'save_project_link'); 
    
    function save_project_link(){  
        global $post;  
        
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ 
            return $post_id;
        }else{
            update_post_meta($post->ID, "projLink", $_POST["projLink"]); 
        } 
    }
?>