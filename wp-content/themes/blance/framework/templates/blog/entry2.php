        <?php
        global $blance_loop;
            $num_comments = get_comments_number();
			?>
                <div class="post-item layout-2 <?php echo $class_column ; ?>">
                <div class="bog-image">
                <?php 
                echo blance_get_post_thumbnail('large');
                 ?>
                </div>
                <div class="content-blog">
                <div class="content-inner">
                    <div class="title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <div class="blog-innfo">
                        on <span class="child"><?php  echo get_the_date(); ?></span>
                    </div>
                   
                </div>
                </div>
                </div>