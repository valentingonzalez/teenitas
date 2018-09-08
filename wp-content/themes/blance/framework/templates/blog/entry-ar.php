 <?php $num_comments = get_comments_number(); ?>
 <div class="post-item layout-2 col-md-4 col-sm-6 col-xs-12">
                            <div class="bog-image">
                            <a href="<?php the_permalink() ?>">
                            <img src="<?php echo get_the_post_thumbnail_url('' , 'jws-imge-crop-thumbnail-blog-related'); ?>" alt="image-blog" />
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
                                <div class="blog-innfo">
                                    <span class="author">By <span class="child"><?php the_author() ?></span></span><span class="date">on <span class="child"><?php  echo get_the_date(); ?></span></span>
                                </div>
                                <div class="blog-link"><a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e("Read More" , "blance") ?></a><span class="right-link"><span class="comment"><i class=" fa fa-comment-o"></i><span class="child"></span><?php echo $num_comments?></span></span></div>
                            </div>
                            </div>
                            </div>