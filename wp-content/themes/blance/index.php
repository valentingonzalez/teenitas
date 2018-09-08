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
	<div class="main-content" style="padding: 100px 0px;">
		<div class="container">
			<div class="row">
				<?php
					if( have_posts() ) {
						while ( have_posts() ) : the_post();
							get_template_part( 'framework/templates/blog/home/entry', get_post_format());
						endwhile;
					}else{
						get_template_part( 'framework/templates/entry', 'none');
					}
					?>
				</div>
			</div>
		</div>
<?php get_footer(); ?>