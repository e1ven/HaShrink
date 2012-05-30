<?php
/**
 * Ajax callback function for portfolio post
 * Upload thumbnail, Upload portfolio data, etc
 *
 * @author Webinpixels
 * @since 2012
 */

 
require_once( get_template_directory() . '/framework/php/metabox.option.php' );
require_once( get_template_directory() . '/framework/php/metabox.class.php' );



add_action('wp_ajax_wip_post_upload_action', 'WIP_post_ajax_callback');
add_action( 'wp_ajax_nopriv_wip_post_upload_action', 'WIP_post_ajax_callback' );
function WIP_post_ajax_callback() {

		global $wpdb;
		
		#check the type of form
		if($_POST['type']){
			$save_type = $_POST['type'];
		} else {
			$save_type = null;
		}
		
		
		
		if( $save_type == 'upload_portfolio_image' ) {

			$imgData = '';
			$returnData = '';
			$PortData = get_option('bd_portfolio_data');
			
			$imgData = isset( $_FILES['portfolio_image'] ) ? true : false;

			if( ! $imgData ){
			
				$returnData = array(
					"error" => true,
					"errorText" => __('Image file cannot be read!', 'wip')
				);
						
				echo json_encode($returnData);			
				die();
				
			} else {
				
				$unique = intval( time() ) . '-WIP-portfolio-data';
				$curID = $unique;
					
					/** ======= break processs ======== */

					$arr_file_type = wp_check_filetype( basename( $_FILES['portfolio_image']['name']) );					
					$uploaded_file_type = $arr_file_type['type'];
					
					# Set an array containing a list of acceptable formats
					$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
					
					/** ======= break processs ======== */
					
					# if data is an image - upload it
					if( in_array( $uploaded_file_type, $allowed_file_types ) ) {
						
						# override the upload process, WordPress need to detect 'wp_handle_upload' before upload the doc
						$filename = $_FILES['portfolio_image'];
						$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] ); 
						$override['test_form'] = false;
						$override['action'] = 'wp_handle_upload';
						
						# upload process...
						$uploaded_file = wp_handle_upload( $filename, $override );
						$upload_tracking[] = 'portfolio_image';
						
						$path_info = wp_upload_dir();
						
						$file_info = pathinfo( $uploaded_file['file'] );
						$image_filename = $file_info['filename'] .'.'. $file_info['extension'];
						$imageinfo = array(
							'subdir' => $path_info['subdir'],
							'image' => $image_filename
						);

						$newThumbs = wip_resize( $uploaded_file['file'], $uploaded_file['url'], 215, 99999, false );
						$newThumb = $newThumbs['url'];

						
							$Sdata = array(
								'id' => $curID,
								'type' => 'image',
								'image' => $imageinfo,
								'video' => '',
							);				
							
							/** ======= break processs ======== */
							
							if( is_array($PortData) ){
								
								$dataIns[$curID] = $Sdata;
								$toIns = $PortData + $dataIns;
							
							} else {
							
								$toIns[$curID] = $Sdata;
							
							}
							
							update_option( 'bd_portfolio_data' , $toIns );
						
						
						#returning into ajax
						$returnData = array(
							"error" => false,
							"image" => $newThumb,
							"ajaxImageId" => $curID
						);
								
						echo json_encode($returnData);
						die();
					
					} else { #if error

						$uploaded_file['error'] = __('Unsupported file type!', 'wip');
						
						$returnData = array(
							"error" => true,
							"errorText" => sprintf ( __('Upload Error: %1$s', 'wip') , $uploaded_file['error'] )
						);
								
						echo json_encode($returnData);
						die();
						
					}

			}	
		
		} elseif( $save_type == 'portfolio_reset' ) {

		
		}  elseif( $save_type == 'portfolio_video' ) {
		
			$vidData = '';
			$returnData = '';
			
			$PortData = get_option('bd_portfolio_data');
			
			if( isset($_POST['data'] ) ){
				$vidData = $_POST['data'];
			}
			
			if( $vidData == "" || $vidData == "Enter video URL" ){
			
				$returnData = array(
					"error" => true,
					"errorText" => __('Please enter the video URL before click the button!', 'wip')
				);
						
				echo json_encode($returnData);			
			
			} else {
				
				$unique = intval( time() ) . '-WIP-portfolio-data';
				$curID = $unique;

						
							$Sdata = array(
								'id' => $curID,
								'type' => 'video',
								'image' => '', 
								'video' => $vidData,
							);				
							
							/** ======= break processs ======== */
							
							if( is_array($PortData) ){
								
								$dataIns[$curID] = $Sdata;
								$toIns = $PortData + $dataIns;
							
							} else {
							
								$toIns[$curID] = $Sdata;
							
							}
							
							/** ======= break processs ======== */
							
							//update the image and thumbnail
							update_option( 'bd_portfolio_data' , $toIns );
						
						#returning into ajax
						$returnData = array(
							"error" => false,
							"vid" => $vidData,
							"ajaxId" => $curID
						);
								
						echo json_encode($returnData);
		
			}
			
		}
		
		
		die();
		
}

?>