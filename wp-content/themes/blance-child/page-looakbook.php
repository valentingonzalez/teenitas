<?php
    get_header();
    query_posts('post_type=lookbook');
?>

<div id="lookbook" class="group"> 

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php
            $title= str_ireplace('"', '', trim(get_the_title()));
            $desc= str_ireplace('"', '', trim(get_the_content()));
            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $site= get_post_custom_values('projLink'); 
        ?>
        <div class="lookbook-item">
            <a href="<?=$site[0] ?>" class="item" style="background-image: url(<?php echo $feat_image ?>) ">
            </a>
        </div>
            
    <?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>