<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-562f7aa6d38d8980" async="async"></script>
<script>    
(function($) {
	"use strict";
	// window.jws_theme_is_mobile_tablet = function() {
    $(document).ready(function() {
        function quanty() {
			/**
             * Add Product Quantity Up Down icon
             */
            $('form.cart .quantity').each(function() {
                $(this).prepend('<span class="qty-minus"><i class="fa fa-angle-left"></i></span>');
                $(this).append('<span class="qty-plus"><i class="fa fa-angle-right"></i></span>');
            });

		}
		quanty() ;
    }); 
        var owl = $('.qick-view-carousel');
        if (owl.children().length > 1) {
        owl.owlCarousel({
        merge: true,
        video: true,
        items: 1,
        smartSpeed: 1000,
        loop: true,
        nav: true,
        dots:true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: false,
        autoplayTimeout: 2000,
        margin: 30,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    }); 
        } else {
          // apply some CSS classes to fake it
        }
           
})(window.jQuery)  
</script>
<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

while ( have_posts() ) : the_post(); ?>
 <div class="product-qickview ">
        <div class="content-image">
        <div class="col-lg-6 pd0">
        <div class=" qick-view-carousel">
		<?php wc_gallery_carousel(); ?>
        </div>
        </div>
        
        <div class="col-lg-6 pd0">
			<div class="summary-content">
				<?php do_action( 'yith_wcqv_product_summary' );
                        jws_theme_woocommerce_sharing()
                 ?>
			</div>
        </div>
        </div>

</div>

<?php endwhile; // end of the loop.