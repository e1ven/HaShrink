<?php

function add_shortcode_button() {
  
  if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
	 
   if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'add_shortcode_tinymce_plugin');
     add_filter('mce_buttons_3', 'register_shortcode_button');
   }
  
}
add_action('init', 'add_shortcode_button');


function register_shortcode_button($buttons) {
   array_push($buttons, "2_columns", "3_columns", "4_columns", "|", 
				"1-2-3_columns", "213_columns", "112_columns", "121_columns", "211_columns", "13_columns", "31_columns",
				"|", "divider", "dropcap", "quot_left", "quot_right", "|", "tabs", "toggle", "wip_video", "wip_button");
   return $buttons;
}

function add_shortcode_tinymce_plugin($plugin_array) {
   $plugin_array['wipshortcode'] = get_template_directory_uri().'/framework/js/shortcode/s_column.js';
   $plugin_array['wipactiveonselect'] = get_template_directory_uri().'/framework/js/shortcode/plugin_activeonselect.js';
   return $plugin_array;
}

