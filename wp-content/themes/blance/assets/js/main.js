jQuery(document).on("ready", function(e) {
    "use strict";

    function a() {
        Modernizr.mq("screen and (max-width:991px)") && (e("#nav  > .menu-item-has-children > a").removeAttr("href"), e("#nav  > li > a").on("click", function() {
            e(this).next(e(".sub-menu")).animate({
                height: "toggle"
            }, 200)
        }))
    }

    function s(e) {
        "close" === e ? (i.removeClass("is-visible"), t.removeClass("search-is-visible")) : (i.toggleClass("is-visible"), t.toggleClass("search-is-visible"), i.hasClass("is-visible") && i.find('input[type="text"]').focus(), i.hasClass("is-visible") ? o.addClass("is-visible") : o.removeClass("is-visible"))
    }
    jQuery(window).on("load", function() {
        e(".preeloader").fadeOut(1e3)
    }), e("#mainmenu-area").sticky({
        topSpacing: 0
    }), e(".about-video-button , .blog-video-button").magnificPopup({
        disableOn: 700,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 320,
        preloader: !1
    }), e(".food-menu-list").mixItUp(), e(".menu-popup").magnificPopup({
        type: "image",
        removalDelay: 500,
        callbacks: {
            beforeOpen: function() {
                this.st.image.markup = this.st.image.markup.replace("mfp-figure", "mfp-figure mfp-with-anim"), this.st.mainClass = this.st.el.attr("data-effect")
            }
        },
        closeOnContentClick: !0,
        midClick: !0
    }), (new WOW).init(), a(), e(".team-slider").jwsCarousel({
        merge: !0,
        video: !0,
        items: 1,
        smartSpeed: 1e3,
        loop: !0,
        nav: !1,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: !1,
        autoplayTimeout: 2e3,
        margin: 15,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1e3: {
                items: 5
            }
        }
    }), e(" .menu-item-object-custom a").on("click", function(a) {
        var s = e(this).attr("href"),
            i = 40,
            t = e(s).offset().top - i;
        e("html, body").animate({
            scrollTop: t
        }, 1500, "easeInOutExpo"), a.preventDefault()
    });
    var i = e(".search-form-jws"),
        t = e(".search-form-trigger"),
        o = e(".search-form-overlay");
    t.on("click", function(e) {
        e.preventDefault(), s()
    }), e(".menu-discount-offer").jwsCarousel({
        merge: !0,
        video: !0,
        items: 1,
        smartSpeed: 1e3,
        loop: !0,
        nav: !1,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: !0,
        autoplayTimeout: 8e3,
        margin: 15,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1e3: {
                items: 1
            }
        }
    }), e(".blog-image-sldie").jwsCarousel({
        merge: !0,
        video: !0,
        items: 1,
        smartSpeed: 1e3,
        loop: !0,
        nav: !0,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: !1,
        autoplayTimeout: 2e3,
        margin: 15,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1e3: {
                items: 1
            }
        }
    }), 
    e(".single-events-page form select").find("option").eq(0).remove() ,
    e(".wpeevent_paypalbuttonimage").removeAttr("src"),
    e(".wpeevent_paypalbuttonimage").attr("type", "submit"),
    e(".wpeevent_paypalbuttonimage").attr("value", "Buy Ticket Now"),   
    e(".testmonial-slider").jwsCarousel({
        merge: !0,
        video: !0,
        items: 1,
        smartSpeed: 1e3,
        loop: !0,
        nav: !0,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: !1,
        autoplayTimeout: 2e3,
        margin: 15,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1e3: {
                items: 1
            }
        }
    }), e("#bt-backtop").on("click", function() {
        return e("html,body").animate({
            scrollTop: 0
        }, 1e3), !1
    }), e(window).scrollTop() > 300 ? e("#bt-backtop").addClass("bt-show") : e("#bt-backtop").removeClass("bt-show"), e(window).on("scroll", function() {
        e(window).scrollTop() > 300 ? e("#bt-backtop").addClass("bt-show") : e("#bt-backtop").removeClass("bt-show")
    }), e("#nav li a").click(function() {
        e(this).hasClass("active") || (e("#nav li a.active").removeClass("active"), e(this).addClass("active"))
    })
}(jQuery));