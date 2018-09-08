<?php get_header(); ?>
<?php $page_title = cs_get_option('golobal-enable-page-title'); if($page_title == "1") : ?>
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
	<div class="main-content ro-container">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>
			<div style="clear: both;"></div>

				
					<?php //if ( comments_open() || get_comments_number() ) comments_template(); ?>
				


		<?php endwhile; // end of the loop. ?>
	</div>
<?php get_footer(); ?>