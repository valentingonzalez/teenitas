            <?php 
            $sticky = ''; 
                if ( is_sticky() ) {
                     $sticky = 'sticky '; 
                } else {
                    $sticky = ''; 
                }
                
             ?>
            <div  class="<?php echo esc_attr($sticky); ?>post-item layout-2 ">
                <div class="bog-image">
                <a href="<?php the_permalink() ?>">
                <?php 
                echo blance_get_post_thumbnail('large');
                 ?>
                 </a>
                </div>
                <div class="content-blog">
                <div class="content-inner">
                    <div class="title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <div class="blog-excrept">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="blog-link"><a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More' , 'blance') ?></a><span class="right-link"><span class="comment"><i class=" fa fa-comment-o"></i><span class="child"></span><?php  $num_comments = get_comments_number(); echo esc_attr($num_comments); ?></span></span></div>
                </div>
                </div>
                </div>