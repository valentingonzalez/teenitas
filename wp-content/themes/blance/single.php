<?php get_header(); ?>
<?php 
$blog_tag = cs_get_option('blog-tag'); 
$blog_author = cs_get_option('blog-author'); 
$blog_socail = cs_get_option('blog-social'); 
$blog_related = cs_get_option('blog-related'); 
$blog_shortcoe = cs_get_option('blog-content-before-footer'); 
// Get page options
$options = get_post_meta( get_the_ID(), '_custom_post_options', true );

// Get product single style
$style = ( is_array( $options ) && $options['post-single-style'] ) ? $options['post-single-style'] : ( cs_get_option( 'post-single-style' ) ? cs_get_option( 'post-single-style' ) : '1' );
// Get all sidebars
$sidebar = cs_get_option( 'post-sidebar' );
$column_sb = "";
$column_ct = "";
if($style == "1" || $style == "2"  ) {
$column_sb = "col-lg-3 col-md-3 col-sm-12 col-xs-12 ";
$column_ct = "col-lg-9 col-md-9 col-sm-12 col-xs-12 ";  
}else{
$column_sb = " ";
$column_ct = "col-lg-12 col-md-12 col-sm-12 col-xs-12";   
}


 ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-562f7aa6d38d8980" async="async"></script>
     <?php $page_title = cs_get_option('wc-enable-page-title'); if($page_title) : ?>
        <div class="page-header">
    	<div class="no_container">
    			<div class="page-breadcrumbs">
    				<?php
    			   jws_get_breadcrumbs();
    				?>
    			</div>
    	
    	</div>
    </div>
    <?php endif; ?>
	<div style="margin-top: 100px;" class="main-content jws-blog-detail blog-page">
		
			<div class="container">
            <div class="row row-same-height">
				<!-- Start Left Sidebar -->
                <?php if($style == "1" ) : ?>
                <div class="sidebar-blog <?php echo esc_attr($column_sb , "blance") ?>">
                <div class=" sticky-move">
					  <?php if ( is_active_sidebar( $sidebar ) ) {
                            		dynamic_sidebar( $sidebar );
      	                 } elseif ( is_active_sidebar( 'jws-sidebar-blog' ) ) {
                      		dynamic_sidebar( 'jws-sidebar-blog' );
      	               } ?>  
                 </div>                  
                </div>
	            <?php endif; ?>
				<!-- End Left Sidebar -->
				<!-- Start Content -->
				<div class="<?php echo esc_attr($column_ct , "blance") ?>">
                    <div class=" single-blog-page single-blog  ">
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'framework/templates/blog/single/entry', get_post_format());
						//setPostViews(get_the_ID());
					endwhile;
                    
					?>
                    </div>
                    <?php if($blog_tag) :  ?>
                    <div class="blog-meta">
                        <?php  echo jws_blance_get_tags(); ?>
                        <a class="action-link" href="#commentform"><?php esc_html_e('Leave a Comment' , 'blance') ?><i class="fa fa-long-arrow-right" ></i></a>
                    </div>
                    <?php endif; ?>
                    <?php if($blog_socail)  echo jwstheme_social(); ?>
                    <?php if($blog_author)  echo jwstheme_author_render(); ?>
                    <?php if($blog_related) echo jws_related_post(); ?>
                    
                    <?php 
                     // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number()  ) {
				
							comments_template();
						}
                     ?>
				</div>
				<!-- End Content -->
                <?php if($style == "2" ) : ?>
                <div class="sidebar-blog  <?php echo esc_attr($column_sb , "blance") ?>">
                <div class=" sticky-move">
					  <?php if ( is_active_sidebar( $sidebar ) ) {
                            		dynamic_sidebar( $sidebar );
      	                 } elseif ( is_active_sidebar( 'jws-sidebar-blog' ) ) {
                      		dynamic_sidebar( 'jws-sidebar-blog' );
      	               } ?> 
                  </div>          
                </div>
                <?php endif; ?>
			</div>
		</div>
	</div>
<div class="before-footer">   
<?php echo do_shortcode( ''.$blog_shortcoe.'' );?> 
</div>    
<?php get_footer(); ?>