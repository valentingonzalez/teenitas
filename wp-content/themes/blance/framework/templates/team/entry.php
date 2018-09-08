<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="ro-blog-sub-article row">
        <div class="col-md-7">
        <div class="content-team-top">
            <h4 class="ro-uppercase"><?php the_title(); ?></h4>
            <span class="bt-experience"><?php echo get_post_meta(get_the_ID(),'tb_team_experience',true); ?></span>
			<div class="ro-sub-content"><?php the_content(); ?></div>
            <div class="content-meta">
            <h6 class="bt-position"><?php echo get_post_meta(get_the_ID(),'tb_team_position',true); ?><i class="fa fa-map-marker"></i></h6>
            <h6 class="bt-phone"><?php echo get_post_meta(get_the_ID(),'tb_team_phone',true); ?><i class="fa fa-phone"></i></h6>
            </div>
        </div>
        </div>
        <div class="col-md-4">
            <div class="thumbnail-team">
            <?php if ( has_post_thumbnail() ) { ?>
			<?php the_post_thumbnail('jws-imge-crop-thumbnail-team-single'); ?>
            <?php } ?>
            <ul>
                <li><a class="facebook" href="<?php echo get_post_meta(get_the_ID(),'tb_team_facebook',true); ?>"><i class="fa fa-facebook"></i></a></li>
                <li><a class="twitter" href="<?php echo get_post_meta(get_the_ID(),'tb_team_twitter',true); ?>"><i class="fa fa-twitter"></i></a></li>
                <li><a class="google" href="<?php echo get_post_meta(get_the_ID(),'tb_team_google',true); ?>"><i class="fa fa-google-plus"></i></a></li>
            </ul>
            </div>
        </div>
        <div class="col-md-1"></div>	
	</div>
    <?php $code = get_post_meta(get_the_ID(),'tb_team_services',true);
     echo do_shortcode( $code ); ?>
</article>