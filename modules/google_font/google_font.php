<?php

function wip_get_google_font_lists(){
	$font = file_get_contents( get_template_directory() . '/modules/google_font/google_font.txt' );
	
	return unserialize($font);
}


function standardFont(){

	$font = array(
		'Arial' => array(
			'font-family' => 'font-family : Arial, tahoma, sans-serif;',
			'font-name' => 'Arial',
			'css-name' => 'arial',
		),
		'Tahoma' => array(
			'font-family' => 'font-family : Tahoma, arial, sans-serif;',
			'font-name' => 'Tahoma',
			'css-name' => 'tahoma',
		),
		'Georgia' =>array(
			'font-family' => 'font-family : Georgia, serif;',
			'font-name' => 'Georgia',
			'css-name' => 'georgia',
		),
		'Bookman Old Style' =>array(
			'font-family' => 'font-family : \'Bookman Old Style\', serif;',
			'font-name' => 'Bookman Old Style',
			'css-name' => 'Bookman Old Style',
		),
		'Courier' =>array(
			'font-family' => 'font-family : Courier, monospace;',
			'font-name' => 'Courier',
			'css-name' => 'courier',
		),
		'Courier New' =>array(
			'font-family' => 'font-family : \'Courier New\', Courier, monospace;',
			'font-name' => 'Courier New',
			'css-name' => 'courier new',
		),
		'Garamond' =>array(
			'font-family' => 'font-family : Garamond, serif;',
			'font-name' => 'Garamond',
			'css-name' => 'garamond',
		),
		'Impact' =>array(
			'font-family' => 'font-family : Impact, Charcoal, sans-serif;',
			'font-name' => 'Impact',
			'css-name' => 'Impact',
		),
		'Lucida Console' =>array(
			'font-family' => 'font-family : \'Lucida Console\', Monaco, monospace;',
			'font-name' => 'Lucida Console',
			'css-name' => 'Lucida Console',
		),
		'Lucida Sans Unicode' =>array(
			'font-family' => 'font-family : \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;',
			'font-name' => 'Lucida Sans Unicode',
			'css-name' => 'Lucida Sans Unicode',
		),
		'MS Sans Serif' =>array(
			'font-family' => 'font-family : \'MS Sans Serif\', Geneva, sans-serif;',
			'font-name' => 'MS Sans Serif',
			'css-name' => 'MS Sans Serif',
		),
		'MS Serif' =>array(
			'font-family' => 'font-family : \'MS Serif\', \'New York\', sans-serif;',
			'font-name' => 'MS Serif',
			'css-name' => 'MS Serif',
		),
		'Palatino Linotype' =>array(
			'font-family' => 'font-family : \'Palatino Linotype\', \'Book Antiqua\', Palatino, serif;',
			'font-name' => 'Palatino Linotype',
			'css-name' => 'Palatino Linotype',
		),
		'Times New Roman' =>array(
			'font-family' => 'font-family : \'Times New Roman\', Times, serif;',
			'font-name' => 'Times New Roman',
			'css-name' => 'Times New Roman',
		),
		'Trebuchet MS' =>array(
			'font-family' => 'font-family : \'Trebuchet MS\', Helvetica, sans-serif;',
			'font-name' => 'Trebuchet MS',
			'css-name' => 'Trebuchet MS',
		),
		'Verdana' =>array(
			'font-family' => 'font-family : Verdana, Geneva, sans-serif;',
			'font-name' => 'Verdana',
			'css-name' => 'Verdana',
		),
		'Webdings' =>array(
			'font-family' => 'font-family : Webdings, sans-serif;',
			'font-name' => 'Webdings',
			'css-name' => 'Webdings',
		)
	);
	
	return $font;

}


function _standardFontnameArray(){
	$standard = array('Arial', 'Tahoma', 'Georgia','Bookman Old Style','Courier','Courier New','Garamond','Impact','Lucida Console','Lucida Sans Unicode','MS Sans Serif','MS Serif','Palatino Linotype','Times New Roman','Trebuchet MS','Verdana','Webdings');
	
	return $standard;
}