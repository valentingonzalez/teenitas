<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="ro-blog-sub-article">
		<?php if ( has_post_thumbnail() ) { ?>
			<?php the_post_thumbnail('full'); ?>
		<?php } ?>
	<h4 class="ro-uppercase"><?php the_title(); ?></h4>
	<p class="ro-sub-content"><?php the_content(); ?></p>
	</div>
</article>