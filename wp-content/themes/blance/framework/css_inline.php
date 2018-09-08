<?php
/**
 * Render Css Inline
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jws_theme_custom_css' ) ) {
	function jws_theme_custom_css( $css = array() ) {

		// Logo width
		$logo_width = cs_get_option( 'logo-max-width' );
		if ( ! empty( $logo_width ) ) {
			$css[] = '
				.jws-branding {
					max-width: ' . esc_attr( $logo_width ) . 'px;
					margin: auto;
				}
			';
		}
		// Logo Height
		$logo_height = cs_get_option( 'logo-light-height' );
		if ( ! empty( $logo_height ) ) {
			$css[] = '
				.logo-blance {
					line-height: ' . esc_attr( $logo_height ) . 'px;
				}
			';
		}
        // Logo Height
		$right_header_height = cs_get_option( 'right-header-light-height' );
		if ( ! empty( $right_header_height ) ) {
			$css[] = '
				#jws_header .right-header {
					height: ' . esc_attr( $right_header_height ) . 'px;
				}
                .jws-my-account {
					line-height: ' . esc_attr( $right_header_height ) . 'px;
				}
			';
		}
		// Boxed layout
		$boxed_bg = cs_get_option( 'boxed-bg' );

		if ( ! empty( $boxed_bg['image'] ) ) {
			$css[] = '.boxed {';
				$css[] = '
					background-image:  url(' .  esc_url( $boxed_bg['image'] ) . ');
					background-size:       ' .  $boxed_bg['size'] .       ';
					background-repeat:     ' .  $boxed_bg['repeat'] .     ';
					background-position:   ' .  $boxed_bg['position'] .   ';
					background-attachment: ' .  $boxed_bg['attachment'] . ';
				';
				if ( ! empty( $boxed_bg['color'] ) ) {
					$css[] = 'background-color: ' .  $boxed_bg['color'] .';';
				}
			$css[] = '}';
		}

		// WC page title
		$wc_head_bg = cs_get_option( 'wc-pagehead-bg' );
        if(class_exists( 'WooCommerce' ) ) {
            $is_shop = is_shop();
        }else {
            $is_shop = '';
        }
		if ( $is_shop  && ! empty( $wc_head_bg ) ) {
			$css[] = '.woocommerce-page .page-header {';
				$css[] = '
					background-image:  url(' .  esc_url( $wc_head_bg['image'] ) . ');
					background-size:       ' .  $wc_head_bg['size'] .       ';
					background-repeat:     ' .  $wc_head_bg['repeat'] .     ';
					background-position:   ' .  $wc_head_bg['position'] .   ';
					background-attachment: ' .  $wc_head_bg['attachment'] . ';
				';
				if ( ! empty( $wc_head_bg['color'] ) ) {
					$css[] = 'background-color: ' .  $wc_head_bg['color'] .';';
				}
			$css[] = '}';
		}
        $wc_head_single_bg = cs_get_option( 'wc-pagehead-single-bg');  
        if ( is_single() && ! empty( $wc_head_single_bg ) ) {
			$css[] = '.single-product .page-header {';
				$css[] = '
					background-image:  url(' .  esc_url( $wc_head_single_bg['image'] ) . ');
					background-size:       ' .  $wc_head_single_bg['size'] .       ';
					background-repeat:     ' .  $wc_head_single_bg['repeat'] .     ';
					background-position:   ' .  $wc_head_single_bg['position'] .   ';
					background-attachment: ' .  $wc_head_single_bg['attachment'] . ';
				';
				if ( ! empty( $wc_head_single_bg['color'] ) ) {
					$css[] = 'background-color: ' .  $wc_head_single_bg['color'] .';';
				}
			$css[] = '}';
		} 
      

		// Portfolio page title
		$portfolio_head_bg = cs_get_option( 'pp-pagehead-bg' );
		if ( ! empty( $portfolio_head_bg ) ) {
			$css[] = '.page-template-archive-portfolio .page-header {';
				$css[] = '
					background-image:  url(' .  esc_url( $portfolio_head_bg['image'] ) . ');
					background-size:       ' .  $portfolio_head_bg['size'] .       ';
					background-repeat:     ' .  $portfolio_head_bg['repeat'] .     ';
					background-position:   ' .  $portfolio_head_bg['position'] .   ';
					background-attachment: ' .  $portfolio_head_bg['attachment'] . ';
				';
				if ( ! empty( $portfolio_head_bg['color'] ) ) {
					$css[] = 'background-color: ' .  $portfolio_head_bg['color'] .';';
				}
			$css[] = '}';
		}
        //  page golobo title
		$golobal_head_bg = cs_get_option( 'golobal-enable-page-title-bg' );
		if ( ! empty( $golobal_head_bg ) ) {
			$css[] = ' .page-header {';
				$css[] = '
					background-image:  url(' .  esc_url( $golobal_head_bg['image'] ) . ');
					background-size:       ' .  $golobal_head_bg['size'] .       ';
					background-repeat:     ' .  $golobal_head_bg['repeat'] .     ';
					background-position:   ' .  $golobal_head_bg['position'] .   ';
					background-attachment: ' .  $golobal_head_bg['attachment'] . ';
				';
				if ( ! empty( $golobal_head_bg['color'] ) ) {
					$css[] = 'background-color: ' .  $golobal_head_bg['color'] .';';
				}
			$css[] = '}';
		}


		// Footer background
		$footer_bg = cs_get_option( 'footer-bg' );

		if ( ! empty( $footer_bg['image'] ) ) {
			$css[] = '.footer__top {';
				$css[] = '
					background-image:  url(' .  esc_url( $footer_bg['image'] ) . ')     ;
					background-size:       ' .  esc_attr( $footer_bg['size'] ) .       ';
					background-repeat:     ' .  esc_attr( $footer_bg['repeat'] ) .     ';
					background-position:   ' .  esc_attr( $footer_bg['position'] ) .   ';
					background-attachment: ' .  esc_attr( $footer_bg['attachment'] ) . ';
				';
				if ( ! empty( $footer_bg['color'] ) ) {
					$css[] = 'background-color: ' .  $footer_bg['color'] .';';
				}
			$css[] = '}';
		}

		// Typography
		$body_font    = cs_get_option( 'body-font' );
		$heading_font = cs_get_option( 'heading-font' );
        $body_font2 = cs_get_option( 'body-font-2' );
        
		$css[] = 'body , .font-body {';
			// Body font family
			$css[] = 'font-family: "' . $body_font['family'] . '";';
			if ( '100italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 100;
					font-style: italic;
				';
			} elseif ( '300italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 300;
					font-style: italic;
				';
			} elseif ( '400italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 400;
					font-style: italic;
				';
			} elseif ( '700italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 700;
					font-style: italic;
				';
			} elseif ( '800italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 700;
					font-style: italic;
				';

			} elseif ( '900italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 900;
					font-style: italic;
				';
			} elseif ( 'regular' == $body_font['variant'] ) {
				$css[] = 'font-weight: 400;';
			} elseif ( 'italic' == $body_font['variant'] ) {
				$css[] = 'font-style: italic;';
			} else {
				$css[] = 'font-weight:' . $body_font['variant'] . ';';
			}

			// Body font size
			if ( cs_get_option( 'body-font-size' ) ) {
				$css[] = 'font-size:' . cs_get_option( 'body-font-size' ) . 'px;';
			}

			// Body color
			if ( cs_get_option( 'body-color' ) ) {
				$css[] = 'color:' . cs_get_option( 'body-color' );
			}
		$css[] = '}';
        $css[] = 'body .banner-inner  {';
			// Body color
            
            if ( cs_get_option( 'body-font-2' )) {
				$css[] = 'font-family: "' . $body_font2['family']  . '";';
			}
			if ( cs_get_option( 'body-color' ) ) {
				$css[] = 'color:' . cs_get_option( 'body-color' );
			}
		$css[] = '}';
		$css[] = 'a , h1, h2, h3, h4, h5, h6{';
			$css[] = 'font-family: "' . $heading_font['family'] . '";';
			if ( '100italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 100;
					font-style: italic;
				';
			} elseif ( '300italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 300;
					font-style: italic;
				';
			} elseif ( '400italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 400;
					font-style: italic;
				';
			} elseif ( '500italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 500;
					font-style: italic;
				';
			} elseif ( '600italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 600;
					font-style: italic;
				';
			} elseif ( '700italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 700;
					font-style: italic;
				';
			} elseif ( '900italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 900;
					font-style: italic;
				';
			} elseif ( 'regular' == $heading_font['variant'] ) {
				$css[] = 'font-weight: 400;';
			} elseif ( 'italic' == $heading_font['variant'] ) {
				$css[] = 'font-style: italic;';
			} else {
				$css[] = 'font-weight:' . $heading_font['variant'];
			}
		$css[] = '}';
		
		if ( cs_get_option( 'heading-color' ) ) {
			$css[] = 'h1, h2, h3, h4, h5, h6 , #jws_header .sticky-wrapper .menu_nav .mainmenu .nav > li > .sub-menu-dropdown a:hover {';
				$css[] = 'color:' . cs_get_option( 'heading-color' );
			$css[] = '}';
              $css[] = ' #jws_header .sticky-wrapper .menu_nav .mainmenu .nav > li > .sub-menu-dropdown a:hover:before {';
				$css[] = 'background-color:' . cs_get_option( 'heading-color' );
			$css[] = '}';
		}

		if ( cs_get_option( 'h1-font-size' ) ) {
			$css[] = 'h1 { font-size:' . cs_get_option( 'h1-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h2-font-size' ) ) {
			$css[] = 'h2 { font-size:' . cs_get_option( 'h2-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h3-font-size' ) ) {
			$css[] = 'h3 { font-size:' . cs_get_option( 'h3-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h4-font-size' ) ) {
			$css[] = 'h4 { font-size:' . cs_get_option( 'h4-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h5-font-size' ) ) {
			$css[] = 'h5 { font-size:' . cs_get_option( 'h5-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h6-font-size' ) ) {
			$css[] = 'h6 { font-size:' . cs_get_option( 'h6-font-size' ) . 'px; }';
		}
		// Primary color
		$primary_color = cs_get_option( 'primary-color' );
		if ( $primary_color ) {
			$css[] = '
				a:hover, a:active,
				.inside-thumb a:hover,
				.jws-blog-slider .post-thumbnail > div a:hover,
				.shop-top-sidebar .product-categories li.current-cat a,
				.quantity .qty a:hover,
				.cart .yith-wcwl-add-to-wishlist a:hover,
				.woocommerce-MyAccount-navigation ul li:hover a,
				.woocommerce-MyAccount-navigation ul li.is-active a {
					color: ' . esc_attr( $primary_color ) . ';
				}
			
				input[type="submit"]:hover,
				button:hover,
				a.button:hover,
				.jws-ajax-load a:hover,
				.widget .tagcloud a:hover,
				.jws-ajax-load a:hover,
				.cart .yith-wcwl-add-to-wishlist:hover {
					border-color: ' . esc_attr( $primary_color ) . ';
				}
			
				input[type="submit"]:hover,
				button:hover,
				a.button:hover,
				.signup-newsletter-form input.submit-btn:hover,
				.widget .tagcloud a:hover,
				.widget_price_filter .ui-slider-range,
				.widget_price_filter .ui-state-default,
				.jws-mini-cart .checkout,
				.jws-ajax-load a:hover,
				.metaslider .flexslider .flex-prev, 
				.metaslider .flexslider .flex-next,
				.single_add_to_cart_button,
				.jws_wcpb_add_to_cart.single_add_to_cart_button, {
					background-color: ' . esc_attr( $primary_color ) . ';
				}
			';
		}
         // three color
		$three_color = cs_get_option( 'three-color' );
		if ( $three_color) {
			$css[] = '
	           .sidebar-blog .widget_tag_cloud .tagcloud a , .archive .post-item.layout-2 .title h5 a:hover , .post-slider .post-item.layout-2 .content-blog .title h5 a:hover , 	.post-slider .post-item.layout-1 .content-blog .content-inner .title h5 a:hover ,  .menu-sidebar-fixed .menu-content .menu-bottom .social-wrap ul li a , .price del .woocommerce-Price-amount, .tb-products-grid article .product-content .item-bottom a , .blance-blog-holder .post-item .content-blog .title a:hover , #content .action-filter-swaper .layout-shop .wc-col-switch a ,	.catalog-sidebar .widget_layered_nav .pa_size li a, .shop-detail-sidebar .widget_layered_nav .pa_size li a , #content .action-filter-swaper .widgets-area .blance_attributes_filter .pa_size ul li a .nav-title , #content .action-filter-swaper .widgets-area .blance-price-filter-list ul li a , #content .action-filter-swaper .widgets-area .product-sort-by ul li a , #content .action-filter-swaper .widgets-area .blance_attributes_filter .pa_color ul li.show-color .count-atr , .woocommerce .product-bottom .tab-product .woocommerce-tabs .wc-tabs li a , 	.woocommerce div.product .content-product-right .shop-bottom .info-product .vg-share-link a , .slick-arrow.slick-disabled , .woocommerce div.product .content-product-right .shop-top .woocommerce-product-rating a , .woocommerce div.product .content-product-right .shop-bottom .info-product .product_meta > span a{
					color: ' . esc_attr( $three_color ) . ';
				}
			';
		}
         // four color
		$four_color = cs_get_option( 'four-color' );
		if ( $four_color) {
			$css[] = '
              .woocommerce-order-received .woocommerce .woocommerce-thankyou-order-received ,  .jws-push-menu .widget_shopping_cart_content .edit-cart:hover , .jws-push-menu .widget_shopping_cart_content .shipping {
					color: ' . esc_attr( $four_color ) . ';
				}
			
			     .woocommerce-order-received .woocommerce .woocommerce-thankyou-order-received , .jws-push-menu .widget_shopping_cart_content .edit-cart:hover	 {
					border-color: ' . esc_attr( $four_color ) . ';
				}
			
			     .jws-push-menu .widget_shopping_cart_content .jws-cart-panel-summary .woocommerce-mini-cart__buttons.buttons a {
					background-color: ' . esc_attr( $four_color ) . ';
				}
			';
		}
          // four color
		$five_color = cs_get_option( 'five-color' );
		if ( $five_color) {
			$css[] = '
			
			     .blas-filter-cat {
					background-color: ' . esc_attr( $five_color ) . ';
				}
			';
		}
		// Secondary color
		$secondary_color = cs_get_option( 'secondary-color' );
		if ( $secondary_color ) {
			$css[] = '
				a,
				h1, h2, h3, h4, h5, h6,
				input[type="submit"],
				button,
				a.button,
				.holder ,.archive .post-item.layout-2 .blog-innfo .child , .woocommerce div.product .content-product-right .shop-bottom form .variations tr td .tawcvs-swatches .swatch-label , .menu-sidebar-fixed .menu-content .menu-bottom .social-wrap ul li a:hover ,  .woocommerce-Price-amount:last-child , .tb-products-grid article .product-content .item-bottom a:hover , .woocommerce div.product .content-product-right .shop-bottom .yith-btn .product-compare-button a:before , .woocommerce div.product .content-product-right .shop-bottom .yith-btn .yith-wcwl-add-to-wishlist > div > a:before , .woocommerce-order-received .woocommerce-thankyou-order-details li , .woocommerce-cart .woocommerce .cart-empty , .woocommerce-checkout .woocommerce .woocommerce-info , .woocommerce-checkout #ship-to-different-address span , .checkout-order-review .woocommerce-checkout-review-order table tbody tr td , .jws-push-menu .widget_shopping_cart_content .jws-cart-panel-summary .woocommerce-mini-cart__total.total , .cart-actions .coupon .button , .shop_table td.product-subtotal span ,.shop_table td.product-price > span , .jws-push-menu .widget_shopping_cart_content .edit-cart , .catalog-sidebar .widget_product_categories .product-categories li.current-cat ,.catalog-sidebar .widget_product_categories .product-categories li:hover, .catalog-sidebar .widget_layered_nav .pa_size li.chosen a, .shop-detail-sidebar .widget_layered_nav .pa_size li.chosen a  , .catalog-sidebar .widget_layered_nav .pa_size li.chosen:before, .shop-detail-sidebar .widget_layered_nav .pa_size li.chosen:before ,  .catalog-sidebar .widget_layered_nav .pa_size li:hover a, .shop-detail-sidebar .widget_layered_nav .pa_size li:hover a  , .catalog-sidebar .widget_layered_nav .pa_size li:hover:before, .shop-detail-sidebar .widget_layered_nav .pa_size li:hover:before ,  #content .action-filter-swaper .widgets-area .shop-filter-actived .found ,  #content .action-filter-swaper .widgets-area .product-sort-by ul li a.active , #content .action-filter-swaper .widgets-area .blance_attributes_filter .pa_size ul li.chosen .nav-title , #content .action-filter-swaper .widgets-area .blance-price-filter-list ul li a.actived ,   .form-custom .mc4wp-form-fields button , #content .action-filter-swaper .widgets-area .blance_attributes_filter .pa_color ul li.chosen .count-atr , .clo25 ,.page-header .page-breadcrumbs .breadcrumbs , #content .action-filter-swaper .layout-shop .wc-col-switch a.active , #content .action-filter-swaper .layout-shop .wc-col-switch span , #content .action-filter-swaper .shop-toolbar .toolbar-right span ,  .woocommerce div.product .content-product-right .shop-bottom .strap-product form .yith-wfbt-items li label input:after , .woocommerce label ,  .woocommerce .product-bottom .tab-product .woocommerce-tabs .wc-tabs li.active a ,  .woocommerce div.product .content-product-right .shop-bottom .info-product .vg-share-link a:hover ,.woocommerce div.product .price .amount , .woocommerce div.product .content-product-right .shop-bottom form .variations tr td label , .star-rating span:before , .stars [class*="star"] ,  .woocommerce .product-bottom .tab-product .woocommerce-tabs .panel .woocommerce-Reviews #comments .comment-text .meta strong ,  .woocommerce label ,  .blance-info-box.icon-alignment-top .box-icon-wrapper , .btn-banner , .woocommerce div.product .content-product-right .shop-top .price ,     .slick-arrow , .woocommerce div.product .content-product-right .shop-top .price ,
                .cart-actions .updatecart .button , .woocommerce-cart .woocommerce-cart-form__cart-item .quantity,
                  .shop-bottom .quantity , .blance-products-element 
                  .products-footer .btn , .owl-carousel .owl-nav div {
					color: ' . esc_attr( $secondary_color ) . ';
				}
			   .single-post .comments-area .comment-respond input:focus , .single-post .comments-area .comment-respond textarea:focus , #back-to-top , .wpcf7 form textarea:focus , .woocommerce div.product .content-product-right .shop-bottom form .variations tr td .tawcvs-swatches .swatch-label.selected ,	.jws-row .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab > a:focus, 
				.jws-row .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab > a:hover,
				.jws-row .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active > a ,.blance-products-loaders:after , .woocommerce .woocommerce-pagination ul.page-numbers li ul.page-numbers li a, .woocommerce-page .woocommerce-pagination ul.page-numbers li a ,  .woocommerce-cart .woocommerce  .button.wc-backward ,  .btn-banner ,  .cart-actions .updatecart .button , .blance-products-loader:after , .woocommerce .woocommerce-pagination ul.page-numbers li ul.page-numbers li a span:after, .woocommerce-page .woocommerce-pagination ul.page-numbers li a span:after ,     .owl-carousel .owl-nav div:hover ,      .woocommerce div.product .content-product-right .shop-bottom .single_add_to_cart_button, 
                    .cart-actions .coupon .button , .jws-push-menu .widget_shopping_cart_content .edit-cart , .woocommerce div.product .content-product-right .shop-bottom .single_add_to_cart_buttons , .blog-footer .btn.basel-blog-load-more {
					border-color: ' . esc_attr( $secondary_color ) . ';
				}
			.ui-slider-horizontal .ui-slider-range ,	.sidebar-blog .widget_tag_cloud .tagcloud a:hover , #back-to-top:hover , .woocommerce-cart .woocommerce  .button.wc-backward , .section-title:before,
				.section-title:after ,.tb-products-grid article .product-thumb .btn-inner-center a:hover ,  .woocommerce-checkout .checkout_coupon .button , .woocommerce-checkout .woocommerce-form-login .form-row .button ,  .checkout-order-review .woocommerce-checkout-review-order .woocommerce-checkout-payment .place-order .button ,  .cart-collaterals .cart_totals .wc-proceed-to-checkout a ,  .btn-banner:hover ,  .woocommerce div.product .content-product-right .shop-bottom .strap-product form .yith-wfbt-submit-block .yith-wfbt-submit-button ,        .product-thumb .onsale , .product-thumb .newpt ,   .owl-carousel .owl-nav div:hover ,  .woocommerce div.product .content-product-right .shop-bottom .single_add_to_cart_button, .woocommerce div.product .content-product-right .shop-bottom .single_add_to_cart_buttons {
					background-color: ' . esc_attr( $secondary_color ) . ';
				}
			';
		}
       
		// Header Top color
		$header_top_color = cs_get_option( 'header-top-color' );
		if ( $header_top_color ) {
			$css[] = '
			     #jws_header .top-bar .header-currency form ,.header-contact,
                .header-contact a , 
				.header-contact,
				.top-bar .woocommerce-currency-switcher-form .wSelect-selected {
					color: ' . esc_attr( $header_top_color ) . ';
				}
			';
		}
		// Header color
		if ( cs_get_option( 'header-background' ) ) {
			$css[] = '.mainmenu-area { background-color: ' . esc_attr( cs_get_option( 'header-background' ) ) . '}';
		}
        // Header color
		if ( cs_get_option( 'body-background-color' ) ) {
			$css[] = 'body { background-color: ' . esc_attr( cs_get_option( 'body-background-color' ) ) . '}';
		}

		// Header top
		if ( cs_get_option( 'header-top-background' ) ) {
			$css[] = '.top-bar { background-color: ' . esc_attr( cs_get_option( 'header-top-background' ) ) . '}';
		}

		// Menu color
		if ( cs_get_option( 'top_menu' ) ) {
			$css[] = '
				#jws_header .sticky-wrapper .menu_nav .mainmenu .nav > li > a {
					color: ' . esc_attr( cs_get_option( 'top_menu' ) ) . ';
				}
			';
		}
		if ( cs_get_option( 'sub_menu' ) ) {
			$css[] = '
				#jws_header .sticky-wrapper .menu_nav .mainmenu .nav > li > .sub-menu-dropdown a   {
					color: ' . esc_attr( cs_get_option( 'sub_menu' ) ) . ';
				}
			';
		}
		// Footer color
		if ( cs_get_option( 'footer-background' ) ) {
			$css[] = '
				#footer-jws {
					background: ' . esc_attr( cs_get_option( 'footer-background' ) ) . ';
				}
			';
		}
         if ( cs_get_option( 'footer-bottom-background' ) ) {
			$css[] = '
				.footer-bottom {
					background: ' . esc_attr( cs_get_option( 'footer-bottom-background' ) ) . ';
				}
			';
		}
		if ( cs_get_option( 'footer-color' ) ) {
			$css[] = '
				#footer-jws {
					color: ' . esc_attr( cs_get_option( 'footer-color' ) ) . ';
				}
			';
		}
        if ( cs_get_option( 'footer-heading-color' ) ) {
			$css[] = '
				#footer-jws .email .logo h3 , #footer-jws .widget-title {
					color: ' . esc_attr( cs_get_option( 'footer-heading-color' ) ) . ';
				}
			';
		}
        if ( cs_get_option( 'footer-bottom-color' ) ) {
			$css[] = '
				#footer-jws .footer-bottom {
					color: ' . esc_attr( cs_get_option( 'footer-bottom-color' ) ) . ';
				}
			';
		}
       
        
		if ( cs_get_option( 'footer-link-color' ) ) {
			$css[] = '
				#footer-jws .email .social-wrap ul li a , #footer-jws .menu li a {
					color: ' . esc_attr( cs_get_option( 'footer-link-color' ) ) . ';
				}
			';
		}

		if ( cs_get_option( 'footer-link-hover-color' ) ) {
			$css[] = '
				#footer-jws .menu li a:hover, #footer-jws .email .social-wrap ul li a:hover {
					color: ' . esc_attr( cs_get_option( 'footer-link-hover-color' ) ) . ';
				}
			';
		}

		// Custom css
		if ( cs_get_option( 'custom-css' ) ) {
			$css[] = cs_get_option( 'custom-css' );
		}

		return preg_replace( '/\n|\t/i', '', implode( '', $css ) );
	}
}