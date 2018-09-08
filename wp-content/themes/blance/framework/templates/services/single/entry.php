<div class="sevices-details-img">
    <?php 
    if (has_post_thumbnail()) the_post_thumbnail('jws-imge-crop-thumbnail-services-single');
    ?>
    </div>
    <div class="title-services">
        <h5>
            <?php the_title(); ?>
        </h5>
    </div>
    <div class="blog-content">
         <?php the_content(); ?>
    </div>
 </div>