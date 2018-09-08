<?php get_header();
$options = get_post_meta( get_the_ID(), '_custom_pp_options', true );
$pp_shortcoe =  $options['shortcode-before-ft']; 
$pp_sub =  $options['sub-content'] ;
$options['enable-sidebar'];
$column = '';
$column_sidebar = '';
if($options['enable-sidebar']) {
 $column = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
$column_sidebar = ' col-lg-4 col-md-4 col-sm-12 col-xs-12 ';   
}else {
  $column = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
  $column_sidebar = ' ';    
}
 ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-562f7aa6d38d8980" async="async"></script>
  <?php $page_title = cs_get_option('wc-enable-page-title'); if($page_title) : ?>
        <div class="page-header">
    	<div class="no_container">
    			<div class="page-breadcrumbs">
    				<?php
    			   jws_get_breadcrumbs();
                    //blance_products_links();
    				?>
    			</div>
    	
    	</div>
    </div>
    <?php endif; ?>
<div class="container portfolio-single" style="padding-top: 100px;padding-bottom: 27px;">
<div class="content ">
                    <?php if(!$options['enable-sidebar']) {?>
                    <div class="pp-content-title">
                        <h5 class="pp-title"><?php the_title(); ?></h5>
                        <p class="pp-des"><?php echo $pp_sub; ?></p>
                        <div class="pp-info">
                            <span class="date"><span><?php echo esc_html('Date: ' , 'blance')?></span><?php  echo  get_the_date(); ?></span>
                             <?php if(is_object_in_term(get_the_ID(), 'portfolio_cat')) { ?> 
                            <span class="category">
                                <?php
                                    '<span>'.esc_html_e('Category: ' , 'blance').'</span>';
                                    $terms = get_the_terms( get_the_ID() , 'portfolio_cat' );  
                                    foreach ( $terms as $term ) {
                                    $term_link = get_term_link( $term );
                                    if ( is_wp_error( $term_link ) ) {
                                        continue;
                                    }
                                    echo '<a class="category-pp" href=" '.esc_url( $term_link ).'">' .$term->name. '<span class="spec">, </span>' . '</a>';
                                    }
                                     ?>
                                     </span>
                                      <?php } ?>
                                     
                                     <span class="tags">
                                     <?php if( the_tags()) { ?> 
                                        <?php esc_html_e('Tags: ' , 'blance')   ?> <?php  the_tags('', ', '); ?>
                                        <?php } ?>
                                    </span>
                                    
                        </div>
                    </div>
                     <?php } ?>
                     <div class="row row-same-height">
                    <div class="pp-content-vc <?php echo $column; ?>">
                    <?php 
                    while ( have_posts() ) : the_post();
						the_content();
						//setPostViews(get_the_ID());
					endwhile; ?>
                    </div> 
                    <?php
                    if($options['enable-sidebar']) {?>
                      <div class="sidebar <?php echo $column_sidebar; ?>">
                        <div class="pp-content-title sticky-move ">
                            <h5 class="pp-title"><?php the_title(); ?></h5>
                            <p class="pp-des"><?php echo $pp_sub; ?></p>
                            <div class="pp-info">
                                <span class="date"><span><?php echo esc_html('Date: ' , 'blance')?></span><?php  echo  get_the_date(); ?></span>
                                <span class="category">
                                    <?php
                                        $terms = get_the_terms( get_the_ID() , 'portfolio_cat' );  
                                        foreach ( $terms as $term ) {
                                        $term_link = get_term_link( $term );
                                        if ( is_wp_error( $term_link ) ) {
                                            continue;
                                        }
                                        echo '<a class="category-pp" href=" '.esc_url( $term_link ).'"><span>'.esc_html_e('Category: ' , 'blance').'</span>' .$term->name.  '</a>';
                                        }
                                         ?>
                                         </span>
                                         <span class="tags">
                                         <?php if( the_tags()) { ?> 
                                            <?php esc_html_e('Tags: ' , 'blance')   ?> <?php  the_tags('', ', '); ?>
                                        <?php } ?>
                                        </span>
                            </div>
                        </div>
                     </div> 
                     <?php } ?>
                      </div> 
                    <div class="pp-content-social">
                    <?php
                     echo jwstheme_social();
                     ?>
                     </div>
                     <div class="nav-post">
                     
                 
                        <?php 
                        $prev_post = get_previous_post(); $next_post = get_next_post();    
                         if(!empty($prev_post)):
                         ?><div class="nav-box previous" style="float:left;"><?php
                               echo '<a href="'.get_the_permalink($prev_post->ID).'" >'.'<div class="text-nav"><span class="prev"><i class="fa fa-long-arrow-left"></i>'.esc_html('previous post' , 'temi').'</span><p>'.get_the_title($prev_post->ID).'</p></div>'. $pevthumbnail = get_the_post_thumbnail($prev_post->ID, array(50,50) ) .'</a>';  
                            ?></div> <?php    
                          endif;
                        if(!empty($next_post)):
                            ?><div class="nav-box next" style="float:right;"><?php
                               echo '<a href="'.get_the_permalink($next_post->ID).'" >'. $pevthumbnail = get_the_post_thumbnail($next_post->ID, array(50,50) ) .'<div class="text-nav"><span class="next-bt">'.esc_html('next post' , 'temi').'<i class="fa fa-long-arrow-right"></i></span><p>'.get_the_title($next_post->ID).'</p></div></a>';  
                            ?></div> <?php   

                        endif;
                        
                        ?>
                        
                        
                        
                    
                     <div class="icon-get-link"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa fa-bars" aria-hidden="true"></i></a></div>  
                     </div> 
                     
</div>
</div>
<div class="before-footer">   
<?php echo do_shortcode( ''.$pp_shortcoe.'' );?> 
</div>   
<?php get_footer(); ?>