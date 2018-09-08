<?php get_header(); ?>
<?php
$jwstheme_options = $GLOBALS['jwstheme_options'];
$tb_show_page_title = isset($jwstheme_options['tb_post_show_page_title']) ? $jwstheme_options['tb_post_show_page_title'] : 1;
$tb_show_page_breadcrumb = isset($jwstheme_options['tb_post_show_page_breadcrumb']) ? $jwstheme_options['tb_post_show_page_breadcrumb'] : 1;
jwstheme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb);
$tb_post_show_post_nav = (int) isset($jwstheme_options['tb_post_show_post_nav']) ?  $jwstheme_options['tb_post_show_post_nav']: 1;
$tb_post_show_post_author = (int) isset($jwstheme_options['tb_post_show_post_author']) ? $jwstheme_options['tb_post_show_post_author'] : 1;
$tb_post_show_post_comment = (int) isset($jwstheme_options['tb_post_show_post_comment']) ?  $jwstheme_options['tb_post_show_post_comment']: 1;
?>
	<div class="main-content bt-blog-article">
		<div class="row">
			<div class="container">
				<?php
				$tb_blog_layout = isset($jwstheme_options['tb_post_layout']) ? $jwstheme_options['tb_post_layout'] : '2cr';
				$cl_sb_left = isset($jwstheme_options['tb_post_left_sidebar_col']) ? $jwstheme_options['tb_post_left_sidebar_col'] : 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
				$cl_content = isset($jwstheme_options['tb_post_content_col']) ? $jwstheme_options['tb_post_content_col'] : ( is_active_sidebar('jwstheme-main-sidebar') ? 'col-xs-12 col-sm-9 col-md-9 col-lg-9' : 'col-xs-12 col-sm-12 col-md-12 col-lg-12' );
				if ( !is_active_sidebar('jwstheme-main-sidebar') && !is_active_sidebar('jwstheme-left-sidebar') && !is_active_sidebar('jwstheme-left-sidebar') ) {
					$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				}
				$cl_sb_right = isset($jwstheme_options['tb_post_right_siedebar_col']) ? $jwstheme_options['tb_post_right_siedebar_col'] : 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
				?>
				<!-- Start Left Sidebar -->
				<?php if ( $tb_blog_layout == '2cl' ) { ?>
					<div class="<?php echo esc_attr($cl_sb_left) ?> sidebar-left">
						<?php if (is_active_sidebar('jwstheme-left-sidebar')) { dynamic_sidebar($sb_left); } else { dynamic_sidebar('jwstheme-main-sidebar'); } ?>
					</div>
				<?php } ?>
				<!-- End Left Sidebar -->
				<!-- Start Content -->
				<div class="<?php echo esc_attr($cl_content) ?> content bt-blog">
					<?php
					while ( have_posts() ) : the_post();
						if ( wp_attachment_is_image( get_the_ID() ) ) {
							$att_image = wp_get_attachment_image_src( get_the_ID(), "full");
							echo '<img src="'.esc_attr($att_image[0]).'" width="'.esc_attr($att_image[1]).'" height="'.esc_attr($att_image[2]).'"  class="attachment-medium" alt="" />';
						}
					endwhile;
					?>
				</div>
				<!-- End Content -->
				<!-- Start Right Sidebar -->
				<?php if ( $tb_blog_layout == '2cr' ) { ?>
					<div class="<?php echo esc_attr($cl_sb_right) ?> sidebar-right">
						<?php if (is_active_sidebar('jwstheme-right-sidebar')) { dynamic_sidebar($sb_right); } else { dynamic_sidebar('jwstheme-main-sidebar'); } ?>
					</div>
				<?php } ?>
				<!-- End Right Sidebar -->
			</div>
		</div>
	</div>
<?php get_footer(); ?>