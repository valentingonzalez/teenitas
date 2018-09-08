<?php $blog_img = cs_get_option('blog-thumbnail');
      $blog_tt = cs_get_option('blog-title'); 
      $blog_meta = cs_get_option('blog-meta');  
 ?>   
                        <?php if($blog_img) : ?>              
                        <div class="blog-details-img">
                            <?php 
                            if (has_post_thumbnail()) the_post_thumbnail('jws-imge-crop-thumbnail-blog-classic');
                             ?>
                        </div>
                        <?php endif; ?>
                        <div class="blog-details">
                            <div class="title-and-meta">
                                <?php if($blog_tt) : ?> 
                                <h3><?php the_title(); ?></h3>
                                <?php endif; ?>
                                <?php if($blog_meta) : ?> 
                                <p class="post-meta"><span class="author"><?php esc_html_e('By ' , 'blance') . the_author(); ?></span><span><?php esc_html_e(' on ' , 'blance') ?><?php echo esc_html(get_the_date('d.m.Y'));  ?></span><span class="line">/</span>
                                <?php
                                $terms = get_the_terms( get_the_ID() , 'category' );  
                                foreach ( $terms as $term ) {
                                $term_link = get_term_link( $term );
                                if ( is_wp_error( $term_link ) ) {
                                    continue;
                                }
                                echo '<i class="fa fa-folder-o" aria-hidden="true"></i><a href=" '.esc_url( $term_link ).'">' .$term->name.  '</a>';
                                }
                                $num_comments = get_comments_number();
                                 ?>
                                 <span class="line">/</span>
                                <span class="comment"><i class=" fa fa-comment-o"></i><?php echo  $num_comments  ?><?php esc_html_e(' Comment ' , 'blance') ?></span>
                                </p>
                                 <?php endif; ?>
                            </div>
                            <div class="blog-content">
                                <?php the_content(); ?>
                            </div>
                        </div>