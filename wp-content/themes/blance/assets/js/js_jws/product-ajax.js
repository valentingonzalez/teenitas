var blanceThemeModule;

(function($) {
    "use strict";

    blanceThemeModule = (function() {

        return {

            init: function() {


                this.productsLoadMore();
                this.productsTabs();
                this.blogLoadMore();
                this.productImages();
                $(window).resize();

                $('body').addClass('document-ready');

        

            },




            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Counter shortcode method
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
            counterShortcode: function(counter) {
                if( counter.attr('data-state') == 'done' || counter.text() != counter.data('final') ) {
                    return;
                }
                counter.prop('Counter',0).animate({
                    Counter: counter.text()
                }, {
                    duration: 3000,
                    easing: 'swing',
                    step: function (now) {
                        if( now >= counter.data('final')) {
                            counter.attr('data-state', 'done');
                        }
                        counter.text(Math.ceil(now));
                    }
                });
            },

            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Activate methods in viewport
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
            visibleElements: function() {

                $('.blance-counter .counter-value').each(function(){
                    $(this).waypoint(function(){
                        blanceThemeModule.counterShortcode($(this));
                    }, { offset: '100%' });
                });

            },

            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * add class in wishlist   
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */

            wishList: function() {
                var body = $("body");

                body.on("click", ".add_to_wishlist", function() {

                    $(this).parent().addClass("feid-in");

                });

            },


            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Compare button
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */

            compare: function() {
                var body = $("body"),
                    button = $("a.compare");

                body.on("click", "a.compare", function() {
                    $(this).addClass("loading");
                });

                body.on("yith_woocompare_open_popup", function() {
                    button.removeClass("loading");
                    body.addClass("compare-opened");
                });

                body.on('click', '#cboxClose, #cboxOverlay', function() {
                    body.removeClass("compare-opened");
                });

            },


            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Load more button for blog shortcode
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
             
            blogLoadMore: function() {
                
                $('.blance-blog-load-more').on('click', function(e) {
                    e.preventDefault();

                    var $this = $(this),
                        holder = $this.parent().siblings('.blance-blog-holder'),
                        atts = holder.data('atts'),
                        paged = holder.data('paged');
                        var $loaded = $('.posts-loaded');
                    $this.addClass('loading');

                    $.ajax({
                        url: MS_Ajax.ajaxurl,
                        data: {
                            atts: atts, 
                            paged: paged, 
                            action: 'blance_get_blog_shortcode'
                        },
                        dataType: 'json',
                        method: 'POST',
                        success: function(data) {
                            if( data.items ) {
                               
                                    // initialize Masonry after all images have loaded  
                                    var items = $(data.items);
                                    
                                    holder.append(items).isotope( 'appended', items );
                                    holder.imagesLoaded().progress(function() {
                                        holder.isotope('layout');
                                        
                                    });
                                holder.data('paged', paged + 1);
                            }
                            $(".content-inner .click-action").click(function() {
                                $(this).toggleClass('pe-7s-close  pe-7s-share ');
                                $(this).parents('.content-inner').find('.read-more , .left-link ').toggleClass('hiiden-nn');
                        
                              
                           }); 
                            if( data.status == 'no-more-posts' ) {
                                $this.hide();
                                $loaded.addClass('active');
                            }
                            
                        },
                        error: function(data) {
                            console.log('ajax error');
                        },
                        complete: function() {
                            $this.removeClass('loading');
                        },
                    });

                });

            },

            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Load more button for products shortcode
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
            productsLoadMore: function() {

                var process = false,
                    intervalID;

                $('.blance-products-element').each(function() {
                    var $this = $(this),
                        cache = [],
                        inner = $this.find('.blance-products-holder');

                    if( ! inner.hasClass('pagination-arrows') && ! inner.hasClass('pagination-more-btn') ) return;

                    cache[1] = {
                        items: inner.html(),
                        status: 'have-posts'
                    };

                    $this.on('recalc', function() {
                        calc();
                    });

                   // if( inner.hasClass('pagination-arrows') ) {
                        //$(window).resize(function() {
                            //calc();
                        //});
                    //}

                    var calc = function() {
                        var height = inner.outerHeight();
                        $this.stop().css({height: height});
                    };

                    // sticky buttons
                    
                    var body = $('body'), 
                        btnWrap = $this.find('.products-footer'),
                        btnLeft = btnWrap.find('.blance-products-load-prev'),
                        btnRight = btnWrap.find('.blance-products-load-next'),
                        loadWrapp = $this.find('.blance-products-loader'),
                        scrollTop,
                        holderTop,
                        btnOffsetContainer,
                        holderBottom,
                        holderHeight,
                        btnsHeight,
                        offsetArrow = 50,
                        offset,
                        windowWidth;

                    if( body.hasClass('rtl') ) {
                        btnLeft = btnRight;
                        btnRight = btnWrap.find('.blance-products-load-prev');
                    }

                    $(window).scroll(function() {
                        buttonsPos();
                    });
                      
                    function buttonsPos() {

                        offset = $(window).height() / 2;

                        windowWidth = $(window).outerWidth(true) + 17;

                        // length scroll
                        scrollTop = $(window).scrollTop();

                        // distance from the top to the element
                        holderTop = $this.offset().top - offset;

                        // offset left to button
                        btnOffsetContainer = $this.offset().left - offsetArrow;

                        // height of buttons
                        btnsHeight = btnLeft.outerHeight();

                        // height of elements
                        holderHeight = $this.height() - 50 - btnsHeight;

                        // and height of element
                        holderBottom = holderTop + holderHeight;

                        if(windowWidth <= 1047 && windowWidth >= 992 || windowWidth <= 825 && windowWidth >= 768 ) {
                            btnOffsetContainer = btnOffsetContainer + 18;
                        }

                        if(windowWidth < 768 || body.hasClass('wrapper-boxed') || body.hasClass('wrapper-boxed-small') || $('.main-header').hasClass('header-vertical') ) {
                            btnOffsetContainer = btnOffsetContainer + 51;
                        }


                        btnLeft.css({
                            'left' : btnOffsetContainer + 'px'
                        });

                        // Right arrow position for vertical header
                        if( $('.main-header').hasClass('header-vertical') && ! body.hasClass('rtl') ) {
                            btnOffsetContainer -= $('.main-header').outerWidth();
                        } else if( $('.main-header').hasClass('header-vertical') && body.hasClass('rtl') ) {
                            btnOffsetContainer += $('.main-header').outerWidth();
                        }

                        btnRight.css({
                            'right' : btnOffsetContainer + 'px'
                        });
                        

                        if (scrollTop < holderTop || scrollTop > holderBottom) {
                            btnWrap.removeClass('show-arrow');
                            loadWrapp.addClass('hidden-loader');
                        } else {
                            btnWrap.addClass('show-arrow');
                            loadWrapp.removeClass('hidden-loader');
                        }

                    };

                    $this.find('.blance-products-load-more').on('click', function(e) {
                        e.preventDefault();

                        if( process ) return; process = true;

                        var $this = $(this),
                            holder = $this.parent().siblings('.blance-products-holder'),
                            atts = holder.data('atts'),
                            paged = holder.data('paged');

                        paged++;

                        loadProducts(atts, paged, holder, $this, [], function(data) {
                            if( data.items ) {
                                if( holder.hasClass('grid-masonry') ) {
                                    isotopeAppend(holder, data.items);
                                } else {
                                    holder.append(data.items);
                                }
                                
                                holder.data('paged', paged);
                            }

                            if( data.status == 'no-more-posts' ) {
                                $this.hide();
                                $('.loaded-all').show();
                            }
                        });

                    });
                    
                    $this.find('.blance-products-load-prev, .blance-products-load-next').on('click', function(e) {
                        e.preventDefault();

                        if( process || $(this).hasClass('disabled') ) return; process = true;

                        clearInterval(intervalID);

                        var $this = $(this),
                            holder = $this.parent().siblings('.blance-products-holder'),
                            next = $this.parent().find('.blance-products-load-next'),
                            prev = $this.parent().find('.blance-products-load-prev'),
                            atts = holder.data('atts'),
                            paged = holder.attr('data-paged');
                        if( $this.hasClass('blance-products-load-prev') ) {
                            if( paged < 2 ) return;
                            paged = paged - 2;
                        }

                        paged++;

                        loadProducts(atts, paged, holder, $this, cache, function(data) {
                            holder.addClass('blance-animated-products');

                            if( data.items ) {
                                holder.html(data.items).attr('data-paged', paged);
                            }

                            if( $(window).width() < 768 ) {
                                $('html, body').stop().animate({
                                    scrollTop: holder.offset().top - 150
                                }, 400);
                            }


                            var iter = 0;
                            intervalID = setInterval(function() {
                                holder.find('.tb-products-grid').eq(iter).addClass('blance-animated');
                                iter++;
                            }, 100);

                            if( paged > 1 ) {
                                prev.removeClass('disabled');
                            } else {
                                prev.addClass('disabled');
                            }

                            if( data.status == 'no-more-posts' ) {
                                next.addClass('disabled');
                            } else {
                                next.removeClass('disabled');
                            }
                        });

                    });
                });

                var loadProducts = function(atts, paged, holder, btn, cache, callback) {

                    if( cache[paged] ) {
                        holder.addClass('loading');
                        setTimeout(function() {
                            callback(cache[paged]);
                            holder.removeClass('loading');
                            process = false;
                        }, 300);
                        return;
                    }

                    holder.addClass('loading').parent().addClass('element-loading');

                    btn.addClass('loading');

                    $.ajax({
                        url: MS_Ajax.ajaxurl,
                        data: {
                            atts: atts, 
                            paged: paged, 
                            action: 'blance_get_products_shortcode'
                        },
                        dataType: 'json',
                        method: 'POST',
                        success: function(data) {
                            cache[paged] = data;
                            callback( data );
                        },
                        error: function(data) {
                            console.log('ajax error');
                        },
                        complete: function() {
                            holder.removeClass('loading').parent().removeClass('element-loading');
                            btn.removeClass('loading');
                            process = false;
                            blanceThemeModule.compare();
                            
                        },
                    });
                };
                var isotopeAppend = function(el, items) {
                    // initialize Masonry after all images have loaded  
                    var items = $(items);
                    el.append(items).isotope( 'appended', items );
                    el.isotope('layout');
                    setTimeout(function() {
                        el.isotope('layout');
                    }, 100);
                    el.imagesLoaded().progress(function() {
                        el.isotope('layout');
                    });
                };

            },


            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Products tabs element AJAX loading
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
            productsTabs: function() {


                var process = false;

                $('.blance-products-tabs').each(function() {
                    var $this = $(this),
                        $inner = $this.find('.blance-tab-content'),
                        cache = [];

                    if( $inner.find('.owl-carousel').length < 1 ) {
                        cache[0] = {
                            html: $inner.html()
                        };
                    }

                    $this.find('.products-tabs-title li').on('click', function(e) {
                        e.preventDefault();

                        var $this = $(this),
                            atts = $this.data('atts'),
                            index = $this.index();

                        if( process || $this.hasClass('active-tab-title') ) return; process = true;

                        loadTab(atts, index, $inner, $this, cache,  function(data) {
                            if( data.html ) {
                                $inner.html(data.html);
                                blanceThemeModule.shopMasonry();
                                blanceThemeModule.productsLoadMore();
                            }
                        });

                    });

                    var $nav = $this.find('.tabs-navigation-wrapper'),
                        $subList = $nav.find('ul'),
                        time = 300;

                    $nav.on('click', '.open-title-menu', function() {
                        var $btn = $(this);

                        if( $subList.hasClass('list-shown') ) {
                            $btn.removeClass('toggle-active');
                            $subList.removeClass('list-shown');
                        } else {
                            $btn.addClass('toggle-active');
                            $subList.addClass('list-shown');
                            setTimeout(function() {
                                $('body').one('click', function(e) {
                                    var target = e.target;
                                    if ( ! $(target).is('.tabs-navigation-wrapper') && ! $(target).parents().is('.tabs-navigation-wrapper')) {
                                        $btn.removeClass('toggle-active');
                                        $subList.removeClass('list-shown');
                                        return false;
                                    }
                                });
                            },10);
                        }

                    })
                    .on('click', 'li', function() {
                        var $btn = $nav.find('.open-title-menu'),
                            text = $(this).text();

                        if( $subList.hasClass('list-shown') ) {
                            $btn.removeClass('toggle-active').text(text);
                            $subList.removeClass('list-shown');
                        }
                    });

                });

                var loadTab = function(atts, index, holder, btn, cache, callback) {

                    btn.parent().find('.active-tab-title').removeClass('active-tab-title');
                    btn.addClass('active-tab-title')

                    if( cache[index] ) {
                        holder.addClass('loading');
                        setTimeout(function() {
                            callback(cache[index]);
                            holder.removeClass('loading');
                            process = false;
                        }, 300);
                        return;
                    }

                    holder.addClass('loading').parent().addClass('element-loading');

                    btn.addClass('loading');

                    $.ajax({
                        url: MS_Ajax.ajaxurl,
                        data: {
                            atts: atts, 
                            action: 'blance_get_products_tab_shortcode'
                        },
                        dataType: 'json',
                        method: 'POST',
                        success: function(data) {
                            cache[index] = data;
                            callback( data );
                        },
                        error: function(data) {
                            console.log('ajax error');
                        },
                        complete: function() {
                            holder.removeClass('loading').parent().removeClass('element-loading');
                            btn.removeClass('loading');
                            process = false;                
                            blanceThemeModule.compare();
                        },
                    });
                };


            },




              /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Product thumbnail images & photo swipe gallery
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
            productImages: function() {
                var currentImage,
                    currentClass = 'current-image',
                    gallery = $('.photoswipe-images'),
                    galleryType = 'photo-swipe'; // magnific photo-swipe

                gallery.each(function() {
                    var $this = $(this);
                    $this.on('click', 'a', function(e) {
                        e.preventDefault();
                        var index = $(e.currentTarget).data('index') - 1;
                        var items = getGalleryItems($this, []);
                        callPhotoSwipe(index, items, $(e.currentTarget));
                    } );
                })

                var callPhotoSwipe = function( index, items, $target ) {
                    var pswpElement = document.querySelectorAll('.pswp')[0];

                    if( $('body').hasClass('rtl') ) {
                        index = items.length - index - 1;
                        items = items.reverse();
                    }
                    var options = {
                        index: index, 
                        getThumbBoundsFn: function(index) {

                        }
                    };

                    // Initializes and opens PhotoSwipe
                    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                    gallery.init(); 
                };

                var getGalleryItems = function( $gallery, items ) {
                    var src, width, height, title;

                    $gallery.find('a').each(function() {
                        src = $(this).attr('href');
                        width = $(this).data('width');
                        height = $(this).data('height');
                        title = $(this).attr('title');
                        if( ! isItemInArray(items, src) ) {
                            items.push({
                                src: src,
                                w: width,
                                h: height,
                                title: ( MS_Ajax.product_images_captions == 'yes' ) ? title : false
                            });
                        }
                    });

                    return items;
                };

                var isItemInArray = function( items, src ) {
                    var i;
                    for (i = 0; i < items.length; i++) {
                        if (items[i].src == src) {
                            return true;
                        }
                    }

                    return false;
                };
            },
            /**
             *-------------------------------------------------------------------------------------------------------------------------------------------
             * Sale final date countdown
             *-------------------------------------------------------------------------------------------------------------------------------------------
             */
            countDownTimer: function() {

                $('.blance-timer').each(function(){
                    $(this).countdown($(this).data('end-date'), function(event) {
                        $(this).html(event.strftime(''
                            + '<span class="countdown-days">%-D <span>' + MS_Ajax.countdown_days + '</span></span> '
                            + '<span class="countdown-hours">%H <span>' + MS_Ajax.countdown_hours + '</span></span> '
                            + '<span class="countdown-min">%M <span>' + MS_Ajax.countdown_mins + '</span></span> '
                            + '<span class="countdown-sec">%S <span>' + MS_Ajax.countdown_sec + '</span></span>'));
                    });
                });

            },
        }
    }());

})(jQuery);


jQuery(document).ready(function() {

    blanceThemeModule.init();
    

});