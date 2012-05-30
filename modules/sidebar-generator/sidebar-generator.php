<?php
/*
Plugin Name: Sidebar Generator
Plugin URI: http://www.getson.info
Description: This plugin generates as many sidebars as you need. Then allows you to place them on any page you wish.
Version: 1.0.1
Author: Kyle Getson
Author URI: http://www.kylegetson.com
Copyright (C) 2009 Clickcom, Inc.
*/

/*
Copyright (C) 2009 Kyle Robert Getson, kylegetson.com and getson.info

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class wip_sidebar_generator {
	
	function wip_sidebar_generator() {
		add_action('init',array('wip_sidebar_generator','init'));		
	}
	
	function init(){
	    $sidebars = wip_sidebar_generator::get_sidebars();

	    if(is_array($sidebars)){
			$z=1;
			foreach($sidebars as $sidebar){
				$sidebar_class = wip_sidebar_generator::convert_class($sidebar);
				register_sidebar(array(
			    	'name'=>$sidebar,
					'before_widget' => '<div class="sidebarbox %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="sidebar-title"><span>',
					'after_title' => '</span></h3>',
		    	));	 $z++;
			}
		}
	}

	function get_sidebar($index){
		
		if( !dynamic_sidebar($index) ){

				if ( !dynamic_sidebar('Default Sidebar') ){
				?>
					<div class="sidebarbox widget_meta">		
						
						<h3 class="sidebar-title"><span>Meta</span></h3>
							<ul>
								<?php wp_register(); ?>
								<li><?php wp_loginout(); ?></li>
								<?php wp_meta(); ?>
							</ul>

					</div>
				<?php
				}			
		
		} 
		
	}
	
	/**
	 * gets the generated sidebars
	 */
	function get_sidebars(){
		$sidebars = get_option('bd_sidebar_gen');
		return $sidebars;
	}
	
	function convert_class($name){
		$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
		return $class;
	}
	
}
$wip_sidebar_generator = new wip_sidebar_generator;

function wip_generated_dynamic_sidebar($index){
	wip_sidebar_generator::get_sidebar($index);	
	return true;
}

/**	
 * Delete custom meta data, after custom sidebar deleted
 */
function autoDeleteMeta($sidebar_name){
	global $wpdb;
	
		$sidebar_meta = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$sidebar_name'", ARRAY_A);
		if ( is_array($sidebar_meta) ){
			foreach ($sidebar_meta as $key => $value) {
				delete_post_meta($value['post_id'], '_bd_sidebar_use');
			}
		}
	return;
}

?>