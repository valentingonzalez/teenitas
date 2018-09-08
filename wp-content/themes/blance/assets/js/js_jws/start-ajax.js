!function($){"use strict";$(document).ready(function(){
  /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * mobile responsive navigation
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */

            function mobileNavigation() {

                var body = $("body"),
                    mobileNav = $(".mobile_menu"),
                    dropDownCat = $(".mobile_menu .mobile_inner .menu-item-has-children"),
                    elementIcon = '<span class="icon-sub-menu"></span>',
                    butOpener = $(".icon-sub-menu");

                dropDownCat.append(elementIcon);

                mobileNav.on("click", ".icon-sub-menu", function(e) {
                    e.preventDefault();

                    if ($(this).parent().hasClass("opener-page")) {
                        $(this).parent().removeClass("opener-page").find("> ul").slideUp(200);
                        $(this).parent().removeClass("opener-page").find(".sub-menu-dropdown  > ul").slideUp(200);
                        $(this).parent().find('> .icon-sub-menu').removeClass("up-icon");
                    } else {
                        $(this).parent().addClass("opener-page").find("> ul").slideDown(200);
                        $(this).parent().addClass("opener-page").find(".sub-menu-dropdown  > ul").slideDown(200);
                        $(this).parent().find('> .icon-sub-menu').addClass("up-icon");
                    }
                });


                $(".button_menu").click(function() {

                    if (body.hasClass("open-mobile-menu")) {
                        closeMenu();
                    } else {
                        openMenu();
                    }

                });

                body.on("click touchstart", ".mobile-overplay", function() {
                    closeMenu();
                });

                function openMenu() {
                    body.addClass("open-mobile-menu");
                }

                function closeMenu() {
                    body.removeClass("open-mobile-menu");
                }
            };
            mobileNavigation(); 
                function sidebar_drop() {   
          $(window).on('resize', function () {
            if ($(window).width() < 991) {
    	           $('.sidebar-blog').addClass('on-mobile');
            }else {
                    $('.sidebar-blog').removeClass('on-mobile');
            }
    		  }).trigger('resize');
             	$('.sidebar-blog').on('click', '.widget-title', function (e) {
             	   if ($(this).closest('.sidebar-blog').hasClass('on-mobile')) { 
        			e.preventDefault();
                    $(this).parent('.widget').find('> ul , > div').slideToggle('slow');
                    }
        		});   
	};
    sidebar_drop(); 
    $("body").on("click", ".showlogin", function(e) { 
        	e.preventDefault();
       $('.custom_form_cc').slideToggle('slow') 
    });
    if ($(window).width() < 991) {
       $(".jws-my-account .account").removeAttr("href");
    }
    
    
})}(window.jQuery);