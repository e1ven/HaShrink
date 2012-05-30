<?php

require_once( get_template_directory() . '/framework/php/panel.options.php' );
require_once( get_template_directory() . '/framework/php/panel.class.php' );


/** handle upload image and delete image */
add_action('wp_ajax_wipanel_upload_action', 'WIPanel_ajax_callback');
add_action( 'wp_ajax_nopriv_wipanel_upload_action', 'WIPanel_ajax_callback' );
function WIPanel_ajax_callback() {
		global $wpdb;
		
		#check the type of form
		if($_POST['type']){
		
			$save_type = $_POST['type'];
			
		} else {
		
			$save_type = null;
			
		}
		
	
		# upload new image
		if( $save_type == 'upload' ) {
			
			#grab the data
			$clickedID = $_POST['name'];

			$arr_file_type = wp_check_filetype( basename( $_FILES[$clickedID]['name']));
			
			$uploaded_file_type = $arr_file_type['type'];
			
			# Set an array containing a list of acceptable formats
			$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
			$errorText = "";
			
			# if data is an image - upload it
			if( in_array( $uploaded_file_type, $allowed_file_types ) ) {
				
				# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
				$filename = $_FILES[$clickedID];
				$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				
				# upload process...
				$uploaded_file = wp_handle_upload( $filename, $override );
				$upload_tracking[] = $clickedID;
				
				if(!is_wp_error($uploaded_file)){
					
					$currentData = get_option($clickedID);
					
					$path_info = wp_upload_dir();
					
					$file_info = pathinfo( $uploaded_file['file'] );
					$image_filename = $file_info['filename'] .'.'. $file_info['extension'];
					$info_to_save = array(
						'subdir' => $path_info['subdir'],
						'type' => $uploaded_file_type,
						'image' => $image_filename
					);
					
					
					if( $currentData != "" && is_array($currentData) ){
						$thatFolder = $path_info['basedir'] . ( ( isset( $currentData['subdir'] ) && ($currentData['subdir'] != "") ) ? $currentData['subdir'] : '' );
						if( isset( $currentData['image'] ) && file_exists( $thatFolder.'/'.$currentData['image'] ) ){
							unlink( $thatFolder.'/'.$currentData['image'] );
						}
						
					}
					
					
					# at once, we save the option.
					update_option( $clickedID , $info_to_save );
					
					#get the height of image - use this for logo
					list($width, $height) = getimagesize($uploaded_file['file']);
					update_option( 'height_of_'.$clickedID , $height );
					
					$returnData = array(	
						"error" => false,
						"image" => $uploaded_file['url']
					);
					
					echo json_encode($returnData);
					
					die();
				
				} else {
					
					foreach( $uploaded_file as $error ){
						$errorText .= $error;
					}
					
					$returnData = array(	
						"error" => true,
						"errorText" => $errorText
					);
					
					echo json_encode($returnData);
					
					die();
				
				}
				
			} else {
				
				#if error
				$errorText .= __('Unsupported file type!', 'wip');
				
				$returnData = array(	
					"error" => true,
					"errorText" => $errorText
				);
				
				echo json_encode($returnData);
				
				die();
				
			}
		
		
		} elseif( $save_type == 'upload_bg' ){
			
			#grab the data
			$clickedID = $_POST['name'];

			$arr_file_type = wp_check_filetype( basename( $_FILES[$clickedID]['name']));
			
			$uploaded_file_type = $arr_file_type['type'];
			
			# Set an array containing a list of acceptable formats
			$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
			$errorText = "";
			
			# if data is an image - upload it
			if( in_array( $uploaded_file_type, $allowed_file_types ) ) {
				
				# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
				$filename = $_FILES[$clickedID];
				$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				
				# upload process...
				$uploaded_file = wp_handle_upload( $filename, $override );
				$upload_tracking[] = $clickedID;
				
				if(!is_wp_error($uploaded_file)){
					
					$returnData = array(	
						"error" => false,
						"image" => $uploaded_file['url']
					);
					
					echo json_encode($returnData);
					
					die();
				
				} else {
					
					foreach( $uploaded_file as $error ){
						$errorText .= $error;
					}
					
					$returnData = array(	
						"error" => true,
						"errorText" => $errorText
					);
					
					echo json_encode($returnData);
					
					die();
				
				}
				
			} else {
				
				#if error
				$errorText .= __('Unsupported file type!', 'wip');
				
				$returnData = array(	
					"error" => true,
					"errorText" => $errorText
				);
				
				echo json_encode($returnData);
				
				die();
				
			}
		
		
		} elseif( $save_type == 'image_reset' ){ #if user click "delete image" icon
			
			#detect the field name/id
			$id = $_POST['data'];
			$path_info = wp_upload_dir();
			
			$currentData = get_option($id);
			
			if( $currentData != "" && is_array($currentData) ){
				$thatFolder = $path_info['basedir'] . ( ( isset( $currentData['subdir'] ) && ($currentData['subdir'] != "") ) ? $currentData['subdir'] : '' );
				if( isset( $currentData['image'] ) && file_exists( $thatFolder.'/'.$currentData['image'] ) ){
					unlink( $thatFolder.'/'.$currentData['image'] );
				}
				
			}
			
			#at once, we update the data into NULL
			update_option( $id, null );
			
			delete_option('height_of_'.$id);
		
		}
		die();
};


add_action('wp_ajax_wipanel_upload_icon_action', 'WIPanel_ajax_icons_callback');
add_action( 'wp_ajax_nopriv_wipanel_upload_icon_action', 'WIPanel_ajax_icons_callback' );
function WIPanel_ajax_icons_callback() {
		global $wpdb;
		
		#check the type of form
		if( isset($_POST['type']) ){
		
			$save_type = $_POST['type'];
			
		} else {
		
			$save_type = null;
			
		}
	
		# upload new image
		if( $save_type == 'upload' ) {
			
			#grab the data
			if( !isset($_FILES['icon_upload']) ){
				$error = array(
					"error" => true,
					"errorText" => __('No image detected!', 'wip')
				);
				
				echo json_encode($error);	
				die();
			}

			$arr_file_type = wp_check_filetype( basename( $_FILES['icon_upload']['name']));
			
			$uploaded_file_type = $arr_file_type['type'];
			
			# Set an array containing a list of acceptable formats
			$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
			
			# if data is an image - upload it
			if( in_array( $uploaded_file_type, $allowed_file_types ) ) {
				
				# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
				$filename = $_FILES['icon_upload'];
				$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				
				# upload process...
				$uploaded_file = wp_handle_upload( $filename, $override );
				$upload_tracking[] = 'icon_upload';
			
			} else {
				
				#if error
				$uploaded_file['error'] = __('Unsupported file type!', 'wip');
				
			}
			
			if( !empty( $uploaded_file['error'] ) ) {
				
				$error = array(
					"error" => true,
					"errorText" => $uploaded_file['error']
				);
				
				echo json_encode($error);	
				die();
				
			} else {
			
				$path_info = wp_upload_dir();
				
				$file_info = pathinfo( $uploaded_file['file'] );
				$image_filename = $file_info['filename'] .'.'. $file_info['extension'];
				
				$info_to_save = array();
				$info_to_save[] = $path_info['subdir'];
				$info_to_save[] = $image_filename;
				
				$iconInfo = implode(',', $info_to_save);
					
				$return = array(
					"error" => false,
					"icon" => $uploaded_file['url'],
					"iconData" => $iconInfo
				);
				
				echo json_encode($return);	
				die();
				
			}
		
		
		} elseif( $save_type == 'image_reset' ){ #if user click "delete image" icon

			$data = isset( $_POST['data'] ) ? $_POST['data'] : '';
			
			if( $data != "" ){
				$path_info = wp_upload_dir();
				
				$ic = explode( ',' , $data );
				
				if( isset( $ic[0] ) && isset( $ic[1] ) ){
					$tF = $path_info['basedir'] . $ic[0] . '/' . $ic[1];
					
					if( file_exists( $tF ) ) unlink( $tF );
				
				}
				
			}
			
			die();
			
		} elseif( $save_type == 'add_icon' ){
			
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				#explode them to get each data, check http://php.net/manual/en/function.parse-str.php
				parse_str($data, $p);
			}
			
			$err_r = array();
			$error = false;
			
			if( $p['wip_icon_image'] == "" ){
				$error = true;
				$err_r[] = __('Please upload the icon!', 'wip');
			}
			
			if( $p['wip_icon_url'] == "" ){
				$error = true;
				$err_r[] = __('Please enter the URL!', 'wip');
			}
			
			if( $error ){
			
				$ert = '<ul>' . "\n";
				foreach( $err_r as $e ){
					$ert .= '<li>' . $e . '</li>' . "\n";
				}
				$ert .= '</ul>';
				
				$errorCallback = array(
					"error" => true,
					"errorText" => $ert
				);
				
				echo json_encode($errorCallback);	
				die();
				
			
			} else {
			
				$path_info = wp_upload_dir();
				$sn = $p['shortname'];
				$ic = explode( ',', $p['wip_icon_image'] );
				
				$icon_img = array(
					'subdir' => $ic[0],
					'file' => $ic[1]
				);
				$icon_url = $p['wip_icon_url'];
				$icon_text = wptexturize( $p['wip_icon_title'] );
				$iconToShow = $path_info['baseurl'] . $ic[0] . '/' . $ic[1];

				
				$toPost = array( "icon" => $icon_img, "text" => $icon_text, "link" => $icon_url);
				$curent = get_option($sn.'_fan_icons');
						
				if ( is_array($curent) ) {
							$new_icon[] = $toPost;
							$saved_icon = array_merge( (array)$curent, (array)$new_icon);	
				} else {
							$saved_icon[] = $toPost;
				}
						
				update_option( $sn.'_fan_icons' , $saved_icon );
				
				$callBack = array(
					"error" => false,
					"iconURL" => $iconToShow
				);
				
				echo json_encode($callBack);	
				die();
			}
		
		} elseif( $save_type == 'delete_icon' ){
		
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				parse_str($data, $p);
			}
			
			$icon_id = $p['data'];
			$sn = $p['shortname'];	
			
			$curent = get_option($sn.'_fan_icons');
						
			if( isset($curent[$icon_id]) ){
				$toDel = $curent[$icon_id];
				if( isset( $toDel['icon'] ) && is_array($toDel['icon']) ){
					$path_info = wp_upload_dir();
					$file = $path_info['basedir'] . $toDel['icon']['subdir'] . '/' . $toDel['icon']['file'];
					
					if( file_exists( $file ) ) unlink( $file );
				}
				
				
				if( count( $curent ) == '1' ){
					delete_option( $sn.'_fan_icons');
				} else {
					unset( $curent[$icon_id] );
								
					$saved_icon = $curent;
					update_option( $sn.'_fan_icons' , $saved_icon );
				}
			}
			
			
		} elseif( $save_type == 'uploadsscript' ) {
			
			#grab the data
			$clickedID = $_POST['data'];

			$arr_file_type = wp_check_filetype( basename( $_FILES[$clickedID]['name']));
			
			$uploaded_file_type = $arr_file_type['ext'];
			
			# if data is an image - upload it
			if( $uploaded_file_type == "js" ) {
				
				# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
				$filename = $_FILES[$clickedID];
				$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				
				# upload process...
				$uploaded_file = wp_handle_upload( $filename, $override );
				# at once, we save the option.
				update_option( $clickedID , $uploaded_file['url'] );
				
			} else {
				
				#if error
				$uploaded_file['error'] = __('Unsupported file type!', 'wip');
				
			}
			
			if( !empty( $uploaded_file['error'] ) ) {
				
				printf ( __('Upload Error: %1$s', 'wip') , $uploaded_file['error'] );
				
			} else {
			
				echo $uploaded_file['url'];
				
			}
			
		} elseif( $save_type == 'add_sidebar' ){
		
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				#explode them to get each data, check http://php.net/manual/en/function.parse-str.php
				parse_str($data, $p);
			}
			
			$err_r = array();
			$error = false;
			
			if( $p['wip_sidebar_name'] == "" ){
				$error = true;
				$err_r[] = __('Error : Please enter the sidebar name!', 'wip');
			}
			
			if( $error ){
			
				echo '<ul>' . "\n";
				foreach( $err_r as $e ){
					echo '<li>' . $e . '</li>' . "\n";
				}
				echo '</ul>';
			
			} else {
			
				$sn = $p['shortname'];
				$sb_name = $p['wip_sidebar_name'];
			
				$get_sidebar_options = wip_sidebar_generator::get_sidebars();
				
				$sidebar_name = str_replace(array("\n","\r","\t"), '', $sb_name);
				
				$sidebar_id = wip_sidebar_generator::convert_class($sidebar_name);
						
					if($sidebar_id == '' ){
								
						$options_sidebar = $get_sidebar_options;
							
					} else {
					
						if(isset($get_sidebar_options[$sidebar_id])){
								
							echo "2"; #alert the user that sidebar name exists
							die();
						}
								
						if ( is_array($get_sidebar_options) ) {
							
							$new_sidebar[$sidebar_id] = $sidebar_id;
							$options_sidebar = $get_sidebar_options + $new_sidebar;	
									
						} else {
							
							$options_sidebar[$sidebar_id] = $sidebar_id;
									
						}
						
					}
					
				update_option( $sn.'_sidebar_gen', $options_sidebar);
				echo $sidebar_id;
			}
		
		
		} elseif( $save_type == 'delete_sidebar' ){
		
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				parse_str($data, $p);
			}
			
			$sidebar_id = $p['data'];
			$sn = $p['shortname'];	
			
			$get_sidebar_options = wip_sidebar_generator::get_sidebars();
			$sidebarcount = count($get_sidebar_options);
			
			if(isset($get_sidebar_options[$sidebar_id])){
							
				unset( $get_sidebar_options[$sidebar_id] );
				autoDeleteMeta($sidebar_id);
				
				if( $sidebarcount == 1 ){
					$options_sidebar = '';
				} else {
					$options_sidebar = $get_sidebar_options;
				}
				update_option( $sn.'_sidebar_gen', $options_sidebar);
						
			}
			
		}
		
		die();
};







add_action('wp_ajax_wipanel_upload_slider_action', 'WIPanel_ajax_slider_callback');
add_action( 'wp_ajax_nopriv_wipanel_upload_slider_action', 'WIPanel_ajax_slider_callback' );
function WIPanel_ajax_slider_callback() {
		global $wpdb;
		
		#check the type of form
		if( isset($_POST['type']) ){
		
			$save_type = $_POST['type'];
			
		} else {
		
			$save_type = null;
			
		}
	
		#upload new slider image
		if( $save_type == 'upload' ) {
		
			#grab the data
			$clickedID = $_POST['name'];

			$arr_file_type = wp_check_filetype( basename( $_FILES[$clickedID]['name'] ));
			
			$uploaded_file_type = $arr_file_type['type'];
			
			# Set an array containing a list of acceptable formats
			$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
			
			# if data is an image - upload it
			if( in_array( $uploaded_file_type, $allowed_file_types ) ) {
				
				# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
				$filename = $_FILES[$clickedID];
				$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				
				# upload process...
				$uploaded_file = wp_handle_upload( $filename, $override );
				$upload_tracking[] = $clickedID;
				
				if( isset( $uploaded_file['error'] ) ){
				
					$returnError = array(
						"error" => true,
						"errorText" => $uploaded_file['error']
					);
						
					echo json_encode($returnError);
					
					die();
				}
				
				
				$path_info = wp_upload_dir();
					
				$file_info = pathinfo( $uploaded_file['file'] );
				$image_filename = $file_info['filename'] .'.'. $file_info['extension'];
				$image_url = $uploaded_file['url'];
				$subdir = $path_info['subdir'];
				
				$returnData = array(
					"error" => false,
					"imgUrl" => $image_url,
					"path" => $uploaded_file['file'],
					"subPath" => $subdir,
					"imageFilename" => $image_filename 
				);
					
				echo json_encode($returnData);
				
				die();
				
			} else {
				
				#if error
				$uploaded_file['error'] = __('Unsupported file type!', 'wip');
				
			}
			
			$errorNew = "";
			if( !empty( $uploaded_file['error'] ) ) {
				$errorNew = sprintf ( __('Upload Error: %1$s', 'wip') , $uploaded_file['error'] );
			}
			
			$returnData = array(
				"error" => true,
				"errorText" => $errorNew
			);
				
			echo json_encode($returnData);
			
			die();

			
		} elseif( $save_type == 'image_reset' ){ #if user click "delete image" icon
			
			$image_path = "";
			
			if( isset( $_POST['data'] ) ){
				$image_path = $_POST['data'];
				
				if( file_exists($image_path) ) unlink( $image_path);
			}
			
		} elseif ( $save_type == 'add_slider' ) {
			
			$p = array();
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				#explode them to get each data, check http://php.net/manual/en/function.parse-str.php
				parse_str($data, $p);
			}
			
			$img = isset( $p['wip_slider_image'] ) ? $p['wip_slider_image'] : '';
			$img_name = isset( $p['wip_slider_image_name'] ) ? $p['wip_slider_image_name'] : '';
			$imgPath = isset($p['wip_slider_image_path']) ? $p['wip_slider_image_path'] : '';
			$img_subdir = isset($p['wip_slider_image_sub_path']) ? $p['wip_slider_image_sub_path'] : '';
			
			$image_det = array(
				"file_name" => $img_name,
				"subdir" => $img_subdir
			);
			
			$link = esc_attr($p['wip_slider_url']);
			$desc = esc_textarea($p['wip_slider_desc']);
			
			/** get op for piecemaker */
			$title = isset($p['wip_slider_title']) ? esc_attr($p['wip_slider_title']) : '';
			$swf = isset($p['wip_slider_swf']) ? esc_attr($p['wip_slider_swf']) : '';
			$pm_pieces = isset($p['wip_slider_pc_pieces']) ? $p['wip_slider_pc_pieces'] : '';
			$pm_time = isset($p['wip_slider_pc_time']) ? $p['wip_slider_pc_time'] : '';
			$pm_transition = isset($p['wip_slider_pc_transition']) ? $p['wip_slider_pc_transition'] : '';
			$pm_delay = isset($p['wip_slider_pc_delay']) ? $p['wip_slider_pc_delay'] : '';
			$pm_depthoffset = isset($p['wip_slider_pc_depthoffset']) ? $p['wip_slider_pc_depthoffset'] : '';
			$pm_cubedistance = isset($p['wip_slider_pc_cubedistance']) ? $p['wip_slider_pc_cubedistance'] : '';
			
			$piecemaker = array(
				"title" => $title,
				"swf" => $swf,
				"pieces" => $pm_pieces,
				"time" => $pm_time,
				"transition" => $pm_transition,
				"delay" => $pm_delay,
				"depthoffset" => $pm_depthoffset,
				"cubedistance" => $pm_cubedistance
			);
			
			$sn = $p['shortname'];
			
			$err_r = "";
			$error = false;
			
			if( $img == "" ){
				$error = true;
				$err_r = __('Error : Please upload the image!', 'wip');
			}
			
			$returnData = "";
			
			if( $error ){
				
				$returnData = array(
					"error" => true,
					"errorText" => $err_r
				);
				
				echo json_encode($returnData);
				
				die();
			} else {
			
				$newThumb = "";
				$unique = intval( time() ) . '-WIP-slider';
				
				if( file_exists( $imgPath ) ) $newThumb = wip_resize( $imgPath, $img, 50, 50, true );
			
				$get_slider_id = get_option($sn . '_slider_id');
				$get_slider_det = get_option($sn . '_slider_det');
				
				$Sdata = array(
					'id' => $unique, 
					'image' => $image_det, 
					'link' => $link,
					'desc' => stripslashes( $desc ),
					'piecemaker' => $piecemaker
				);
				$Sdata_id = $unique;
				
				if( is_array($get_slider_id) ){
					
					$dataInsID[] = $Sdata_id;
					$toInsID = array_merge( (array)$get_slider_id, (array)$dataInsID);
				
				} else {
				
					$toInsID[] = $Sdata_id;
				
				}
				
				if( is_array($get_slider_det) ){
					
					$dataIns[$unique] = $Sdata;
					$toIns = $get_slider_det + $dataIns;
				
				
				} else {
				
					$toIns[$unique] = $Sdata;
				
				}
				
				update_option( $sn . '_slider_det', $toIns);
				update_option( $sn . '_slider_id', $toInsID);
				
				$returnData = array(
					"error" => false,
					"thumb" => $newThumb['url'],
					"id" => $unique
				);
				
				wip_delete_site_trans();
				echo json_encode($returnData);
				
				die();
			}
			
		} elseif( $save_type == 'slider_order' ){
			
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				parse_str($data, $p);
			}
			
			$arrData = $p['dt'];
			$fns = $p['length'];
			$sn = $p['shortname'];

			$usef = "";
			for($i = 0; $i < $fns; $i++){
				$usef .= $arrData[$i];
			}
				
			$files = array();
			if( is_array($arrData) ):
				foreach ( $arrData as $k => $l )
				{
						if($l != "")
						$files[$l] = $l;
				}
			endif;
				
			$fls = "";
			if($usef == ""){
					$fls = "";
			} else {
					$fls = $files;
			}
			
			wip_delete_site_trans();
			update_option( $sn.'_slider_id', $fls);
			
			die();
		
		} elseif( $save_type == 'take_data' ){
			
			if( isset( $_POST['data'] ) ){
				$ids = $_POST['data'];
			}
			
			$get_slider_det = get_option('bd_slider_det');
			
			$returnData = array();
			
			if( !empty( $get_slider_det ) ){
				
				if( array_key_exists( $ids , $get_slider_det ) ){
					$taken = $get_slider_det[$ids];
					
					$uploadPath = wp_upload_dir();
					if( isset( $taken['image'] ) ){
						$img_url = $uploadPath['baseurl'] .  $taken['image']['subdir'] . '/'. $taken['image']['file_name'];
					}
					
					if( isset( $taken['piecemaker'] ) ){
						$p =  $taken['piecemaker'];
						
						$title = isset($p['title']) ? $p['title'] : '';
						$swf = isset($p['swf']) ? $p['swf'] : '';
						$pm_pieces = isset($p['pieces']) ? $p['pieces'] : '';
						$pm_time = isset($p['time']) ? $p['time'] : '';
						$pm_transition = isset($p['transition']) ? $p['transition'] : '';
						$pm_delay = isset($p['delay']) ? $p['delay'] : '';
						$pm_depthoffset = isset($p['depthoffset']) ? $p['depthoffset'] : '';
						$pm_cubedistance = isset($p['cubedistance']) ? $p['cubedistance'] : '';
					}
					
					$returnData = array(
						"id" => $ids,
						"img" => $img_url,
						"title" => $title,
						"pm_swf" => $swf,
						"pm_pieces" => $pm_pieces,
						"pm_time" => $pm_time,
						"pm_transition" => $pm_transition,
						"pm_delay" => $pm_delay,
						"pm_depthoffset" => $pm_depthoffset,
						"pm_cubedistance" => $pm_cubedistance,
						"link" => $taken['link'],
						"desc" => $taken['desc']
					);
					
				}
				
			}
			
			echo json_encode($returnData);
			
			die();
			
		} elseif ( $save_type == 'delete_slider' ) {
		
			if( isset( $_POST['data'] ) ){
				$id = $_POST['data'];
			}
			
			$get_slider_id = get_option('bd_slider_id');
			$get_slider_det = get_option('bd_slider_det');
			$uploadPath = wp_upload_dir();

			if( !empty( $get_slider_det ) ){
			
	
				if( array_key_exists( $id, $get_slider_det ) ){
					$dataToDelete = $get_slider_det[$id];

					if( isset( $dataToDelete['image'] ) ){
						$oldimage_path = $uploadPath['basedir'] .  $dataToDelete['image']['subdir'] . '/'. $dataToDelete['image']['file_name'];
						$oldimg_url = $uploadPath['baseurl'] .  $dataToDelete['image']['subdir'] . '/'. $dataToDelete['image']['file_name'];
						if( file_exists($oldimage_path) ){
							$oldThumb = wip_resize( $oldimage_path, $oldimg_url, 50, 50, true );
							$oldthumbnail_path = $oldThumb['path'];
							
							unlink( $oldimage_path );		//delete old image
							
							if( file_exists($oldthumbnail_path) ) unlink( $oldthumbnail_path );	//delete old thumbnail
						}
					}
				}
				
			}
			
			if(isset($get_slider_det[$id])){			
				unset( $get_slider_det[$id] );
							
				$new_get_slider_det = $get_slider_det;
				update_option( 'bd_slider_det', $new_get_slider_det);		
			}
			
			
			foreach( $get_slider_id as $f => $g ){
				if( $g == $id ){
					unset( $get_slider_id[$f] );
					
					$new_get_slider_id = $get_slider_id;
					update_option( 'bd_slider_id', $new_get_slider_id);	
				}
			}
			wip_delete_site_trans();
			
			die();
		
		} elseif ( $save_type == 'upload_edit' ) {

			$returnData = "";
			$imgData = isset( $_FILES['image_edit'] ) ? true : false;
			$EditId = isset( $_POST['sliderId'] ) ? $_POST['sliderId'] : '' ;
		
			$error = false;
			
			if( !$imgData ){
				
				$error = true;
			
			}
			
			if( $EditId == "" ){
				
				$error = true;
			
			}
			
			if( $error ){
			
				$returnData = array(
					"error" => true,
					"errorText" => __('Image or edit id cannot be found!', 'wip')
				);
				
				echo json_encode($returnData);
				
				die();
			} else {
			
				$get_slider_det = get_option('bd_slider_det');
				
				#grab the data
				$arr_file_type = wp_check_filetype( basename( $_FILES['image_edit']['name']) );
				$uploaded_file_type = $arr_file_type['type'];
				
				# Set an array containing a list of acceptable formats
				$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
				
				# if data is an image - upload it
				if( in_array( $uploaded_file_type, $allowed_file_types ) ) {
					
					# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
					$filename = $_FILES['image_edit'];
					$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
					$override['test_form'] = false;
					$override['action'] = 'wp_handle_upload';
					
					# upload process...
					$uploaded_file = wp_handle_upload( $filename, $override );
					$upload_tracking[] = 'image_edit';
					
					#get upload path
					$uploadPath = wp_upload_dir();
					
					$file_info = pathinfo( $uploaded_file['file'] );
					$image_filename = $file_info['filename'] .'.'. $file_info['extension'];
					$subdir = $uploadPath['subdir'];
					$newImg = $uploaded_file['url'];
					$newImgPath = $uploaded_file['file'];
					
					if( !empty( $get_slider_det ) ){
						
						if( array_key_exists( $EditId, $get_slider_det ) ){
							$dataToEdit = $get_slider_det[$EditId];

							if( isset( $dataToEdit['image'] ) ){
								$oldimage_path = $uploadPath['basedir'] .  $dataToEdit['image']['subdir'] . '/'. $dataToEdit['image']['file_name'];
								$oldimg_url = $uploadPath['baseurl'] .  $dataToEdit['image']['subdir'] . '/'. $dataToEdit['image']['file_name'];
								if( file_exists($oldimage_path) ){
									$oldThumb = wip_resize( $oldimage_path, $oldimg_url, 50, 50, true );
									$oldthumbnail_path = $oldThumb['path'];
									
									unlink( $oldimage_path );		//delete old image
									unlink( $oldthumbnail_path );	//delete old thumbnail
								}
							}
						}
					}
				
				}

				$newThumbs = wip_resize( $newImgPath, $newImg, 50, 50, true );
				$newThumb = $newThumbs['url'];
				
				foreach( $get_slider_det as $i => &$box){
					if( $i == $EditId ){
						$box['image']['file_name'] = $image_filename;
						$box['image']['subdir'] = $subdir;
					}
				}
				unset($box);
				
				//update the image data
				update_option( 'bd_slider_det' , $get_slider_det );
				
				$returnData = array(
					"error" => false,
					"imgUrl" => $newImg,
					"thumbnail" => $newThumb
				);
				
				wip_delete_site_trans();
				echo json_encode($returnData);
				
				die();
			}
			
			
			
		} elseif ( $save_type == 'edit_data_slider' ){
		
			$returnData = "";
			$p = array();
			if( isset( $_POST['data'] ) ){
				$data = $_POST['data'];
				#explode them to get each data, check http://php.net/manual/en/function.parse-str.php
				parse_str($data, $p);
				
			}
			
			$id = isset($p['editid']) ? $p['editid'] : '';
			
			if( $id == "" ){
				
				$returnData = array(
					"error" => true,
					"errorText" => __("cannot read the required ID!", "wip")
				);
			
			} else {
				
				$get_slider_det = get_option('bd_slider_det');
				
				foreach( $get_slider_det as $i => &$box){
					if( $i == $id ){
						$box['link'] = isset($p['wip_slider_url_edit']) ? $p['wip_slider_url_edit'] : '';
						$box['desc'] = isset($p['wip_slider_desc_edit']) ? esc_textarea($p['wip_slider_desc_edit']) : '';
						$box['piecemaker']['title'] = isset($p['wip_slider_title_edit']) ? $p['wip_slider_title_edit'] : '';
						$box['piecemaker']['swf'] = isset($p['wip_slider_swf_edit']) ? $p['wip_slider_swf_edit'] : '';
						$box['piecemaker']['pieces'] = isset($p['wip_slider_pc_pieces_edit']) ? $p['wip_slider_pc_pieces_edit'] : '9';
						$box['piecemaker']['time'] = isset($p['wip_slider_pc_time_edit']) ? $p['wip_slider_pc_time_edit'] : '1.2';
						$box['piecemaker']['transition'] = isset($p['wip_slider_pc_transition_edit']) ? $p['wip_slider_pc_transition_edit'] : '';
						$box['piecemaker']['delay'] = isset($p['wip_slider_pc_delay_edit']) ? $p['wip_slider_pc_delay_edit'] : '0.1';
						$box['piecemaker']['depthoffset'] = isset($p['wip_slider_pc_depthoffset_edit']) ? $p['wip_slider_pc_depthoffset_edit'] : '300';
						$box['piecemaker']['cubedistance'] = isset($p['wip_slider_pc_cubedistance_edit']) ? $p['wip_slider_pc_cubedistance_edit'] : '20';

					}
				}
				unset($box);						
				
				update_option( 'bd_slider_det' , $get_slider_det );
				wip_delete_site_trans();
				
				$returnData = array(
					"error" => false
				);
				
			}
			
			echo json_encode($returnData);
		
		}
		
		die();

}


/** save data per section via ajax */
add_action('wp_ajax_save', 'WIPanel_ajaxsave_callback');
function WIPanel_ajaxsave_callback() {
	global $wpdb, $options;
	
	# get the array options,  check panel.options.php
	$options = WIP_get_options();
	
	#detect the action name
	if( isset( $_POST['action'] ) && $_POST['action']){
		
			$action = $_POST['action'];
			
	} else {
		
			$action = null;
			
	}
	
	#detect the part, eg "general setting", "home settings" etc,
	#we just need to update a section per single click...
	#so another section/tab data will got no any changes..
	$optPart = isset( $_POST['part'] ) ? $_POST['part'] : '';
	
	
	if( isset($action) && $action == 'save'){
		
		#first level array, let get into inside :)
		foreach($options as $parent => $ops ){
			
			#check if this is the right section?
			if( $parent == $optPart ){
				#finally, get each option from the array and do the action
				foreach( $ops['options'] as $a => $b ):
					#let's go into deep array!!!!
					foreach ( $b as $c => $d ){
						if($c == "id"){
							$toID = "";
							if( isset($_POST[ $d ]) ) $toID = $_POST[ $d ];
							
							WIP_do_options_action( $d, $toID );
						}
					}		
				
				endforeach;
				
if( $parent == 'layout_and_style' ){
	$body_text = get_template_directory() . '/css/custom/body-css.css';
	if( !is_writeable($body_text) ){
		if( !(@ chmod( $body_text, 0755)) ){
			die( __('Seems the "body-css.css" is unwriteable! Please change the file permission of "css/custom/body-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'body-background' );
}
			
			} 
			else { #not on parent, let's jump into child array
				
				if( isset( $ops['child'] ) ){
					foreach( $ops['child'] as $childName => $childKey ){
						if( $childName ==  $optPart ){
							
							foreach( $childKey as $cn => $cv ){
								foreach( $cv as $kl => $vb ){
									
									if( $kl == "id" ){
										$toID = "";
										if( isset($_POST[ $vb ]) ) $toID = $_POST[ $vb ];
										
										WIP_do_options_action( $vb, $toID );
									}
								
								}
							} /** end for each; */
	

if( $childName == 'piecemaker_2_settings' ){
	delete_site_transient( 'piecemaker_slider_data' );
}	
							
/** we have special action here,
	for custom font, css and layout */
if( $childName == 'font_manager' ){
	$font_text = get_template_directory() . '/css/custom/font-family.css';
	if( !is_writeable($font_text) ){
		if( !(@ chmod( $font_text, 0755)) ){
			die( __('Seems the "font-family.css" is unwriteable! Please change the file permission of "css/custom/font-family.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'font-family' );
} /** end if $childName == font_manager */

if( $childName == 'general_skin' ){
	$general_text = get_template_directory() . '/css/custom/general-css.css';
	if( !is_writeable($general_text) ){
		if( !(@ chmod( $general_text, 0755)) ){
			die( __('Seems the "general-css.css" is unwriteable! Please change the file permission of "css/custom/general-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'general-css' );
} /** end if $childName == general_skin */

if( $childName == 'header_skin' ){
	$header_text = get_template_directory() . '/css/custom/header-css.css';
	if( !is_writeable($header_text) ){
		if( !(@ chmod( $header_text, 0755)) ){
			die( __('Seems the "header-css.css" is unwriteable! Please change the file permission of "css/custom/header-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'header-css' );
} /** end if $childName == header_skin */

if( $childName == 'menu_skin' ){
	$menu_text = get_template_directory() . '/css/custom/menu-css.css';
	if( !is_writeable($menu_text) ){
		if( !(@ chmod( $menu_text, 0755)) ){
			die( __('Seems the "menu-css.css" is unwriteable! Please change the file permission of "css/custom/menu-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'menu-css' );
} /** end if $childName == menu_skin */	

if( $childName == 'top_shopping_cart' ){
	$topcart_text = get_template_directory() . '/css/custom/topcart-css.css';
	if( !is_writeable($topcart_text) ){
		if( !(@ chmod( $topcart_text, 0755)) ){
			die( __('Seems the "topcart-css.css" is unwriteable! Please change the file permission of "css/custom/topcart-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'topcart-css' );
} /** end if $childName == top_shopping_cart */

if( $childName == 'homepage_slider_skin' ){
	$slider_text = get_template_directory() . '/css/custom/slider-css.css';
	if( !is_writeable($slider_text) ){
		if( !(@ chmod( $slider_text, 0755)) ){
			die( __('Seems the "slider-css.css" is unwriteable! Please change the file permission of "css/custom/slider-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'slider-css' );
} /** end if $childName == homepage_slider_skin */


if( $childName == 'footer_widget_skin' ){
	$fw_text = get_template_directory() . '/css/custom/footer-widget-css.css';
	if( !is_writeable($fw_text) ){
		if( !(@ chmod( $fw_text, 0755)) ){
			die( __('Seems the "footer-widget-css.css" is unwriteable! Please change the file permission of "css/custom/footer-widget-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'footer-widget' );
} /** end if $childName == footer_widget_skin */

if( $childName == 'copyright_area_skin' ){
	$cr_text = get_template_directory() . '/css/custom/copyright-css.css';
	if( !is_writeable($cr_text) ){
		if( !(@ chmod( $cr_text, 0755)) ){
			die( __('Seems the "copyright-css.css" is unwriteable! Please change the file permission of "css/custom/copyright-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'copyright' );
} /** end if $childName == copyright_area_skin */

if( $childName == 'product_section' ){
	$woo_text = get_template_directory() . '/css/custom/product-css.css';
	if( !is_writeable($woo_text) ){
		if( !(@ chmod( $woo_text, 0755)) ){
			die( __('Seems the "product-css.css" is unwriteable! Please change the file permission of "css/custom/product-css.css"!', 'wip') );
		}
	}
	
	write_custom_css( 'product' );
} /** end if $childName == product_section */
							
						}
					}
				}
			
			} /** end if $parent == $optPart */
			
		}
	
	}
	

	die('1');

}

/** reset data via ajax */
add_action('wp_ajax_wipanel_reset_section', 'WIPanel_ajax_reset_function');
function WIPanel_ajax_reset_function(){
	global $wpdb;
	# get the array options,  check panel.options.php
	$options = WIP_get_options();
	
	#check the type
	if( isset($_POST['type']) && $_POST['type']){
		
		$save_type = $_POST['type'];
			
	} else {
		
		$save_type = null;
			
	}
	
	#get the section, for reset all setting this is should be "all"
	if( isset($_POST['data']) && $_POST['data']) $section = $_POST['data'];
		
		#check again, just to make sure
		if($save_type == 'reset'){
			#first level array, let get into inside :)
			foreach($options as $parent => $ops ){
				
				#if not all, that's mean user only reset the spesific section
				if($section != 'all'){
					
					#let's go into deep array!!!!
					if( $parent == $section ){
						
						foreach( $ops['options'] as $a => $b ):
						
							foreach ( $b as $c => $d ){
								if($c == "id"){
									delete_option( $d );
								}
							}

						endforeach;
					
					} else {
					
							if( isset( $ops['child'] ) ){
								foreach( $ops['child'] as $childName => $childKey ){
									if( $childName == $section ){
										
										foreach( $childKey as $cn => $cv ){
											foreach( $cv as $kl => $vb ){
												
												if( $kl == "id" ){
													delete_option( $vb );
												}
											
											}
										} /** end for each; */
										
									}
								}
							}
					
					
					}
					
					if($section == 'general_settings'){
						delete_option('height_of_bd_logo');
					}
					
				} else { #if all - then delete'em all
					#let's go into deep array!!!!
					foreach( $ops['options'] as $a => $b ):
						
							foreach ( $b as $c => $d ){
								if($c == "id"){
									delete_option( $d );
								}
							}
						
					endforeach;
					
					delete_option('height_of_bd_logo');
				
				}
			}
		
		}

	
	
	#let's sent the right message into the ajax
	if($section == 'all'){
		die('2');
	} else {
		die('1');
	}
}

function WIP_do_options_action( $id, $value ){

	if( $value != "" ) {
	
		update_option( $id, $value );
	
	} else {
	
		delete_option( $id ); 
	
	}
}


function write_custom_css( $section = 'font-family' ){

switch( $section ){

	case 'font-family':
	$font_text = get_template_directory() . '/css/custom/font-family.css';
		
	$write_to = '/** ===== font style ===== */ ' . "\n";
	$write_to .= get_font_embed_css( get_wip_option_by('bd_body_font', 'Droid Sans') ) . "\n";
	$write_to .= get_font_embed_css( get_wip_option_by('bd_heading_font', 'Droid Serif') ) . "\n";
	$write_to .= get_font_embed_css( get_wip_option_by('bd_menu_font', 'Droid Sans') ) . "\n";
	$write_to .= 
'body,
input,textarea,select,button,
ul.news_widget_style li h3{
	'.get_font_family_by_name( get_wip_option_by('bd_body_font', 'Droid Sans') ).'
}' . "\n";
	$write_to .= 
'h1,h2,h3,h4,h5,h6, .amount{
	'.get_font_family_by_name( get_wip_option_by('bd_heading_font', 'Droid Serif' ) ).'
}
ul#main-nav{
	'.get_font_family_by_name( get_wip_option_by('bd_menu_font', 'Droid Serif' ) ).'
}' . "\n";

@file_put_contents($font_text, $write_to);

		break;



		
	case 'body-background':
	$body_text = get_template_directory() . '/css/custom/body-css.css';
	$write_to = 
'body{
	background-color : #'.get_wip_option_by('bd_allbackgroundcolor', 'e6e6e6').';
	'. ( ( get_option('bd_allbackgroundimage') != "" ) ? 'background-image: url('.get_option('bd_allbackgroundimage').');' : '' ) .'
	'. ( ( get_option('bd_allbackgroundimage') != "" ) ? 'background-position: '.strtolower(get_wip_option_by('bd_allbackground_bg_pos', 'left top')).';' : '' ) .'
	'. ( ( get_option('bd_allbackgroundimage') != "" ) ? 'background-attachment: '.strtolower(get_wip_option_by('bd_allbackground_bg_attach', 'scroll')).';' : '' ) .'
	'. ( ( get_option('bd_allbackgroundimage') != "" ) ? 'background-repeat: '.strtolower(get_wip_option_by('bd_allbackground_bg_repeat', 'repeat')).';' : '' ) .'
}' . "\n";

@file_put_contents($body_text, $write_to);
		break;
		
	


	
	case 'general-css':
	$general_text = get_template_directory() . '/css/custom/general-css.css';
	
	$selectBorder = colourBrightness( '#'.get_wip_option_by('bd_content_bgColor', 'FFFFFF'), '-0.85' );
	$selectBorderLightDark = colourBrightness( '#'.get_wip_option_by('bd_content_bgColor', 'FFFFFF'), '-0.95' );
	$selectBorderDark = colourBrightness( '#'.get_wip_option_by('bd_content_bgColor', 'FFFFFF'), '-0.65' );
	$selectBg = colourBrightness( '#'.get_wip_option_by('bd_content_bgColor', 'FFFFFF'), '0.65' );
	
	$form_bg = colourBrightness( '#'.get_wip_option_by('bd_content_bgColor', 'FFFFFF'), '0.85' );
	$table_bg = colourBrightness( '#'.get_wip_option_by('bd_content_bgColor', 'FFFFFF'), '0.88' );
	
	$defaultsubmit_orig = '#' . get_option('bd_defaultbuttonbgcolor');
	$defaultsubmit_light = colourBrightness( $defaultsubmit_orig, '0.88' );
	$defaultsubmit_gradient = new gradient_image($defaultsubmit_light, $defaultsubmit_orig, 32, 5, 30);
	$defaultsubmit_gradient_reserve = new gradient_image($defaultsubmit_orig, $defaultsubmit_light, 32, 5, 30);
	$defaultsubmit_new_grd = $defaultsubmit_gradient->createPNG(false, true);
	$defaultsubmit_new_grd_reserve = $defaultsubmit_gradient_reserve->createPNG(false, true);
	$defaultsubmit_border = colourBrightness( $defaultsubmit_orig, '-0.8' );
	$defaultsubmit_innerShadow = colourBrightness( $defaultsubmit_light, '0.8' );


	$tag_border = colourBrightness( '#'.get_wip_option_by('bd_general_link_color', '28a3d1'), '-0.8' );


	$sidebar_title_bg = '#'.get_wip_option_by('bd_sidebar_title_bg', '888888');
	$sidebar_title_bg_dark = colourBrightness( $sidebar_title_bg, '-0.88' );
	$sidebar_title_bg_grad = new gradient_image($sidebar_title_bg, $sidebar_title_bg_dark, 32, 5, 40);
	$sidebar_title_bg_grad_new = $sidebar_title_bg_grad->createPNG(false, true);

	
	$write_to = '/** ===== general color style ===== */ ' . "\n";
	$write_to .= 
'body{
	color : #'.get_wip_option_by('bd_body_fontcolor', '737373').';
}
#main-inner-site input[type=text], 
#main-inner-site input[type=password], 
#main-inner-site input[type=file], 
#main-inner-site textarea, 
#main-inner-site select{
	background-color: '.$form_bg.';
	color: #'.get_wip_option_by('bd_body_fontcolor', '737373').';
}' . "\n";
	$write_to .= 
'h1,h2,h3,h4,h5,h6{
	color : #'.get_wip_option_by('bd_heading_fontcolor', '333333').';
}' . "\n";
	$write_to .= 
'a,
a>h3{
	color : #'.get_wip_option_by('bd_general_link_color', '28a3d1').';
}' . "\n";
	$write_to .= 
'a:hover,
a>h3:hover{
	color : #'.get_wip_option_by('bd_general_link_hovercolor', '999999').';
}' . "\n";
	$write_to .= 
'blockquote,
.quote_left,
.quote_right{
	color : #'.get_wip_option_by('bd_blockquote_color', '999999').';
}
a.button,
.sidebarbox a.button,
input[type="submit"],
button[type="submit"],
table.cart td.actions a.checkout-button{
	background: #'.get_wip_option_by('bd_defaultbuttonbgcolor', '777777').'  url("data:image/png;base64,'.base64_encode($defaultsubmit_new_grd).'") scroll left top repeat-x;
	color: #'.get_wip_option_by('bd_defaultbuttoncolor', 'FFFFFF').';
	border: 1px solid '.$defaultsubmit_border.';
	-box-shadow: inset 0px 1px 0px '.$defaultsubmit_innerShadow.', 0 1px 2px rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: inset 0px 1px 0px '.$defaultsubmit_innerShadow.', 0 1px 2px rgba(0, 0, 0, 0.08);
	-moz-box-shadow: inset 0px 1px 0px '.$defaultsubmit_innerShadow.', 0 1px 2px rgba(0, 0, 0, 0.08);
	text-shadow: 0px -1px 0px '.$defaultsubmit_border.';
}
a.button:hover,
.sidebarbox a.button:hover,
input[type="submit"]:hover,
button[type="submit"]:hover,
table.cart td.actions a.checkout-button:hover{
	background: #'.get_wip_option_by('bd_defaultbuttonbgcolor', '777777').'  url("data:image/png;base64,'.base64_encode($defaultsubmit_new_grd_reserve).'") scroll left bottom repeat-x;
	color: #'.get_wip_option_by('bd_defaultbuttoncolor', 'FFFFFF').'!important;
}
input, select, textarea{
	border-top-color:'.$selectBorderLightDark.';
	border-left-color:'.$selectBorderLightDark.';
	border-bottom-color: '.$selectBorder.';
	border-right-color: '.$selectBorder.';
}' . "\n";
	$write_to .= 
'#main-inner-site,
.wip-product-single-page .product_meta{
	background-color : #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
#main-inner-site table td,
.col-1,
.col-2{
	background-color: '.$table_bg.';
}
.dividers a,
.woocommerce-account form h3{
	background-color: #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
.sidebarbox h3.sidebar-title{
	background: #'.get_wip_option_by('bd_sidebar_title_bg', '888888').'  url("data:image/png;base64,'.base64_encode($sidebar_title_bg_grad_new).'") scroll left top repeat-x;
	color: #'.get_wip_option_by('bd_sidebar_title_color', 'FFFFFF').';
}
#single-page-title{
	background-color : #'.get_wip_option_by('bd_innerpage_title_bgColor', 'FFFFFF').';
	'. ( ( get_option('bd_innerpage_title_bgimage') != "" ) ? 'background-image: url('.get_option('bd_innerpage_title_bgimage').');' : '' ) .'
	'. ( ( get_option('bd_innerpage_title_bgimage') != "" ) ? 'background-position: '.strtolower(get_wip_option_by('bd_innerpage_title_bg_pos', 'left top')).';' : '' ) .'
	'. ( ( get_option('bd_innerpage_title_bgimage') != "" ) ? 'background-attachment: '.strtolower(get_wip_option_by('bd_innerpage_title_bg_attach', 'scroll')).';' : '' ) .'
	'. ( ( get_option('bd_innerpage_title_bgimage') != "" ) ? 'background-repeat: '.strtolower(get_wip_option_by('bd_innerpage_title_bg_repeat', 'repeat')).';' : '' ) .'
}
#single-page-title h1{
	color: #'.get_wip_option_by('bd_innerpage_title_fontcolor', '444444').';
	font-style: '.get_wip_option_by('bd_innerpage_title_fontstyle', 'normal').';
	font-weight: '.get_wip_option_by('bd_innerpage_title_fontweight', 'normal').';
	text-transform: '.get_wip_option_by('bd_innerpage_title_texttransform', 'none').';
}
.tagcloud a{
	background: #'.get_wip_option_by('bd_general_link_color', '28a3d1').';
	border-color: '.$tag_border.';
	color : #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
table#wp-calendar caption,
table#wp-calendar tfoot tr td{
	border-color: '.$selectBorder.';
	background-color: '.$selectBg.';
}
table#wp-calendar thead th{
	border-color: '.$selectBorder.';
}
table#wp-calendar tbody td{
	border-color: '.$selectBorderLightDark.';
	background-color: '.$selectBg.';
}
.selectBox-dropdown,
.selectBox-dropdown-menu,
.selectBox-inline{
	background-color: '.$form_bg.';
	border: solid 1px '.$selectBorder.';
	color : #'.get_wip_option_by('bd_body_fontcolor', '737373').';
}
.selectBox-dropdown .selectBox-arrow{
	border-left: solid 1px '.$selectBorder.';
}
.selectBox-dropdown:focus,
.selectBox-dropdown:focus .selectBox-arrow{
	border-color: '.$selectBorder.';
}
div.product .woocommerce_tabs ul.tabs li a,
.wip_tab ul.tab-lists li a{
	color : #'.get_wip_option_by('bd_heading_fontcolor', '333333').';
}
div.product .woocommerce_tabs ul.tabs li.active,
div.product .woocommerce_tabs .panel,
.wip_tab ul.tab-lists li.active,
.wip_tab .panes,
div.related.products h2 span,
div.upsells.products h2 span,
#blog-related h2 span,
#portfolio-related h2 span{
	background-color : #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
div.product .woocommerce_tabs .panel table.shop_attributes tr,
div.product table.group_table tr{
	border-bottom: 1px solid #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
div.product div.quantity input[name="quantity"],
div.product div.quantity input.input-text.qty,
input.input-text.qty{
	border-top: 1px solid '.$selectBorderLightDark.';
	border-bottom: 1px solid '.$selectBorderLightDark.';
}
.jspTrack{
	background: '.$selectBorderLightDark.';
}
.jspDrag{
	background: '.$selectBorderDark.';
}
#reviews #comments ol.commentlist li img,
#reviews #comments ol.commentlist li .comment-text,
ol.commentlist li .comment_entries,
.single-blog-entry #respond,
#review_form,
.toggle_container,
.woo_product_content form.cart,
.woo_product_content div[itemprop="description"],
#product_gallery_and_summary .images a[itemprop="image"],
.product_lists_thumbnail,
.sidebarbox{
	background-color: '.$table_bg.';
	border-top-color:'.$selectBorderLightDark.';
	border-left-color:'.$selectBorderLightDark.';
	border-bottom-color: '.$selectBorder.';
	border-right-color: '.$selectBorder.';
}
.sidebarbox a{
	color: #'.get_wip_option_by('bd_sidebar_link_color', '888888').';
}
.sidebarbox a:hover{
	color: #'.get_wip_option_by('bd_sidebar_link_color_hover', 'e83e00').';
}
.wp-caption,
.gallery-icon a img{
	background-color: '.$table_bg.'!important;
	border-top-color:'.$selectBorderLightDark.'!important;
	border-left-color:'.$selectBorderLightDark.'!important;
	border-bottom-color: '.$selectBorder.'!important;
	border-right-color: '.$selectBorder.'!important;	
}
div.variations_button div.quantity{
	border-color: '.$table_bg.';
}
.comment_entries .commentmetadata{
	border-bottom-color: '.$selectBorder.';
}
#woo_checkout_tab_process{
	background-color: '.$table_bg.';
	border-color: '.$selectBorder.';
}
#woo_checkout_tab_process ul li a{
	color: '.$selectBorderDark.';
}
#woo_checkout_tab_process ul li.viewed a,
#woo_checkout_tab_process ul li a:hover{
	color : #'.get_wip_option_by('bd_general_link_color', '28a3d1').';
}
.addresses header.title,
.addresses .col-1 address,
.addresses .col-2 address,
.woocommerce-account form,
.woocommerce-checkout form.login,
.woocommerce-checkout form.wip-login,
table.shop_table thead,
table.shop_table tbody,
.cart_totals table,
#customer_details .col-1,
#customer_details .col-2{
	border-top-color:'.$selectBorderLightDark.';
	border-left-color:'.$selectBorderLightDark.';
	border-bottom-color: '.$selectBorder.';
	border-right-color: '.$selectBorder.';
}
#customer_details .col-1 h3:first-child,
#customer_details .col-2 h3,
.single-blog-entry #respond h3#reply-title,
#review_form #respond h3#reply-title,
.toggle_container h3.toggle_title{
	border-bottom-color: '.$selectBorder.';
}
.toggle_container h3.toggle_title{
	background-color : #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
table.shop_table thead th{
	border-left-color:'.$selectBorder.';
}
table.shop_table tbody td{
	border-left-color:'.$selectBorderLightDark.';
	border-top-color:'.$selectBorderLightDark.';
}
.cart_totals,
.shipping_calculator .shipping-calculator-form{
	border: 1px solid '.$selectBorderLightDark.';
}
.cart_totals h2,
form.shipping_calculator h2{
	background-color : #'.get_wip_option_by('bd_content_bgColor', 'FFFFFF').';
}
.cart_totals table th{
	border-top-color: '.$selectBorder.';
}
.cart_totals table td,
ul.products li h3.product-title-on-lists{
	border-top-color: '.$selectBorderLightDark.';
}' . "\n";

@file_put_contents($general_text, $write_to);
		break;
		
		
		
		
	case 'header-css':
	$header_text = get_template_directory() . '/css/custom/header-css.css';
	
	$topUtBorder = colourBrightness( '#'.get_wip_option_by('bd_searchwrap_bgColor', '333333'), '-0.85' );

	$write_to = '/** ===== header skin ===== */ ' . "\n";
	$write_to .= 
'#top{
	background-color : #'.get_wip_option_by('bd_header_bgColor', 'FAFAFA').';
	'. ( ( get_option('bd_headerbgimage') != "" ) ? 'background-image: url('.get_option('bd_headerbgimage').');' : '' ) .'
	'. ( ( get_option('bd_headerbgimage') != "" ) ? 'background-position: '.strtolower(get_wip_option_by('bd_header_bg_pos', 'left top')).';' : '' ) .'
	'. ( ( get_option('bd_headerbgimage') != "" ) ? 'background-attachment: '.strtolower(get_wip_option_by('bd_header_bg_attach', 'scroll')).';' : '' ) .'
	'. ( ( get_option('bd_headerbgimage') != "" ) ? 'background-repeat: '.strtolower(get_wip_option_by('bd_header_bg_repeat', 'repeat')).';' : '' ) .'
}
#top-utilitize a{
	color : #'.get_wip_option_by('bd_toplinkcolor', 'E3E3E3').';
}
#top-utilitize a:hover{
	color : #'.get_wip_option_by('bd_toplinkhovercolor', 'AAAAAA').';
}
#search-form-top input[type="text"]{
	color : #'.get_wip_option_by('bd_searchcolor', 'E3E3E3').';
} 
#main-site{
	border-top: 2px solid #'.get_wip_option_by('bd_header_bgLine', '28a3d1').';
}' . "\n";

@file_put_contents($header_text, $write_to);
		break;
		
		
		
		
		
	case 'menu-css':
	$menu_text = get_template_directory() . '/css/custom/menu-css.css';
	
	$write_to = '/** ===== menu skin ===== */ ' . "\n";
	$write_to .= 
'#site-nav{
	background-color: #'.get_wip_option_by('bd_menuparentbg', 'F9F9F9').';
}
#main-nav li a{
	color: #'.get_wip_option_by('bd_menuparentcolor', '888888').';
	background-color: #'.get_wip_option_by('bd_menuparentbg', 'F9F9F9').';
}
#main-nav li a:hover,
#main-nav li a.pageactive,
#main-nav li.onhove a.onhov{
	color: #'.get_wip_option_by('bd_menuparenthovercolor', '444444').';
}
#main-nav li ul a, #main-nav li.onhove ul a, 
#main-nav li.onhove li.onhove ul a, 
#main-nav li.onhove li.onhove li.onhove ul a{
	color: #'.get_wip_option_by('bd_menudropdowncolor', '888888').';
	background-color: #'.get_wip_option_by('bd_menudropdownbg', 'FAFAFA').';
}
#main-nav li ul a:hover, #main-nav li.onhove ul a:hover, 
#main-nav li.onhove li.onhove ul a:hover, 
#main-nav li.onhove li.onhove li.onhove ul a:hover,
#main-nav ul li.onhove a.onhov,
#main-nav ul ul li.onhove a.onhov,
#main-nav ul ul ul li.onhove a.onhov{
	background-color: #'.get_wip_option_by('bd_menudropdownbghover', 'F8F8F8').';
	color: #'.get_wip_option_by('bd_menudropdownhovercolor', '666666').';
}
#main-nav li ul a.pageactive, #main-nav li.onhove ul a.pageactive,
#main-nav li.onhove li.onhove ul a.pageactive, 
#main-nav li.onhove li.onhove li.onhove ul a.pageactive,
#main-nav ul li.onhove a.onhov.pageactive,
#main-nav ul ul li.onhove a.onhov.pageactive,
#main-nav ul ul ul li.onhove a.onhov.pageactive{
	background-color: #'.get_wip_option_by('bd_menudropdownbghover', 'F8F8F8').';
	color: #'.get_wip_option_by('bd_menudropdownhovercolor', '666666').';
}' . "\n";

@file_put_contents($menu_text, $write_to);
		break;





	case 'topcart-css':
	$topcart_text = get_template_directory() . '/css/custom/topcart-css.css';
	
	$tocart_defaultbg = '#' . get_option('bd_topcartbg');
	$topcart_Border = colourBrightness( '#'.get_wip_option_by('bd_topcartbg', '333333'), '-0.85' );

	$topcartButton_orig = '#' . get_option('bd_topcartdropbuttonbg');
	$topcartButton_light = colourBrightness( $topcartButton_orig, '0.90' );
	$topcartButton_gradient = new gradient_image($topcartButton_light, $topcartButton_orig, 32, 5, 40);
	$topcartButton_gradient_reserve = new gradient_image($topcartButton_orig, $topcartButton_light, 32, 5, 40);
	$topcartButton_new_grd = $topcartButton_gradient->createPNG(false, true);
	$topcartButton_new_grd_reserve = $topcartButton_gradient_reserve->createPNG(false, true);
	$topcartButton_border = colourBrightness( $tocart_defaultbg, '-0.8' );
	$topcartButton_innerShadow = colourBrightness( $topcartButton_light, '0.92' );

	$write_to = '/** ===== top shopping cart skin ===== */ ' . "\n";
	$write_to .= 
'#wip_woo_cart{
	background: '.$tocart_defaultbg.';
	border-color: '.$topcart_Border.';
}
.wip_woo_inner_cart .top_cart_text{
	color: #'.get_wip_option_by('bd_topcartnumbercolor', 'FFFFFF').';
}
.wip_woo_cart_drop{
	background-color: #'.get_wip_option_by('bd_topcartdropdownbg', 'cdd1d4').';
	border-color: '.colourBrightness( '#'.get_wip_option_by('bd_topcartdropdownbg', 'cdd1d4'), '-0.85' ).';
	border-top-color: #'.get_wip_option_by('bd_topcartdropdownitemlink', '28a3d1').';
}
.wip_woo_cart_drop ul.cart_list li{
	background: #'.get_wip_option_by('bd_topcartdropdownitem', '989fa1').';
	border: 1px solid '.colourBrightness( '#'.get_wip_option_by('bd_topcartdropdownbg', 'cdd1d4'), '-0.8' ).';
	color: #'.get_wip_option_by('bd_topcartdropdownitemcolor', '989fa1').';
}
.wip_woo_cart_drop ul.cart_list li a{
	color: #'.get_wip_option_by('bd_topcartdropdownitemlink', '28a3d1').';
}
.wip_woo_cart_drop ul.cart_list li a:hover{
	color: #'.get_wip_option_by('bd_topcartdropdownitemlink_hover', 'afc5d1').';
}
.wip_woo_cart_drop p.total{
	color: #'.get_wip_option_by('bd_topcartdropdownsubtotal', 'FFFFFF').';
}
.wip_woo_cart_drop p.buttons a.button{
	background: #'.get_wip_option_by('bd_topcartdropbuttonbg', '28a3d1').'  url("data:image/png;base64,'.base64_encode($topcartButton_new_grd).'") scroll left bottom repeat-x;
	color: #'.get_wip_option_by('bd_topcartdropbuttoncolor', 'FFFFFF').';
	border: 1px solid '.$topcartButton_border.';
	-box-shadow: inset 0px 1px 0px '.$topcartButton_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: inset 0px 1px 0px '.$topcartButton_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.08);
	-moz-box-shadow: inset 0px 1px 0px '.$topcartButton_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.08);
	text-shadow: none;
}
.wip_woo_cart_drop p.buttons a.button:hover{
	background: #'.get_wip_option_by('bd_topcartdropbuttonbg', '28a3d1').'  url("data:image/png;base64,'.base64_encode($topcartButton_new_grd_reserve).'") scroll left bottom repeat-x;
	color: #'.get_wip_option_by('bd_topcartdropbuttoncolor', 'FFFFFF').'!important;
}' . "\n";


@file_put_contents($topcart_text, $write_to);
		break;





	case 'slider-css':
	$slider_text = get_template_directory() . '/css/custom/slider-css.css';
	
	$nivoButton_normal = '#' . get_option('bd_nivoslider_navbg');	
	$nivoButton_normal_light = colourBrightness( $nivoButton_normal, '0.3' );
	$nivoButton_gradient = new gradient_image($nivoButton_normal_light, $nivoButton_normal, 32, 5, 10);
	$nivoButton_new_grd = $nivoButton_gradient->createPNG(false, true);
	$nivoButton_normal_innerShadow = colourBrightness( $nivoButton_normal_light, '0.6' );
	
	$nivoButton_active = '#' . get_option('bd_nivoslider_navbg_active');
	$nivoButton_active_light = colourBrightness( $nivoButton_active, '0.3' );
	$nivoButton_active_gradient = new gradient_image($nivoButton_active_light, $nivoButton_active, 32, 5, 10);
	$nivoButton_active_grd = $nivoButton_active_gradient->createPNG(false, true); 
	$nivoButton_active_innerShadow = colourBrightness( $nivoButton_active_light, '0.6' );
	
	$nivoButton_normal_border = colourBrightness( '#'.get_wip_option_by('bd_sliderbgcolor', 'FFFFFF') , '-0.55' );
	$nivoButton_active_border = colourBrightness( $nivoButton_active, '-0.75' );
	
	$write_to = '/** ===== slider area skin ===== */ ' . "\n";
	$write_to .= 
'#slider_wraper{
	background-color : #'.get_wip_option_by('bd_sliderbgcolor', 'FFFFFF').';
	'. ( ( get_option('bd_sliderbgimage') != "" ) ? 'background-image: url('.get_option('bd_sliderbgimage').');' : '' ) .'
	'. ( ( get_option('bd_sliderbgimage') != "" ) ? 'background-position: '.strtolower(get_wip_option_by('bd_slider_bg_pos', 'left top')).';' : '' ) .'
	'. ( ( get_option('bd_sliderbgimage') != "" ) ? 'background-attachment: '.strtolower(get_wip_option_by('bd_slider_bg_attach', 'scroll')).';' : '' ) .'
	'. ( ( get_option('bd_sliderbgimage') != "" ) ? 'background-repeat: '.strtolower(get_wip_option_by('bd_slider_bg_repeat', 'repeat')).';' : '' ) .'
}
.nivo-controlNav a{
	background: #'.get_wip_option_by('bd_nivoslider_navbg', '777777').'  url("data:image/png;base64,'.base64_encode($nivoButton_new_grd).'") scroll left bottom repeat-x;
	border: 1px solid '.$nivoButton_normal_border.';
	-box-shadow: inset 0px 1px 0px '.$nivoButton_normal_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2);
	-webkit-box-shadow: inset 0px 1px 0px '.$nivoButton_normal_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: inset 0px 1px 0px '.$nivoButton_normal_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2);
}
.nivo-controlNav a.active{
	background: #'.get_wip_option_by('bd_nivoslider_navbg_active', '28a3d1').'  url("data:image/png;base64,'.base64_encode($nivoButton_active_grd).'") scroll left bottom repeat-x;
	border: 1px solid '.$nivoButton_normal_border.';
	-box-shadow: inset 0px 1px 0px '.$nivoButton_active_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2);
	-webkit-box-shadow: inset 0px 1px 0px '.$nivoButton_active_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: inset 0px 1px 0px '.$nivoButton_active_innerShadow.', 0 1px 3px rgba(0, 0, 0, 0.2);
}' . "\n";

@file_put_contents($slider_text, $write_to);
		break;



	case 'footer-widget':
	$fw_text = get_template_directory() . '/css/custom/footer-widget-css.css';
	
	
	$footer_selectBorder = colourBrightness( '#'.get_wip_option_by('bd_fwbgcolor', '888888'), '-0.85' );
	$footer_selectBorderLightDark = colourBrightness( '#'.get_wip_option_by('bd_fwbgcolor', '888888'), '-0.95' );
	$footer_selectBorderDark = colourBrightness( '#'.get_wip_option_by('bd_fwbgcolor', '888888'), '-0.65' );
	$footer_selectBg = colourBrightness( '#'.get_wip_option_by('bd_fwbgcolor', '888888'), '0.65' );

	$footer_form_bg = colourBrightness( '#'.get_wip_option_by('bd_fwbgcolor', '888888'), '0.75' );
	
	
	$pekok = get_wip_option_by('bd_fwbgcolor', '888888');
	$listBG = '../../images/arrow-lists-white.png';
	if( wip_get_brightness($pekok) > 160 ){
		$listBG = '../../images/arrow-lists.png';
	}
	
	$write_to = '/** ===== footer widget skin ===== */ ' . "\n";
	$write_to .= 
'#footer{
	color: #'.get_wip_option_by('bd_fwbody_fontcolor', 'DADADA').';
	background-color : #'.get_wip_option_by('bd_fwbgcolor', '888888').';
	'. ( ( get_option('bd_fwbgimage') != "" ) ? 'background-image: url('.get_option('bd_fwbgimage').');' : '' ) .'
	'. ( ( get_option('bd_fwbgimage') != "" ) ? 'background-position: '.strtolower(get_wip_option_by('bd_fw_bg_pos', 'left top')).';' : '' ) .'
	'. ( ( get_option('bd_fwbgimage') != "" ) ? 'background-attachment: '.strtolower(get_wip_option_by('bd_fw_bg_attach', 'scroll')).';' : '' ) .'
	'. ( ( get_option('bd_fwbgimage') != "" ) ? 'background-repeat: '.strtolower(get_wip_option_by('bd_fw_bg_repeat', 'repeat')).';' : '' ) .'
}
#footer table#wp-calendar caption,
#footer table#wp-calendar tfoot tr td{
	border-color: '.$footer_selectBorder.';
	background-color: '.$footer_selectBg.';
}
#footer table#wp-calendar thead th{
	border-color: '.$footer_selectBorder.';
}
#footer table#wp-calendar tbody td{
	border-color: '.$footer_selectBorderLightDark.';
	background-color: '.$footer_selectBg.';
}
#footer .selectBox-dropdown,
#footer .selectBox-dropdown-menu,
#footer .selectBox-inline{
	background-color: '.$footer_selectBg.';
	border: solid 1px '.$footer_selectBorder.';
}
#footer .selectBox-dropdown .selectBox-arrow{
	border-left: solid 1px '.$footer_selectBorder.';
}
#footer .selectBox-dropdown:focus,
#footer .selectBox-dropdown:focus .selectBox-arrow {
	border-color: '.$footer_selectBorderDark.';
}
#footer input[type=text], 
#footer input[type=password], 
#footer input[type=file], 
#footer textarea, 
#footer select{
	background-color: '.$footer_form_bg.';
	color: #'.get_wip_option_by('bd_fwbody_fontcolor', 'DADADA').';
}
#footer input[type=text], 
#footer input[type=password], 
#footer input[type=file], 
#footer select, 
#footer textarea{
	border-top-color:'.$footer_selectBorderLightDark.';
	border-left-color:'.$footer_selectBorderLightDark.';
	border-bottom-color: '.$footer_selectBorder.';
	border-right-color: '.$footer_selectBorder.';
}
.footer-widget h3.footer-widget-title{
	color: #'.get_wip_option_by('bd_fwwidget_titlecolor', 'FAFAFA').';
	border-color: #'.get_wip_option_by('bd_fwwidget_title_bordercolor', 'BFBFBF').';
}
.footer-widget h1,
.footer-widget h2,
.footer-widget h3,
.footer-widget h4,
.footer-widget h5,
.footer-widget h6{
	color: #'.get_wip_option_by('bd_fwheading_fontcolor', 'F8F8F8').';
}
.footer-widget a{
	color: #'.get_wip_option_by('bd_fw_link_color', '28A3D1').';
}
.footer-widget a:hover{
	color: #'.get_wip_option_by('bd_fw_link_hovercolor', 'AAAAAA').';
}
.footer-widget ul li{
	background: url('.$listBG.') scroll 0px 9px no-repeat;
}' . "\n";

@file_put_contents($fw_text, $write_to);
		break;





	case 'copyright':
	$cr_text = get_template_directory() . '/css/custom/copyright-css.css';
	
	$write_to = '/** ===== copyright skin ===== */ ' . "\n";
	$write_to .= 
'#site_bottom{
	color: #'.get_wip_option_by('bd_crbody_fontcolor', 'AAAAAA').';
	background-color : #'.get_wip_option_by('bd_crbgcolor', '888888').';
	'. ( ( get_option('bd_crbgimage') != "" ) ? 'background-image: url('.get_option('bd_crbgimage').');' : '' ) .'
	'. ( ( get_option('bd_crbgimage') != "" ) ? 'background-position: '.strtolower(get_wip_option_by('bd_cr_bg_pos', 'left top')).';' : '' ) .'
	'. ( ( get_option('bd_crbgimage') != "" ) ? 'background-attachment: '.strtolower(get_wip_option_by('bd_cr_bg_attach', 'scroll')).';' : '' ) .'
	'. ( ( get_option('bd_crbgimage') != "" ) ? 'background-repeat: '.strtolower(get_wip_option_by('bd_cr_bg_repeat', 'repeat')).';' : '' ) .'
}
#site_bottom a{
	color: #'.get_wip_option_by('bd_cr_link_color', '28a3d1').';
}
#site_bottom a:hover{
	color: #'.get_wip_option_by('bd_cr_link_hovercolor', 'AAAAAA').';
}' . "\n";

@file_put_contents($cr_text, $write_to);
		break;





	case 'product':
	$woo_text = get_template_directory() . '/css/custom/product-css.css';
	

	$sale_ribbon_c = '#' . get_option('bd_sale_ribbon_bg');
	$percent = 0.7;
	$sale_ribbon_l = colourBrightness( $sale_ribbon_c, $percent );
	$ribbon_gradient = new gradient_image($sale_ribbon_l, $sale_ribbon_c, 32, 5, 40);
	$ribbon_new_grd = $ribbon_gradient->createPNG(false, true);
	$shadow_color = colourBrightness( '#'.get_wip_option_by('bd_price_area_bg', 'a1c41e'), '-0.85' );
	
	$bt_hover_bgc = colourBrightness( '#'.get_wip_option_by('bd_price_area_bg', 'a1c41e'), '0.90' );
	
	$addTC_bg_single = '#' . get_option('bd_addtocart_single_bg');
	$addTC_bg_l_single = colourBrightness( $addTC_bg_single, '0.90' );
	$addTC_bg_single_inset = colourBrightness( $addTC_bg_l_single, '0.92' );
	$addTC_gradient_single = new gradient_image($addTC_bg_l_single, $addTC_bg_single, 32, 5, 40);
	$addTC_gradient_hover_single = new gradient_image($addTC_bg_single, $addTC_bg_l_single, 32, 5, 40);
	$addTC_new_grd_single = $addTC_gradient_single->createPNG(false, true);
	$addTC_new_grd_hover_single = $addTC_gradient_hover_single->createPNG(false, true);
	$btBorder_single = colourBrightness( $addTC_bg_single, '-0.8' );

	$pr = '#'.get_wip_option_by('bd_variable_product_price_bg', '888888');
	$pr_font = '#'.get_wip_option_by('bd_variable_product_price_color', '888888');
	$bg_price = '../../images/price.png';
	if( wip_get_brightness($pr) > 160 ){
		$bg_price = '../../images/price-dark.png';	
	}

	$font_pr = '0.90';
	if( wip_get_brightness($pr_font) > 160 ){
		$font_pr = '-0.90';	
	}

	$write_to = '/** ===== products area skin ===== */ ' . "\n";
	$write_to .= 
'span.onsale{
	background: #' . get_option('bd_sale_ribbon_bg').' url("data:image/png;base64,'.base64_encode($ribbon_new_grd).'") scroll left bottom repeat-x;
	color: #'.get_wip_option_by('bd_sale_ribbon_font', 'FFFFFF').';
}
.product_list_price{
	background-color: #'.get_wip_option_by('bd_price_area_bg', 'a1c41e').';
	color: #'.get_wip_option_by('bd_actual_price_font', 'FFFFFF').';
	text-shadow: none;
}
span.product_list_button a.button:hover{
	background-color: '.$bt_hover_bgc.';
}
.product.type-product.status-publish.hentry .summary button.button.alt{
	background: #' . get_option('bd_addtocart_single_bg').' url("data:image/png;base64,'.base64_encode($addTC_new_grd_single).'") scroll left bottom repeat-x;
	color: #'.get_wip_option_by('bd_addtocart_single_font', 'FFFFFF').';
	border: 1px solid '.$btBorder_single.';
	-box-shadow: inset 0px 1px 0px '.$addTC_bg_single_inset.', 0 1px 3px rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: inset 0px 1px 0px '.$addTC_bg_single_inset.', 0 1px 3px rgba(0, 0, 0, 0.08);
	-moz-box-shadow: inset 0px 1px 0px '.$addTC_bg_single_inset.', 0 1px 3px rgba(0, 0, 0, 0.08);
}
.product.type-product.status-publish.hentry .summary button.button.alt:hover{
	background: #' . get_option('bd_addtocart_single_bg').' url("data:image/png;base64,'.base64_encode($addTC_new_grd_hover_single).'") scroll left top repeat-x;
	color: #'.get_wip_option_by('bd_addtocart_single_font', 'FFFFFF').'!important;
}
div.product .single_variation_wrap .single_variation{
	border-color: '.colourBrightness( '#'.get_wip_option_by('bd_variable_product_price_bg', '888888'), '-0.85' ).';
	background-color: #'.get_wip_option_by('bd_variable_product_price_bg', '888888').';
	background-image : url('.$bg_price.');
}
div.product .single_variation_wrap .single_variation span.price{
	color: #'.get_wip_option_by('bd_variable_product_price_color', '888888').';
}
div.product .single_variation_wrap  p.stock,
.single_variation span.price del .amount{
	color: '.colourBrightness( '#'.get_wip_option_by('bd_variable_product_price_color', '888888'), $font_pr ).';
}' . "\n";

@file_put_contents($woo_text, $write_to);
		break;
		

}
	
}



function wip_delete_site_trans(){
	delete_site_transient( 'slider_data' );
	delete_site_transient( 'piecemaker_slider_data' );
}

function wip_get_brightness($hex) {

	$hex = str_replace('#', '', $hex);

	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}

?>