<?php
if( !is_admin() ):
add_action('wp_head', 'wip_callNivo_script');
add_action('wp_head', '_piecemaker_script_embed');
add_action('wp_head', 'wip_print_sliderHeight');
endif;

function wip_print_sliderHeight(){
	if( is_home() ){
		$add = "";
		$height = get_wip_option_by( 'bd_sliderHeight', 400 );
		if( get_option('bd_slidertype') == 'flash' ) {
			$height = (int)$height + 80;
			$add = ' overflow: display!important;';
		} else {
			$add = ' margin-bottom: 30px!important;';
		}
		
		echo '<style type="text/css">#slider{width: 940px; height: '.$height.'px!important; position: relative;'.$add.' }</style>' . "\n";
	}
}


/**
 * get images for nivoslider
 */
function wip_get_nivo_images(){

	$result = get_site_transient( 'slider_data' );
	if ( false === $result ) {	
	
		$get_slider_id = get_option('bd_slider_id');
		$get_slider_det = get_option('bd_slider_det');

		$return = '<div id="slider" class="wip_nivo">' . "\n";
		
		if( !empty($get_slider_id) ) {

			foreach( $get_slider_id as $i => $ids):
			
				if( array_key_exists( $ids, $get_slider_det ) ) {
						
						$image = _wip_breakthis_image_map( $get_slider_det[$ids]['image'] );
						$link = $get_slider_det[$ids]['link'];
						$desc = $get_slider_det[$ids]['desc'];
			
						if($link != "") $return .= '<a href="' . $link . '">' . "\n";
							$return .= '<img src="' . $image . '" alt="" title="' . wptexturize( stripslashes($desc) ) . '"/>' . "\n";
						if($link != "") $return .= '</a>' . "\n";

				}
				
			endforeach;

		} else {
			
			$return .= "";
			
		}

		$return .= '</div>' . "\n";
		
		$result = $return;
		
		$timeout = 60 * 60 * 72;
		set_site_transient( 'slider_data', $result, $timeout );
	}
	
	echo $result;
}



function _wip_build_piecemaker_xml(){

	$upload = wp_upload_dir();
	$cachefile = $upload['basedir'] . '/_builder_piecemaker.xml';
	$cachefileUrl = $upload['baseurl'] . '/_builder_piecemaker.xml';
	
	$piecemaker_cache = get_site_transient( 'piecemaker_slider_data' );
	$height = get_wip_option_by( 'bd_sliderHeight', 400 );
	
	if ( !file_exists($cachefile)  || ( false === $piecemaker_cache ) ){
		$get_slider_id = get_option('bd_slider_id');
		$get_slider_det = get_option('bd_slider_det');
	
		if( !empty($get_slider_id) ) {
		
			$pm = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
			$pm .= '<Piecemaker>' . "\n";
			$pm .= '<Contents>' . "\n";

				foreach( $get_slider_id as $i => $ids):
				
					if( array_key_exists( $ids, $get_slider_det ) ) {
							
							$image = _wip_breakthis_image_map( $get_slider_det[$ids]['image'] );
							$link =  $get_slider_det[$ids]['link'];
							$desc = wptexturize( stripslashes( wpautop( $get_slider_det[$ids]['desc'] ) ) );
							
							$title = "";
							$swf = "";
							if( isset( $get_slider_det[$ids]['piecemaker'] ) ){
								$pms = $get_slider_det[$ids]['piecemaker'];
								
								$title =  $pms['title'];
								$swf = $pms['swf'];
							}
							
							
							if( trim($swf) != "" ){
								
								if( substr( trim($swf), -3) == 'swf' ){
									$pm .= '<Flash Source="'.trim($swf).'" Title="'.$title.'">' . "\n";
									$pm .= '<Image Source="'.$image.'" />' . "\n";
									$pm .= '</Flash>' . "\n";
								} else {
									$pm .= '<Video Source="'.trim($swf).'" Title="'.$title.'" Width="940" Height="'.$height.'" Autoplay="true">' . "\n";
									$pm .= '<Image Source="'.$image.'" />' . "\n";
									$pm .= '</Video>' . "\n";
								}
								
							} else {
								$pm .= '<Image Source="'.$image.'" Title="'.$title.'">' . "\n";
								
								if( $desc != "" ) $pm .= '<Text>'.$desc.'</Text>' . "\n";
								
								if( $link != "" ) $pm .= '<Hyperlink URL="'.$link.'" Target="_self" />' . "\n";
								
								$pm .= '</Image>' . "\n";
							}
							

					}
					
				endforeach;
			
			$pm .= '</Contents>' . "\n";
			
			$pm .= '<Settings ImageWidth="940" ImageHeight="'.$height.'" LoaderColor="0x'.get_wip_option_by('bd_pc_LoaderColor','333333').'" InnerSideColor="0x'.get_wip_option_by('bd_pc_InnerSideColor','222222').'" SideShadowAlpha="'.get_wip_option_by('bd_pc_SideShadowAlpha','0.8').'" DropShadowAlpha="'.get_wip_option_by('bd_pc_DropShadowAlpha','0.7').'" DropShadowDistance="'.get_wip_option_by('bd_pc_DropShadowDistance','25').'" DropShadowScale="'.get_wip_option_by('bd_pc_DropShadowScale','0.95').'" DropShadowBlurX="'.get_wip_option_by('bd_pc_DropShadowBlurX','40').'" DropShadowBlurY="'.get_wip_option_by('bd_pc_DropShadowBlurY','4').'" MenuDistanceX="'.get_wip_option_by('bd_pc_MenuDistanceX','20').'" MenuDistanceY="'.get_wip_option_by('bd_pc_MenuDistanceY','50').'" MenuColor1="0x'.get_wip_option_by('bd_pc_MenuColor1','999999').'" MenuColor2="0x'.get_wip_option_by('bd_pc_MenuColor2','333333').'" MenuColor3="0x'.get_wip_option_by('bd_pc_MenuColor3','FFFFFF').'" ControlSize="'.get_wip_option_by('bd_pc_ControlSize','100').'" ControlDistance="'.get_wip_option_by('bd_pc_ControlDistance','20').'" ControlColor1="0x'.get_wip_option_by('bd_pc_ControlColor1','222222').'" ControlColor2="0x'.get_wip_option_by('bd_pc_ControlColor2','FFFFFF').'" ControlAlpha="'.get_wip_option_by('bd_pc_ControlAlpha','0.8').'" ControlAlphaOver="'.get_wip_option_by('bd_pc_ControlAlphaOver','0.95').'" ControlsX="450" ControlsY="280&#xD;&#xA;" ControlsAlign="center" TooltipHeight="'.get_wip_option_by('bd_pc_TooltipHeight','32').'" TooltipColor="0x'.get_wip_option_by('bd_pc_TooltipColor','222222').'" TooltipTextY="5" TooltipTextStyle="P-Italic" TooltipTextColor="0x'.get_wip_option_by('bd_pc_TooltipTextColor','FFFFFF').'" TooltipMarginLeft="5" TooltipMarginRight="7" TooltipTextSharpness="'.get_wip_option_by('bd_pc_TooltipTextSharpness','50').'" TooltipTextThickness="'.get_wip_option_by('bd_pc_TooltipTextThickness','-100').'" InfoWidth="'.get_wip_option_by('bd_pc_InfoWidth','400').'" InfoBackground="0x'.get_wip_option_by('bd_pc_InfoBackground','FFFFFF').'" InfoBackgroundAlpha="'.get_wip_option_by('bd_pc_InfoBackgroundAlpha','0.95').'" InfoMargin="15" InfoSharpness="0" InfoThickness="0" Autoplay="'.get_wip_option_by('bd_pc_Autoplay','10').'" FieldOfView="45"></Settings>' . "\n";
			$pm .= '<Transitions>' . "\n";
			foreach( $get_slider_id as $a => $idx):
				if( array_key_exists( $idx, $get_slider_det ) ) {
					if( isset( $get_slider_det[$idx]['piecemaker'] ) ){
						$pmx = $get_slider_det[$idx]['piecemaker'];
						
						$pm .= '<Transition Pieces="'.$pmx['pieces'].'" Time="'.$pmx['time'].'" Transition="'.$pmx['transition'].'" Delay="'.$pmx['delay'].'" DepthOffset="'.$pmx['depthoffset'].'" CubeDistance="'.$pmx['cubedistance'].'"></Transition>' . "\n";
					}
				}
			endforeach;
			$pm .= '</Transitions>' . "\n";
			$pm .= '</Piecemaker>' . "\n";
		
		
			@file_put_contents($cachefile, $pm);
			$timeout = 60 * 60 * 72;
			set_site_transient( 'piecemaker_slider_data', 'xml file is exists and no changes', $timeout );
		}
	}
	
	
	echo $cachefileUrl;
	
}



/*
Call nivoSlider, and throw the data into wp_head
*/
function wip_callNivo_script(){
if( is_home() ):
	/*get all settings from theme option*/
	$effect = ( get_option('bd_nivo_effect') != "" ) ? get_option('bd_nivo_effect') : 'random';
	$slices = ( get_option('bd_nivo_slices') != "" ) ? get_option('bd_nivo_slices') : 15;
	$speed = ( get_option('bd_nivo_speed') != "" ) ? get_option('bd_nivo_speed') : 500;
	$delay = ( get_option('bd_nivo_delay') != '' ) ? get_option('bd_nivo_delay') : 5000;
	$opc = (get_option('bd_nivo_opacity') != "" ) ? get_option('bd_nivo_opacity') : '0.8';	
	$boxCols = ( get_option('bd_nivo_boxCols') != "" ) ? get_option('bd_nivo_boxCols') : 8;
	$boxRows = ( get_option('bd_nivo_boxRows') != "" ) ? get_option('bd_nivo_boxRows') : 4;
	$pauseOnHover = (get_option('bd_nivo_hoverpause') !== '0') ? 'true' : 'false';
	

?>
<script type="text/javascript">
/* <![CDATA[ */
(function($){
	$(window).load(function(){
		$("#slider").nivoSlider({
			effect:"<?php echo $effect; ?>",
			slices: <?php echo $slices; ?>,
			boxCols: <?php echo $boxCols; ?>,
			boxRows: <?php echo $boxRows; ?>,
			animSpeed: <?php echo $speed; ?>,
			pauseTime: <?php echo $delay; ?>,
			directionNavHide: true,
			captionOpacity: <?php echo $opc; ?>,
			pauseOnHover: <?php echo $pauseOnHover; ?>,
			controlNav: true
		});
	});
})(jQuery);
/* ]]> */
</script>
<?php
endif;
}



function _piecemaker_script_embed(){
if( is_home() && (get_option('bd_slidertype') == 'flash') ):
$uploadPath = wp_upload_dir();
$height = get_wip_option_by( 'bd_sliderHeight', 400 );
?>
<script type="text/javascript">
/* <![CDATA[ */
      var flashvars = {};
      flashvars.cssSource = "<?php echo get_template_directory_uri(); ?>/modules/piecemaker/piecemaker.css";
      flashvars.xmlSource = "<?php _wip_build_piecemaker_xml(); ?>";
		
      var params = {};
      params.play = "true";
      params.menu = "false";
      params.scale = "showall";
      params.wmode = "transparent";
      params.allowfullscreen = "true";
      params.allowscriptaccess = "always";
      params.allownetworking = "all";
	  
      swfobject.embedSWF('<?php echo get_template_directory_uri(); ?>/modules/piecemaker/piecemaker.swf', 'slider', '1000', '<?php echo $height+80; ?>', '10', null, flashvars, params, null);
/* ]]> */
</script>
<?php
endif;

}




/**
 * explode the array
 * and get image from subdir data and filename data
 */
function _wip_breakthis_image_map( $array_data ){

	$uploadPath = wp_upload_dir();
	$img_url = false;
	
	if( is_array( $array_data ) ){
		$img_url = $uploadPath['baseurl'] .  $array_data['subdir'] . '/'. $array_data['file_name'];
	}
	
	return $img_url;
}
?>