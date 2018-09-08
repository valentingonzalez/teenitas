<?php get_header(); ?>
<?php
$jwstheme_options = $GLOBALS['jwstheme_options'];
$tb_show_page_title = isset($jwstheme_options['tb_page_show_page_title']) ? $jwstheme_options['tb_page_show_page_title'] : 1;
$tb_show_page_breadcrumb = isset($jwstheme_options['tb_page_show_page_breadcrumb']) ? $jwstheme_options['tb_page_show_page_breadcrumb'] : 1;
jwstheme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb);
?>
	<div class="main-content bt-blog-list">
		<div class="container">
			<div class="row">
				<?php
				$tb_blog_layout = isset($jwstheme_options['tb_blog_layout']) ? $jwstheme_options['tb_blog_layout'] : '2cr';
				$cl_sb_left = isset($jwstheme_options['tb_blog_left_sidebar_col']) ? $jwstheme_options['tb_blog_left_sidebar_col'] : 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
				$cl_content = isset($jwstheme_options['tb_blog_content_col']) ? $jwstheme_options['tb_blog_content_col'] : ( is_active_sidebar('jwstheme-main-sidebar') ? 'col-xs-12 col-sm-12 col-md-9 col-lg-9' : 'col-xs-12 col-sm-12 col-md-12 col-lg-12' );
				if ( !is_active_sidebar('jwstheme-main-sidebar') && !is_active_sidebar('jwstheme-left-sidebar') && !is_active_sidebar('jwstheme-left-sidebar') ) {
					$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				}
				$cl_sb_right = isset($jwstheme_options['tb_blog_right_siedebar_col']) ? $jwstheme_options['tb_blog_right_siedebar_col'] : 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
				?>
				<!-- Start Left Sidebar -->
				<?php if ( $tb_blog_layout == '2cl' ) { ?>
					<div class="<?php echo esc_attr($cl_sb_left) ?> sidebar-left">
						<?php if (is_active_sidebar('jwstheme-left-sidebar')) { dynamic_sidebar('jwstheme-left-sidebar'); } else { dynamic_sidebar('jwstheme-main-sidebar'); } ?>
					</div>
				<?php } ?>
				<!-- End Left Sidebar -->
				<!-- Start Content -->
				<div class="<?php echo esc_attr($cl_content) ?> content">
					<?php
					if( have_posts() ) {
						while ( have_posts() ) : the_post();
							get_template_part( 'framework/templates/blog/entry', get_post_format());
						endwhile;
						
						jwstheme_paging_nav();
					}else{
						get_template_part( 'framework/templates/entry', 'none');
					}
					?>
				</div>
				<!-- End Content -->
				<!-- Start Right Sidebar -->
				<?php if ( $tb_blog_layout == '2cr' ) { ?>
					<div class="<?php echo esc_attr($cl_sb_right) ?> sidebar-right">
						<?php if (is_active_sidebar('jwstheme-right-sidebar')) { dynamic_sidebar('jwstheme-right-sidebar'); } else { dynamic_sidebar('jwstheme-main-sidebar'); } ?>
					</div>
				<?php } ?>
				<!-- End Right Sidebar -->
			</div>
		</div>
	</div>
<?php get_footer(); ?>