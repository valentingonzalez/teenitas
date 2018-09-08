<?php
        global $blance_loop;
            $num_comments = get_comments_number();
			?>
                <div class="post-item layout-1">
                <div class="bog-image">
                <?php 
                echo blance_get_post_thumbnail('large');
                 ?>
                </div>
                <div class="content-blog">
                <div class="content-inner">
                    <?php if(get_the_category_list( ', ' ) ): ?>
				        <div class="meta-post-categories"><?php echo get_the_category_list( ', ' ); ?></div>
		          	<?php endif; ?>
                    <div class="title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <div class="blog-innfo">
                        <span class="author">By <span class="child"><?php the_author() ?></span></span><span class="date">on <span class="child"><?php  echo get_the_date(); ?></span></span>
                    </div>
                    <div class="blog-link"><a class="read-more" href="<?php the_permalink(); ?>"><?php echo $blance_loop['readmore_text'] ?></a><span class="right-link"><span class="comment"><i class=" fa fa-comment-o"></i><span class="child"></span><?php echo $num_comments?></span></span></div>
                </div>
                </div>
                </div>