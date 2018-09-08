<?php 
/**
 * Layout Name: Header blance One
 * Preview Image: /assets/images/headers/header-blance-v1.jpg
 */

# variable
$tb_sticky_menu = ( isset( $jwstheme_options['tb_sticky_menu'] ) && (int) $jwstheme_options['tb_sticky_menu'] == 1 ) ? true : false;
?>

<!-- Start Header -->
<header>
	<div id="jws_header" class="jws-header-v4"><!-- bt-header-stick/bt-header-fixed -->
		<!-- Start Header Top -->
		<div class="top-bar">
			<div class="no_container">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="header-contact l_p_0-3px text-left"><?php echo do_shortcode( cs_get_option( 'header-top-left' ) ); ?></div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="header-contact l_p_1px text-center"><?php echo do_shortcode( cs_get_option( 'header-top-center' ) ); ?></div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                   	    <?php if ( cs_get_option( 'header-top-right' ) ) : ?>
						<div class="header-currency text-right"><?php echo do_shortcode( cs_get_option( 'header-top-right' ) ); ?></div>
    					<?php endif; ?>
                    </div>
                </div>
                </div>
		</div>
		<!-- End Header Top -->

		<!-- Start Header Menu -->
        <div id="mainmenu-area-sticky-wrapper" class="sticky-wrapper">
		<div class="mainmenu-area pll47 plr64" id="menu-area<?php echo esc_attr( ( $tb_sticky_menu == true ) ? ' mainmenu-area ' : '' ); ?>">
            <nav class="menu_nav">
			<div class="no_container">
				<div class="row mainmenu">
                        <div class="col-md-3 col-xs-6">
                            <div class="logo-center text-left">
                            <?php jws_blance_logo(); ?>
                            </div>
                        </div> 
                        <div class="col-md-6 position_fix text-center hidden-xs hidden-sm ">
						<?php
						$attr = array(
                            'theme_location' => 'main_navigation',
							'menu_id' => 'nav',
							'menu' => '',
                            'container' => '',
							'container_class' => 'bt-menu-list hidden-xs hidden-sm ',
							'menu_class'      => ' nav navbar-nav cl-effect-11',
							'echo'            => true,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
                            
						);
                        wp_nav_menu( $attr );
                        ?>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="right-header jws-action flr">
                            <?php 
                            
						    if ( class_exists( 'WooCommerce' ) ) {
						            echo jws_blance_wc_my_account();  
    								if ( class_exists( 'YITH_WCWL' ) ) {
    									global $yith_wcwl;
    									echo '<a class="cb chp hidden-xs" href="' . esc_url( $yith_wcwl->get_wishlist_url() ) . '"><i class="pe-7s-like clo25 ml fz24 midde "></i></a>';
    								}
                                     echo jws_blance_shopping_cart();
   							}
     						?>
                            <div class="search-form">
                            <div class="action-search">
                                <a href="#">
                                    <i class="clo25 fz24 midde ml pe-7s-search"></i>
                                </a>
                            </div>
                            </div>
                            </div>
                        </div>
                        <div class="button_menu hidden-lg hidden-md">
                            <i class="fa fa-bars"></i>
                        </div>  
				</div>
			</div>
          </nav>  
		</div>
       </div> 
		<!-- End Header Menu -->
	</div>
  <?php if ( class_exists( 'WooCommerce' ) && !is_cart() ) : ?>	
		<div class="jws-mini-cart jws-push-menu">
			<div class="jws-mini-cart-content">
				<h3 class="title"><?php esc_html_e( 'YOUR CART', 'blance' );?> <i class="close-cart pe-7s-close pa"></i></h3>
				<div class="widget_shopping_cart_content"></div>
			</div>
		</div><!-- .jws-mini-cart -->
	<?php endif ?>
</header>
<!-- End Header -->
