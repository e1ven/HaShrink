var wipLayoutManager;

(function($){


	var api = wipLayoutManager = {
	
		options : {
			speedOnMove : 250,
			ajaxThemeAction : 'wipProcessLayoutAjax'
		},
		
		
		init : function() {
			api.ListHolder = $('#actual-layout');
			api.contentLists = $('#wip-layout-item-lists');
			api.innerLists = $('.layout-placer-lists');
			
			this.attachLayoutEditListeners();
			this.addItemToLayout();
			this.eventOnAddContent();
			
			if( 0 != $('.color_scheme_input_on_layout').length ) this.colorPickerApi();
			
			if(0 != api.contentLists.length){
				this.doSortables();
			}

		},
		
		
		attachLayoutEditListeners : function() {
			var that = this;
			$('#wip-form-layout').bind('click', function(e) {
				if ( e.target && e.target.className ) {
					if ( -1 != e.target.className.indexOf('wip-edit-layout-item') ) {
						return that.eventOnClickEditLink(e.target);
					} else if ( -1 != e.target.className.indexOf('delete_layout_item') ) {
						return that.eventOnDeleteLayout(e.target);
					} else if ( -1 != e.target.className.indexOf('opener-content-column-block') ) {
						return that.eventOnClickEditContent(e.target);
					} else if ( -1 != e.target.className.indexOf('delete-box-content-column-block') ) {
						return that.eventOnDeleteContent(e.target);
					}
				}
			});
		},
		
		
		eventOnClickEditLink : function(clickedEl){
			var settings, item,
			matchedSection = /#(.*)$/.exec(clickedEl.href);
			if ( matchedSection && matchedSection[1] ) {
				settings = $('#'+matchedSection[1]);
				item = settings.parent();
				if( 0 != item.length ) {
					if( item.hasClass('wip-layout-edit-inactive') ) {
						settings.slideDown(api.options.speedOnMove);
						item.removeClass('wip-layout-edit-inactive')
							.addClass('wip-layout-edit-active');
					} else {
						settings.slideUp(api.options.speedOnMove);
						item.removeClass('wip-layout-edit-active')
							.addClass('wip-layout-edit-inactive');
					}
					return false;
				}
			}
		},
		
		
		eventOnClickEditContent : function(clickedEl){
			var settings, item,
			matchedSection = /#(.*)$/.exec(clickedEl.href);
			if ( matchedSection && matchedSection[1] ) {
				settings = $('#'+matchedSection[1]);
				item = settings.parent();
				if( 0 != item.length ) {
					if( item.hasClass('inactive') ) {
						item.css({'width':'400px', 'z-index' : '1000', 'position': 'relative'});
						settings.slideDown(api.options.speedOnMove);
						item.removeClass('inactive')
							.addClass('active');
					} else {
						settings.slideUp(api.options.speedOnMove);
						item.removeAttr('style');
						item.removeClass('active')
							.addClass('inactive');
					}
					return false;
				}
			}
		
		},
		
		
		eventOnDeleteLayout : function(clickedEl){
			var settings, item,
			matchedSection = /#(.*)$/.exec(clickedEl.href);
			if ( matchedSection && matchedSection[1] ) {
				settings = $('#'+matchedSection[1]);

				if( 0 != settings.length ) {
					if( settings.hasClass('wip-layout-item') ) {	
						if( $('.wip-layout-item').length == '2' ){	
							$('#wip-layout-item-lists').fadeOut(api.options.speedOnMove,
								function(){
									$(this).remove();
								}
							);
						} else {
							settings.fadeOut(api.options.speedOnMove,
								function(){
									settings.remove();
								}
							);
						}
					} else if( settings.hasClass('layout-placer-item') ) {
						var opp = settings.parent();
						if( opp.find('li').length == '1'){
							opp.fadeOut(api.options.speedOnMove,
								function(){
									$(this).remove();
								}
							);
						} else {
							settings.fadeOut(api.options.speedOnMove,
								function(){
									settings.remove();
								}
							);
						}
					}
					return false;
				}
			}
		},
		
		
		
		eventOnDeleteContent : function(clickedEl){
			var settings, item,
			matchedSection = /#(.*)$/.exec(clickedEl.rel);
			if ( matchedSection && matchedSection[1] ) {
				settings = $('#'+matchedSection[1]);
				item = settings.parent();
				if( 0 != settings.length ) {
					settings.fadeOut(api.options.speedOnMove,
								function(){
									settings.remove();
								}
							);
					item.parent().find('.wip-layout-modules').fadeIn(api.options.speedOnMove);
					return false;
				}
			}
		},
		
		addItemToLayout : function(){
			$('.col_insert').each( function(){
				var t = $(this),
					tID = t.attr('id'),
					anchor = t.find('.anchor_insert_cols');
				
				anchor.bind('click', function(e){
					e.preventDefault();
					var spin = t.find('.waiting');
					
					spin.show();
					
					params = {
						'action': api.options.ajaxThemeAction,
						'type': 'addItemToLayout', 
						'layout': tID
					};
					
					$.post( ajaxurl, params, function(response) {
						spin.hide();
						if( 0 != $('#wip-layout-item-lists').length ){
							var _ulHtml = $('#wip-layout-item-lists').html();
							//$('#wip-layout-item-lists').html( _ulHtml + response );
							$('#wip-layout-item-lists').append( response );
						} else {

							var _ulHtml = $('<ul id="wip-layout-item-lists" />')
										.css({opacity : 0});
							api.ListHolder.html(_ulHtml);
								
							_ulHtml.html(response).animate({ opacity : 1 }, api.options.speedOnMove);
							
						}
						
						$('#wip-layout-item-lists').sortable({
							handle: '.wip-layout-item-handle',
							placeholder: 'sortable-placeholder',
							opacity: 0.5
						});

									$('.layout-placer-lists').each(function(){
										var t = $(this);
										t.sortable({
											handle: '.wip-layout-item-handle',
											placeholder: 'sortable-placeholder',
											items : 'li',
											connectWith: '.layout-placer-lists',
											dropOnEmpty : true,
											revert: 200,
											opacity: 0.5,
											update: function(event, ui) {
												var inputID = ui.item.find('input[name^="id"]'),
													parentNow = ui.item.closest('li.wip-layout-item');

												if( parentNow.hasClass('wip-layout-item') ){
													var inputParentVal = parentNow.find('input[name^="parent_id"]').val(),
														inputIDval = inputID.val();
													
													inputID.attr('name', 'id['+inputParentVal+']['+inputIDval+']');
												}

												$(this).sortable( "refresh" );
												if( t.find('li').length == 0 ){
													t.css('height','20px');
												} else {
													t.css('height','auto');
												}
											}
										});
									});
						
					});
					
				});
				
			});

		},
		
		
		eventOnAddContent : function(){
			var selectPr, thisID, 
				that = this;
			$('#wip-form-layout').bind('change', function(e) {
				if ( e.target && e.target.parentNode.className ) {
					if( -1 != e.target.parentNode.className.indexOf('span-module') ){
						
						if( -1 != e.target.parentNode.className.indexOf('module-for-column') ){
							
							if( 0 != e.target.value ){
								
								thisID = e.target.id,
										tgPar = e.target.parentNode,
										tgLoad = '<span class="module_loading"></span>',
								
								params = {
									'action': api.options.ajaxThemeAction,
									'type': 'addContentToBox',
									'formname': e.target.name,
									'formvalue': e.target.value
								};

								
								$(tgLoad).appendTo(tgPar);

								$.post( ajaxurl, params, function(response) {
									
									$(tgPar).find('.module_loading').remove();
									$('#wip-placercolumn-'+response.col+'-'+response.parID).find('.wip-layout-modules').hide();
									
									$('#wip-column-content-placer-'+response.col+'-'+response.parID).html(response.html);
									
									$('#'+thisID).prop("selectedIndex",0);
									
								}, 'json');
								
							}
						} else {
						
							if( 0 != e.target.value ){
								
								thisID = e.target.id;
								
								var tgPar = e.target.parentNode,
									tgLoad = '<span class="module_loading"></span>',
									uId = e.target.name.replace(/[^\d.]/g, "");
								
								$(tgLoad).appendTo(tgPar);
								
								params = {
									'action': api.options.ajaxThemeAction,
									'type': 'addContentToLayout',
									'uId': uId,
									'contentValue': e.target.value
								};
								
								$('#'+thisID).prop("selectedIndex",0);
								
								$.post( ajaxurl, params, function(response) {
									$(tgPar).find('.module_loading').remove();
									
									if( 0 != $('#layout-placer-'+uId).find('ul.layout-placer-lists').length ){
										var _ulHtml = $('#layout-placer-'+uId).find('ul.layout-placer-lists').html();
										//$('#layout-placer-'+uId).find('ul.layout-placer-lists').html( _ulHtml + response );
										$('#layout-placer-'+uId).find('ul.layout-placer-lists').append(response);
									} else {

										var _ulHtml = $('<ul class="layout-placer-lists" />')
													.css({opacity : 0});
													
										$('#layout-placer-'+uId).html(_ulHtml);
											
										_ulHtml.html(response).animate({ opacity : 1 }, api.options.speedOnMove);
										
									}
									
									$('.layout-placer-lists').each(function(){
										var t = $(this);
										t.sortable({
											handle: '.wip-layout-item-handle',
											placeholder: 'sortable-placeholder',
											items : 'li',
											connectWith: '.layout-placer-lists',
											dropOnEmpty : true,
											revert: 200,
											opacity: 0.5,
											update: function(event, ui) {
												var inputID = ui.item.find('input[name^="id"]'),
													parentNow = ui.item.closest('li.wip-layout-item');

												if( parentNow.hasClass('wip-layout-item') ){
													var inputParentVal = parentNow.find('input[name^="parent_id"]').val(),
														inputIDval = inputID.val();
													
													inputID.attr('name', 'id['+inputParentVal+']['+inputIDval+']');
												}

												$(this).sortable( "refresh" );
												if( t.find('li').length == 0 ){
													t.css('height','20px');
												} else {
													t.css('height','auto');
												}
											}
										});
									});
									
									that.colorPickerApi();
								
								});
							}
						}
						
					}
				}
			});
		
		},
		
		
		colorPickerApi : function(){

			var inp = $('.color_scheme_input_on_layout');
			var ids = $(inp).attr('id');
			
			if( inp.length ){	
				inp.each(function(){
					var op = $(this);
					$(this).ColorPicker({
						color: $(this).val(),
						onSubmit: function(hsb, hex, rgb, el) {
							$(el).val(hex);
							$(el).ColorPickerHide();
						},
						onChange: function(hsb, hex, rgb){
							op.val(hex);
						}
					}).bind('keyup', function(){
						$(this).ColorPickerSetColor(this.value);
					});
				});
			}
		
		},
		
		
		doSortables : function(){
		
			api.contentLists.sortable({
				handle: '.wip-layout-item-handle',
				placeholder: 'sortable-placeholder',
				opacity: 0.5
			});
			
			if(api.innerLists.length){
				api.innerLists.each(function(){
					var t = $(this);
					t.sortable({
						handle: '.wip-layout-item-handle',
						placeholder: 'sortable-placeholder',
						items : 'li',
						connectWith: '.layout-placer-lists',
						dropOnEmpty : true,
						revert: 200,
						opacity: 0.5,
						update: function(event, ui) {
							var inputID = ui.item.find('input[name^="id"]'),
								parentNow = ui.item.closest('li.wip-layout-item');

							if( parentNow.hasClass('wip-layout-item') ){
								var inputParentVal = parentNow.find('input[name^="parent_id"]').val(),
									inputIDval = inputID.val();
								
								inputID.attr('name', 'id['+inputParentVal+']['+inputIDval+']');
							}

							$(this).sortable( "refresh" );
							if( t.find('li').length == 0 ){
								t.css('height','20px');
							} else {
								t.css('height','auto');
							}
						}
					});
				});
			}

		
		}
		
		
	};
	
	$(document).ready(function(){ wipLayoutManager.init(); });

})(jQuery);