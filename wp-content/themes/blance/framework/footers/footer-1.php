<?php 
/**
 * Layout Name: Footer blance One
 * Preview Image: /assets/images/footers/footer-blance-v1.jpg
**/
?>
	<div id="footer-jws" class="footer-v1">
        <div class="container">
            <div class="row row-same-height footer-top"> 
		<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 email">
            <?php
		          if ( is_active_sidebar( 'jws-email-sidebar' ) ) {
		              dynamic_sidebar( 'jws-email-sidebar' );
		          }
            ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 location">
            <?php
		          if ( is_active_sidebar( 'jws-location-sidebar' ) ) {
		              dynamic_sidebar( 'jws-location-sidebar' );
		          }
            ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 infomation">
            <?php
		          if ( is_active_sidebar( 'jws-infomation-sidebar' ) ) {
		              dynamic_sidebar( 'jws-infomation-sidebar' );
		          }
            ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 instagram">
             <?php
		          if ( is_active_sidebar( 'jws-instagram-sidebar' ) ) {
		              dynamic_sidebar( 'jws-instagram-sidebar' );
		          }
            ?>
        </div>
        	
	</div>
</div>
<div class="footer-bottom text-center">
            <?php echo do_shortcode( cs_get_option( 'footer-copyright' ) ); ?>
</div>
</div>
</div><!-- #wrap -->