<?php
get_header(); 
$image_id = cs_get_option( 'image_404' );
$attachment = wp_get_attachment_image_src( $image_id, 'full' );
?>

<div id="jws-content">
    <div class="background-404">
    <img src="<?php echo esc_url($attachment[0]) ?>" alt="404-image" />
    </div>
    
	<div class="container">
    <div class="text-inner">
		<section class="error-404 not-found">
			<div id="content-wrapper">
				<h1><?php echo esc_html__( '404 error!', 'blance' ); ?></h1>
				<h3 class="page-title"><?php esc_html_e( "Opps! This page Can't Be Found.", 'blance' ); ?></h3>
				<p><a href="<?php echo esc_url( home_url( '/' ) ) ;?>" rel="home"><?php esc_html_e('Home Page' ,'blance' ); ?></a></p>
			</div>
		</section><!-- .error-404 -->
	</div>
    </div>
</div>


<?php get_footer(); ?>