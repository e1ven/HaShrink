( function($){

	function pagemenu(pageid){
		$(pageid + " ul").css({display: "none"});
		$(pageid).find('a').removeAttr('title');
		var kl = $(pageid + " li").filter(":has(>ul)");
		
		kl.each(function(){
			$(this).css({position: "relative"});
		
			$(this).hover(function(){
				var ulDrop = $(this).find('ul:first');
				$(this).addClass('onhove');
				$(this).find('a:eq(0)').addClass('onhov');


				ulDrop.stop().css({overflow:"hidden", height:"auto",visibility: "visible",display: "none"}).slideDown(300,
					function(){
						ulDrop.css({overflow:"visible", height:"auto"});
					}
				);	
			}, function(){
				var biz = $(this).find('a:eq(0)'),
					ulDrop = $(this).find('ul:first');

				ulDrop.stop().css({overflow:"hidden", display:"none"});
				biz.removeClass('onhov');
				$(this).removeClass('onhove');				
			});
		})
		$(pageid +' .current_page_item').find('a:first').addClass('pageactive');
		$(pageid +' .current-menu-item').find('a:first').addClass('pageactive');
		
	};
	
	/**
	 * Product lists scroller,
	 * used, jQuery scrollpane plugin + mousewheel plugin
	 */
	function _product_lists_scroller(){
	
		var toScroll = $('.images').find('.thumbnails');
		
		if( toScroll.length ){
			
			var tLength = toScroll.find('a').length,
				tHtml = toScroll.html(),
				tRep = '<div class="inner_scroll">'+tHtml+'</div>';
			
			if( tLength ){
				toScroll.addClass('init_scroll').css('height', '96px').html( tRep );
				
				$('.inner_scroll').css({width : (tLength*84)-4+'px'});
				toScroll.each(function(){
					var t = $(this);
					t.jScrollPane({
						showArrows : false,
						animateEase : 'easeInOutElastic'
					});
				});
			}
			
		}
	
	};
	


	function blog_thumbnail_hover(){
	
	$('.full-column-blog-thumbnail, .standard-blog-thumbnail, .column-blog-thumbnail, .fullwidth-blog-thumbnail').each(function(){
		var $_img = $(this).find('img');
		$_img.hover(function(){
			$_img.stop().animate({ opacity : 0.5 }, 400 );
		}, function(){
			$_img.stop().animate({ opacity : 1 }, 400 );
		});
	});
	
	};




	function product_thumbnail_hover(){
	
		$('.product_lists_thumbnail').each(function(){
			var $_img = $(this).find('img');
			$_img.hover(function(){
				$_img.stop().animate({ opacity : 0.5 }, 400 );
			}, function(){
				$_img.stop().animate({ opacity : 1 }, 400 );
			});
		});
		
		
		if( $('.product-gallery-thumbnail').length ){
			var tp = $('.product-gallery-thumbnail').find('img');
			tp.each(function(){
				var $_t = $(this);
				
				$_t.hover(function(){
					$_t.stop().animate({ opacity : 0.3 }, 400 );
				}, function(){
					$_t.stop().animate({ opacity : 1 }, 400 );
				});
			});
		}
	
	};
	



	function tableColapse(){
	
		$('table').each(function(){
			$(this).attr('cellspacing', '0');
		});
	
	};
	


	
	function portfolio_thumbnail_hover(){
		
		$('.portfolio-thumbnail').each(function(){
			var $_img = $(this).find('img.portfolio-original');
			$_img.hover(function(){
				$_img.stop().animate({ opacity : 0.05 }, 400 );
			}, function(){
				$_img.stop().animate({ opacity : 1 }, 400 );
			});
		});
		
		$('.portfolio_widget_thumbnail').each(function(){
			var $_img_t = $(this).find('img.portfolio_widget_thumbnail_default');
			$_img_t.hover(function(){
				$_img_t.stop().animate({ opacity : 0.05 }, 400 );
			}, function(){
				$_img_t.stop().animate({ opacity : 1 }, 400 );
			});
		});
		
		
	}
	




	function bt_hover_sp(){
		var bt = $('.button_tagline');
		
		if(bt.length){
			bt.each(function(){
				var t = $(this);
				t.hover(function(){
					t.stop().animate({ opacity : 0.65 },200);
				}, function(){
					t.stop().animate({ opacity : 1.0 },200);
				});
			});
		}
	};





	function _top_cart_hover(){

		$('#wip_woo_cart').hover(function(){
				var drop = $(this).find('.wip_woo_cart_drop');
				if( drop.length && drop.is(':hidden') ){
						$('#wip_woo_cart').addClass('cart_over');
						drop.css({opacity : 0.95});
						drop.slideDown(400);
				}
		}, function(){
				var drop = $(this).find('.wip_woo_cart_drop');
				if( drop.length && drop.not(':hidden') ){
					drop.slideUp(400);
					$('#wip_woo_cart').removeClass('cart_over');
				}
		});
		
		if( $('body').hasClass('woocommerce-cart') || $('body').hasClass('woocommerce-checkout') ){
			$('.wip_woo_cart_drop').remove();
		}

	};
	
	



	function sortStyle(){
	
		var sel = $('select');

		if( sel.length ){
			sel.each(function(){
				var t = $(this);
				if( t.parent().attr('id') != 'billing_country_field' && t.parent().attr('id') != 'shipping_country_field' && t.attr('id') != 'rating' && t.attr('id') != 'shipping_method' && t.attr('class') != 'country_to_state' ){
					t.selectBox();
				}
			});
		}

		
	}





	function shortcodeTabs(){

		if( $('div.wip_tab').length ){

			$('div.wip_tab').each( function(){
				var $tabs_wrapper = $(this);

				$tabs_wrapper.find('.panes .pane').hide();
				$tabs_wrapper.find('.panes .pane:eq(0)').show();
				$tabs_wrapper.find('ul.tab-lists li:eq(0)').addClass('active');

				$tabs_wrapper.find('ul.tab-lists li a').click(function(){
					var $tab = $(this);

					$('ul.tab-lists li', $tabs_wrapper).removeClass('active');
					$('div.pane', $tabs_wrapper).hide();
					$('div.pane:eq(' + $tab.attr('rel') + ')', $tabs_wrapper).show();
					$tab.parent().addClass('active');

					return false;
				});

			});
		}
	}




	function toggleHandle(){
		var togPar = $('.toggle_container');
		
		togPar.each(function(){
			var redeclareTogPar = $(this);
			var headClick = $(this).find('.toggle_title');
			
			redeclareTogPar.find('.toggle_body').hide();
			headClick.removeClass('toggle_open');
			
			headClick.click(function(){
				
				var togBody = redeclareTogPar.find('.toggle_body');
				
				if( togBody.is(':hidden') ){
				
					togBody.slideDown(200);
					$(this).find('.toggle_indicator').html('&ndash;');
					$(this).addClass('toggle_open');
					
				} else {
				
					togBody.slideUp(200);
					$(this).find('.toggle_indicator').html('&plus;');
					$(this).removeClass('toggle_open');
				
				}
			
			});
		
		});

	};
	



	function socAndFlickr(){
		var soc = $('ul.builder_social_icons');
		var flickr = $('ul.flickr-image');
		
		soc.each(function(){
			var sic = $(this).find('a');
		
			sic.each(function(){
				$(this).hover( function(){
				
					$(this).find('img').stop().animate({ opacity : 0.6 }, 500 );
				
				}, function(){
					$(this).find('img').stop().animate({ opacity : 1.0 }, 500 );
				});
			});
		});
		
		flickr.each(function(){
			var fia = $(this).find('li');
			var flick = $(this);
			
			fia.each(function(){
				$(this).hover( function(){
					$(flick).find('li').not(this).find('img').stop().animate({ opacity : 0.3 }, 700 );
					$(this).find('img').stop().animate({ opacity : 1.0 }, 700 );
				
				}, function(){
					$(flick).find('li').not(this).find('img').stop().animate({ opacity : 1.0 }, 700 );
				});
			});
		});
		
	};


	
	$(document).ready(function(){
		pagemenu('#main-nav');
		product_thumbnail_hover();
		portfolio_thumbnail_hover();
		blog_thumbnail_hover();
		bt_hover_sp();
		_top_cart_hover();
		sortStyle();
		tableColapse();
		shortcodeTabs();
		toggleHandle();
		socAndFlickr();
	});

})(jQuery);

jQuery(document).ready(function(){
	jQuery('[placeholder]').each(function(i, el){jQuery(el).pH();});
});
jQuery.fn.pH=function(df){ var el = jQuery(this);df = df || el.attr('placeholder');if(df && df.length) {el.focus(function() {if(el.val() == el.data('df')) el.val('').removeClass('empty');});el.blur(function() {if(!el.val().length) el.val(el.data('df')).addClass('empty');});el.closest('form').submit(function() {if(el.val() == el.data('df')) el.val('');});el.data('df', df).attr('title', df).trigger('blur');}return this;};



/** WooCommerce event helper */
( function($){

	$(function(){
		var WooLength = $('ul.products').length;
		var WooCheckout = $('.woocommerce-checkout').length;
		
		/** only read if there are product listing found in a page */
		if( WooLength ){
		
			/** find if the topcart dropdown is exists, in case user delete this area to meet their needs */
			if( $('#wip_woo_cart').length ){
				var dropParent = $('#wip_woo_cart'),
					parentValue = dropParent.find('.wip_woo_inner_cart').find('.amount'),
					cartDrop = dropParent.find('.wip_woo_cart_drop');
				
				//read the Trigger event from WooCommerce
				$('body').bind('added_to_cart', function(){
						
						cartDrop.load( window.location + ' .wip_woo_cart_drop:eq(0) > *', function() {
							var subtotal = cartDrop.find('.total').find('.amount');				
							parentValue.html(subtotal.html());
							
							$.browser.opera  = /opera/.test(navigator.userAgent.toLowerCase());  
							if ($.browser.opera){
								$('html').animate({scrollTop : 0}, {queue:false, duration:1000, easing: 'easeInOutCirc'} );
							} else {
								$('html,body').animate({scrollTop : 0}, {queue:false, duration:1000, easing: 'easeInOutCirc'} );
							}
						});
						
						return false;
				});
				
			}
		
		}
		
		
		if( $('.woocommerce_error').length > 0 ){
			$('.woocommerce_error').append('<br/><button id="warning-close" type="submit" class="button">OK</button>');
			$('.woocommerce_error').css({
				top: ($(window).height()-168)/2+'px',
				left: ($(window).width()-500)/2+'px',
				opacity: 0}).delay(300).animate({ opacity : 0.95 }, 700 );
			$('#warning-close').live('click', function(){
				$('#warning-close').parent().remove();
				return false;
			});
		}
		
		
		if( $('.product_list_price').length ){
			$('.product_list_price').each(function(){
				$(this).find('del').css({opacity : .75});
			});
		}
		
		
		if( $('.product_list_button').length){
			$('.product_list_button').each( function(){
				var bt = $(this),
					bta = $(this).find('a');
					
				if( bta.length ){
					var bta_txt = bta.text();
					if( bta_txt != "" ){
						var tool = '<span class="item-meta-tip"><span>'+bta_txt+'</span></span>';
						
						bt.append( tool );
					}
				}
				
				
					bta.hover( function(){
						var tooltip = bta.parent().find('.item-meta-tip');

						tooltip.css({display: 'block', opacity : '0', right : '54px'});
						tooltip.stop().animate({ opacity : 1, right : '36px'}, 300 );
					
					}, function(){
						var tooltip = bta.parent().find('.item-meta-tip');
						
						tooltip.stop().animate({ opacity : 0, right : '54px'}, 300, function() { tooltip.css({ display : 'none' }) } );
					});
			
			});
		}
		
		
		if( WooCheckout ){
			var pInfo = $('.woocommerce-checkout').find('p.info'),
				wLogin = $('form.login'),
				wBilling = $('#customer_details').find('.col-1'),
				wShipping = $('#customer_details').find('.col-2'),
				processBar = $('#woo_checkout_process_bar').find('.process_bar'),
				clicker = $('#checkout_tab_process').find('li');
				
			if( wLogin.length ){	
				wLogin.removeClass('login').addClass('wip-login').show();
				wLogin.wrap('<div id="process-0"/>');
			}
			wBilling.wrap('<div id="process-1"/>');
			wShipping.wrap('<div id="process-2"/>');
			$('#order_review').hide();
			$('#order_review_heading').hide();
			
			$('body').bind('update_checkout', function() {
				//$('#order_review').hide();

			});
			
			$('body').bind('updated_checkout', function(){
				var wOrder = $('#order_review').find('table.shop_table'),
				wPayment = $('#order_review').find('#payment'),
				wButton = wPayment.find('.form-row');
				
				$('#order_review').show();
				wOrder.wrap('<div id="process-4"/>');
				wOrder.after( wButton );
				wPayment.wrap('<div id="process-3"/>');
				
				if( $('.viewed').length ){
					var v = $('.viewed').find('a').attr('data');
					if( v == 'process-4' ){
						$('#process-4').show();
					}
					
					if( v == 'process-3' ){
						$('#process-3').show();
					}
				}
			});
			
			
			$(document).ajaxStop(function(){
				if( $('.woocommerce_error').length > 0 ){
					$('.woocommerce_error').each( function(){
						var er = $(this);
						if( er.parent().parent().hasClass('widget_login') ){
						
						} else {
							er.append('<br/><button id="warning-close" type="submit" class="button">OK</button>');
							er.css({
								top: ($(window).height()-168)/2+'px',
								left: ($(window).width()-500)/2+'px',
								opacity: 0}).delay(300).animate({ opacity : 0.95 }, 700 );
							$('#warning-close').live('click', function(){
								$('#warning-close').parent().remove();
								return false;
							});
						}
					});
				}
			});
			
			pInfo.each(function(){
				var p = $(this);
				if( p.find('.showlogin').length ){
					p.remove();
				}
			});
			
			
			$('#process-0, #process-1, #process-2, #process-3, #process-4').hide();
			if( $('#process-0').length ){
				$('#process-0').show();
				$('#checkout_tab_process').find('li:first').addClass('viewed');
				processBar.stop().animate({width : '20%'}, {duration:1000,easing:'easeOutSine'});
			} else {
				$('#process-1').show();
				if( $('#checkout_tab_process').find('li.tolog').length ){
					$('#checkout_tab_process').find('li:eq(1)').addClass('viewed');
					processBar.stop().animate({width : '40%'}, {duration:1000,easing:'easeOutSine'});
				} else {
					 $('#checkout_tab_process').find('li').css({width : '25%'});
					$('#checkout_tab_process').find('li:first').addClass('viewed');
					processBar.stop().animate({width : '25%'}, {duration:1000,easing:'easeOutSine'});
				}
			}
			
			clicker.each(function(){
				var t = $(this),
					c = t.find('a'),
					d = c.attr('data'),
					tw = 100/ parseInt( $('#checkout_tab_process').find('li').length ),
					leftpos = t.index();
				c.click(function(e){
					e.preventDefault();
					if( $('#'+d).is(':hidden') ){
						$('#process-0, #process-1, #process-2, #process-3, #process-4').hide();
						$('#'+d).show();
						$('.viewed').removeClass('viewed');
						t.addClass('viewed');
						if( leftpos == '0' ){
							processBar.stop().animate({width : tw+'%'}, {duration:1000,easing:'easeOutSine'});
						} else {
							processBar.stop().animate({width : tw*(leftpos+1)+'%'}, {duration:1000,easing:'easeOutSine'});
						}
					}
				});
			});
		}
		
		
		
		$('a[itemprop="image"]').hover( function(){
			var prop_i = $(this).find('img');
			prop_i.stop().animate({ opacity : .5 }, 300 );
		}, function(){
			var prop_i = $(this).find('img');
			prop_i.stop().animate({ opacity : 1.00 }, 300 );
		});
		
		if( $('#woo_price_ribbon').length ){
			if( $('#woo_price_ribbon').html().search('<') == -1 ){
				$('#woo_price_ribbon').css({lineHeight : '80px'});
			}
		}
		
		if( bdVar.use_fancy == 'false' ){
			var wrap = $('body.single-product').find('.images').find('a[itemprop="image"]');
			var thum = $('body.single-product').find('.product-gallery-thumbnail');
			if( wrap.length ){
				wrap.attr('rel', 'prettyPhoto');
			}
			
			if( thum.length ){
				var aThumb = thum.find('a');
				if( aThumb.length ){
					aThumb.each(function(){
						$(this).attr('rel', 'prettyPhoto[products]');
					});
				}
			}
			
		}
		
		
		var defaultgal = $('.gallery').find('a');
			defaultgal.each(function(){
				if(this.href.match(/\.(jpe?g|png|bmp|gif|tiff?)$/i)){
					$(this).attr('rel', 'prettyPhoto[gallery]');
				}
			});
		
		$("a[rel^='prettyPhoto']").prettyPhoto({theme: bdVar.pp_theme, social_tools : false});
		
	});

})(jQuery);




( function($){
	$(function(){
	
	if( $('form#contact-form').length ){
		$('form#contact-form').bind('submit', function() {
			var that = $(this);
			
			var name = $('#hname').val(),
				mail = $('#hmail').val(),
				subs = $('#hsubj').val(),
				mess = $('#hmess').val();
			
			var data =  that.serialize();
			
			that.find('.button').removeClass('added').addClass('loading');
			
			if (name != "" && mail != "" && subs != "" && mess != "")
				{

					$.post(
						bdVar.ajaxurl,
						{
							action : 'send-the-mail',
							data : data
						},
						function( response ) {
							
							if(response == "email_error") {
									that.find('.button').removeClass('added').removeClass('loading');
									$('#hmail').next('.req').html(' ! <small>please enter your valid email address</small>');
							
							} else {
									that.find('.button').removeClass('loading').addClass('added')
									$('#hname, #hmail, #hsubj, #hmess').val("");
									$('<p id="contact_success">' + response + '</p>').insertBefore('#adm-contact');
									d = setTimeout('fade_notice()', 2000);
							}
						}
					);
					
				} 
			else 
				{
					that.find('.button').removeClass('added').removeClass('loading');
					
					if(name == "") $('#hname').next('.req').text(' !');
					if(mail == "") $('#hmail').next('.req').text(' !');
					if(subs == "") $('#hsubj').next('.req').text(' !');
					if(mess == "") $('#hmess').next('.req').text(' !');
					
					return false;
				}
				
			return false;
		});
		
		$('#hname, #hmail, #hsubj, #hmess').focus(function(){
			$(this).next('.req').text(' *');
		});

	}

	});
})(jQuery);