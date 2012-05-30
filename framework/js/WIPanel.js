( function(j){

//convert checkbox	
function wCB(){
	
	var _form = j('.wip-form');

	_form.each(function(){
	
		var checkBox = j(this).find("input[type='checkbox']");
		
		checkBox.each(function(){

			var jthis = j(this);
			var jthisID = jthis.attr('name');
			var value = "0"
			
			if( jthis.attr('checked') ){
				
				value = "1";
			
			}
			
			var ni = '<input type="hidden" name="'+jthisID+'" value="'+value+'"/>';
			
			var __embed = '<div class="WIP-jq-check"><a href="#" rel="1">ON</a><a href="#" rel="0">OFF</a>'+ni+'</div>';
			
			j(__embed).insertBefore( jthis );
			
			jthis.remove();
		
		});
		
	});
	
	j('.WIP-jq-check').each(function(){
			
		var newInput = j(this).find("input[type='hidden']");
		var liveA = j(this).find('a');
		var On = j(this).find("a[rel='1']");
		var Off = j(this).find("a[rel='0']");
				
		if ( newInput.attr('value') == "1" ){
		
			On.addClass('checked');
			
		} else {
		
			Off.addClass('checked');
			
		}
		
		liveA.each(function(){
		
			liveA.click(function(){
				
				var WhatRel = j(this).attr('rel');
				
				if( WhatRel == "0" ){
					if( j(this).parent().find("input[type^='hidden']").attr('value') == "0" ){
						return false;
					} else {
						j(this).parent().find('.checked').removeClass('checked');
						
						j(this).addClass('checked');
						j(this).parent().find("input[type^='hidden']").attr('value', '0');
						
						return false;
					}
				} else {
					if( j(this).parent().find("input[type^='hidden']").attr('value') == "1" ){
						return false;
					} else {
						j(this).parent().find('.checked').removeClass('checked');
						
						j(this).addClass('checked');
						j(this).parent().find("input[type^='hidden']").attr('value', '1');
						
						return false;
					}
				}
				
				return false;
				
			});
			
		});
		
	});

};

/** ====================================================================================================== */

//detect the href location
function pta(){
	var ur = location.href.replace( '#', '?v=');
	var par = br_grab_param('v', ur);
		
	if(par == ""){
			
			j('.wip-area').css('display', 'none');
			j('.wip-area:eq(0)').css('display', 'block');
			j('#wip-tabs').find('a:eq(0)').addClass('tab-active');
	} else {
		
			j('.wip-area').css('display', 'none');
			j('#'+par).css('display', 'block');
			
			var parsi = j('#wip-tabs').find('ul');
			var parsi_a = parsi.find('a');
			parsi_a.each(function(){
				
				var liliy = j(this).parent(),
					ulliy = liliy.parent();
				
				if( j(this).attr('href') == '#'+par+''){
					if( ulliy.hasClass('child_left') ){
						j('.child-tab-active').removeClass('child-tab-active');
						j(this).addClass('child-tab-active');

						ulliy.slideDown();						
						ulliy.parent().find('a:first').addClass('tab-active');
						
					} else {
						j(this).addClass('tab-active');
						if( liliy.find('ul.child_left').length ){
							liliy.find('ul.child_left').slideDown();
							j('.child-tab-active').removeClass('child-tab-active');
							liliy.find('ul.child_left').find('a:first').addClass('child-tab-active');
						}
					}
				}
				
			});
	}
		
		doTab();
		
}

/** ====================================================================================================== */

//the panel tab action	
function doTab(){
		var pars = j('#wip-tabs').find('ul');
		var pars_a = pars.find('a');
		var curent_ur = location.href;
		
		pars_a.each(function(){
		
			var liliy = j(this).parent(),
				ulliy = liliy.parent();
		
			j(this).click(function(){
				var toOpen = j(this).attr('href');
				var $thisA = j(this);
				if( j(toOpen).is(':hidden') ){
					
					if( ulliy.hasClass('child_left') ){
						j('.child-tab-active').removeClass('child-tab-active');
						$thisA.addClass('child-tab-active');
					} else {
						j('.tab-active').removeClass('tab-active');
						$thisA.addClass('tab-active');
						
						if( liliy.find('ul.child_left').length ){
							var uut = liliy.find('ul.child_left');
							
							j('.child_left').not(uut).slideUp();
							if( uut.is(':hidden')){
								uut.slideDown();
							}
							j('.child-tab-active').removeClass('child-tab-active');
							liliy.find('ul.child_left').find('a:first').addClass('child-tab-active');
						} else {
							if( j('.child_left').length ){
								j('.child_left').slideUp();
							}
						}
					}
					
						j('.wip-area').filter(':not(:hidden)').animate({ opacity : 0}, 350, function(){
							j(this).css('display', 'none');
						});
						j(toOpen).animate({ opacity : 1}, 350, function(){
							j(this).css('display', 'block');
						});
					
					var uri = curent_ur.replace( '#', '?v=');
					var pari = br_grab_param('v', uri);
					
					if(pari != ""){
						toCurr = curent_ur.replace( '#'+pari, '');
					} else {
						toCurr = curent_ur;
					}
						document.location.href = toCurr+toOpen;
				}
				return false;
			});
		});
	
};

/** ====================================================================================================== */

//function to read the URL	
function br_grab_param(name,url){
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( url );
		if( results == null )
			return "";
			else
		return results[1];
};

/** ====================================================================================================== */

//handle upload image
function wIU(){

	if( j('.uploadify_upload_image').length ){
		
		j('.uploadify_upload_image').each(function(){
			var uploadHandle = j(this),
				uploadID = uploadHandle.attr('id');
		
			  j('#'+uploadID).uploadify({
				'uploader'  : wip.up_uploader,
				'script'    : ajaxurl,
				'cancelImg' : wip.up_cancel,
				'buttonImg' : wip.up_buttonimageupload,
				'height' : 30,
				'width' : 98,
				'auto'      : true,
				'multi' : false,
				'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;*.ico',
				'fileDesc'    : 'Image File',
				'scriptData' : {'action' : 'wipanel_upload_action', 'type' : 'upload', 'name' : uploadID},
				'fileDataName' : uploadID,
				'sizeLimit' : wip.up_maxsize,
				'onComplete'  : function(event, ID, fileObj, response, data) {
					
					var _callback = j.parseJSON( response );

					if( _callback.error ){
						var buildReturn = '<span class="upload-error"><span>' + _callback.errorText + '</span></span>';
						j(".upload-error").remove();
						uploadHandle.parent().after(buildReturn);
					}
					else {
						var buildReturn = '<img class="image_preview" id="image_'+uploadID+'" src="'+_callback.image+'" alt="" /><a href="#" class="delete_image" rel="'+uploadID+'" title="Delete image"></a>';
						var imContainer = uploadHandle.parent().find('.wip-image-preview');
					
						j(".upload-error").remove();
						j("#image_" + uploadID).remove();	
						imContainer.html(buildReturn);
						imContainer.addClass('preview-img').css('display', 'none').fadeIn();
					}
					
				}
			  });

		});
	}

	
	j('.delete_image').live('click', function(){

			var clickedObject = j(this);
			var parObj = j(this).parent();
			var theID = j(this).attr('rel');	
			var actionURL = parObj.parent().find('.ajax_action_url').val();
					
			var ajax_url = actionURL;

				var data = {
					action: 'wipanel_upload_action',
					type: 'image_reset',
					data: theID
				};

			j.post(ajax_url, data, function(response) {
				
				var object_to_remove = parObj.parent().find('.wip-image-preview');
				
				object_to_remove.find('img, a').fadeOut(500,function(){ 
					j(this).remove(); 
					object_to_remove.removeClass('preview-img');
				});
				
				parObj.parent().find('.uploaded_url').val('');				
			});

			return false; 
	});

};

/** ====================================================================================================== */


function _upBG(){

	if( j('.uploadify_upload_bg').length ){
		
		j('.uploadify_upload_bg').each(function(){
			var uploadHandle = j(this),
				uploadID = uploadHandle.attr('id').replace('uploader_', '');
		
			  j('#uploader_'+uploadID).uploadify({
				'uploader'  : wip.up_uploader,
				'script'    : ajaxurl,
				'cancelImg' : wip.up_cancel,
				'buttonImg' : wip.up_buttonimageupload,
				'height' : 30,
				'width' : 98,
				'auto'      : true,
				'multi' : false,
				'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;*.ico',
				'fileDesc'    : 'Image File',
				'scriptData' : {'action' : 'wipanel_upload_action', 'type' : 'upload_bg', 'name' : uploadID},
				'fileDataName' : uploadID,
				'sizeLimit' : wip.up_maxsize,
				'onComplete'  : function(event, ID, fileObj, response, data) {
					
					var _callback = j.parseJSON( response );

					if( _callback.error ){
						var buildReturn = '<span class="upload-error"><span>' + _callback.errorText + '</span></span>';
						j(".upload-error").remove();
						uploadHandle.parent().after(buildReturn);
					}
					else {
						j('#'+uploadID).val( _callback.image );
					}
					
				}
			  });

		});
	}

}


/** ====================================================================================================== */

function _fda(){
	
	var forms = j('form.uajax');
	
	var mL = parseFloat(j(window).width());
	var mT = parseFloat(j(window).height());
		
	var tp = parseFloat(Math.floor((mT-100)/2));
	var lt = parseFloat(Math.floor((mL-300)/2));
	
	var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Processing</div>';
	
	forms.each(function(){
		
		j(this).submit(function() {
			var data =  j(this).serialize();
			
					j('body').append(notice);
					j('#WIP_ajax_notice').fadeIn();
					
					interval = window.setInterval(function(){
						var text = j('#WIP_ajax_notice').text();
						if (text.length < 14){	
							j('#WIP_ajax_notice').text(text + '.'); 
						} else { 
							j('#WIP_ajax_notice').text('Processing'); 
						} 
					}, 200);
			
			j.post(ajaxurl, data, function(response) {
				
					window.clearInterval(interval);
					j('#WIP_ajax_notice').remove();
						  
					if(response == 1) {
						show_noticery(1);
						t = setTimeout('fade_notice()', 1200);
					
					} else if( response == 0 ){
						show_noticery(0);
						t = setTimeout('fade_notice()', 1200);
					} else {
						show_noticery(response);
						t = setTimeout('fade_notice()', 1200);
					}
				
			});
			  
			  return false;
		});
	});
	
};

/** ====================================================================================================== */
//reset data
function _rda(){

	var forms = j('form.uajax_reset');
	
	var mL = parseFloat(j(window).width());
	var mT = parseFloat(j(window).height());
		
	var tp = parseFloat(Math.floor((mT-100)/2));
	var lt = parseFloat(Math.floor((mL-300)/2));
	
	var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Processing</div>';
	
	
	forms.each(function(){
		
		var theID = j(this).find('.parto').val();	
		var actionURL = j(this).find('.ajax_action_url').val();
		
		j(this).submit(function() {
		
				j('body').append(notice);
				j('#WIP_ajax_notice').fadeIn();
					
				interval = window.setInterval(function(){
					var text = j('#WIP_ajax_notice').text();
					if (text.length < 14){	
							j('#WIP_ajax_notice').text(text + '.'); 
					} else { 
							j('#WIP_ajax_notice').text('Processing'); 
					} 
				}, 200);
				
				var ajax_url = actionURL;

					var data = {
						action: 'wipanel_reset_section',
						type: 'reset',
						data: theID
					};

				j.post(ajax_url, data, function(response) {
					
					window.clearInterval(interval);
					j('#WIP_ajax_notice').remove();
					
					if ( response == 1 ) {
					
						show_noticery(2);
						t = setTimeout('fade_notice()', 1200);
						location.reload(true);
					
					} else if( response == 2 ) {
						var ur = location.href.replace( '#', '?v=');
						var par = br_grab_param('v', ur);
						
						if(par != ""){
							tohref = location.href.replace( '#'+par, '');
						} else {
							tohref = location.href;
						}
						
						show_noticery(2);
						t = setTimeout('fade_notice()', 1200);
						window.location = tohref;
						
					} else {
						show_noticery(response);
						t = setTimeout('fade_notice()', 1200);					
					}
					
				});

				return false; 
		});
	});

};

/** ====================================================================================================== */

// Sucess/error/processing message
function show_noticery(n) {

	var mLf = parseFloat(j(window).width());
	var mTf = parseFloat(j(window).height());
		
	var tpf = parseFloat(Math.floor((mTf-100)/2));
	var ltf = parseFloat(Math.floor((mLf-300)/2));
	
		if(n == 1) {
			var nts = '<div id="WIP_ajax_sucess" style="top:'+tpf+'px; left:'+ltf+'px;">Options saved</div>';
		} else if(n == 2) {
			var nts = '<div id="WIP_ajax_sucess" style="top:'+tpf+'px; left:'+ltf+'px;">Success Reset data</div>';
		} else if(n == 4) {
			var nts = '<div id="WIP_ajax_sucess" style="top:'+tpf+'px; left:'+ltf+'px;">Success add icon</div>';
		} else if(n == 5) {
			var nts = '<div id="WIP_ajax_sucess" style="top:'+tpf+'px; left:'+ltf+'px;">Success add data</div>';
		} else if(n == 6) {
			var nts = '<div id="WIP_ajax_sucess" style="top:'+tpf+'px; left:'+ltf+'px;">Success add sidebar</div>';
		} else if(n == 7) {
			var nts = '<div id="WIP_ajax_error" style="top:'+tpf+'px; left:'+ltf+'px;">Sidebar name already in use!</div>';
		} else if(n == 8) {
			var nts = '<div id="WIP_ajax_error" style="top:'+tpf+'px; left:'+ltf+'px;">Success update data</div>';
		} else if(n == 0){
			var nts = '<div id="WIP_ajax_error" style="top:'+tpf+'px; left:'+ltf+'px;">ERROR, Options could not be saved</div>';	
		} else {
			var nts = '<div id="WIP_ajax_error" style="top:'+tpf+'px; left:'+ltf+'px;">'+n+'</div>';
		}
		
	j('body').append(nts);
	
};

/** ====================================================================================================== */

function _zx(){


	if( j('.uploadify_upload_icon').length ){
	
		
		j('.uploadify_upload_icon').each(function(){
		
			var uploadHandle = j(this),
				uploadID = uploadHandle.attr('id');
		
			  j('#'+uploadID).uploadify({
				'uploader'  : wip.up_uploader,
				'script'    : ajaxurl,
				'cancelImg' : wip.up_cancel,
				'buttonImg' : wip.up_buttonimageupload,
				'height' : 30,
				'width' : 98,
				'auto'      : true,
				'multi' : false,
				'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;*.ico',
				'fileDesc'    : 'Image File',
				'scriptData' : {'action' : 'wipanel_upload_icon_action', 'type' : 'upload'},
				'fileDataName' : 'icon_upload',
				'sizeLimit' : wip.up_maxsize,
				'onComplete'  : function(event, ID, fileObj, response, data) {
					
					var _callback = j.parseJSON( response );

					if( _callback.error ){
						var buildReturn = '<span class="upload-error"><span>' + _callback.errorText + '</span></span>';
						j(".upload-error").remove();
						uploadHandle.parent().after(buildReturn);
					}
					else {

						var buildReturns = '<img class="icon_up_preview" src="'+_callback.icon+'" alt="" /><a href="#" class="delete_icon" rel="'+uploadID+'" title="Delete image"></a>';
						var imContainers = uploadHandle.parent().find('.icon-preview');
						
						j(".upload-error").remove();
						imContainers.find('img').remove();	
						imContainers.html(buildReturns);
						uploadHandle.parent().find('.main_form_icon').val(_callback.iconData);
					
					
					}
					
				}
			  });

		});
	}

/** ====================================================================================================== */

//delete icon
j('.delete_icon').live('click', function(){

		var clickedObject = j(this);
		var parObj = j(this).parent();
		var theID = parObj.parent().find('.main_form_icon').val();

			var data = {
				action: 'wipanel_upload_icon_action',
				type: 'image_reset',
				data: theID
			};

		j.post(ajaxurl, data, function(response) {
			
			var object_to_remove = parObj.parent().find('.icon-preview');
			
			object_to_remove.find('img, a').fadeOut(500,function(){ 
				j(this).remove(); 
			});
			
			parObj.parent().find('.main_form_icon').val('');				
		});

		return false; 
});

/** ====================================================================================================== */

j('form.iconajax').submit(function() {

	var mL = parseFloat(j(window).width());
	var mT = parseFloat(j(window).height());
		
	var tp = parseFloat(Math.floor((mT-100)/2));
	var lt = parseFloat(Math.floor((mL-300)/2));
	
	/** get the data */
	var th = j(this);
	var dt_title = j(this).find("input[name='wip_icon_title']").val();
	var dt_url = j(this).find("input[name='wip_icon_url']").val();
	var dt_shortname = j(this).find("input[name='shortname']").val();
	var leng = j('#iconicon_lists').find('.iconicon-data').length;
	
	var dttoshow = '<tr class="iconicon-data"> \
					<td colspan="2" style="padding-top: 10px; padding-bottom: 10px; height: 50px; line-height: 30px;"> \
					<span style="display: inline-block;width: 50px; float: left;"> \
					<a href="'+dt_url+'" target="_blank" style="text-shadow: none;" title="'+dt_title+'"> \
					<img src="{icon_src}" alt="" class="alignleft" style="margin: 0px; display: block;"/>\
					</a>\
					</span> \
					<a class="delete_icon_lists delete_delete" href="#" rel="data='+leng+'&shortname='+dt_shortname+'" style="text-shadow: none;" title="Delete"></a>\
					</td> \
					</tr>';
	
	var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Processing</div>';
	
	var data = {
		action: 'wipanel_upload_icon_action',
		type: 'add_icon',
		data: j(this).serialize()
	};
	
	j('body').append(notice);
	j('#WIP_ajax_notice').fadeIn();
					
	interval = window.setInterval(function(){
		var text = j('#WIP_ajax_notice').text();
			if (text.length < 14){	
					j('#WIP_ajax_notice').text(text + '.'); 
				} else { 
					j('#WIP_ajax_notice').text('Processing'); 
			} 
	}, 200);
	
	j.post(ajaxurl, data, function(response) {
				
		window.clearInterval(interval);
		j('#WIP_ajax_notice').remove();
						  
			if( response.error ) {
				show_noticery( response.errorText );
				t = setTimeout('fade_notice()', 1200);
			
			} else {

				show_noticery(4);
				t = setTimeout('fade_notice()', 1200);
				
				var dttoshowNext = dttoshow.replace(/{icon_src}/g, response.iconURL);
				
				if(leng == 0) j('.icon-no-data').remove();
				
				th.find("input[name='wip_icon_image']").val('');
				th.find("input[name='wip_icon_title']").val('');
				th.find("input[name='wip_icon_url']").val('');
				th.find('.icon-preview').html('');
				
				j('#iconicon_lists').append(dttoshowNext);
			}
				
	}, 'json' );
			  
	return false;

});

/** ====================================================================================================== */

j('.delete_icon_lists').live('click', function(){
		var id = j(this).attr('rel');
		var tdPar = j(this).parent();
		
			var data = {
				action: 'wipanel_upload_icon_action',
				type: 'delete_icon',
				data: id
			};

		j.post(ajaxurl, data, function(response) {
			
			var tr_to_remove = tdPar.parent();
			
			tr_to_remove.fadeOut(500,function(){ 
				j(this).remove(); 
			});				
		});

		return false;

});

};

/** ====================================================================================================== */

function jbt(){

	j('form.sgajax').submit(function() {

		var mL = parseFloat(j(window).width());
		var mT = parseFloat(j(window).height());
			
		var tp = parseFloat(Math.floor((mT-100)/2));
		var lt = parseFloat(Math.floor((mL-300)/2));
		
		var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Processing</div>';
		
		/** get the data */
		var th = j(this);
		
		var data = {
			action: 'wipanel_upload_icon_action',
			type: 'add_sidebar',
			data: j(this).serialize()
		};
		
		j('body').append(notice);
		j('#WIP_ajax_notice').fadeIn();
						
		interval = window.setInterval(function(){
			var text = j('#WIP_ajax_notice').text();
				if (text.length < 14){	
						j('#WIP_ajax_notice').text(text + '.'); 
					} else { 
						j('#WIP_ajax_notice').text('Processing'); 
				} 
		}, 200);
		
		j.post(ajaxurl, data, function(response) {
					
			window.clearInterval(interval);
			j('#WIP_ajax_notice').remove();
							  
				if(response == 2 ) {
					
					show_noticery(7);
					t = setTimeout('fade_notice()', 1200);
				
				} else if (response.search('Error') > -1){
				
					show_noticery(response);
					t = setTimeout('fade_notice()', 1200);
				
				} else {
					
					show_noticery(6);
					t = setTimeout('fade_notice()', 1200);
					
					var dt_shortname = th.find("input[name='shortname']").val();
					var leng = j('#wip-sidebarsidebar-lists').find('.wip-sidebar-data').length;
					
					var newSide = '<tr class="wip-sidebar-data">\
								<td colspan="2" style="padding-top: 10px; padding-bottom: 10px; height: 50px; line-height: 30px;" class="sidebar-lists">\
								<span style="text-shadow: none; color: #555; margin-right: 20px;">\
								<strong>'+response+'</strong>\
								</span>\
								<a class="delete_sidebar_lists delete_delete" href="#" rel="data='+response+'&shortname='+dt_shortname+'" style="text-shadow: none;" title="Delete"></a>\
								<td></tr>';
					
					if(leng == 0) j('.wip-no-sidebar').remove();
					
					th.find("input[name='wip_sidebar_name']").val('');
					
					j('#wip-sidebarsidebar-lists').append(newSide);
					
				}
					
		});
				  
		return false;

	});


	j('.delete_sidebar_lists').each(function(){
		
		j(this).click(function(){
			var id = j(this).attr('rel');
			var tdPar = j(this).parent();
			
				var data = {
					action: 'wipanel_upload_icon_action',
					type: 'delete_sidebar',
					data: id
				};

			j.post(ajaxurl, data, function(response) {
				
				var tr_to_remove = tdPar.parent();
				
				tr_to_remove.fadeOut(500,function(){ 
					j(this).remove(); 
				});				
			});

			return false; 
		});


	});

};

/** ====================================================================================================== */

function _sldr(){

	if( j('.uploadify_upload_slider').length ){
	
		
		j('.uploadify_upload_slider').each(function(){
			var uploadHandle = j(this),
				uploadID = uploadHandle.attr('id');
		
			  j('#'+uploadID).uploadify({
				'uploader'  : wip.up_uploader,
				'script'    : ajaxurl,
				'cancelImg' : wip.up_cancel,
				'buttonImg' : wip.up_buttonimageupload,
				'height' : 30,
				'width' : 98,
				'auto'      : true,
				'multi' : false,
				'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;*.ico',
				'fileDesc'    : 'Image File',
				'scriptData' : {'action' : 'wipanel_upload_slider_action', 'type' : 'upload', 'name' : uploadID},
				'fileDataName' : uploadID,
				'sizeLimit' : wip.up_maxsize,
				'onComplete'  : function(event, ID, fileObj, response, data) {
					
					var _callback = j.parseJSON( response );

					if( _callback.error ){
						var buildReturn = '<span class="upload-error"><span>' + _callback.errorText + '</span></span>';
						j(".upload-error").remove();
						uploadHandle.parent().after(buildReturn);
					}
					else {

						var buildReturns = '<img class="slider_up_preview" src="'+_callback.imgUrl+'" alt="" /><a href="#" class="delete_slider" rel="'+uploadID+'" title="Delete image"></a>';
						var imContainers = uploadHandle.parent().find('.slider-preview');
						
						j(".upload-error").remove();
						imContainers.find('img').remove();	
						imContainers.html(buildReturns);
						uploadHandle.parent().find('.main_form_slider').val( _callback.imgUrl );
						uploadHandle.parent().find('.main_form_slider_image_name').val( _callback.imageFilename );
						uploadHandle.parent().find('.main_form_slider_path').val( _callback.path );
						uploadHandle.parent().find('.main_form_slider_sub_path').val( _callback.subPath );
					
					
					}
					
				}
			  });

		});
	}
	
	j('.delete_slider').live('click', function(){

			var clickedObject = j(this);
			var parObj = j(this).parent();
			var theID = j('#sliderslider').find('.main_form_slider_path').val();
					
			var ajax_url = actionURL;

				var data = {
					action: 'wipanel_upload_slider_action',
					type: 'image_reset',
					data: theID
				};

			j.post(ajax_url, data, function(response) {
				
				var object_to_remove = j('#sliderslider').find('.slider-preview');
				
				object_to_remove.find('img, a').fadeOut(500,function(){ 
					j(this).remove(); 
				});
				

				j('#sliderslider').find('.main_form_slider').val('');
				j('#sliderslider').find('.main_form_slider_image_name').val('');
				j('#sliderslider').find('.main_form_slider_path').val('');
				j('#sliderslider').find('.main_form_slider_sub_path').val('');				
			});

			return false; 
	});
	
	j('form.sliderajax').submit(function() {

		var mL = parseFloat(j(window).width());
		var mT = parseFloat(j(window).height());
			
		var tp = parseFloat(Math.floor((mT-100)/2));
		var lt = parseFloat(Math.floor((mL-300)/2));
		
		/** get the data */
		var th = j(this);
		var dt_shortname = j(this).find("input[name='shortname']").val();
		var leng = j('#slider-lists').find('.slider-data').length;
		
		var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Processing</div>';
		
		var data = {
			action: 'wipanel_upload_slider_action',
			type: 'add_slider',
			data: j(this).serialize()
		};
		
		j('body').append(notice);
		j('#WIP_ajax_notice').fadeIn();
						
		interval = window.setInterval(function(){
			var text = j('#WIP_ajax_notice').text();
				if (text.length < 14){	
						j('#WIP_ajax_notice').text(text + '.'); 
					} else { 
						j('#WIP_ajax_notice').text('Processing'); 
				} 
		}, 200);
		
		j.post(ajaxurl, data, function(obj) {
			
			window.clearInterval(interval);
			j('#WIP_ajax_notice').remove();
				
				if( obj.error ){
					
					show_noticery(obj.errorText);
					t = setTimeout('fade_notice()', 1200);
				
				} else {
				
					show_noticery(5);
					t = setTimeout('fade_notice()', 1200);
					
					if(leng == 0) j('.no-slider').remove();
					
					th.find("input[name='wip_slider_image']").val('');
					th.find("input[name='wip_slider_image_name']").val('');
					th.find("input[name='wip_slider_image_path']").val('');
					th.find("input[name='wip_slider_image_sub_path']").val('');
					th.find("input[name='wip_slider_url']").val('');
					th.find("input[name='wip_slider_title']").val('');
					th.find("textarea[name='wip_slider_desc']").val('');
					th.find('.slider-preview').html('');
					
					var dttoshow = '<li class="slider-data"> \
						<span class="slider-data-in"> \
							<span class="img-slid"><img src="'+obj.thumb+'" alt="" /></span> \
							<a href="#" class="slider-delete" title="delete"></a> \
							<a href="#" class="slider-edit" title="edit"></a> \
							<input type="hidden" name="_wip_slider_data[]" value="'+obj.id+'" />\
						</span> \
						</li>';
					
					j('#slider-lists').append(dttoshow);
					
						j('#slider-lists').sortable({ 
							activeclass : 'sortableactive', 
							opacity: 0.5,
							update: function(){
							
								var stCount = j('#slider-lists').find('li').length;
								var stData = j('input[name=\'_wip_slider_data[]\']');
								var loadProc = '<div class="load_proc"></div>';
								var ft;
												
								ft = "";
								stData.each(function(){		
									ft += 'dt[]='+j(this).val()+'&';			
								});
												
								j('#slider-lists-con').append(loadProc);
								j('.load_proc').css({display:'block',opacity:0}).animate({opacity : 0.90},300);
												
								var datax = {
									action: 'wipanel_upload_slider_action',
									type: 'slider_order',
									data: ft+'length='+stCount+'&shortname='+dt_shortname
								};
												
								j.post(ajaxurl , datax, function(response) {
									j('.load_proc').animate({opacity:0},300,function(){
										j(this).remove();
									});
								});
							
							}
							});
						j( "#slider-lists" ).disableSelection();
					
				}
					
		}, 'json' );
				  
		return false;

	});
	
	j('#slider-lists').each( function(){
		
		j("a.slider-edit", this).live("click", function(){
			
			j('#slider-lists').sortable('disable');
			j('#slider-edit-form').fadeOut();
			j('#slider-lists li').fadeIn();
			
			var Par = j(this).parent();
			var ParOfPar = j('#main-slider-form').parent();
			var Id = Par.find('input[name=\'_wip_slider_data[]\']').val();
			var actionURL = j('.ajax_action_url').val();
			j('form.sliderajaxedit').attr('id', Id);
			
			var mL = parseFloat(j(window).width());
			var mT = parseFloat(j(window).height());
				
			var tp = parseFloat(Math.floor((mT-100)/2));
			var lt = parseFloat(Math.floor((mL-300)/2));
			
			var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Please wait</div>';
			
			var data = {
				action: 'wipanel_upload_slider_action',
				type: 'take_data',
				data: Id
			};
			
			j('body').append(notice);
			j('#WIP_ajax_notice').fadeIn();
			
			j.post(ajaxurl, data, function(r) {
				
				j('#slideredit').find('img').attr('src', r.img);
				j('#slider-edit-form').find('input#wip_slider_swf_edit').val(r.pm_swf);
				j('#slider-edit-form').find('input#wip_slider_title_edit').val(r.title);
				j('#slider-edit-form').find('input#wip_slider_pc_pieces_edit').val(r.pm_pieces);
				j('#slider-edit-form').find('input#wip_slider_pc_time_edit').val(r.pm_time);
				j('#slider-edit-form').find('select#wip_slider_pc_transition_edit').val(r.pm_transition);
				j('#slider-edit-form').find('input#wip_slider_pc_delay_edit').val(r.pm_delay);
				j('#slider-edit-form').find('input#wip_slider_pc_depthoffset_edit').val(r.pm_depthoffset);
				j('#slider-edit-form').find('input#wip_slider_pc_cubedistance_edit').val(r.pm_cubedistance);
				
				j('#slider-edit-form').find('input#wip_slider_url_edit').val(r.link);
				j('#slider-edit-form').find('textarea#wip_slider_desc_edit').val(r.desc);
				
				j('#slider-edit-form').find('input#editid').val(r.id);
				
				j('#WIP_ajax_notice').remove();
			
				j('#main-slider-form').fadeOut(300, function() { 
				
					j.browser.opera  = /opera/.test(navigator.userAgent.toLowerCase());  
					if (j.browser.opera){
						j('html').animate({scrollTop : 0}, 'fast' );
					} else {
						j('html,body').animate({scrollTop : 0}, 'fast' );
					} 
					
					j('#slider-edit-form').fadeIn(300, function(){
					
						var e_form = j('#slider-edit-form').find('form#'+r.id);
						
						
						/** upload edited image */
						if( j('#slideredit').find('object').length == '0' ){
						
						j('.uploadify_upload_slider_edit').each(function(){
							var uploadHandleEdit = j(this),
								uploadIDedit = uploadHandleEdit.attr('id');
						
							  j('#'+uploadIDedit).uploadify({
								'uploader'  : wip.up_uploader,
								'script'    : ajaxurl,
								'cancelImg' : wip.up_cancel,
								'buttonImg' : wip.up_buttonimageupload,
								'height' : 30,
								'width' : 98,
								'auto'  : true,
								'multi' : false,
								'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;*.ico',
								'fileDesc'  : 'Image File',
								'scriptData' : {'action' : 'wipanel_upload_slider_action', 'type' : 'upload_edit', 'sliderId' : r.id},
								'fileDataName' : 'image_edit',
								'sizeLimit' : wip.up_maxsize,
								'onComplete'  : function(event, ID, fileObj, response, data) {
									
									var _callback = j.parseJSON( response );

									if( _callback.error ){
										var buildReturn = '<span class="upload-error"><span>' + _callback.errorText + '</span></span>';
										j(".upload-error").remove();
										uploadHandleEdit.parent().after(buildReturn);
									}
									else {

										var buildReturns = '<img class="slider_up_preview" src="'+_callback.imgUrl+'" alt="" />';
										var imContainers = j('#slideredit').find('.slider-preview-edit');
										
										j(".upload-error").remove();
										imContainers.find('img').remove();	
										imContainers.html(buildReturns);
										Par.find('img').attr('src', _callback.thumbnail);
									
									}
									
								}
							  });

						});
						
						}
	
							j(e_form).live('submit', function() {

								var mL = parseFloat(j(window).width());
								var mT = parseFloat(j(window).height());
									
								var tp = parseFloat(Math.floor((mT-100)/2));
								var lt = parseFloat(Math.floor((mL-300)/2));
								
								var notice = '<div id="WIP_ajax_notice" style="top:'+tp+'px; left:'+lt+'px;">Processing</div>';
								
								var data = {
									action: 'wipanel_upload_slider_action',
									type: 'edit_data_slider',
									data: j(this).serialize()
								};
								
								j('body').append(notice);
								j('#WIP_ajax_notice').fadeIn();
								
								j.post(ajaxurl, data, function(response) {
											
									j('#WIP_ajax_notice').remove();
									j('form.sliderajaxedit').removeAttr('id');
									
										if( response.error ){
											
											show_noticery( response.errorText );
											t = setTimeout('fade_notice()', 1200);
										
										} else {
										
											show_noticery(8);
											t = setTimeout('fade_notice()', 1200);

											j('#slideredit').find('img').attr('src', '');
											j('#slider-edit-form').find('input#wip_slider_swf_edit').val();
											j('#slider-edit-form').find('input#wip_slider_title_edit').val('');
											j('#slider-edit-form').find('input#wip_slider_pc_pieces_edit').val('');
											j('#slider-edit-form').find('input#wip_slider_pc_time_edit').val('');
											j('#slider-edit-form').find('select#wip_slider_pc_transition_edit').val('');
											j('#slider-edit-form').find('input#wip_slider_pc_delay_edit').val('');
											j('#slider-edit-form').find('input#wip_slider_pc_depthoffset_edit').val('');
											j('#slider-edit-form').find('input#wip_slider_pc_cubedistance_edit').val('');
											j('#slider-edit-form').find('input#wip_slider_url_edit').val('');
											j('#slider-edit-form').find('textarea#wip_slider_desc_edit').val('');
											j('#slider-edit-form').find('input#editid').val('');


											j('#slider-edit-form').fadeOut( 300, function(){

												j('#main-slider-form').fadeIn();
												
												j('#slider-lists').sortable('enable');
											
											});
										}
											
								}, 'json' );
										  
								return false;

							});
							

					
					});
					
				});
				

				j('#cancel_slider-edit').live( 'click', function() {
					
					j(".upload-error").remove();
					
					j('form.sliderajaxedit').removeAttr('id');
					
					j('#slider-edit-form').fadeOut( 300, function(){
					
						j('#slideredit').find('img').attr('src', '');
						j('#slider-edit-form').find('input#wip_slider_swf_edit').val();
						j('#slider-edit-form').find('input#wip_slider_title_edit').val('');
						j('#slider-edit-form').find('input#wip_slider_pc_pieces_edit').val('');
						j('#slider-edit-form').find('input#wip_slider_pc_time_edit').val('');
						j('#slider-edit-form').find('select#wip_slider_pc_transition_edit').val('');
						j('#slider-edit-form').find('input#wip_slider_pc_delay_edit').val('');
						j('#slider-edit-form').find('input#wip_slider_pc_depthoffset_edit').val('');
						j('#slider-edit-form').find('input#wip_slider_pc_cubedistance_edit').val('');
						j('#slider-edit-form').find('input#wip_slider_url_edit').val('');
						j('#slider-edit-form').find('textarea#wip_slider_desc_edit').val('');
						j('#slider-edit-form').find('input#editid').val('');
											
						j('#main-slider-form').fadeIn();
						
						j('#slider-lists').sortable('enable');
					
					});
				
				
				});
			
			
			}, 'json');
			
			
			return false;
			
		});
		
		
		j("a.slider-delete", this).live("click", function(){
		
			var Par = j(this).parent();
			var Id = Par.find('input[name=\'_wip_slider_data[]\']').val();
		
			var data = {
				action: 'wipanel_upload_slider_action',
				type: 'delete_slider',
				data: Id
			};
			
			j.post(ajaxurl, data, function(response) {
			
				var object_to_remove = Par.parent();
				
				object_to_remove.fadeOut(200, function() { j(this).remove() } );
			
			});
			
			return false;
		
		});
	
	});
	
	
	j('#slider-lists').sortable({ 
		activeclass : 'sortableactive', 
		opacity: 0.5,
		update: function(){
							
			var stCount = j('#slider-lists').find('li').length;
			var stData = j('input[name=\'_wip_slider_data[]\']');
			var dt_shortname = j('input[name=\'shortname\']').val();
			var loadProc = '<div class="load_proc"></div>';
			var ft;
												
			ft = "";
			stData.each(function(){		
				ft += 'dt[]='+j(this).val()+'&';			
			});
												
			j('#slider-lists-con').append(loadProc);
			j('.load_proc').css({display:'block',opacity:0}).animate({opacity : 0.90},300);
												
			var datax = {
				action: 'wipanel_upload_slider_action',
				type: 'slider_order',
				data: ft+'length='+stCount+'&shortname='+dt_shortname
			};
												
			j.post(ajaxurl , datax, function(response) {
				j('.load_proc').animate({opacity:0},300,function(){
					j(this).remove();
				});
			});
							
		}
	});
	j( "#slider-lists" ).disableSelection();

}


function toggleHandle(){
		var togPar = j('.wip_section_labelonOff');
		
		j(togPar).each(function(){
			var redeclareTogPar = j(this);
			var headClick = j(this).find('h2');
			
			
			j(headClick).click(function(){
				
				var togBody = redeclareTogPar.find('.wip_labelonOff_jq');
				
				if( togBody.is(':hidden') ){
				
					j(togBody).slideDown(200);
					
					j(this).addClass('toggle_open');
					j(this).find('span').text('[ - ]');
				} else {
				
					j(togBody).slideUp(200);
					
					j(this).removeClass('toggle_open');
					j(this).find('span').text('[ + ]');
				}
			
			});
		
		});

};

function CufS(){

	j('.upload_script_button').each(function(){

			var clickedObject = j(this);
			var clickedID = j(this).attr('rel');
			var actionURL = j(this).parent().find('.ajax_action_url').val();

			new AjaxUpload(clickedID, {
				  action: actionURL,
				  name: clickedID, // File upload name
				  data: { // Additional data to send
						action: 'wipanel_upload_icon_action',
						type: 'uploadsscript',
						data: clickedID },
				  autoSubmit: true, // Submit file after selection
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
				  
						clickedObject.text('Uploading'); // change button text, when user selects file	
						
						this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
						
						interval = window.setInterval(function(){
							var text = clickedObject.text();
							if (text.length < 13){	
								clickedObject.text(text + '.'); 
							} else { 
								clickedObject.text('Uploading'); 
							} 
						}, 200);
				  }, onComplete: function(file, response) {

					window.clearInterval(interval);
					clickedObject.text('Upload');	
					this.enable(); // enable upload button

					// If there was an error
					if(response.search('Upload Error') > -1){
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						j(".upload-error").remove();
						clickedObject.parent().after(buildReturn);

					}
					else{
						//alert(response);
						j(".upload-error").remove();
						clickedObject.parent().find('.uploaded_script').val(response);
					}
				  }
				});
				

	});
	
};

j(document).ready(function(){
	wCB(); 
	wIU(); 
	pta();
	_upBG();	
	_fda(); 
	_rda(); 
	_zx(); 
	jbt();
	_sldr();
	toggleHandle();
	//CufS();
});
})(jQuery);

function fade_notice() {
	jQuery('#WIP_ajax_sucess, #WIP_ajax_error').fadeOut(500, function(){
		jQuery('#WIP_ajax_sucess, #WIP_ajax_error').remove();
	});
	clearTimeout(t);
}

(function(q){
	function doColorPick(){
		var inp = q('.color_scheme_input');
		var ids = q(inp).attr('id');
		
		inp.each(function(){
			var op = q(this),
				label = op.parent(),
				imit = label.parent().find('.imitation_form_color');
			q(this).ColorPicker({
				color: q(this).val(),
				onSubmit: function(hsb, hex, rgb, el) {
					q(el).val(hex);
					q(el).ColorPickerHide();
				},
				onChange: function(hsb, hex, rgb){
					op.val(hex);
					label.css({ backgroundColor : '#'+hex});
					imit.text('#'+hex);
				}
			}).bind('keyup', function(){
				q(this).ColorPickerSetColor(this.value);
			});
		});
	}

q(document).ready(function(){
	doColorPick();
});
})(jQuery);