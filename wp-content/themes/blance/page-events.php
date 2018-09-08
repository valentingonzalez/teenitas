<?php
/*
Template Name: Events Template
*/
?>
<?php get_header(); ?>
<?php
$jwstheme_options = $GLOBALS['jwstheme_options'];
$tb_show_page_title = isset($jwstheme_options['tb_page_show_page_title']) ? $jwstheme_options['tb_page_show_page_title'] : 1;
$tb_show_page_breadcrumb = isset($jwstheme_options['tb_page_show_page_breadcrumb']) ? $jwstheme_options['tb_page_show_page_breadcrumb'] : 1;
jwstheme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb);

$tb_show_page_comment = (int) isset($jwstheme_options['page_comment']) ?  $jwstheme_options['page_comment']: 1;
?>
<div class="main-content bt-events">
	<div class="container">
	<div class="main-content ro-container">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; // end of the loop. ?>
	</div>
	</div>
</div>
<?php get_footer(); ?>