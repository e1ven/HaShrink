<?php
/**
 * Helper for our shortcodes!
 * @author webinpixels
 * 2012
 */
	
/** Youtube shortcode */
add_shortcode('youtube', 'youtube_shortcode');
	function youtube_shortcode($atts, $content = null ){
		extract(shortcode_atts(array(
			'url'		=> '',
			'width'		=> '600',
			'height'	=> '367',
			'align'		=> 'left',
			'autoplay'	=> 'false',
		), $atts));
		
		$class= "";
		if( $align == 'left' )$class=" alignleft";
		if( $align == 'center' )$class=" aligncenter";
		if( $align == 'right' )$class=" alignright";
	
	ob_start();
	
		if(empty($url) ) echo __('Shortcode ERROR! You MUST enter the youtube URL', 'wip');

		$autoplay = ( $autoplay == "true" ) ? "1" : "0";
		
		$before = '<span class="motion'.$class.'">';
		$after = '</span>';
		
		echo $before.WIPobjectPrint($url, 'youtube', $width, $height, $autoplay).$after;
		
	$youtube = ob_get_clean();
	return $youtube;
		
	}








	
/** Vimeo shortcode */
add_shortcode('vimeo', 'vimeo_shortcode');
	function vimeo_shortcode($atts, $content = null ){
		extract(shortcode_atts(array(
			'url'		=> '',
			'width'		=> '600',
			'height'	=> '367',
			'align'		=> 'left',
			'autoplay'	=> 'false',
		), $atts));
		
		$class= "";
		if( $align == 'left' )$class=" alignleft";
		if( $align == 'center' )$class=" aligncenter";
		if( $align == 'right' )$class=" alignright";
		
	ob_start();
		
		if(empty($url) ) echo __('Shortcode ERROR! You MUST enter the vimeo URL', 'wip');
		
		$autoplay = ( $autoplay == "true" ) ? "1" : "0";
		
		$before = '<div class="motion'.$class.'">';
		$after = '</div>' . "\n" . '<div class="clear"></div>' . "\n";
		
		echo $before.WIPobjectPrint($url, 'vimeo', $width, $height, $autoplay).$after;
		
	$vimeo = ob_get_clean();
	return $vimeo;
	}
	








/** flowplayer shortcode */	
add_shortcode('flv_video', 'fp_shortcode');
add_shortcode('mp4_video', 'fp_shortcode');
	function fp_shortcode($atts, $content = null ){
		extract(shortcode_atts(array(
			'url'		=> '',
			'width'		=> '600',
			'height'	=> '367',
			'align'		=> 'left',
			'autoplay'	=> 'false',
		), $atts));
		
		$class= "";
		if( $align == 'left' )$class=" alignleft";
		if( $align == 'center' )$class=" aligncenter";
		if( $align == 'right' )$class=" alignright";
		
	ob_start();
		
		if(empty($url) ) echo __('Shortcode ERROR! You MUST enter the video URL', 'wip');
		
		$before = '<div class="motion'.$class.'">';
		$after = '</div>' . "\n" . '<div class="clear"></div>' . "\n";
		
		echo $before.WIPobjectPrint($url, 'flowplayer', $width, $height, $autoplay).$after;
		
	$sleftho = ob_get_clean();
	return $sleftho;
		
	}








/** quicktime shortcode */
add_shortcode('3gp_video', 'qt_shortcode');
add_shortcode('mov_video', 'qt_shortcode');
	function qt_shortcode($atts, $content = null ){
		extract(shortcode_atts(array(
			'url'		=> '',
			'width'		=> '600',
			'height'	=> '367',
			'align'		=> 'left',
			'autoplay'	=> 'false',
		), $atts));
		
		$class= "";
		if( $align == 'left' )$class=" alignleft";
		if( $align == 'center' )$class=" aligncenter";
		if( $align == 'right' )$class=" alignright";
		
	ob_start();
		
		if(empty($url) ) echo __('Shortcode ERROR! You MUST enter the video URL', 'wip');
		
		$before = '<div class="motion'.$class.'">';
		$after = '</div>' . "\n" . '<div class="clear"></div>' . "\n";
		
		echo $before.WIPobjectPrint($url, 'quicktime', $width, $height, $autoplay).$after;
		
	$flowp = ob_get_clean();
	return $flowp;
		
	}
	









add_shortcode('contactform', 'inter_contactform');
	function inter_contactform( $atts, $content = null ) {
		ob_start();
			echo wip_show_contact_form();
		$cf = ob_get_clean();
		return $cf;
	}
	
function wip_show_contact_form()
{
	global $post;

	$return = '<div id="adm-contact">' . "\n";
	$return .= '<form action="' . get_permalink() .'/#adm-contact" id="contact-form">' . "\n";
	$return .= '<p><span class="label">' . __('Name', 'wip') .' </span><input type="text" name="hname" id="hname" value="" /><span class="req"> *</span></p>' . "\n";
	$return .= '<p><span class="label">' . __('E-mail', 'wip') .' </span><input type="text" name="hmail" id="hmail" value="" /><span class="req"> *</span></p>'. "\n";
	$return .= '<p><span class="label">' . __('Subject', 'wip') .' </span><input type="text" name="hsubj" id="hsubj" value="" /><span class="req"> *</span></p>'. "\n";
	$return .= '<p style="vertical-align: top;"><span class="label">' . __('Message', 'wip') .' </span><textarea name="hmess" id="hmess" rows="12" cols="16" ></textarea><span class="req"> *</span></p>'. "\n";
	$return .= '<p><span class="label">&nbsp;</span><input type="submit" name="submit" id="contact_submit" class="button contactform_button" value="' . __('Send Message', 'wip') .'" /></p>'. "\n";
	$return .= '<div class="clear"></div>' . "\n";	
	$return .= '</form></div>' . "\n";

	return $return;
}








/** toggle */
add_shortcode('toggle', 'toggle_sc');
	function toggle_sc($atts, $content = null ){
		extract(shortcode_atts(array(
			'title'		=> 'Title of toggle',
		), $atts));
		
		ob_start();
		
		$return = '<div class="toggle_container shortcode">' . "\n";
		$return .= '<h3 class="toggle_title">'.$title.'<span class="toggle_indicator">&plus;</span></h3>' . "\n";
		$return .= '<div class="toggle_body">' . do_shortcode($content);
		$return .= '<div class="clear"></div>' . "\n";
		$return .= '</div>' . "\n";
		$return .= '</div>' . "\n";
		
		echo $return;
		
		$toggle = ob_get_clean();
		
		return $toggle;
	}









/** Tabs shortcode */	
add_shortcode( 'tabgroup', 'tab_group' );
	function tab_group( $atts, $content ){	
	
	ob_start();
	
		$GLOBALS['tab_count'] = 0;
		do_shortcode( $content );

		if( is_array( $GLOBALS['tabs'] ) ){
			foreach( $GLOBALS['tabs'] as $a => $tab ){
			
				$tabs[] = '<li><a class="" href="#" rel="'.$a.'">'.$tab['title'].'</a></li>';
				$panes[] = '<div class="pane">'.do_shortcode($tab['content']).'</div>';
			
			}
			
			echo '<div class="wip_tab shortcode">' . "\n".'<ul class="tab-lists">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="panes">'.implode( "\n", $panes ).'</div>'."\n". '</div>' . "\n";
		
		}
	
	$tabs = ob_get_clean();	
		
		return $tabs;
	
	}
	

add_shortcode( 'tab', 'etdc_tab' );
	function etdc_tab( $atts, $content ){
		extract(shortcode_atts(array(
			'title' => 'Tab %d'
		), $atts));
	
	ob_start();
	
		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );

		$GLOBALS['tab_count']++;
	ob_get_clean();
	}
	









/**
 * Button shortcode helper
 */
add_shortcode('button', 'button_sc');
function button_sc($atts, $content = null ){
	extract(shortcode_atts(array(
		'size'		=> 'medium',
		'href'		=> '#',
		'bgcolor'	=> '#555555',
		'fontcolor'	=> '#FFFFFF',
		'text'	=> 'Button text',
	), $atts));

	$height = "";
	switch( $size ){
		case 'medium':
			$height = 32;
			break;
		case 'small':
			$height = 24;
			break;
		case 'big':
			$height = 48;
			break;
	}

	$bgcolor_light = colourBrightness( $bgcolor, '0.82' );
	$bgcolor_gradient = new gradient_image($bgcolor_light, $bgcolor, 32, 5, $height);
	$bgcolor_gradient_reserve = new gradient_image($bgcolor, $bgcolor_light, 32, 5, $height);
	$bgcolor_new_grd = $bgcolor_gradient->createPNG(false, true);
	$bgcolor_new_grd_reserve = $bgcolor_gradient_reserve->createPNG(false, true);
	$bgcolor_border = colourBrightness( $bgcolor, '-0.8' );
	$bgcolor_innerShadow = colourBrightness( $bgcolor_light, '0.8' );
	

	ob_start();
	
	$randum = _wip_randomAlphaNum();
	$objectID = 'wip-button-' . $randum;
	$hexYou = sc_HexToRGB( $bgcolor_border );
	$hexUsed = implode(',', $hexYou);

	$return = '<style type="text/css">#'.$objectID.'{background: '.$bgcolor.'  url("data:image/png;base64,'.base64_encode($bgcolor_new_grd).'") scroll left top repeat-x; color: '.$fontcolor.'; border: 1px solid '.$bgcolor_border.'; -box-shadow: inset 0px 1px 0px '.$bgcolor_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2); -webkit-box-shadow: inset 0px 1px 0px '.$bgcolor_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2); -moz-box-shadow: inset 0px 1px 0px '.$bgcolor_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2); text-shadow: 0px -1px 0px rgba('.$hexUsed.', .7); } #'.$objectID.':hover{background: '.$bgcolor.'  url("data:image/png;base64,'.base64_encode($bgcolor_new_grd_reserve).'") scroll left bottom repeat-x; color: '.$fontcolor.'; } </style>';
	$return .= '<a id="'.$objectID.'" class="'.$size.'-button button-shortcode" href="'.$href.'">'.stripslashes( $text ).'</a>';
	
	echo $return;
	
	$button = ob_get_clean();
	
	return $button;
}



function _wip_randomAlphaNum( $length = 8 ){

    $chars = 'bcdfghjklmnprstvwxzaeiou';
   	$result = "";

    for ($p = 0; $p < $length; $p++)
    {
        $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
    }
   
    return $result;

}



function sc_HexToRGB($hex) {
	$hex = ereg_replace("#", "", $hex);
	$color = array();
	
	if(strlen($hex) == 3) {
		$color['r'] = hexdec(substr($hex, 0, 1) . $r);
		$color['g'] = hexdec(substr($hex, 1, 1) . $g);
		$color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
		$color['r'] = hexdec(substr($hex, 0, 2));
		$color['g'] = hexdec(substr($hex, 2, 2));
		$color['b'] = hexdec(substr($hex, 4, 2));
	}
	
	return $color;
}