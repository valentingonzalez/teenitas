<?php  
        global $blance_loop;
        $pp_layout =  cs_get_option( 'pp-style' );
        $options = get_post_meta( get_the_ID(), '_custom_pp_options', true );

        $metro = '';
        if(isset($_GET["layout"])) {
        $_GET["layout"] ==  '';  
        }
        if(isset($_GET["column"])) {
            $_GET["column"] == '';
        }
        
        if ( isset( $options['wc-thumbnail-size'] )  && $pp_layout == "metro" || isset($_GET["layout"]) &&  $_GET["layout"] == "metro" && $options['wc-thumbnail-size']    )  {
            $large = 2;
            $metro = ' metro-item';
        } else {
            $large = 1;
        }
        if(isset($_GET["column"]) && $_GET["column"] == "20") {
            $columns_layout = "20";  
        }elseif(isset($_GET["column"]) && $_GET["column"] == "4") {
            $columns_layout = "3";
        }elseif(isset($_GET["column"]) && $_GET["column"] == "3"){
            $columns_layout = "4";
        }
        elseif(isset($_GET["column"]) && $_GET["column"] == "5"){
            $columns_layout = "20";
        }else {
            $columns_layout =  cs_get_option( 'pp-column' );
        }
        $class_column = "col-md-" . (int) $columns_layout * $large . $metro . " col-sm-6 col-xs-12";
?>
                <div class="portfolio-item <?php echo $class_column ; ?>">
                <div class="pp-ct">
                <div class="portfolio-image">
                <?php 
                
                if ( isset( $options['wc-thumbnail-size'] ) && $options['wc-thumbnail-size'] && $pp_layout == "metro" || isset($_GET["layout"]) &&  $_GET["layout"] == "metro" && $options['wc-thumbnail-size']    )  {
                the_post_thumbnail("jws_portfolio_metro");
                }elseif( $pp_layout == "metro" || isset($_GET["layout"]) && $_GET["layout"] == "metro"  ) {
                  the_post_thumbnail("jws_portfolio_metro_x1");  
                }else {
                  the_post_thumbnail("portfolio-grid"); 
                }
                 ?>
                </div>
                <a href="<?php the_permalink(); ?>">
                    <div class="content-portfolio">
                        <div class="title">
                            <h5><?php the_title(); ?></h5>
                        </div>
                        <?php
                        $terms = get_the_terms( get_the_ID() , 'portfolio_cat' ); 
                        if($terms) {
                            foreach ( $terms as $term ) {
                                $term_link = get_term_link( $term );
                                if ( is_wp_error( $term_link ) ) {
                                    continue;
                            }
                            echo '<a class="category-pp" href=" '.esc_url( $term_link ).'">' .$term->name.  '</a>';
                        }
                        }
                        ?>
                    </div>
                </a>
                </div>
                </div>
          