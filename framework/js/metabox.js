( function($){

//convert checkbox	
function wCB(){
	
	var _form = $('.wip-meta-form');

	_form.each(function(){
	
		var checkBox = $(this).find("input[type='checkbox']");
		
		checkBox.each(function(){

			var jthis = $(this);
			var jthisID = jthis.attr('name');
			var value = "0"
			
			if( jthis.attr('checked') ){
				
				value = "1";
			
			}
			
			var ni = '<input type="hidden" name="'+jthisID+'" value="'+value+'"/>';
			
			var __embed = '<div class="WIP-jq-check"><a href="#" rel="1">ON</a><a href="#" rel="0">OFF</a>'+ni+'</div>';
			
			$(__embed).insertBefore( jthis );
			
			jthis.remove();
		
		});
		
	});
	
	$('.WIP-jq-check').each(function(){
			
		var newInput = $(this).find("input[type='hidden']");
		var liveA = $(this).find('a');
		var On = $(this).find("a[rel='1']");
		var Off = $(this).find("a[rel='0']");
				
		if ( newInput.attr('value') == "1" ){
		
			On.addClass('checked');
			
		} else {
		
			Off.addClass('checked');
			
		}
		
		liveA.each(function(){
		
			liveA.click(function(){
				
				var WhatRel = $(this).attr('rel');
				
				if( WhatRel == "0" ){
					if( $(this).parent().find("input[type^='hidden']").attr('value') == "0" ){
						return false;
					} else {
						$(this).parent().find('.checked').removeClass('checked');
						
						$(this).addClass('checked');
						$(this).parent().find("input[type^='hidden']").attr('value', '0');
						
						return false;
					}
				} else {
					if( $(this).parent().find("input[type^='hidden']").attr('value') == "1" ){
						return false;
					} else {
						$(this).parent().find('.checked').removeClass('checked');
						
						$(this).addClass('checked');
						$(this).parent().find("input[type^='hidden']").attr('value', '1');
						
						return false;
					}
				}
				
				return false;
				
			});
			
		});
		
	});

};

function metabox_upim(){

	if( $('.uploadify_upload_portfolio').length ){
		
		$('.uploadify_upload_portfolio').each(function(){
			var uploadHandle = $(this),
				uploadID = uploadHandle.attr('id');
		
			  $('#'+uploadID).uploadify({
				'uploader'  : bdVar.up_uploader,
				'script'    : ajaxurl,
				'cancelImg' : bdVar.up_cancel,
				'buttonImg' : bdVar.up_buttonimageupload,
				'height' : 30,
				'width' : 98,
				'auto'      : true,
				'multi' : false,
				'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;*.ico',
				'fileDesc'    : 'Image File',
				'scriptData' : {'action' : 'wip_post_upload_action', 'type' : 'upload_portfolio_image'},
				'fileDataName' : 'portfolio_image',
				'sizeLimit' : bdVar.up_maxsize,
				'onComplete'  : function(event, ID, fileObj, response, data) {
					
					var _callback = $.parseJSON( response );

					if( _callback.error ){
						var buildReturn = '<span class="upload-error"><span>' + _callback.errorText + '</span></span>';
						$(".upload-error").remove();
						uploadHandle.parent().after(buildReturn);
						
						setTimeout(function(){
						
							$(".upload-error").fadeOut('slow', function(){ $(this).remove(); } );
						
						}, 1300);
						
					}
					else {
						var buildReturns = '<img class="thumb_preview" src="'+_callback.image+'" alt="" /><a id="delete_portfolio" href="#" title="remove"></a>';
						var imContainers = $('#portfolio_o').find('.p-preview');
						var formdescT = $('#portfolio_o').find('.wip-desc');
							
						$('#portfolio-bt-handle').fadeOut(200);
						formdescT.fadeOut(200);
						imContainers.fadeIn(200);
									
						$('#portfolio_o').find('.portfolio_id').val(_callback.ajaxImageId);
						imContainers.html(buildReturns);
					}
					
				}
			  });

		});
	}
	
	
	
	$('#delete_portfolio').each( function(){
	
		$('#delete_portfolio').live('click', function(){
		
			var Oid = $('#portfolio_o').find('.portfolio_id').val();
			var imContainers = $('#portfolio_o').find('.p-preview');
			var formdescT = $('#portfolio_o').find('.wip-desc');
			
				var data = {
					action: 'wip_post_upload_action',
					type: 'portfolio_reset',
					data: Oid
				};

				$.post(ajaxurl, data, function(response) {
					
					imContainers.html('');
					
					imContainers.fadeOut(200);
					$('#portfolio-bt-handle').fadeIn(200);
					formdescT.fadeIn(200);
			
				});

				return false; 
		});
	});
	
	
	
	
	$('.insert_video').each(function(){
		
		$(this).click(function(){
			
			var $this = $(this);
			$this.text('Please wait');
			
				intervalVideo = window.setInterval(function(){
					var text = $this.text();
					if (text.length < 15){	
						$this.text(text + '.'); 
					} else { 
						$this.text('Please wait'); 
					} 
				}, 200);
				
				var data = {
					action: 'wip_post_upload_action',
					type: 'portfolio_video',
					data: $('#portfolio-video').val()
				};
				
				$.post(ajaxurl, data, function(response) {
				
					window.clearInterval(intervalVideo);
					$this.text('Insert Video');	
					
						if( response.error ){
							
							var buildReturns = '<span class="upload-error"><span>' + response.errorText + '</span></span>';
							$(".upload-error").remove();
							$this.parent().after(buildReturns);
							
							setTimeout(function(){		
								$(".upload-error").fadeOut('slow', function(){ $(this).remove(); } );
							}, 1300);

						}
						else{
							$('#portfolio-video').val('');
							var buildReturns = WIPdoNiceThing( response.vid ) + '<a id="delete_portfolio" href="#" title="delete"></a>';
							var vidContainers = $('#portfolio_o').find('.p-preview');
							var formdescT = $('#portfolio_o').find('.wip-desc');
							
							$('#portfolio-bt-handle').fadeOut(200);
							formdescT.fadeOut(200);
							vidContainers.fadeIn(200);
									
							$('#portfolio_o').find('.portfolio_id').val( response.ajaxId );
							vidContainers.html(buildReturns);
							
						}
				
				}, 'json');
				
				
		
		});
	
	
	});


}





function WIPdoNiceThing(obj){

	var flash_mark 	= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{width}" height="{height}">\
	<param name="wmode" value="transparent" />\
	<param name="allowfullscreen" value="true" />\
	<param name="allowscriptaccess" value="always" />\
	<param name="movie" value="{path}" />\
	<embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{width}" height="{height}" wmode="transparent">\
	</embed></object>';
	
	var vimeo_mark	= '<iframe src="http://player.vimeo.com/video/{path}?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0&amp;color=00ff66" width="{width}" height="{height}" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

	
	var flow_mark = '<object id="PortfolioPostDataVideo" width="{width}" height="{height}" data="'+bdVar.flowurl+'" type="application/x-shockwave-flash">\
	<param name="wmode" value="opaque" />\
	<param name="movie" value="'+bdVar.flowurl+'" />\
	<param name="bgcolor" value="0x000000" />\
	<param name="allowfullscreen" value="true" />\
	<param name="allowscriptacces" value="always" />\
	<param name="flashvars" value=\'config={"clip":{"url":"{path}","autoPlay":false,"autoBuffering":false, "scaling": "fit"}}\' />\
	<embed type="application/x-shockwave-flash" width="{width}" height="{height}" wmode="opaque" bgcolor="0x000000" allowscriptacces="always" src="'+bdVar.flowurl+'" flashvars=\'config={"clip":{"url":"{path}","autoPlay":false,"autoBuffering":false, "scaling": "fit"}}\'/>\
	</object>';
	
	var quicktime_mark 	= '<object classid="clsid:02bf25d5-8c17-4b23-bc80-d3488abddc6b" codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0" height="{height}" width="{width}">\
	<param name="src" value="{path}"/>\
	<param name="autoplay" value="false"/>\
	<param name="scale" value="tofit"/>\
	<param name="type" value="video/quicktime"/>\
	<embed src="{path}" scale="tofit" height="{height}" width="{width}" autoplay="false" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/">\
	</embed></object>';

	
			switch( wip_getFileType(obj) ){
					case 'youtube':
						var w = 215;
						var h = 161;
						var movie = 'http://www.youtube.com/v/'+wip_grab_url_param('v', obj)+'?fs=1&amp;hl=en_US&amp;autoplay=0';
						var insert = flash_mark.replace(/{width}/g,w).replace(/{height}/g,h).replace(/{path}/g,movie);

					break;
					case 'vimeo':
						var w = 215;
						var h = 161;
						var movie = obj.replace('/www.', '/').replace('http://vimeo.com/','');
					
						var insert = vimeo_mark.replace(/{width}/g,w).replace(/{height}/g,h).replace(/{path}/g,movie);

					break;
					case 'quicktime':
						var w = 215;
						var h = 161;
						var movie = obj;
					
						var insert = quicktime_mark.replace(/{width}/g,w).replace(/{height}/g,h).replace(/{path}/g,movie);

					break;
					case 'custom':
						var w = 215;
						var h = 161;
						var movie = obj;
					
						var insert = flow_mark.replace(/{width}/g,w).replace(/{height}/g,h).replace(/{path}/g,movie);

					break;
					case 'flash':
						var w = 215;
						var h = 161;
						var insert = flash_mark.replace(/{width}/g,w).replace(/{height}/g,h).replace(/{path}/g,obj);
					break;
			}
			
	return insert;
}







$(document).ready(function(){
	metabox_upim();
	wCB();
});

})(jQuery);

function wip_grab_url_param(name,url){
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( url );
	if( results == null )
		return "";
	 else
	return results[1];
};

function wip_getFileType(itemSrc){
	if(itemSrc.match(/youtube\.com\/watch/i)){
		return 'youtube';
	}else if(itemSrc.match(/vimeo\.com/i)){
		return 'vimeo';
	}else if(itemSrc.indexOf('.mov')!=-1){
		return 'quicktime';
	}else if(itemSrc.indexOf('.mp4')!=-1){
		return 'custom';
	}else if(itemSrc.indexOf('.flv')!=-1){
		return 'custom';
	}else if(itemSrc.indexOf('.3gp')!=-1){
		return 'quicktime';
	}else if(itemSrc.indexOf('.swf')!=-1){
		return 'flash';
	}
};