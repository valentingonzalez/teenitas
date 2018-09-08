<?php
/* 
Template Name: Portfolio Page
*/
get_header( );  ?>
    <?php 
    if(!isset($_GET["column"])) {
      $post_per_page_pp = cs_get_option('pp-number-per-page');   
    }
     if(isset($_GET["number"]) &&  $_GET["number"] == "10") { 
        $post_per_page_pp = "10";
     }elseif(isset($_GET["number"]) && $_GET["number"] == "7") {
        $post_per_page_pp = "7";
     }elseif(isset($_GET["number"]) && $_GET["number"] == "12") {
        $post_per_page_pp = "12";
     }elseif(isset($_GET["number"]) && $_GET["number"] == "15") {
        $post_per_page_pp = "15";
     }elseif(isset($_GET["number"]) && $_GET["number"] == "9") {
        $post_per_page_pp = "9";
     }
     else{$post_per_page_pp = cs_get_option('pp-number-per-page');}
            
     
        $args = array(
	    	'post_type' => 'portfolio',
	    	'status' => 'published',
	    	'paged' => $paged,	
	    	'posts_per_page' => $post_per_page_pp
		);
        if( isset($_GET["column"]) && $_GET["column"] == "20") {
          $columns_layout = "20";  
        }elseif(isset($_GET["column"]) &&$_GET["column"] == "4") {
           $columns_layout = "3";
        }elseif(isset($_GET["column"]) &&$_GET["column"] == "3"){
           $columns_layout = "4";
        }elseif(isset($_GET["column"]) &&$_GET["column"] == "5"){
           $columns_layout = "20";
        }else {
            $columns_layout =  cs_get_option( 'pp-column' );
        }
        $turn_full_width = cs_get_option('pp-layout-full');
        $portfolio_query = new WP_Query($args);
                            $class = $data = $sizer = '';
                            $class = 'jws-masonry';
                        	$data  = 'data-masonry=\'{"selector":".portfolio-item  ", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
                        	$sizer = '<div class="grid-sizer size-'.$columns_layout.'"></div>';
                    
    ?>
    <?php $page_title = cs_get_option('pp-enable-page-title'); if($page_title == "1") : ?>
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
	<?php if ( have_posts() ) : ?>
					<div style="padding: 100px 30px 70px 30px;" class="<?php if($turn_full_width == '1' || isset($_GET["full"]) && $_GET["full"] == "width" ) {echo 'no_' ; } ?>container">
                      <div class="portfolio-container ">
                
                    	    
                            <div class="row <?php echo esc_attr( $class ); ?>" <?php echo wp_kses_post( $data ); ?>>
                            <?php
        						echo wp_kses_post( $sizer );
        					?>
					       	<?php while ( $portfolio_query->have_posts() ) :
                               $portfolio_query->the_post();
                               
                               ?>
                                
								<?php get_template_part( 'framework/templates/portfolio/entry' ); ?>
                                
							<?php endwhile; // end of the loop. ?>
                            </div>
                            
						</div>  
                        
                        <?php endif; ?>
				</div>
                <?php
				if( have_posts() ) {
						while ( have_posts() ) : the_post();
							the_content();
						endwhile;
						}
		        ?>

<?php get_footer( ); ?>
