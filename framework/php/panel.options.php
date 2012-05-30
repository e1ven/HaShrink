<?php

#Define the theme name, short name, and translate id
$themename = "The_Builder";
$shortname = "bd";
$tid = "wip";

#option array
$tp_page_id = retrieve_page_data(true); /* get page id lists */
$tp_page_name = retrieve_page_data(false); /* get page title/name lists */

$tp_cat_id = retrieve_cat_data(true); /* get cat id lists */
$tp_cat_name = retrieve_cat_data(false); /* get cat title/name lists */

$sidebarOpt = get_custom_sidebar_array(); /** custom sidebar in array */


function WIP_get_options(){
	global $shortname, $tid, $tp_page_id, $tp_page_name, $sidebarOpt;
	
	$fontOption = array();
	$gf = _wipfr_font_lists_array('google', 'font-name');
	$df = _wipfr_font_lists_array('standard', 'font-name');
	$fontOption[] = array(
		 "label" => '',
		 "font" => NULL
	);
	$fontOption[] = array(
		 "label" => __('Google Web Font', 'wip'),
		 "font" => $gf
	);
	$fontOption[] = array(
		 "label" => '',
		 "font" => NULL
	);
	$fontOption[] = array(
		"label" => __('Standard Font', 'wip'),
		"font" => $df
	);
	

	
	$WIPopt = array();

	$WIPopt['general_settings'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/gear.png',
		"options" => array(
		
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),	

			
						"logo" => array (
							"type"	=> 'upload_image',
							"label" => __('Site logo', $tid),
							"id"	=> $shortname . '_logo',
							"desc" => '',
						),
						
						"favicon" => array (
							"type"	=> 'upload_image',
							"label" => __('Upload your favicon', $tid),
							"id"	=> $shortname . '_favicon',
							"desc" => '',
						),
						
						
						"prettyPhoto" => array (
							"type"	=> 'selectid',
							"label" => __('PrettyPhoto theme', $tid),
							"id"	=> $shortname . '_pp_style',
							"option"=> array('Default', 'Light rounded', 'Dark rounded', 'Light square', 'Dark square', 'Facebook'),
							"choosen" => array('pp_default', 'light_rounded', 'dark_rounded', 'light_square', 'dark_square', 'facebook'),
							"std"	=> 'pp_default',
							"desc"	=> __('Select the prettyPhoto(lightbox) style. If you want to use prettyPhoto in single product page, you need to turn off the default lightbox in WooCommerce settings page', $tid),
						),
						
						"copyright" => array (
							"type"	=> 'textareasmall',
							"label" => __('Copyright text', $tid),
							"id"	=> $shortname . '_ct',
							"desc"	=> __('Enter the copyright text.', $tid),
							"std"	=> "",
						),
						
					
						"headerscript" => array (
							"type"	=> 'textareascript',
							"label" => __('Header script', $tid),
							"id"	=> $shortname . '_hs',
							"desc"	=> __('If you need to add scripts to your header (like Mint tracking code), enter your code here.<br> Note: do not enter any advertisement script here', $tid),
							"std"	=> "",
						),
						
						"footerscript" => array (
							"type"	=> 'textareascript',
							"label" => __('Footer Script', $tid),
							"id"	=> $shortname . '_fs',
							"desc"	=> __('If you need to add scripts to your footer (like Google tracking code), enter your code here.<br> Note: do not enter any advertisement script here', $tid),
							"std"	=> "",
					),
					
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'general_settings',
						"reset"	=> true,
					),
					
		),
	);
	
	
	$WIPopt['layout_and_style'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/skin.png',
		"child" => array(
			"first" => array(
				"title" => __('Layout', $tid)
			),
			"font_manager" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),

					"headingfont" => array (
						"type"	=> 'select_label',
						"label" => __('Heading Font (H1 - H6)', $tid),
						"id"	=> $shortname . '_heading_font',
						"option"=> $fontOption,
						"std"	=> 'Droid Serif',
						"desc"	=> __('Select font for heading, H1 - H6', $tid),
					),
					
					"bodyfont" => array (
						"type"	=> 'select_label',
						"label" => __('Body Font', $tid),
						"id"	=> $shortname . '_body_font',
						"option"=> $fontOption,
						"std"	=> 'Droid Sans',
						"desc"	=> __('Select font for body (text)', $tid),
					),
					
					"menufont" => array (
						"type"	=> 'select_label',
						"label" => __('Main Menu Font', $tid),
						"id"	=> $shortname . '_menu_font',
						"option"=> $fontOption,
						"std"	=> 'Droid Sans',
						"desc"	=> __('Select font for main menu', $tid),
					),
					
					"font_warning" => array(
						"type"	=> 'label',
						"first-row" => true,
						"label" => __('Note: for best performance, if you decide to use Google Api\'s fonts - you may choose the same font for body text font and main menu font', $tid),
					),
						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'font_manager',
						"reset"	=> false,
					),
			),
			"general_skin" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
					
						"wrap_generalskin" => array(
							"type" => 'wraper',
							"label" => __('Content background color', $tid),
							"area" => 'wrap_generalskin',
						),

						"generalbgcolor" => array (
							"type"	=> 'color',
							"label" => __('Background Color', $tid),
							"id"	=> $shortname . '_content_bgColor',
							"std" => 'fafafa',
							"desc" => '',
						),
						
						"generalclear" => array(
							"type" => 'clear_float',
						),
						
						"wrap_generalskin_close" => array(
							"type" => 'wraper_close',
						),

						"headingfontcolor" => array (
							"type"	=> 'color',
							"label" => __('Heading Font Color (H1 - H6)', $tid),
							"id"	=> $shortname . '_heading_fontcolor',
							"std" => '4d4d4d',
							"desc" => '',
						),
					
						"bodyfontcolor" => array (
							"type"	=> 'color',
							"label" => __('Body Font Color', $tid),
							"id"	=> $shortname . '_body_fontcolor',
							"std" => '858585',
							"desc" => '',
						),
						
						"alinkcolor" => array (
							"type"	=> 'color',
							"label" => __('Link font color', $tid),
							"id"	=> $shortname . '_general_link_color',
							"std" => '4d4d4d',
							"desc" => '',
						),
						
						"alinkhovercolor" => array (
							"type"	=> 'color',
							"label" => __('Link font color on mouseover', $tid),
							"id"	=> $shortname . '_general_link_hovercolor',
							"std" => '2999e9',
							"desc" => '',
						),
						
						"blockquotecolor" => array (
							"type"	=> 'color',
							"label" => __('Blockquote font color', $tid),
							"id"	=> $shortname . '_blockquote_color',
							"std" => '5e5e5e',
							"desc" => '',
						),
						
						"defaultbuttonbgcolor" => array (
							"type"	=> 'color',
							"label" => __('Default submit button background color', $tid),
							"id"	=> $shortname . '_defaultbuttonbgcolor',
							"std" => '2999e9',
							"desc" => '',
						),
						
						"defaultbuttoncolor" => array (
							"type"	=> 'color',
							"label" => __('Default submit button font color', $tid),
							"id"	=> $shortname . '_defaultbuttoncolor',
							"std" => 'fcfcfc',
							"desc" => '',
						),


						"wrap_sidebarskin" => array(
							"type" => 'wraper',
							"label" => __('Sidebar', $tid),
							"area" => 'wrap_sidebarskin',
						),


						"sidebar_title_bg" => array (
							"type"	=> 'color',
							"label" => __('Sidebar title background color', $tid),
							"id"	=> $shortname . '_sidebar_title_bg',
							"std" => '4f4f4f',
							"desc" => '',
						),

						"sidebarclear" => array(
							"type" => 'clear_float',
						),

						"wrap_sidebarskin_close" => array(
							"type" => 'wraper_close',
						),


						"sidebar_title_color" => array (
							"type"	=> 'color',
							"label" => __('Sidebar title color', $tid),
							"id"	=> $shortname . '_sidebar_title_color',
							"std" => 'ebebeb',
							"desc" => '',
						),

						"sidebar_link_color" => array (
							"type"	=> 'color',
							"label" => __('Sidebar link color', $tid),
							"id"	=> $shortname . '_sidebar_link_color',
							"std" => '6b6b6b',
							"desc" => '',
						),

						"sidebar_link_color_hover" => array (
							"type"	=> 'color',
							"label" => __('Sidebar link color on mouseover', $tid),
							"id"	=> $shortname . '_sidebar_link_color_hover',
							"std" => '2999e9',
							"desc" => '',
						),



						
						"wrap_innerpagetitle" => array(
							"type" => 'wraper',
							"label" => __('Inner page title area', $tid),
							"area" => 'wrap_innerpagetitle',
						),

						"innerpagetitlebgcolor" => array (
							"type"	=> 'color',
							"label" => __('Background Color', $tid),
							"id"	=> $shortname . '_innerpage_title_bgColor',
							"std" => 'f2f2f2',
							"desc" => '',
						),
						
						"innerpagetitlebgimage" => array (
							"type"	=> 'upload_background',
							"label" => __('background image', $tid),
							"id"	=> $shortname . '_innerpage_title_bgimage',
							"desc" => '',
						),
						
						"innerclear" => array(
							"type" => 'clear_float',
						),
						
							"innerpagetitle_bgposition" => array (
								"type"	=> 'select',
								"label" => __('Background Position', $tid),
								"id"	=> $shortname . '_innerpage_title_bg_pos',
								"option"=> array('Left Top', 'Left Center', 'Left Bottom', 'Center Top', 'Center Center', 'Center Bottom', 'Right Top', 'Right Center', 'Right Bottom'),
								"std"	=> 'Left Top',
								"desc"	=> '',
							),
							
							"innerpagetitle_bgattachment" => array (
								"type"	=> 'select',
								"label" => __('Background Attachment', $tid),
								"id"	=> $shortname . '_innerpage_title_bg_attach',
								"option"=> array('Scroll', 'Fixed', 'Inherit'),
								"std"	=> 'Scroll',
								"desc"	=> '',
							),
							
							"innerpagetitle_bgrepeat" => array (
								"type"	=> 'select',
								"label" => __('Background Repeat', $tid),
								"id"	=> $shortname . '_innerpage_title_bg_repeat',
								"option"=> array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'),
								"std"	=> 'repeat',
								"desc"	=> '',
							),
							
						"innerpagesclear2" => array(
							"type" => 'clear_float',
						),
						
						"wrap_innerpagetitle_close" => array(
							"type" => 'wraper_close',
						),

						"innerpagetitlefont" => array (
							"type"	=> 'color',
							"label" => __('Title font Color', $tid),
							"id"	=> $shortname . '_innerpage_title_fontcolor',
							"std" => '4f4f4f',
							"desc" => '',
						),


						"innerpagetitlefontstyle" => array (
							"type"	=> 'selectid',
							"label" => __('Font Style', $tid),
							"id"	=> $shortname . '_innerpage_title_fontstyle',
							"option"=> array('Normal', 'Italic'),
							"choosen" => array('normal', 'italic'),
							"std"	=> 'normal',
							"desc" => '',
						),

						"innerpagetitlefontweight" => array (
							"type"	=> 'selectid',
							"label" => __('Font Weight', $tid),
							"id"	=> $shortname . '_innerpage_title_fontweight',
							"option"=> array('Normal', 'Bold'),
							"choosen" => array('normal', 'Bold'),
							"std"	=> 'normal',
							"desc" => '',
						),

						"innerpagetitlefonttransform" => array (
							"type"	=> 'selectid',
							"label" => __('Text Transform', $tid),
							"id"	=> $shortname . '_innerpage_title_texttransform',
							"option"=> array('None', 'Capitalize', 'Uppercase', 'Lowercase'),
							"choosen" => array('none', 'capitalize', 'uppercase', 'lowercase'),
							"std"	=> 'capitalize',
							"desc" => '',
						),
						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'general_skin',
						"reset"	=> false,
					),
			),
			"header_skin" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
					
						"wrap_headerskin" => array(
							"type" => 'wraper',
							"label" => __('Header background color and image', $tid),
							"area" => 'wrap_headerskin',
						),

						"headerbgcolor" => array (
							"type"	=> 'color',
							"label" => __('Background Color', $tid),
							"id"	=> $shortname . '_header_bgColor',
							"std" => 'fafafa',
							"desc" => '',
						),
						
						"headerbgimage" => array (
							"type"	=> 'upload_background',
							"label" => __('background image', $tid),
							"id"	=> $shortname . '_headerbgimage',
							"desc" => '',
						),
						
						"headerclear" => array(
							"type" => 'clear_float',
						),
						
						"headerbgline" => array (
							"type"	=> 'color',
							"label" => __('Top Line Color', $tid),
							"id"	=> $shortname . '_header_bgLine',
							"std" => '4f4f4f',
							"desc" => '',
						),
						
							"headerbg_bgposition" => array (
								"type"	=> 'select',
								"label" => __('Background Position', $tid),
								"id"	=> $shortname . '_header_bg_pos',
								"option"=> array('Left Top', 'Left Center', 'Left Bottom', 'Center Top', 'Center Center', 'Center Bottom', 'Right Top', 'Right Center', 'Right Bottom'),
								"std"	=> 'Left Top',
								"desc"	=> '',
							),
							
							"header_bgattachment" => array (
								"type"	=> 'select',
								"label" => __('Background Attachment', $tid),
								"id"	=> $shortname . '_header_bg_attach',
								"option"=> array('Scroll', 'Fixed', 'Inherit'),
								"std"	=> 'Scroll',
								"desc"	=> '',
							),
							
							"header_bgrepeat" => array (
								"type"	=> 'select',
								"label" => __('Background Repeat', $tid),
								"id"	=> $shortname . '_header_bg_repeat',
								"option"=> array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'),
								"std"	=> 'repeat',
								"desc"	=> '',
							),
							
						"headerclear2" => array(
							"type" => 'clear_float',
						),
						
						"wrap_headerskin_close" => array(
							"type" => 'wraper_close',
						),

						"toplinkcolor" => array (
							"type"	=> 'color',
							"label" => __('Top links font color', $tid),
							"id"	=> $shortname . '_toplinkcolor',
							"std" => '636363',
							"desc" => '',
						),

						"toplinkcolorhover" => array (
							"type"	=> 'color',
							"label" => __('Top links font color on hover', $tid),
							"id"	=> $shortname . '_toplinkhovercolor',
							"std" => '8c8c8c',
							"desc" => '',
						),
						
						"searchcolor" => array (
							"type"	=> 'color',
							"label" => __('Search form font color', $tid),
							"id"	=> $shortname . '_searchcolor',
							"std" => '636363',
							"desc" => '',
						),
						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'header_skin',
						"reset"	=> false,
					),
			),
			"menu_skin" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
						
						"menuparentbg" => array (
							"type"	=> 'color',
							"label" => __('Menu background color', $tid),
							"id"	=> $shortname . '_menuparentbg',
							"std" => '4f4f4f',
							"desc" => '',
						),
						
						"menuparentcolor" => array (
							"type"	=> 'color',
							"label" => __('Menu link color', $tid),
							"id"	=> $shortname . '_menuparentcolor',
							"std" => 'd4d4d4',
							"desc" => '',
						),
						
						"menuparenthovercolor" => array (
							"type"	=> 'color',
							"label" => __('Menu link color on hover', $tid),
							"id"	=> $shortname . '_menuparenthovercolor',
							"std" => '6cb6eb',
							"desc" => '',
						),
						
						"menudropdownbg" => array (
							"type"	=> 'color',
							"label" => __('Menu dropdown background color', $tid),
							"id"	=> $shortname . '_menudropdownbg',
							"std" => '6b6b6b',
							"desc" => '',
						),
						
						"menudropdownbghover" => array (
							"type"	=> 'color',
							"label" => __('Menu dropdown background color on hover', $tid),
							"id"	=> $shortname . '_menudropdownbghover',
							"std" => '737373',
							"desc" => '',
						),
						
						"menudropdowncolor" => array (
							"type"	=> 'color',
							"label" => __('Menu dropdown link color', $tid),
							"id"	=> $shortname . '_menudropdowncolor',
							"std" => 'c9c9c9',
							"desc" => '',
						),
						
						"menudropdownhovercolor" => array (
							"type"	=> 'color',
							"label" => __('Menu dropdown link color on hover', $tid),
							"id"	=> $shortname . '_menudropdownhovercolor',
							"std" => 'f2f2f2',
							"desc" => '',
						),

						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'menu_skin',
						"reset"	=> false,
					),
			),
			"top_shopping_cart" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
						
						"topcartbg" => array (
							"type"	=> 'color',
							"label" => __('Top shopping cart background color', $tid),
							"id"	=> $shortname . '_topcartbg',
							"std" => '4f4f4f',
							"desc" => '',
						),
						
						"topcartnumbercolor" => array (
							"type"	=> 'color',
							"label" => __('Cart value font color', $tid),
							"id"	=> $shortname . '_topcartnumbercolor',
							"std" => 'd4d4d4',
							"desc" => '',
						),

						"topcartdrop" => array(
							"type"	=> 'label',
							"first-row" => false,
							"label" => __('Below are settings for top cart dropdown', $tid),
						),

						"topcartdropdownbg" => array (
							"type"	=> 'color',
							"label" => __('Top shopping cart dropdown background color', $tid),
							"id"	=> $shortname . '_topcartdropdownbg',
							"std" => '636363',
							"desc" => '',
						),

						"topcartdropdownitem" => array (
							"type"	=> 'color',
							"label" => __('Item list background color', $tid),
							"id"	=> $shortname . '_topcartdropdownitem',
							"std" => '757575',
							"desc" => '',
						),

						"topcartdropdownitemprice" => array (
							"type"	=> 'color',
							"label" => __('Color for Price and text inside the item list', $tid),
							"id"	=> $shortname . '_topcartdropdownitemcolor',
							"std" => 'c7c7c7',
							"desc" => '',
						),

						"topcartdropdownitemlink" => array (
							"type"	=> 'color',
							"label" => __('Link font color', $tid),
							"id"	=> $shortname . '_topcartdropdownitemlink',
							"std" => '93b6cf',
							"desc" => '',
						),

						"topcartdropdownitemlink_hover" => array (
							"type"	=> 'color',
							"label" => __('Link font color on hover', $tid),
							"id"	=> $shortname . '_topcartdropdownitemlink_hover',
							"std" => 'c7c7c7',
							"desc" => '',
						),


						"topcartdropdownsubtotal" => array (
							"type"	=> 'color',
							"label" => __('color for Subtotal text and amount', $tid),
							"id"	=> $shortname . '_topcartdropdownsubtotal',
							"std" => 'cfcfcf',
							"desc" => '',
						),

						"topcartdropbutton" => array(
							"type"	=> 'label',
							"first-row" => false,
							"label" => __('Below are settings button on top shopping cart dropdown', $tid),
						),

						"topcartdropbuttonbg" => array (
							"type"	=> 'color',
							"label" => __('"View Cart" and "Checkout" button background color', $tid),
							"id"	=> $shortname . '_topcartdropbuttonbg',
							"std" => '2999e9',
							"desc" => '',
						),

						"topcartdropbuttoncolor" => array (
							"type"	=> 'color',
							"label" => __('"View Cart" and "Checkout" button font color', $tid),
							"id"	=> $shortname . '_topcartdropbuttoncolor',
							"std" => 'fafafa',
							"desc" => '',
						),

						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'top_shopping_cart',
						"reset"	=> false,
					),
			),
			"homepage_slider_skin" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
					
						"wrap_sliderskin" => array(
							"type" => 'wraper',
							"label" => __('Slider area background color and image', $tid),
							"area" => 'wrap_sliderskin',
						),

						"sliderbgcolor" => array (
							"type"	=> 'color',
							"label" => __('Background Color', $tid),
							"id"	=> $shortname . '_sliderbgcolor',
							"std" => 'f2f2f2',
							"desc" => '',
						),
						
						"sliderbgimage" => array (
							"type"	=> 'upload_background',
							"label" => __('background image', $tid),
							"id"	=> $shortname . '_sliderbgimage',
							"desc" => '',
						),
						
						"generalclear" => array(
							"type" => 'clear_float',
						),
						
							"slider_bgposition" => array (
								"type"	=> 'select',
								"label" => __('Background Position', $tid),
								"id"	=> $shortname . '_slider_bg_pos',
								"option"=> array('Left Top', 'Left Center', 'Left Bottom', 'Center Top', 'Center Center', 'Center Bottom', 'Right Top', 'Right Center', 'Right Bottom'),
								"std"	=> 'Left Top',
								"desc"	=> '',
							),
							
							"slider_bgattachment" => array (
								"type"	=> 'select',
								"label" => __('Background Attachment', $tid),
								"id"	=> $shortname . '_slider_bg_attach',
								"option"=> array('Scroll', 'Fixed', 'Inherit'),
								"std"	=> 'Scroll',
								"desc"	=> '',
							),
							
							"slider_bgrepeat" => array (
								"type"	=> 'select',
								"label" => __('Background Repeat', $tid),
								"id"	=> $shortname . '_slider_bg_repeat',
								"option"=> array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'),
								"std"	=> 'repeat',
								"desc"	=> '',
							),
							
						"sliderclear2" => array(
							"type" => 'clear_float',
						),
						
						"wrap_sliderskin_close" => array(
							"type" => 'wraper_close',
						),
						
						
						"nivoslider_navbg" => array (
							"type"	=> 'color',
							"label" => __('Nivo slider navigation background color (on normal)', $tid),
							"id"	=> $shortname . '_nivoslider_navbg',
							"std" => 'bfbfbf',
							"desc" => '',
						),
						
						"nivoslider_navbg_active" => array (
							"type"	=> 'color',
							"label" => __('Nivo slider navigation background color (on active)', $tid),
							"id"	=> $shortname . '_nivoslider_navbg_active',
							"std" => '2999e9',
							"desc" => '',
						),
						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'homepage_slider_skin',
						"reset"	=> false,
					),
			),
			"footer_widget_skin" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
					
						"wrap_fwskin" => array(
							"type" => 'wraper',
							"label" => __('Footer widgets area background color and image', $tid),
							"area" => 'wrap_fwskin',
						),

						"fwbgcolor" => array (
							"type"	=> 'color',
							"label" => __('Background Color', $tid),
							"id"	=> $shortname . '_fwbgcolor',
							"std" => '636363',
							"desc" => '',
						),
						
						"fwbgimage" => array (
							"type"	=> 'upload_background',
							"label" => __('background image', $tid),
							"id"	=> $shortname . '_fwbgimage',
							"desc" => '',
						),
						
						"bfclear" => array(
							"type" => 'clear_float',
						),
						
							"fw_bgposition" => array (
								"type"	=> 'select',
								"label" => __('Background Position', $tid),
								"id"	=> $shortname . '_fw_bg_pos',
								"option"=> array('Left Top', 'Left Center', 'Left Bottom', 'Center Top', 'Center Center', 'Center Bottom', 'Right Top', 'Right Center', 'Right Bottom'),
								"std"	=> 'Left Top',
								"desc"	=> '',
							),
							
							"fw_bgattachment" => array (
								"type"	=> 'select',
								"label" => __('Background Attachment', $tid),
								"id"	=> $shortname . '_fw_bg_attach',
								"option"=> array('Scroll', 'Fixed', 'Inherit'),
								"std"	=> 'Scroll',
								"desc"	=> '',
							),
							
							"fw_bgrepeat" => array (
								"type"	=> 'select',
								"label" => __('Background Repeat', $tid),
								"id"	=> $shortname . '_fw_bg_repeat',
								"option"=> array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'),
								"std"	=> 'repeat',
								"desc"	=> '',
							),
							
						"fwclear2" => array(
							"type" => 'clear_float',
						),
						
						"wrap_fwskin_close" => array(
							"type" => 'wraper_close',
						),

						"fwwidgettitlecolor" => array (
							"type"	=> 'color',
							"label" => __('Widget title font color', $tid),
							"id"	=> $shortname . '_fwwidget_titlecolor',
							"std" => 'e0e0e0',
							"desc" => '',
						),

						"fwwidgetbordercolor" => array (
							"type"	=> 'color',
							"label" => __('Widget title border color', $tid),
							"id"	=> $shortname . '_fwwidget_title_bordercolor',
							"std" => '828282',
							"desc" => '',
						),

						"fwheadingfontcolor" => array (
							"type"	=> 'color',
							"label" => __('Heading Font Color (H1 - H6) for this area', $tid),
							"id"	=> $shortname . '_fwheading_fontcolor',
							"std" => 'c2c2c2',
							"desc" => '',
						),
					
						"fwbodyfontcolor" => array (
							"type"	=> 'color',
							"label" => __('Content/Text Font Color for this area', $tid),
							"id"	=> $shortname . '_fwbody_fontcolor',
							"std" => 'bababa',
							"desc" => '',
						),
						
						"fwlinkcolor" => array (
							"type"	=> 'color',
							"label" => __('Link font color for this area', $tid),
							"id"	=> $shortname . '_fw_link_color',
							"std" => 'c2c2c2',
							"desc" => '',
						),
						
						"fwlinkhovercolor" => array (
							"type"	=> 'color',
							"label" => __('Link font color on hover for this area', $tid),
							"id"	=> $shortname . '_fw_link_hovercolor',
							"std" => 'ededed',
							"desc" => '',
						),
						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'footer_widget_skin',
						"reset"	=> false,
					),
			),
			"copyright_area_skin" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
					
						"wrap_crskin" => array(
							"type" => 'wraper',
							"label" => __('Copyright area background color and image', $tid),
							"area" => 'wrap_crskin',
						),

						"crbgcolor" => array (
							"type"	=> 'color',
							"label" => __('Background Color', $tid),
							"id"	=> $shortname . '_crbgcolor',
							"std" => '2e2e2e',
							"desc" => '',
						),
						
						"crbgimage" => array (
							"type"	=> 'upload_background',
							"label" => __('background image', $tid),
							"id"	=> $shortname . '_crbgimage',
							"desc" => '',
						),
						
						"crclear" => array(
							"type" => 'clear_float',
						),
						
							"cr_bgposition" => array (
								"type"	=> 'select',
								"label" => __('Background Position', $tid),
								"id"	=> $shortname . '_cr_bg_pos',
								"option"=> array('Left Top', 'Left Center', 'Left Bottom', 'Center Top', 'Center Center', 'Center Bottom', 'Right Top', 'Right Center', 'Right Bottom'),
								"std"	=> 'Left Top',
								"desc"	=> '',
							),
							
							"cr_bgattachment" => array (
								"type"	=> 'select',
								"label" => __('Background Attachment', $tid),
								"id"	=> $shortname . '_cr_bg_attach',
								"option"=> array('Scroll', 'Fixed', 'Inherit'),
								"std"	=> 'Scroll',
								"desc"	=> '',
							),
							
							"cr_bgrepeat" => array (
								"type"	=> 'select',
								"label" => __('Background Repeat', $tid),
								"id"	=> $shortname . '_cr_bg_repeat',
								"option"=> array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'),
								"std"	=> 'repeat',
								"desc"	=> '',
							),
							
						"crclear2" => array(
							"type" => 'clear_float',
						),
						
						"wrap_crskin_close" => array(
							"type" => 'wraper_close',
						),
					
						"crbodyfontcolor" => array (
							"type"	=> 'color',
							"label" => __('Text Font Color for this area', $tid),
							"id"	=> $shortname . '_crbody_fontcolor',
							"std" => 'bcc3c4',
							"desc" => '',
						),
						
						"crlinkcolor" => array (
							"type"	=> 'color',
							"label" => __('Link font color for this area', $tid),
							"id"	=> $shortname . '_cr_link_color',
							"std" => '2999e9',
							"desc" => '',
						),
						
						"crlinkhovercolor" => array (
							"type"	=> 'color',
							"label" => __('Link font color on hover for this area', $tid),
							"id"	=> $shortname . '_cr_link_hovercolor',
							"std" => 'AAAAAA',
							"desc" => '',
						),
						
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'copyright_area_skin',
						"reset"	=> false,
					),
			),
			"product_section" => array(
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),

					"product_lists_label" => array(
						"type"	=> 'label',
						"first-row" => true,
						"label" => __('Settings for product listing', $tid),
					),

					"ribbonsale" => array (
						"type"	=> 'color',
						"label" => __('"Sale" ribbon background color', $tid),
						"id"	=> $shortname . '_sale_ribbon_bg',
						"std" => '2999e9',
						"desc" => '',
					),

					"ribbonsalefonr" => array (
						"type"	=> 'color',
						"label" => __('"Sale" ribbon font color', $tid),
						"id"	=> $shortname . '_sale_ribbon_font',
						"std" => 'fafafa',
						"desc" => '',
					),

					"priceareabg" => array (
						"type"	=> 'color',
						"label" => __('Price area background color', $tid),
						"id"	=> $shortname . '_price_area_bg',
						"std" => '4f4f4f',
						"desc" => '',
					),

					"actualpricefont" => array (
						"type"	=> 'color',
						"label" => __('Price font color', $tid),
						"id"	=> $shortname . '_actual_price_font',
						"std" => 'f7f7f7',
						"desc" => 'Price font color',
					),

					
					"product_lists_label_single" => array(
						"type"	=> 'label',
						"first-row" => true,
						"label" => __('Settings for single product page', $tid),
					),


					"single_shoppage_price" => array (
						"type"	=> 'radio',
						"label" => __('Product Price Ribbon Color', $tid),
						"id"	=> $shortname . '_single_shoppage_price',
						"desc"	=> __('Select the ribbon color that match with your site style.', $tid),
						"std"	=> "dark",
						"option" => array( __('Dark', $tid), __('Red', $tid), __('Orange', $tid), __('Green', $tid), __('Blue', $tid), __('Yellow', $tid) ),
						"choosen" => array('dark', 'red', 'orange', 'green', 'blue', 'yellow'),
					),

					"variable_product_price_bg" => array (
						"type"	=> 'color',
						"label" => __('"Variable product" price background color', $tid),
						"id"	=> $shortname . '_variable_product_price_bg',
						"std" => 'f3f3f3',
						"desc" => __('Background color of variable product price', 'wip'),
					),

					"variable_product_price_color" => array (
						"type"	=> 'color',
						"label" => __('"Variable product" price font color', $tid),
						"id"	=> $shortname . '_variable_product_price_color',
						"std" => '2999e9',
						"desc" => __('Font color of variable product price', 'wip'),
					),
					
					"addviewopbuttonsingle" => array (
						"type"	=> 'color',
						"label" => __('"Add to cart" button background color on single product page', $tid),
						"id"	=> $shortname . '_addtocart_single_bg',
						"std" => '2999e9',
						"desc" => '',
					),

					"addviewopbuttoncolorsingle" => array (
						"type"	=> 'color',
						"label" => __('"Add to cart" button font color on single product page', $tid),
						"id"	=> $shortname . '_addtocart_single_font',
						"std" => 'fcfcfc',
						"desc" => '',
					),

					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'product_section',
						"reset"	=> false,
					),
			),
		),
		"options" => array(
		
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),
					
					"skinlayout" => array (
						"type"	=> 'radio',
						"label" => __('Layout Style', $tid),
						"id"	=> $shortname . '_skinlayout',
						"desc"	=> __('Select a layout style, stretched or boxed layout', $tid),
						"std"	=> "box",
						"option" => array( __('Stretched Layout', $tid), __('Boxed Layout', $tid) ),
						"choosen" => array('full', 'box'),
					),
					
						"wrap_allbackgroundcolor" => array(
							"type" => 'wraper',
							"label" => __('Outer area skin settings for boxed layout', $tid),
							"area" => 'form_for_bd_allbackgroundcolor',
						),
						
						"allbackgroundcolor" => array (
							"type"	=> 'color',
							"label" => __('background color', $tid),
							"id"	=> $shortname . '_allbackgroundcolor',
							"std" => 'e8e8e8',
						),
						
						"allbackgroundimage" => array (
							"type"	=> 'upload_background',
							"label" => __('background image', $tid),
							"id"	=> $shortname . '_allbackgroundimage',
							"desc" => '',
						),
						
							"allbackground_bgposition" => array (
								"type"	=> 'select',
								"label" => __('Background Position', $tid),
								"id"	=> $shortname . '_allbackground_bg_pos',
								"option"=> array('Left Top', 'Left Center', 'Left Bottom', 'Center Top', 'Center Center', 'Center Bottom', 'Right Top', 'Right Center', 'Right Bottom'),
								"std"	=> 'Left Top',
								"desc"	=> '',
							),
							
							"allbackground_bgattachment" => array (
								"type"	=> 'select',
								"label" => __('Background Attachment', $tid),
								"id"	=> $shortname . '_allbackground_bg_attach',
								"option"=> array('Scroll', 'Fixed', 'Inherit'),
								"std"	=> 'Scroll',
								"desc"	=> '',
							),
							
							"allbackground_bgrepeat" => array (
								"type"	=> 'select',
								"label" => __('Background Repeat', $tid),
								"id"	=> $shortname . '_allbackground_bg_repeat',
								"option"=> array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'),
								"std"	=> 'repeat',
								"desc"	=> '',
							),
						
						"wrap_allbackgroundcolor_close" => array(
							"type" => 'wraper_close',
						),

			
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'layout_and_style',
						"reset"	=> false,
					),
					
		),
	);



	$WIPopt['site_elements'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/tools.png',
		"options" => array(
		
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),


					"logo_position" => array (
						"type"	=> 'radio',
						"label" => __('Logo position', $tid),
						"id"	=> $shortname . '_logo_position',
						"desc"	=> '',
						"std"	=> "left",
						"option" => array( __('Left', $tid), __('Right', $tid), __('Center', $tid) ),
						"choosen" => array('left', 'right', 'center'),
					),

					"top_search_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the top search bar?', $tid),
						"id"	=> $shortname . '_top_search_off',
						"desc"	=> '',
						"std"	=> "0",
					),

					"top_links_beforesearch_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the links before top search form', $tid),
						"id"	=> $shortname . '_top_links_beforesearch_off',
						"desc"	=> __('Turn off the links before search form? However, these links only shown when woocommerce active', 'wip'),
						"std"	=> "1",
					),

					"top_shoppingcart_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the top shopping cart', $tid),
						"id"	=> $shortname . '_top_shoppingcart_off',
						"desc"	=> __('Turn off the top shopping cart? However, this shopping cart only shown when woocommerce active', 'wip'),
						"std"	=> "1",
					),

					"top_productsearch_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the "product search" form', $tid),
						"id"	=> $shortname . '_top_productsearch_off',
						"desc"	=> __('Turn off the "product search" form after page title in shop sections? However, this form only shown when woocommerce active', 'wip'),
						"std"	=> "1",
					),

					"footer_widget_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the footer widgets area', $tid),
						"id"	=> $shortname . '_footer_widget_off',
						"desc"	=> '',
						"std"	=> "1",
					),


					"blog_related_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the related posts in blog', $tid),
						"id"	=> $shortname . '_blog_related_off',
						"desc"	=> '',
						"std"	=> "1",
					),

					"portfolio_related_off" => array (
						"type"	=> 'onecheck',
						"label" => __('Turn off the related projects in portfolio', $tid),
						"id"	=> $shortname . '_portfolio_related_off',
						"desc"	=> '',
						"std"	=> "1",
					),
					

					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'site_elements',
						"reset"	=> true,
					),
					
		),
	);
	
	
	
	$WIPopt['shop_page'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/commerce.png',
		"options" => array(
		
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),	

					
					"shoppage_layout" => array (
						"type"	=> 'radio',
						"label" => __('Shop page layout', $tid),
						"id"	=> $shortname . '_shoppage_layout',
						"desc"	=> __('Select a layout style, for main shop page. Page content manager will not works for this page, since woocommerce handle the content from plugin\'s function!', $tid),
						"std"	=> "content-sidebar",
						"option" => array( __('Content - Sidebar', $tid), __('Sidebar - Content', $tid), __('Fullwidth (no sidebar)', $tid) ),
						"choosen" => array('content-sidebar', 'sidebar-content', 'fullwidth'),
					),
						
						"shoppage_columns" => array (
							"type"	=> 'select',
							"label" => __('Number of columns', $tid),
							"id"	=> $shortname . '_shoppage_columns',
							"option"=> array('2', '3', '4', '5'),
							"desc"	=> '',
							"std"	=> "4",
						),
						
						
						"shoppage_sidebar" => array (
							"type"	=> 'select',
							"label" => __('Select a sidebar', $tid),
							"id"	=> $shortname . '_shoppage_sidebar',
							"option"=> $sidebarOpt,
							"desc"	=> '',
							"std"	=> "Default Sidebar",
						),
					
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'shop_page',
						"reset"	=> true,
					),
					
		),
	);



	$WIPopt['posts_per_page'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/diagram.png',
		"options" => array(
		
					"form" => array(
						"type" => 'form',
						"ajax" => true,
					),	

						
					"shoppage_postperpage" => array (
						"type"	=> 'text',
						"label" => __('Posts per page for shop sections.', $tid),
						"id"	=> $shortname . '_shoppage_postperpage',
						"desc"	=> __("This setting will also take affect into product tag archive, product category archive, search results for product and any other product related archive pages"),
						"std"	=> "12",
					),


					"blocat_postperpage" => array (
						"type"	=> 'text',
						"label" => __('Posts per page for blog category.', $tid),
						"id"	=> $shortname . '_blocat_postperpage',
						"desc"	=> __("This setting will also take affect into blog tag archive, date archive and any other blog related archive pages"),
						"std"	=> "5",
					),

					"portfoliocat_postperpage" => array (
						"type"	=> 'text',
						"label" => __('Posts per page for portfolio category.', $tid),
						"id"	=> $shortname . '_portfoliocat_postperpage',
						"desc"	=> '',
						"std"	=> "12",
					),


					"search_postperpage" => array (
						"type"	=> 'text',
						"label" => __('Posts per page for search results page.', $tid),
						"id"	=> $shortname . '_search_postperpage',
						"desc"	=> '',
						"std"	=> "6",
					),
						

					
					"close_form" => array (
						"type"	=> 'close_form',
						"part" => 'posts_per_page',
						"reset"	=> true,
					),
					
		),
	);
	
	
	
	$WIPopt['slider_settings'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/right.png',
		"child" => array(
			"first" => array(
				"title" => __('General Config', $tid)
			),
			"nivo_slider_settings" => array(
			
				"form" => array(
					"type" => 'form',
					"ajax" => true,
				),
				
				"slidereffect" => array (
					"type"	=> 'selectid',
					"label" => __('Select an effect for nivoslider', $tid),
					"id"	=> $shortname . '_nivo_effect',
					"option"=> array('Random', 'Slice Down', 'Slide Down Left', 'Slice Up', 'Slice Up Left', 'Slice Up Down', 'Slide Up Down Left', 'Fold', 'Fade', 'Slide In Right', 'Slide In Left', 'Box Random', 'Box Rain', 'Box Rain Reserve', 'Box Rain Grow', 'Box Rain Grow Reserve'),
					"choosen" => array('random', 'sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade', 'slideInRight', 'slideInLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse'),
					"std"	=> 'random',
					"desc"	=> __('Define the effect, default is "random"', $tid),
				),
				
				"animate_time" => array (
					"type"	=> 'text',
					"label" => __('Animation time', $tid),
					"id"	=> $shortname . '_nivo_speed',
					"desc"	=> __('Animated time for each object &raquo; 1000 = 1 second', $tid),
					"std"	=> "500",
				),
						
				"nivo_slide_delay" => array (
					"type"	=> 'text',
					"label" => __('Delay', $tid),
					"id"	=> $shortname . '_nivo_delay',
					"desc"	=> __('Delay/Pause time between slider object &raquo; 1000 = 1 second', $tid),
					"std"	=> "6000",
				),
						
				"nivoslice" => array (
					"type"	=> 'text',
					"label" => __('Slice', $tid),
					"id"	=> $shortname . '_nivo_slices',
					"desc"	=> __('Define the slices for each image, default is 15', $tid),
					"std"	=> "15",
				),
				
				"nivoboxcols" => array (
					"type"	=> 'text',
					"label" => __('Box Cols', $tid),
					"id"	=> $shortname . '_nivo_boxCols',
					"desc"	=> __('Use for box animations. Define number of box cols', $tid),
					"std"	=> "8",
				),
				
				"nivoboxrows" => array (
					"type"	=> 'text',
					"label" => __('Box Rows', $tid),
					"id"	=> $shortname . '_nivo_boxRows',
					"desc"	=> __('Use for box animations. Define number of box rows', $tid),
					"std"	=> "4",
				),
				
				"nivocap" => array (
					"type"	=> 'select',
					"label" => __('Caption opacity', $tid),
					"id"	=> $shortname . '_nivo_opacity',
					"option"=> array('0.5', '0.6', '0.7', '0.8', '0.9', '1.00'),
					"std"	=> '0.8',
					"desc"	=> __('Define the opacity of the caption.', $tid),
				),
				
				"nivo_hoverpause" => array (
					"type"	=> 'onecheck',
					"label" => __('Hover Pause', $tid),
					"id"	=> $shortname . '_nivo_hoverpause',
					"desc"	=> __('Pause the animation on Hover', $tid),
					"std"	=> "1",
				),
		
				"close_form" => array (
					"type"	=> 'close_form',
					"part" => 'nivo_slider_settings',
					"reset"	=> true,
				),
			),
			"piecemaker_2_settings" => array(
			
				"form" => array(
					"type" => 'form',
					"ajax" => true,
				),
				
				"pc_LoaderColor" => array (
					"type"	=> 'color',
					"label" => __('Loader Color', $tid),
					"id"	=> $shortname . '_pc_LoaderColor',
					"std" => '333333',
					"desc" => __('Color of the cubes before the first image appears, also the color of the back sides of the cube, which become visible at some transition types', $tid),
				),
				
				"pc_InnerSideColor" => array (
					"type"	=> 'color',
					"label" => __('Inner Side Color', $tid),
					"id"	=> $shortname . '_pc_InnerSideColor',
					"std" => '222222',
					"desc" => __('Color of the inner sides of the cube when sliced', $tid),
				),
				
				"pc_SideShadowAlpha" => array (
					"type"	=> 'text',
					"label" => __('Side Shadow Alpha', $tid),
					"id"	=> $shortname . '_pc_SideShadowAlpha',
					"std" => '0.8',
					"desc" => __('Sides get darker when moved away from the front. This is the degree of darkness. 0 == no change, 1 == 100% black', $tid),
				),
				
				"pc_DropShadowAlpha" => array (
					"type"	=> 'text',
					"label" => __('Drop Shadow Alpha', $tid),
					"id"	=> $shortname . '_pc_DropShadowAlpha',
					"std" => '0.7',
					"desc" => __('Alpha of the drop shadow. 0 == no shadow, 1 == opaque', $tid),
				),
				
				"pc_DropShadowDistance" => array (
					"type"	=> 'text',
					"label" => __('Drop Shadow Distance', $tid),
					"id"	=> $shortname . '_pc_DropShadowDistance',
					"std" => '25',
					"desc" => __('Distance of the shadow from the bottom of the image', $tid),
				),
				
				"pc_DropShadowScale" => array (
					"type"	=> 'text',
					"label" => __('Drop Shadow Scale', $tid),
					"id"	=> $shortname . '_pc_DropShadowScale',
					"std" => '0.95',
					"desc" => __('The value should between 0 and 1. 1 would be no resizing at all', $tid),
				),
				
				"pc_DropShadowBlurX" => array (
					"type"	=> 'text',
					"label" => __('Drop Shadow Blur X', $tid),
					"id"	=> $shortname . '_pc_DropShadowBlurX',
					"std" => '40',
					"desc" => __('Blur of the drop shadow on the x-axis', $tid),
				),
				
				"pc_DropShadowBlurY" => array (
					"type"	=> 'text',
					"label" => __('Drop Shadow Blur Y', $tid),
					"id"	=> $shortname . '_pc_DropShadowBlurY',
					"std" => '4',
					"desc" => __('Blur of the drop shadow on the y-axis', $tid),
				),
				
				"pc_MenuDistanceX" => array (
					"type"	=> 'text',
					"label" => __('Menu Distance X', $tid),
					"id"	=> $shortname . '_pc_MenuDistanceX',
					"std" => '20',
					"desc" => __('Distance between two menu items (from center to center)', $tid),
				),
				
				"pc_MenuDistanceY" => array (
					"type"	=> 'text',
					"label" => __('Menu Distance Y', $tid),
					"id"	=> $shortname . '_pc_MenuDistanceY',
					"std" => '50',
					"desc" => __('Distance of the menu from the bottom of the image', $tid),
				),
				
				"pc_MenuColor1" => array (
					"type"	=> 'color',
					"label" => __('Menu Color 1', $tid),
					"id"	=> $shortname . '_pc_MenuColor1',
					"std" => '999999',
					"desc" => __('Color of an inactive menu item', $tid),
				),
				
				"pc_MenuColor2" => array (
					"type"	=> 'color',
					"label" => __('Menu Color 2', $tid),
					"id"	=> $shortname . '_pc_MenuColor2',
					"std" => '333333',
					"desc" => __('Color of an active menu item', $tid),
				),
				
				"pc_MenuColor3" => array (
					"type"	=> 'color',
					"label" => __('Menu Color 3', $tid),
					"id"	=> $shortname . '_pc_MenuColor3',
					"std" => 'FFFFFF',
					"desc" => __('Color of the inner circle of an active menu item. Should equal the background color of the whole thing.', $tid),
				),
				
				"pc_ControlSize" => array (
					"type"	=> 'text',
					"label" => __('Control Size', $tid),
					"id"	=> $shortname . '_pc_ControlSize',
					"std" => '100',
					"desc" => __('Size of the controls, which appear on rollover (play, stop, info, link)', $tid),
				),
				
				"pc_ControlDistance" => array (
					"type"	=> 'text',
					"label" => __('Control Distance', $tid),
					"id"	=> $shortname . '_pc_ControlDistance',
					"std" => '20',
					"desc" => __('Distance between the controls (from the borders)', $tid),
				),
				
				"pc_ControlColor1" => array (
					"type"	=> 'color',
					"label" => __('Control Color 1', $tid),
					"id"	=> $shortname . '_pc_ControlColor1',
					"std" => '222222',
					"desc" => __('Background color of the controls', $tid),
				),
				
				"pc_ControlColor2" => array (
					"type"	=> 'color',
					"label" => __('Control Color 2', $tid),
					"id"	=> $shortname . '_pc_ControlColor2',
					"std" => 'FFFFFF',
					"desc" => __('Font color of the controls', $tid),
				),
				
				"pc_ControlAlpha" => array (
					"type"	=> 'text',
					"label" => __('Control Alpha', $tid),
					"id"	=> $shortname . '_pc_ControlAlpha',
					"std" => '0.8',
					"desc" => __('Alpha of a control, when mouse is not over', $tid),
				),
				
				"pc_ControlAlphaOver" => array (
					"type"	=> 'text',
					"label" => __('Control Alpha Over', $tid),
					"id"	=> $shortname . '_pc_ControlAlphaOver',
					"std" => '0.95',
					"desc" => __('Alpha of a control, when mouse is over', $tid),
				),
				
				"pc_TooltipHeight" => array (
					"type"	=> 'text',
					"label" => __('Tooltip Height', $tid),
					"id"	=> $shortname . '_pc_TooltipHeight',
					"std" => '32',
					"desc" => __('Height of the tooltip surface in the menu', $tid),
				),
				
				"pc_TooltipColor" => array (
					"type"	=> 'color',
					"label" => __('Tooltip Color', $tid),
					"id"	=> $shortname . '_pc_TooltipColor',
					"std" => '222222',
					"desc" => __('Color of the tooltip surface in the menu', $tid),
				),
				
				"pc_TooltipTextColor" => array (
					"type"	=> 'color',
					"label" => __('Tooltip Text Color', $tid),
					"id"	=> $shortname . '_pc_TooltipTextColor',
					"std" => 'FFFFFF',
					"desc" => __('Color of the tooltip text', $tid),
				),
				
				"pc_TooltipTextSharpness" => array (
					"type"	=> 'text',
					"label" => __('Tooltip Text Sharpness', $tid),
					"id"	=> $shortname . '_pc_TooltipTextSharpness',
					"std" => '50',
					"desc" => __('Sharpness of the tooltip text (-400 to 400)', $tid),
				),
				
				"pc_TooltipTextThickness" => array (
					"type"	=> 'text',
					"label" => __('Tooltip Text Thickness', $tid),
					"id"	=> $shortname . '_pc_TooltipTextThickness',
					"std" => '-100',
					"desc" => __('Thickness of the tooltip text (-400 to 400)', $tid),
				),
				
				"pc_InfoWidth" => array (
					"type"	=> 'text',
					"label" => __('Info Width', $tid),
					"id"	=> $shortname . '_pc_InfoWidth',
					"std" => '400',
					"desc" => __('The width of the info text field', $tid),
				),
				
				"pc_InfoBackground" => array (
					"type"	=> 'color',
					"label" => __('Info Background', $tid),
					"id"	=> $shortname . '_pc_InfoBackground',
					"std" => 'FFFFFF',
					"desc" => __('The background color of the info text field', $tid),
				),
				
				"pc_InfoBackgroundAlpha" => array (
					"type"	=> 'text',
					"label" => __('Info Background Alpha', $tid),
					"id"	=> $shortname . '_pc_InfoBackgroundAlpha',
					"std" => '0.95',
					"desc" => __('The alpha of the background of the info text. The image shines through, when smaller than 1', $tid),
				),
				
				"pc_Autoplay" => array (
					"type"	=> 'text',
					"label" => __('Autoplay', $tid),
					"id"	=> $shortname . '_pc_Autoplay',
					"std" => '10',
					"desc" => __('Number of seconds from one transition to another, if not stopped. Set to 0 to disable autoplay', $tid),
				),

			
				"close_form" => array (
					"type"	=> 'close_form',
					"part" => 'piecemaker_2_settings',
					"reset"	=> true,
				),
			),
		),
		"options" => array(
		
				"form" => array(
					"type" => 'form',
					"ajax" => true,
				),
				
				
				"slidertype" => array (
					"type"	=> 'radio',
					"label" => __('Select a slider', $tid),
					"id"	=> $shortname . '_slidertype',
					"desc"	=> '',
					"std"	=> "nivo",
					"option" => array( __('Piecemaker 2', $tid), __('Nivo Slider', $tid) ),
					"choosen" => array('flash', 'nivo'),
				),
				
				
				"sliderHeight" => array (
					"type"	=> 'text',
					"label" => __('Slider Height', $tid),
					"id"	=> $shortname . '_sliderHeight',
					"desc"	=> __('The Container Height of Slider, in pixels!', $tid),
					"std"	=> "400",
				),
		
				"close_form" => array (
					"type"	=> 'close_form',
					"part" => 'slider_settings',
					"reset"	=> true,
				),
		),
	);
	
	$WIPopt['slider_image'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/jquery_icon.png',
		"options" => array(
	
				"wipslider" => array (
					"type"	=> 'slider',
					"shortname" => $shortname,
				),
	
		),
	);
	

	$WIPopt['contact_form'] = array(
	
		"icon" => get_template_directory_uri().'/framework/images/letter.png',
		"options" => array(
		
				"form" => array(
					"type" => 'form',
					"ajax" => true,
				),
				
				"contact_label" => array(
					"type"	=> 'label',
					"first-row" => true,
					"label" => __('To use contact form, please enter the shortcode <strong>[contactform]</strong> in any page', $tid),
				),
				
				"cf_email" => array (
					"type"	=> 'text',
					"label" => __('Email address', $tid),
					"id"	=> $shortname . '_cf_email',
					"desc"	=> __('Enter the email address that will integrated with Contact form', $tid),
					"std"	=> get_option('admin_email'),
				),
				
				"cf_success" => array (
					"type"	=> 'text',
					"label" => __('Success message', $tid),
					"id"	=> $shortname . '_cf_success',
					"desc"	=> __('Enter the success message.', $tid),
					"std"	=> 'Thankyou, your message has been sent!',
				),
				
				"cf_auto" => array (
					"type"	=> 'onecheck',
					"label" => __('Use Auto Responder?', $tid),
					"id"	=> $shortname . '_cf_auto',
					"desc"	=> '',
					"std"	=> "0",
				),
				
				"cf_subject_res" => array (
					"type"	=> 'text',
					"label" => __('Auto responder email subject', $tid),
					"id"	=> $shortname . '_cf_subject_res',
					"desc"	=> __('Enter the auto responder email subject', $tid),
					"std"	=> 'Thankyou for contacting me!',
				),
				
				"cf_auto_res" => array (
					"type"	=> 'textarea',
					"label" => __('Auto Responder message', $tid),
					"id"	=> $shortname . '_cf_auto_res',
					"desc"	=> __('Enter the auto responder message,<br/>use {name} &raquo; automatically change with the sender\'s name<br/>and {email} &raquo; automatically change with the sender\'s email address', $tid),
					"std"	=> "Hello {name} - {email},". Chr(13) . Chr(13) ."Thankyou for contacting me via contact form in my contact page. I will make respond into your message as soon as possible" . Chr(13) . Chr(13) . "Sincerely," . Chr(13) . "Site Owner.",
				),
	
				"close_form" => array (
					"type"	=> 'close_form',
					"part" => 'contact_form',
					"reset"	=> true,
				),
		),
	);
	
	$WIPopt['social_icons'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/tw.png',
		"options" => array(
	
				"wipico" => array (
					"type"	=> 'upload_icons',
					"shortname" => $shortname,
				),
	
		),
	);
	
	$WIPopt['custom_sidebar'] = array(
		
		"icon" => get_template_directory_uri().'/framework/images/monitor_32.png',
		"options" => array(
	
				"wipsidebar" => array (
					"type"	=> 'add_sidebar',
					"shortname" => $shortname,
				),
	
		),
	);
	

	$Options = $WIPopt;


	return $Options;
}

?>