! function(e) {
	"use strict";

	function t() {
		var t = this;
		t.BREAKPOINT_LARGE = 864, t.classWidgetPanelOpen = "widget-panel-open", t.$window = e(window), t.$document = e(document), t.$html = e("html"), t.$body = e("body"), t.$widgetPanelOverlay = e("#jws-widget-panel-overlay"), t.$header = e("#jws-header"), t.$shopBrowseWrap = e(".bt-product-items"), t.$widgetPanel = e(".jws-mini-cart"), t.widgetPanelAnimSpeed = 250, t.panelsAnimSpeed = 200, t.init(), t.bind()
	}
	e.nmThemeExtensions || (e.nmThemeExtensions = {}), t.prototype = {
		init: function() {
			var e = this;
			e.widgetPanelPrep(), e.loadExtension(), e.$body.hasClass("jws-added-to-cart") && (e.$body.removeClass("jws-added-to-cart"), e.$window.load(function() {
				e.$widgetPanel.length && (e.widgetPanelShow(!0), setTimeout(function() {
					e.widgetPanelCartHideLoader()
				}, 1e3))
			}))
		},
		loadExtension: function() {
			var t = this;
			e.nmThemeExtensions.singleProduct && e.nmThemeExtensions.singleProduct.call(t), e.nmThemeExtensions.add_to_cart && e.nmThemeExtensions.add_to_cart.call(t), e.nmThemeExtensions.infload && e.nmThemeExtensions.infload.call(t), e.nmThemeExtensions.cart && e.nmThemeExtensions.cart.call(t)
		},
		updateUrlParameter: function(e, t, a) {
			var n = e.indexOf("#"),
				i = -1 === n ? "" : e.substr(n);
			e = -1 === n ? e : e.substr(0, n);
			var s = new RegExp("([?&])" + t + "=.*?(&|$)", "i"),
				o = -1 !== e.indexOf("?") ? "&" : "?";
			return e = e.match(s) ? e.replace(s, "$1" + t + "=" + a + "$2") : e + o + t + "=" + a, e + i
		},
		bind: function() {
			var t = this;
			e("#jws-page-overlay, #jws-widget-panel-overlay , .close-cart ").bind("click", function() {
				var a = e(this);
				t.widgetPanelHide(), a.addClass("fade-out"), setTimeout(function() {
					a.removeClass("show fade-out")
				}, t.panelsAnimSpeed)
			}), t.$widgetPanel.length && t.widgetPanelBind()
		},
		widgetPanelPrep: function() {
			var t = this;
			t.cartPanelAjax = null, t.quantityInputsBindButtons(t.$widgetPanel), t.$widgetPanel.on("blur", "input.qty", function() {
				var a = e(this),
					n = parseFloat(a.val()),
					i = parseFloat(a.attr("max"));
				"" !== n && "NaN" !== n || (n = 0), "NaN" === i && (i = ""), n > i && (a.val(i), n = i), n > 0 && t.widgetPanelCartUpdate(a)
			}), t.$document.on("nm_qty_change", function(a, n) {
				t.widgetPanelCartUpdate(e(n))
			})
		},
		widgetPanelBind: function() {
			var t = this;
			e(".cart-contents").bind("click", function(a) {
			     e("body").removeClass("open-mobile-menu");
				if(a.preventDefault(), t.$body.hasClass(t.classMobileMenuOpen)) {
					var n = e(this);
					t.$pageOverlay.trigger("click"), setTimeout(function() {
						n.trigger("click")
					}, t.panelsAnimSpeed)
				} else t.widgetPanelShow()
			}), e(".close-cart").bind("click.close-cart", function(t) {
				t.preventDefault(), e("#jws-widget-panel-overlay").trigger("click")
			}), t.$widgetPanel.on("click.close-cart", "#jws-cart-panel-continue", function(t) {
				t.preventDefault(), e("#jws-widget-panel-overlay").trigger("click")
			}), t.$widgetPanel.on("click", "#jws-cart-panel .cart_list .remove", function(e) {
				e.preventDefault(), t.widgetPanelCartRemoveProduct(this)
			})
		},
		widgetPanelShow: function(e) {
			var t = this;
			e && t.widgetPanelCartShowLoader(), t.$body.addClass("widget-panel-opening " + t.classWidgetPanelOpen), t.$widgetPanelOverlay.addClass("show"), setTimeout(function() {
				t.$body.removeClass("widget-panel-opening")
			}, t.widgetPanelAnimSpeed)
		},
		widgetPanelHide: function() {
			var e = this;
			e.$body.addClass("widget-panel-closing"), e.$body.removeClass(e.classWidgetPanelOpen), setTimeout(function() {
				e.$body.removeClass("widget-panel-closing")
			}, e.widgetPanelAnimSpeed)
		},
		widgetPanelCartShowLoader: function() {
			e("#jws-cart-panel-loader").addClass("show")
		},
		widgetPanelCartHideLoader: function() {
			e("#jws-cart-panel-loader").addClass("fade-out"), setTimeout(function() {
				e("#jws-cart-panel-loader").removeClass("fade-out show")
			}, 200)
		},
		widgetPanelCartRemoveProduct: function(t) {
			var a = this,
				n = e(t),
				i = n.closest("li"),
				s = i.parent("ul"),
				o = n.data("cart-item-key");
			i.closest("li").addClass("loading"), a.cartPanelAjax = e.ajax({
				type: "POST",
				url: MS_Ajax.ajaxurl,
				data: {
					action: "nm_cart_panel_remove_product",
					cart_item_key: o
				},
				dataType: "json",
				error: function(e, t, a) {
					console.log("NM: AJAX error - widgetPanelCartRemoveProduct() - " + a), i.closest("li").removeClass("loading")
				},
				complete: function(t) {
					a.cartPanelAjax = null;
					var n = t.responseJSON;
					n && "1" === n.status ? (i.css({
						"-webkit-transition": "0.2s opacity ease",
						transition: "0.2s opacity ease",
						opacity: "0"
					}), setTimeout(function() {
						i.css("display", "block").slideUp(150, function() {
							i.remove();
							var t = s.children("li");
							1 == t.length && e("#jws-cart-panel").addClass("jws-cart-panel-empty"), a.shopReplaceFragments(n.fragments), a.$body.trigger("added_to_cart", [n.fragments, n.cart_hash])
						})
					}, 160)) : console.log("NM: Couldn't remove product from cart")
				}
			})
		},
		widgetPanelCartUpdate: function(t) {
			var a = this;
			a.cartPanelAjax && a.cartPanelAjax.abort(), t.closest("li").addClass("loading");
			var n = {
				action: "nm_cart_panel_update"
			};
			n[t.attr("name")] = t.val(), a.cartPanelAjax = e.ajax({
				type: "POST",
				url: MS_Ajax.ajaxurl,
				data: n,
				dataType: "json",
				complete: function(t) {
					var n = t.responseJSON;
					n && "1" === n.status && a.shopReplaceFragments(n.fragments), e("#jws-cart-panel .cart_list").children(".loading").removeClass("loading")
				}
			})
		},
		shopReplaceFragments: function(t) {
			var a;
			e.each(t, function(t, n) {
				a = e(n), a.length && e(t).replaceWith(a)
			})
		},
		quantityInputsBindButtons: function(t) {
			var a = this;
			t.off("click.nmQty").on("click.nmQty", ".jws-qty-plus, .jws-qty-minus", function() {
				var t = e(this),
					n = t.closest(".quantity").find(".qty"),
					i = parseFloat(n.val()),
					s = parseFloat(n.attr("max")),
					o = parseFloat(n.attr("min")),
					l = n.attr("step");
				i && "" !== i && "NaN" !== i || (i = 0), "" !== s && "NaN" !== s || (s = ""), "" !== o && "NaN" !== o || (o = 0), "any" !== l && "" !== l && void 0 !== l && "NaN" !== parseFloat(l) || (l = 1), t.hasClass("jws-qty-plus") ? s && (s == i || i > s) ? n.val(s) : (n.val(i + parseFloat(l)), a.quantityInputsTriggerEvents(n)) : o && (o == i || o > i) ? n.val(o) : i > 0 && (n.val(i - parseFloat(l)), a.quantityInputsTriggerEvents(n))
			})
		},
		quantityInputsTriggerEvents: function(e) {
			var t = this;
			e.trigger("change"), t.$document.trigger("nm_qty_change", e)
		}
	}, e.nmTheme = t.prototype, e(document).ready(function() {
		new t
	})
}(jQuery);
//2
! function(t) {
	"use strict";
	t.extend(t.nmTheme, {
		atc_init: function() {
			var t = this;
			t.atcBind()
		},
		atcBind: function() {
			var a = this;
			a.$body.on("click", "  .quick-view-modal .single_add_to_cart_button", function(o) {
				var r = t(this);
				if(r.is(".disabled")) return void console.log("NM: Add-to-cart button disabled");
				if(r.hasClass("jws-simple-add-to-cart-button") || r.hasClass("jws-variable-add-to-cart-button")) {
					o.preventDefault(), r.attr("disabled", "disabled");
					var e = r.closest("form");
					if(!e.length) return;
					var i = {
						product_id: e.find("[name*='add-to-cart']").val(),
						product_variation_data: e.serialize()
					};
					a.$body.trigger("adding_to_cart", [r, i]), a.atcAjaxSubmitForm(r, i)
				}
			})
		},
		atcAjaxSubmitForm: function(a, o) {
			var r = this;
			if(!o.product_id) return void console.log("NM (Error): No product id found");
			var e = wc_add_to_cart_params.wc_ajax_url.toString().replace("wc-ajax=%%endpoint%%", "add-to-cart=" + o.product_id + "&jws-ajax-add-to-cart=1");
			t.ajax({
				type: "POST",
				url: e,
				data: o.product_variation_data,
				dataType: "html",
				cache: !1,
				headers: {
					"cache-control": "no-cache"
				},
				error: function(t, a, o) {
					console.log("NM: AJAX error - atcAjaxSubmitForm() - " + o)
				},
				success: function(o) {
					var e = t("<div>" + o + "</div>"),
						i = e.find("#jws-shop-notices-wrap"),
						n = !!i.find(".woocommerce-error").length,
						c = "",
						d = {
							".jws-menu-cart-count": e.find(".jws-menu-cart-count").prop("outerHTML"),
							"#jws-shop-notices-wrap": i.prop("outerHTML"),
							"#jws-cart-panel": e.find("#jws-cart-panel").prop("outerHTML")
						};
					r.shopReplaceFragments(d), r.$body.trigger("added_to_cart", [d, c]), r.quickviewOpen ? (t.magnificPopup.close(), n ? r.isShop && r.shopScrollToTop() : r.$widgetPanel.length && setTimeout(function() {
						r.widgetPanelShow(!1)
					}, 350)) : (a.removeAttr("disabled"), n && setTimeout(function() {
						t("#jws-widget-panel-overlay").trigger("click"), r.isShop && r.shopScrollToTop()
					}, 500)), e.empty()
				}
			})
		}
	}), t.nmThemeExtensions.add_to_cart = t.nmTheme.atc_init
}(jQuery);
//3
! function(n) {
	"use strict";
	n.extend(n.nmTheme, {
		singleProduct_init: function() {
			var t = this;
			t.quantityInputsBindButtons(n(".action"))
		}
	}), n.nmThemeExtensions.singleProduct = n.nmTheme.singleProduct_init
}(jQuery);
//4
! function(t) {
	"use strict";
	t.extend(t.nmTheme, {
		cart_init: function() {
			var e = this;
			t("body").hasClass("woocommerce-cart") && e.quantityInputsBindButtons(t(".woocommerce")), e.$body.on("added_to_cart", function() {
				t("#jws-quickview").is(":visible") && e.cartTriggerUpdate()
			})
		},
		cartTriggerUpdate: function() {
			var e = t('div.woocommerce > form input[name="update_cart"]');
			e.prop("disabled", !1), setTimeout(function() {
				e.trigger("click")
			}, 100)
		}
	}), t.nmThemeExtensions.cart = t.nmTheme.cart_init
}(jQuery);
//5
var blanceThemeModule;
! function(a) {
	"use strict";
	blanceThemeModule = function() {
		return {
			init: function() {
				this.productsLoadMore(), this.productsTabs(), this.blogLoadMore(), this.productImages(), a(window).resize(), a("body").addClass("document-ready")
			},
			counterShortcode: function(a) {
				"done" != a.attr("data-state") && a.text() == a.data("final") && a.prop("Counter", 0).animate({
					Counter: a.text()
				}, {
					duration: 3e3,
					easing: "swing",
					step: function(e) {
						e >= a.data("final") && a.attr("data-state", "done"), a.text(Math.ceil(e))
					}
				})
			},
			visibleElements: function() {
				a(".blance-counter .counter-value").each(function() {
					a(this).waypoint(function() {
						blanceThemeModule.counterShortcode(a(this))
					}, {
						offset: "100%"
					})
				})
			},
			wishList: function() {
				var e = a("body");
				e.on("click", ".add_to_wishlist", function() {
					a(this).parent().addClass("feid-in")
				})
			},
			compare: function() {
				var e = a("body"),
					t = a("a.compare");
				e.on("click", "a.compare", function() {
					a(this).addClass("loading")
				}), e.on("yith_woocompare_open_popup", function() {
					t.removeClass("loading"), e.addClass("compare-opened")
				}), e.on("click", "#cboxClose, #cboxOverlay", function() {
					e.removeClass("compare-opened")
				})
			},
			blogLoadMore: function() {
				a(".blance-blog-load-more").on("click", function(e) {
					e.preventDefault();
					var t = a(this),
						o = t.parent().siblings(".blance-blog-holder"),
						s = o.data("atts"),
						n = o.data("paged"),
						i = a(".posts-loaded");
					t.addClass("loading"), a.ajax({
						url: MS_Ajax.ajaxurl,
						data: {
							atts: s,
							paged: n,
							action: "blance_get_blog_shortcode"
						},
						dataType: "json",
						method: "POST",
						success: function(e) {
							if(e.items) {
								var s = a(e.items);
								o.append(s).isotope("appended", s), o.imagesLoaded().progress(function() {
									o.isotope("layout")
								}), o.data("paged", n + 1)
							}
							a(".content-inner .click-action").click(function() {
								a(this).toggleClass("pe-7s-close  pe-7s-share "), a(this).parents(".content-inner").find(".read-more , .left-link ").toggleClass("hiiden-nn")
							}), "no-more-posts" == e.status && (t.hide(), i.addClass("active"))
						},
						error: function() {
							console.log("ajax error")
						},
						complete: function() {
							t.removeClass("loading")
						}
					})
				})
			},
			productsLoadMore: function() {
				var e, t = !1;
				a(".blance-products-element").each(function() {
					function n() {
						m = a(window).height() / 2, v = a(window).outerWidth(!0) + 17, l = a(window).scrollTop(), c = i.offset().top - m, u = i.offset().left - _, f = w.outerHeight(), h = i.height() - 50 - f, p = c + h, (1047 >= v && v >= 992 || 825 >= v && v >= 768) && (u += 18), (768 > v || b.hasClass("wrapper-boxed") || b.hasClass("wrapper-boxed-small") || a(".main-header").hasClass("header-vertical")) && (u += 51), w.css({
							left: u + "px"
						}), a(".main-header").hasClass("header-vertical") && !b.hasClass("rtl") ? u -= a(".main-header").outerWidth() : a(".main-header").hasClass("header-vertical") && b.hasClass("rtl") && (u += a(".main-header").outerWidth()), z.css({
							right: u + "px"
						}), c > l || l > p ? (C.removeClass("show-arrow"), x.addClass("hidden-loader")) : (C.addClass("show-arrow"), x.removeClass("hidden-loader"))
					}
					var i = a(this),
						r = [],
						d = i.find(".blance-products-holder");
					if(d.hasClass("pagination-arrows") || d.hasClass("pagination-more-btn")) {
						r[1] = {
							items: d.html(),
							status: "have-posts"
						}, i.on("recalc", function() {
							g()
						});
						var l, c, u, p, h, f, m, v, g = function() {
								var a = d.outerHeight();
								i.stop().css({
									height: a
								})
							},
							b = a("body"),
							C = i.find(".products-footer"),
							w = C.find(".blance-products-load-prev"),
							z = C.find(".blance-products-load-next"),
							x = i.find(".blance-products-loader"),
							_ = 50;
						b.hasClass("rtl") && (w = z, z = C.find(".blance-products-load-prev")), a(window).scroll(function() {
							n()
						}), i.find(".blance-products-load-more").on("click", function(e) {
							if(e.preventDefault(), !t) {
								t = !0;
								var n = a(this),
									i = n.parent().siblings(".blance-products-holder"),
									r = i.data("atts"),
									d = i.data("paged");
								d++, o(r, d, i, n, [], function(e) {
									e.items && (i.hasClass("grid-masonry") ? s(i, e.items) : i.append(e.items), i.data("paged", d)), "no-more-posts" == e.status && (n.hide(), a(".loaded-all").show())
								})
							}
						}), i.find(".blance-products-load-prev, .blance-products-load-next").on("click", function(s) {
							if(s.preventDefault(), !t && !a(this).hasClass("disabled")) {
								t = !0, clearInterval(e);
								var n = a(this),
									i = n.parent().siblings(".blance-products-holder"),
									d = n.parent().find(".blance-products-load-next"),
									l = n.parent().find(".blance-products-load-prev"),
									c = i.data("atts"),
									u = i.attr("data-paged");
								if(n.hasClass("blance-products-load-prev")) {
									if(2 > u) return;
									u -= 2
								}
								u++, o(c, u, i, n, r, function(t) {
									i.addClass("blance-animated-products"), t.items && i.html(t.items).attr("data-paged", u), a(window).width() < 768 && a("html, body").stop().animate({
										scrollTop: i.offset().top - 150
									}, 400);
									var o = 0;
									e = setInterval(function() {
										i.find(".tb-products-grid").eq(o).addClass("blance-animated"), o++
									}, 100), u > 1 ? l.removeClass("disabled") : l.addClass("disabled"), "no-more-posts" == t.status ? d.addClass("disabled") : d.removeClass("disabled")
								})
							}
						})
					}
				});
				var o = function(e, o, s, n, i, r) {
						return i[o] ? (s.addClass("loading"), void setTimeout(function() {
							r(i[o]), s.removeClass("loading"), t = !1
						}, 300)) : (s.addClass("loading").parent().addClass("element-loading"), n.addClass("loading"), void a.ajax({
							url: MS_Ajax.ajaxurl,
							data: {
								atts: e,
								paged: o,
								action: "blance_get_products_shortcode"
							},
							dataType: "json",
							method: "POST",
							success: function(a) {
								i[o] = a, r(a)
							},
							error: function() {
								console.log("ajax error")
							},
							complete: function() {
								s.removeClass("loading").parent().removeClass("element-loading"), n.removeClass("loading"), t = !1, blanceThemeModule.compare()
							}
						}))
					},
					s = function(e, t) {
						var t = a(t);
						e.append(t).isotope("appended", t), e.isotope("layout"), setTimeout(function() {
							e.isotope("layout")
						}, 100), e.imagesLoaded().progress(function() {
							e.isotope("layout")
						})
					}
			},
			productsTabs: function() {
				var e = !1;
				a(".blance-products-tabs").each(function() {
					var o = a(this),
						s = o.find(".blance-tab-content"),
						n = [];
					s.find(".owl-carousel").length < 1 && (n[0] = {
						html: s.html()
					}), o.find(".products-tabs-title li").on("click", function(o) {
						o.preventDefault();
						var i = a(this),
							r = i.data("atts"),
							d = i.index();
						e || i.hasClass("active-tab-title") || (e = !0, t(r, d, s, i, n, function(a) {
							a.html && (s.html(a.html), blanceThemeModule.productsLoadMore())
						}))
					});
					var i = o.find(".tabs-navigation-wrapper"),
						r = i.find("ul");
					i.on("click", ".open-title-menu", function() {
						var e = a(this);
						r.hasClass("list-shown") ? (e.removeClass("toggle-active"), r.removeClass("list-shown")) : (e.addClass("toggle-active"), r.addClass("list-shown"), setTimeout(function() {
							a("body").one("click", function(t) {
								var o = t.target;
								return a(o).is(".tabs-navigation-wrapper") || a(o).parents().is(".tabs-navigation-wrapper") ? void 0 : (e.removeClass("toggle-active"), r.removeClass("list-shown"), !1)
							})
						}, 10))
					}).on("click", "li", function() {
						var e = i.find(".open-title-menu"),
							t = a(this).text();
						r.hasClass("list-shown") && (e.removeClass("toggle-active").text(t), r.removeClass("list-shown"))
					})
				});
				var t = function(t, o, s, n, i, r) {
					return n.parent().find(".active-tab-title").removeClass("active-tab-title"), n.addClass("active-tab-title"), i[o] ? (s.addClass("loading"), void setTimeout(function() {
						r(i[o]), s.removeClass("loading"), e = !1
					}, 300)) : (s.addClass("loading").parent().addClass("element-loading"), n.addClass("loading"), void a.ajax({
						url: MS_Ajax.ajaxurl,
						data: {
							atts: t,
							action: "blance_get_products_tab_shortcode"
						},
						dataType: "json",
						method: "POST",
						success: function(a) {
							i[o] = a, r(a)
						},
						error: function() {
							console.log("ajax error")
						},
						complete: function() {
							s.removeClass("loading").parent().removeClass("element-loading"), n.removeClass("loading"), e = !1, blanceThemeModule.compare()
						}
					}))
				}
			},
			productImages: function() {
				var e = a(".photoswipe-images");
				e.each(function() {
					var e = a(this);
					e.on("click", "a", function(s) {
						s.preventDefault();
						var n = a(s.currentTarget).data("index") - 1,
							i = o(e, []);
						t(n, i, a(s.currentTarget))
					})
				});
				var t = function(e, t) {
						var o = document.querySelectorAll(".pswp")[0];
						a("body").hasClass("rtl") && (e = t.length - e - 1, t = t.reverse());
						var s = {
								index: e,
								getThumbBoundsFn: function() {}
							},
							n = new PhotoSwipe(o, PhotoSwipeUI_Default, t, s);
						n.init()
					},
					o = function(e, t) {
						var o, n, i, r;
						return e.find("a").each(function() {
							o = a(this).attr("href"), n = a(this).data("width"), i = a(this).data("height"), r = a(this).attr("title"), s(t, o) || t.push({
								src: o,
								w: n,
								h: i,
								title: "yes" == MS_Ajax.product_images_captions ? r : !1
							})
						}), t
					},
					s = function(a, e) {
						var t;
						for(t = 0; t < a.length; t++)
							if(a[t].src == e) return !0;
						return !1
					}
			},
			countDownTimer: function() {
				a(".blance-timer").each(function() {
					a(this).countdown(a(this).data("end-date"), function(e) {
						a(this).html(e.strftime('<span class="countdown-days">%-D <span>' + MS_Ajax.countdown_days + '</span></span> <span class="countdown-hours">%H <span>' + MS_Ajax.countdown_hours + '</span></span> <span class="countdown-min">%M <span>' + MS_Ajax.countdown_mins + '</span></span> <span class="countdown-sec">%S <span>' + MS_Ajax.countdown_sec + "</span></span>"))
					})
				})
			}
		}
	}()
}(jQuery), jQuery(document).ready(function() {
	blanceThemeModule.init()
});
//6
jQuery(document).on("ready", function(e) {
	"use strict";

	function o() {
		e(".icon-menu-sb ").click(function(o) {
			o.stopPropagation(), e(".menu-sidebar-fixed ").toggleClass("active")
		}), e("body").click(function() {
			e(".menu-sidebar-fixed").hasClass("active") && e(".menu-sidebar-fixed").removeClass("active")
		}), e(".pe-7s-close").click(function(o) {
			o.stopPropagation(), e(".menu-sidebar-fixed").removeClass("active")
		}), e(".menu-sidebar-fixed").click(function(o) {
			o.stopPropagation(), e(".menu-sidebar-fixed").addClass("active")
		})
	}

	function t() {
		if(e("#back-to-top").length) {
			var o = 100,
				t = function() {
					var t = e(window).scrollTop();
					t > o ? e("#back-to-top").addClass("show") : e("#back-to-top").removeClass("show")
				};
			t(), e(window).on("scroll", function() {
				t()
			}), e("#back-to-top").on("click", function(o) {
				o.preventDefault(), e("html,body").animate({
					scrollTop: 0
				}, 700)
			})
		}
	}

	function a() {
		e("body").on("click", ".action-search a", function(o) {
			o.preventDefault(), b(e("#search-modal")), e("#search-modal").addClass("show")
		}), e("body").on("click", ".close-modal , .moal-overlay ", function(o) {
			o.preventDefault(), y(e("#search-modal")), e("#search-modal").removeClass("show")
		})
	}

	function s() {
		function o() {
			var o = n.val(),
				i = "";
			if(s.find(".product-cats").length > 0 && (i = s.find(".product-cats input:checked").val()), o.length < 1) return void s.removeClass("searching found-products found-no-product").addClass("invalid-length");
			s.removeClass("found-products found-no-product").addClass("searching");
			var c = o + i;
			if(c in a) {
				var l = a[c];
				s.removeClass("searching"), s.addClass("found-products"), r.find(".woocommerce").html(l.products), e(document.body).trigger("jws_ajax_search_request_success", [r]), r.find(".woocommerce, .buttons").slideDown(function() {
					s.removeClass("invalid-length")
				}), s.addClass("searched actived")
			} else t = e.ajax({
				url: MS_Ajax.ajaxurl,
				dataType: "json",
				method: "post",
				data: {
					action: "jws_search_products",
					nonce: MS_Ajax.nextNonce,
					term: o,
					cat: i
				},
				success: function(o) {
					var t = o.data;
					s.removeClass("searching"), s.addClass("found-products"), r.find(".woocommerce").html(t), r.find(".woocommerce, .buttons").slideDown(function() {
						s.removeClass("invalid-length")
					}), e(document.body).trigger("jws_ajax_search_request_success", [r]), a[c] = {
						found: !0,
						products: t
					}, s.addClass("searched actived")
				}
			});
			e(document.body).on("jws_ajax_search_request_success", function(e, o) {
				o.find("img").lazyload({
					threshold: 1e3
				})
			})
		}
		var t = null,
			a = {},
			s = e("#search-modal"),
			i = s.find("form"),
			n = i.find("input.search-field"),
			r = s.find(".search-results");
		s.on("keyup", ".search-field", function(e) {
			var a = !1;
			"undefined" == typeof e.which ? a = !0 : "number" == typeof e.which && e.which > 0 && (a = !e.ctrlKey && !e.metaKey && !e.altKey), a && (t && t.abort(), o())
		}).on("change", ".product-cats input", function() {
			t && t.abort(), o()
		}).on("focusout", ".search-field", function() {
			n.val().length < 2 && r.find(".woocommerce, .buttons").slideUp(function() {
				s.removeClass("searching searched actived found-products found-no-product invalid-length")
			})
		})
	}

	function i() {
		var o = e(".jws-masonry");
		o.each(function(o, t) {
			var a = e(this).data("masonry");
			if(void 0 !== a) {
				var s = a.selector,
					i = a.columnWidth,
					n = a.layoutMode;
				e(this).imagesLoaded(function() {
					e(t).isotope({
						layoutMode: n,
						itemSelector: s,
						percentPosition: !0,
						masonry: {
							columnWidth: i
						}
					})
				})
			}
		})
	}

	function n() {
		var o = e(window).height();
		e(".cmm-horizontal").css({
			"max-height": o + "px"
		})
	}

	function r() {
		e(".blance-video , .about-video-button").on("click", function() {
			var o = e(this),
				t = o.siblings("iframe"),
				a = t.attr("src"),
				s = a + "&autoplay=1";
			a.indexOf("vimeo.com") + 1 && (s = a + "?autoplay=1"), t.attr("src", s), o.addClass("hidden-video-bg")
		})
	}

	function c() {
		e(".video-popup , .blance-button-wrapper  ").length > 0 && (e(".action-popup-url ,  .about-video-button").magnificPopup({
			disableOn: 0,
			type: "iframe"
		}), e(".jws-popup-mp4").magnificPopup({
			disableOn: 0,
			type: "inline"
		}))
	}

	function l() {
		var o = e("body");
		o.on("click", ".add_to_wishlist", function() {
			e(this).parent().addClass("feid-in")
		})
	}

	function d() {
		var o = e("body"),
			t = e("a.compare");
		o.on("click", "a.compare", function() {
			e(this).addClass("loading")
		}), o.on("yith_woocompare_open_popup", function() {
			t.removeClass("loading"), o.addClass("compare-opened")
		}), o.on("click", "#cboxClose, #cboxOverlay", function() {
			o.removeClass("compare-opened")
		})
	}

	function m() {
		if("undefined" == typeof woocommerce_price_slider_params) return !1;
		if(e(".catalog-sidebar").find(".widget_price_filter").length <= 0 && e("#jws-shop-topbar").find(".widget_price_filter").length <= 0) return !1;
		e("input#min_price, input#max_price").hide(), e(".price_slider, .price_label").show();
		var o = e(".price_slider_amount #min_price").data("min"),
			t = e(".price_slider_amount #max_price").data("max"),
			a = parseInt(o, 10),
			s = parseInt(t, 10);
		"" != e(".price_slider_amount #min_price").val() && (a = parseInt(e(".price_slider_amount #min_price").val(), 10)), "" != e(".price_slider_amount #max_price").val() && (s = parseInt(e(".price_slider_amount #max_price").val(), 10)), e(document.body).bind("price_slider_create price_slider_slide", function(o, t, a) {
			"left" === woocommerce_price_slider_params.currency_pos ? (e(".price_slider_amount span.from").html(woocommerce_price_slider_params.currency_symbol + t), e(".price_slider_amount span.to").html(woocommerce_price_slider_params.currency_symbol + a)) : "left_space" === woocommerce_price_slider_params.currency_pos ? (e(".price_slider_amount span.from").html(woocommerce_price_slider_params.currency_symbol + " " + t), e(".price_slider_amount span.to").html(woocommerce_price_slider_params.currency_symbol + " " + a)) : "right" === woocommerce_price_slider_params.currency_pos ? (e(".price_slider_amount span.from").html(t + woocommerce_price_slider_params.currency_symbol), e(".price_slider_amount span.to").html(a + woocommerce_price_slider_params.currency_symbol)) : "right_space" === woocommerce_price_slider_params.currency_pos && (e(".price_slider_amount span.from").html(t + " " + woocommerce_price_slider_params.currency_symbol), e(".price_slider_amount span.to").html(a + " " + woocommerce_price_slider_params.currency_symbol)), e(document.body).trigger("price_slider_updated", [t, a])
		}), "undefined" != typeof e.fn.slider && e(".price_slider").slider({
			range: !0,
			animate: !0,
			min: o,
			max: t,
			values: [a, s],
			create: function() {
				e(".price_slider_amount #min_price").val(a), e(".price_slider_amount #max_price").val(s), e(document.body).trigger("price_slider_create", [a, s])
			},
			slide: function(o, t) {
				e("input#min_price").val(t.values[0]), e("input#max_price").val(t.values[1]), e(document.body).trigger("price_slider_slide", [t.values[0], t.values[1]])
			},
			change: function(o, t) {
				e(document.body).trigger("price_slider_change", [t.values[0], t.values[1]])
			}
		})
	}

	function u() {
		var o = e("#jws-shop-toolbar"),
			t = e("#jws-shop-topbar"),
			a = e("#jws-categories-filter"),
			s = o.find(".woocommerce-ordering"),
			i = e(".catalog-sidebar");
		e(window).on("resize", function() {
			e(window).width() < 991 ? (o.addClass("on-mobile"), t.addClass("on-mobile"), i.addClass("on-mobile")) : (a.removeAttr("style"), e("#jws-toggle-cats-filter").removeClass("active"), o.removeClass("on-mobile"), t.removeClass("on-mobile"), i.removeClass("on-mobile"), t.find(".widget-title").next().removeAttr("style"), i.find(".widget-title").next().removeAttr("style"))
		}).trigger("resize"), e(document.body).find(".shop-toolbar, .shop-bottombar").on("click", ".jws-filter", function(o) {
			o.preventDefault(), e(this).closest(".shop-toolbar").hasClass("on-mobile") ? ( s.slideUp(200), e("#jws-toggle-cats-filter").removeClass("active"), e("#jws-ordering").removeClass("active"), setTimeout(function() {
				t.slideToggle(200)
			}, 200)) : t.slideToggle(), t.toggleClass("active"), e(this).toggleClass("active"), t.closest(".shop-bottombar").toggleClass("show"), e("#jws-filter-overlay").toggleClass("show"), e(document.body).toggleClass("show-filters-content")
		}), e(document.body).on("click", "#jws-filter-overlay", function(o) {
			o.preventDefault(), t.slideToggle(), e(".jws-filter").removeClass("active"), t.closest(".shop-bottombar").toggleClass("show"), e("#jws-filter-overlay").toggleClass("show"), t.removeClass("active"), e(document.body).removeClass("show-filters-content")
		}), e(document.body).on("click", "#jws-toggle-cats-filter", function(o) {
			o.preventDefault(), e(this).closest(".shop-toolbar").hasClass("on-mobile") && (t.slideUp(200), setTimeout(function() {
				a.slideToggle(200)
			}, 200), e(this).toggleClass("active"), e(".jws-filter").removeClass("active"), t.removeClass("active"))
		}), e(document.body).on("click", "#jws-ordering", function(o) {
			o.preventDefault(), e(this).closest(".shop-toolbar").hasClass("on-mobile") && (t.slideUp(200), setTimeout(function() {
				s.slideToggle(200)
			}, 200), e(this).toggleClass("active"), e(".jws-filter").removeClass("active"), t.removeClass("active"))
		}), t.on("click", ".widget-title", function(o) {
			e(this).closest(".shop-topbar").hasClass("on-mobile") && (o.preventDefault(), e(this).closest(".widget").siblings().find(".widget-title").next().slideUp(200), e(this).closest(".widget").siblings().removeClass("active"), e(this).next().slideToggle(200), e(this).closest(".widget").toggleClass("active"))
		}), i.on("click", ".widget-title", function(o) {
			e(this).closest(".catalog-sidebar").hasClass("on-mobile") && (o.preventDefault(), e(this).closest(".widget").siblings().find(".widget-title").next().slideUp(200), e(this).closest(".widget").siblings().removeClass("active"), e(this).next().slideToggle(200), e(this).closest(".widget").toggleClass("active"))
		})
	}

	function p() {
		e(document.body).on("price_slider_change", function() {
			var o = e(".price_slider").closest("form").get(0),
				t = e(o),
				a = t.attr("action") + "?" + t.serialize();
			e(document.body).trigger("blance_catelog_filter_ajax", a, e(this))
		}), e(document.body).on("click", " #remove-filter-actived", function(o) {
			o.preventDefault();
			var t = e(this).attr("href");
			e(document.body).trigger("blance_catelog_filter_ajax", t, e(this))
		}), e(document.body).find("#jws-shop-product-cats").on("click", ".cat-link", function(o) {
			o.preventDefault();
			var t = e(this).attr("href");
			e(document.body).trigger("blance_catelog_filter_ajax", t, e(this))
		}), e(document.body).find("#jws-shop-toolbar").find(".woocommerce-ordering").on("click", "a", function(o) {
			o.preventDefault(), e(this).addClass("active");
			var t = e(this).attr("href");
			e(document.body).trigger("blance_catelog_filter_ajax", t, e(this))
		}), e(document.body).find("#jws-categories-filter").on("click", "a", function(o) {
			o.preventDefault(), e(this).addClass("selected");
			var t = e(this).attr("href");
			e(document.body).trigger("blance_catelog_filter_ajax", t, e(this))
		}), e(document.body).find("#jws-shop-topbar, .catalog-sidebar").on("click", "a", function(o) {
			var t = e(this).closest(".widget");
			if(t.hasClass("widget_product_tag_cloud") || t.hasClass("widget_product_categories") || t.hasClass("widget_layered_nav_filters") || t.hasClass("widget_layered_nav") || t.hasClass("product-sort-by") || t.hasClass("blance-price-filter-list")) {
				o.preventDefault(), e(this).closest("li").addClass("chosen");
				var a = e(this).attr("href");
				e(document.body).trigger("blance_catelog_filter_ajax", a, e(this))
			}
			t.hasClass("widget_product_tag_cloud") && e(this).addClass("selected"), t.hasClass("product-sort-by") && e(this).addClass("active")
		}), e(document.body).on("blance_catelog_filter_ajax", function(o, t, a) {
			var s = e(".bt-product-items"),
				n = e(".catalog-sidebar"),
				r = e("#jws-categories-filter"),
				c = e("#jws-shop-topbar"),
				u = e(".shop-toolbar .woocommerce-ordering");
			if(e("#jws-shop-toolbar").length > 0) {
				var p = e("#jws-shop-toolbar").offset().top - 200;
				e("html, body").stop().animate({
					scrollTop: p
				}, 1200)
			}
			e(".blance-products-loaders").addClass("show"), "?" == t.slice(-1) && (t = t.slice(0, -1)), t = t.replace(/%2C/g, ","), history.pushState(null, null, t), e(document.body).trigger("blance_ajax_filter_before_send_request", [t, a]), e.get(t, function(o) {
				s.replaceWith(e(o).find(".bt-product-items")), n.html(e(o).find(".catalog-sidebar").html()), r.html(e(o).find("#jws-categories-filter").html()), c.html(e(o).find("#jws-shop-topbar").html()), u.html(e(o).find(".shop-toolbar .woocommerce-ordering").html()), e(".blance-products-loaders").removeClass("show"), i(), m(), l(), d(), j(), e("#jws-shop-loading").removeClass("show"), e(document.body).trigger("blance_ajax_filter_request_success", [o, t])
			}, "html")
		}), e(document.body).on("blance_ajax_filter_before_send_request", function() {
			(e("#jws-shop-toolbar").hasClass("on-mobile") || e("#jws-shop-topbar").hasClass("on-mobile")) && ( e("#jws-shop-topbar").slideUp(), e("#jws-toggle-cats-filter").removeClass("active"), e(".jws-filter").removeClass("active"))
		})
	}

	function f() {
		e(document.body).on("click", ".jws-swatch-variation-image", function(o) {
			o.preventDefault(), e(this).siblings(".jws-swatch-variation-image").removeClass("selected"), e(this).addClass("selected");
			var t = e(this).data("src"),
				a = e(this).parents(".tb-products-grid").find("article > .product-thumb"),
				s = a.find("img").first(),
				i = s.first().width(),
				n = s.first().height();
			a.addClass("image-loading"), a.css({
				width: i,
				height: n,
				display: "block"
			}), s.attr("src", t), s.load(function() {
				a.removeClass("image-loading"), a.removeAttr("style")
			})
		})
	}

	function h() {
		var o = e("#product-thumbnails").find(".thumbnails"),
			t = e("#product-images");
		t.not(".slick-initialized").slick({
			slidesToScroll: 1,
			asNavFor: ".thumbnails",
			fade: !0,
			prevArrow: '<span class="ti-angle-left"></span>',
			nextArrow: '<span class="ti-angle-right"></span>'
		}), o.not(".slick-initialized").slick({})
	}

	function _() {
		if(e(".jws-image-zoom").length > 0) {
			var o = e(".jws-image-zoom");
			o.zoom({
				touch: !1
			})
		}
	}

	function g() {
		e(window).width() > 991 && e(".sticky-move").stick_in_parent()
	}

	function v() {
		e("body").on("tawcvs_initialized", function() {
			e(".variations_form").unbind("tawcvs_no_matching_variations"), e(".variations_form").on("tawcvs_no_matching_variations", function(o, t) {
				o.preventDefault(), t.addClass("selected"), e(".variations_form").find(".woocommerce-variation.single_variation").show(), "undefined" != typeof wc_add_to_cart_variation_params && e(".variations_form").find(".single_variation").slideDown(200).html("<p>" + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + "</p>")
			})
		}), e(document).on("found_variation", "form.variations_form", function(o) {
			o.preventDefault(), e("#product-images").slick("slickGoTo", 0, !0)
		}).on("reset_image", function() {
			e("#product-images").slick("slickGoTo", 0, !0)
		}), e(".variations_form").find("td.value").each(function() {
			e(this).find(".variation-selector").hasClass("hidden") ? e(this).prev().addClass("show-label") : e(this).addClass("show-select")
		})
	}

	function w() {
		e(document.body).on("click", "#blance-shop-infinite-loading a.next", function(o) {
			if(o.preventDefault(), !e(this).data("requestRunning")) {
				e(this).data("requestRunning", !0), e(".dots-loading").addClass("show");
				var t = e(this).closest(".woocommerce-pagination").prev(".product-list"),
					a = e(this).closest(".woocommerce-pagination");
				e.get(e(this).attr("href"), function(o) {
					var s = e(o).find(".product-list").children(".tb-products-grid"),
						i = e(o).find(".woocommerce-pagination").html();
					a.html(i), e(document.body).hasClass("catalog-board-content") ? s.imagesLoaded(function() {
						t.isotope("insert", s), a.find(".page-numbers.next").data("requestRunning", !1), e(document.body).trigger("blance_shop_ajax_loading_success")
					}) : (t.append(s), a.find(".page-numbers.next").data("requestRunning", !1), e(document.body).trigger("blance_shop_ajax_loading_success"), t.isotope("insert", s)), a.find("li .page-numbers").hasClass("next") || a.addClass("loaded")
				})
			}
		}), e(document.body).on("blance_shop_ajax_loading_success", function() {
			e(".blance-products-loader").removeClass("show"), i(), l(), d(), j()
		})
	}

	function v() {
		e(document.body).on("tawcvs_initialized", function() {
			e(".variations_form").unbind("tawcvs_no_matching_variations"), e(".variations_form").on("tawcvs_no_matching_variations", function(o, t) {
				o.preventDefault(), t.addClass("selected"), e(".variations_form").find(".woocommerce-variation.single_variation").show(), "undefined" != typeof wc_add_to_cart_variation_params && e(".variations_form").find(".single_variation").slideDown(200).html("<p>" + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + "</p>")
			})
		}), e(document).on("found_variation", "form.variations_form", function(o) {
			o.preventDefault(), e("#product-images").slick("slickGoTo", 0, !0)
		}).on("reset_image", function() {
			e("#product-images").slick("slickGoTo", 0, !0)
		}), e(".variations_form").find("td.value").each(function() {
			e(this).find(".variation-selector").hasClass("hidden") ? e(this).prev().addClass("show-label") : e(this).addClass("show-select")
		})
	}

	function b(o) {
		e(document.body).addClass("modal-open"), o.fadeIn(), o.addClass("open")
	}

	function y() {
		e(document.body).removeClass("modal-open")
	}

	function C() {
		e(document.body).on("click", ".product-quick-view", function(o) {
			o.preventDefault();
			var t = e(this),
				a = t.attr("href"),
				s = e("#quick-view-modal"),
				i = s.find(".product"),
				n = s.find(".close-modal").first().clone();
			i.hide().html("").addClass("invisible"), s.addClass("loading"), b(s), e.get(a, function(o) {
				var t = e(o),
					a = t.find("#content").find(".product-top "),
					r = a.find(".info-product"),
					c = (a.find("script"), a.find(".product-thumbnails")),
					l = a.find(".variations_form"),
					d = a.find(".woocommerce-product-gallery__wrapper"),
					m = a.find(".product-advanced"),
					u = t.find(".product").attr("class");
				r.remove(), c.remove(), m.remove(), i.addClass(u), i.show().html(a).prepend(n), d.not(".slick-initialized").slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: !1,
					prevArrow: '<span class="ti-angle-left"></span>',
					nextArrow: '<span class="ti-angle-right"></span>'
				}), s.removeClass("loading"), i.removeClass("invisible"), d.find(".photoswipe").on("click", function(e) {
					e.preventDefault()
				}), s.removeClass("loading"), i.removeClass("invisible"), d.find(".woocommerce-product-gallery__image a").on("click", function(e) {
					e.preventDefault()
				}), "undefined" != typeof wc_add_to_cart_variation_params && (l.wc_variation_form(), l.find(".variations select").change()), "undefined" != typeof e.fn.tawcvs_variation_swatches_form && l.tawcvs_variation_swatches_form(), d.imagesLoaded(function() {
					d.addClass("loaded")
				}), v(), e(".yith-wfbt-item input").removeAttr("type"), e(".yith-wfbt-item input").attr("type", "checkbox")
			}, "html")
		}), e("#quick-view-modal").on("click", function(o) {
			var t = o.target;
			e(t).closest("div.product").length <= 0 && y()
		}), e("#quick-view-modal").on("click", function(o) {
			var t = o.target;
			e(t).closest("div.product").length <= 0 && y()
		})
	}

	function j() {
		e(".blance-timer").each(function() {
			e(this).countdown(e(this).data("end-date"), function(o) {
				e(this).html(o.strftime('<h4 class="countdown-days">%-D <span>Days</span></h4> <h4 class="countdown-hours">%H <span>Hrs</span></h4> <h4 class="countdown-min">%M <span>Mins</span></h4> <h4 class="countdown-sec">%S <span>Secs</span></h4>'))
			})
		})
	}
	e(".cmm-toggle span").click(function() {
		e("body").toggleClass("overlay-mobile")
	}), o(), (e("#jws_header").hasClass("jws-header-v1") || e("#jws_header").hasClass("jws-header-v2") || e("#jws_header").hasClass("jws-header-v4")) && e(".mainmenu-area ").sticky({
		topSpacing: 0
	}), e("#jws_header").hasClass("jws-header-v3") && e(window).width() > 992 && e(".mobimenu ").sticky({
		topSpacing: 0
	}), t(), a(), s(), n(), r(), e(".360-image a").magnificPopup({
		type: "inline",
		mainClass: "mfp-fade",
		removalDelay: 160,
		disableOn: !1,
		preloader: !1,
		fixedContentPos: !1,
		callbacks: {
			open: function() {
				e(window).resize()
			}
		}
	}), e(".yith-wfbt-item input").removeAttr("type"), e(".yith-wfbt-item input").attr("type", "checkbox"), c(), l(), d(), u(), p(), e(".jws-carousel").slick({
		prevArrow: '<span class="ti-angle-left"></span>',
		nextArrow: '<span class="ti-angle-right"></span>'
	}), f(), e(".product-images-content").hasClass("no_galley") === !1 && h(), _(), g(), v(), w(), e(document.body).on("click", ".close-modal", function(e) {
		e.preventDefault(), y()
	}), C(), j()
}(jQuery));
//7
! function(a) {
	"use strict";
	var d = function() {
		a("body").on("click", ".single_add_to_cart_button , .ajax_add_to_cart", function(d) {
			a(this).hasClass("disabled") || (d.preventDefault(), a("body").addClass("widget-panel-open"), a("#jws-widget-panel-overlay").addClass("show"), a("body").removeClass("modal-open"))
		})
	};
	a(document).ready(function() {
		d()
	})
}(jQuery);
//8
! function(o) {
	"use strict";
	o.extend(o.nmTheme, {
		infload_init: function() {
			var o = this;
			o.$shopBrowseWrap.children(".jws-paginations");
			o.shopInfLoadBind()
		},
		shopInfLoadBind: function() {
			var n = this,
				r = n.$shopBrowseWrap.children(".jws-infload-controls");
			if(n.shopInfLoadBound = !0, n.infloadScroll = !!r.hasClass("scroll-mode"), n.infloadScroll) {
				n.infscrollLock = !1;
				var l, e = Math.round(n.$document.height() - r.offset().top),
					i = null;
				n.$window.resize(function() {
					i && clearTimeout(i), i = setTimeout(function() {
						var o = n.$shopBrowseWrap.children(".jws-infload-controls");
						e = Math.round(n.$document.height() - o.offset().top)
					}, 100)
				}), n.$window.bind("smartscroll.infscroll", function() {
					n.infscrollLock || (l = 0 + n.$document.height() - n.$window.scrollTop() - n.$window.height(), e > l && n.shopInfLoadGetPage())
				})
			} else {
				var s = o(".bt-product-items");
				s.on("click", ".jws-infload-btn", function(o) {
					o.preventDefault(), n.shopInfLoadGetPage()
				}), s.on("click", ".jws-infload-to-top", function(o) {
					o.preventDefault(), n.shopScrollToTop()
				})
			}
			n.infloadScroll && n.$window.trigger("scroll")
		},
		shopInfLoadGetPage: function() {
			var n = this,
				r = n.$shopBrowseWrap.children(".jws-infload-link").find("a"),
				l = n.$shopBrowseWrap.children(".jws-infload-controls"),
				e = r.attr("href");
			e ? (e = n.updateUrlParameter(e, "shop_load", "products"), l.addClass("jws-loader"), n.shopAjax = o.ajax({
				url: e,
				dataType: "html",
				cache: !1,
				headers: {
					"cache-control": "no-cache"
				},
				method: "GET",
				error: function(o, n, r) {
					console.log("NM: AJAX error - shopInfLoadGetPage() - " + r)
				},
				complete: function() {
					l.removeClass("jws-loader")
				},
				success: function(i) {
					var s = o("<div>" + i + "</div>"),
						a = s.children(".product-list").children(".tb-products-grid");
					n.$shopBrowseWrap.find(".product-list").append(a), e = s.find(".jws-infload-link").children("a").attr("href"), e ? r.attr("href", e) : (n.$shopBrowseWrap.addClass("all-products-loaded"), n.infloadScroll ? n.infscrollLock = !0 : l.addClass("hide-btn"), r.removeAttr("href")), n.shopAjax = !1, n.infloadScroll && n.$window.trigger("scroll")
				}
			})) : n.infloadScroll && (n.infscrollLock = !0)
		}
	}), o.nmThemeExtensions.infload = o.nmTheme.infload_init
}(jQuery);
//9
! function(o) {
	"use strict";
	o(document).ready(function() {
		var s = function() {
			var s = o(".jws-masonry");
			s.each(function(s, i) {
				var e = o(this).data("masonry");
				if(void 0 !== e) {
					var t = e.selector,
						a = e.columnWidth,
						c = e.layoutMode;
					o(this).imagesLoaded(function() {
						o(i).isotope({
							layoutMode: c,
							itemSelector: t,
							percentPosition: !0,
							masonry: {
								columnWidth: a
							}
						})
					})
				}
			})
		};
		s();
		var i = function() {
			o("body").on("click", ".wc-col-filter a", function(i) {
				i.preventDefault();
				var e = o(this),
					t = e.data("col"),
					a = e.closest(".wc-col-filter"),
					c = o(".tb-products-grid"),
					d = o(".product-list .grid-sizer");
				e.hasClass("active") || (a.find("a").removeClass("active"), e.addClass("active"), c.removeClass(" col-md-3 col-md-2 col-md-4 col-md-20 col-md-6").addClass("col-md-" + t), d.removeClass("size-2 size-3 size-4 size-20 size-6 size-12").addClass("size-" + t), s())
			})
		};
		i()
	})
}(window.jQuery);