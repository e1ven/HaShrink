<?php
/**
 * Class for custom metabox
 * 
 * @author WebInPixels
 */
 
Class WIP_metabox{


	function WIP_metabox_builder( $formArray ){
		
		global $post;
	
		$this->WIP_metabox_before();
		
		
		$this->WIP_metabox_content( $formArray );
		
		
		$this->WIP_metabox_after();	
	
	}
	
	
	
	
	function WIP_metabox_before(){
		?>
<div id="wip_custom_metabox">
		<?php
	}
	
	
	function WIP_metabox_content( $opt ){
	
		foreach($opt as $option ):
		
			$this->WIP_print_form($option);
		
		endforeach;
	
	}
	
	
	
	
	
	
	function WIP_metabox_after(){
		?>
</div><!-- #wip_custom_metabox -->
		<?php
	}

	function WIP_print_form( $O ){
	
		switch ( $O['type'] ){
		
			case 'text':
				$this->text_input( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;
				
			case 'one_check':
				$this->onecheck_input( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;
				
			case 'select':
				$this->select_input( $O['id'], $O['label'], $O['std'], $O['desc'], $O['option'] );
				break;
				
			case 'layout':
				$this->select_layout( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;
				
			case 'thumbnail':
				$this->upload_thumbnail( $O['id'], $O['label'], $O['desc'] );
				break;
				
			case 'portfolio-data':
				$this->upload_portfolio( $O['id'], $O['label'], $O['desc'] );
				break;
				
			case 'featured':
				$this->portfolio_sticky( $O['id'], $O['label'], $O['desc'] );
				break;
		
		}
	
	}
	
	
	
	
	
	
	//text input
	function text_input( $id, $label, $std, $desc ){
		
		global $post;
		
		$value = get_post_meta( $post->ID, $id, true);
		
		?>
		
			<div class="wip-meta-form">
				
				<span class="wip-label"><?php echo $label; ?></span>
			
				<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="text" value="<?php if( $value != "" ) { echo stripslashes( $value ); } else { echo $std; } ?>" />
				
				<?php if( $desc != "" ) { ?><div class="wip-desc"><?php echo stripslashes( $desc ); ?></div><?php } ?>
			
			</div>
		
		<?php
	}
	
	
	
	
	
	
	function onecheck_input( $id, $label, $std, $desc = "" ){
	
	global $post;
		
	$value = get_post_meta( $post->ID, $id, true);
	
	if( $value != "" ){
		
		if( $value === "1" ){
			$s = ' checked="checked"';
		} elseif( $value === "0" ) {
			$s = '';
		}
	
	} else {
		
		if( $std === "1" ){
			$s = ' checked="checked"';
		} else {
			$s = '';
		}
	
	}
	
	
	?>
	
				<div class="wip-meta-form">
					
					<span class="wip-label"><?php echo $label; ?></span>
					
					<input type="checkbox" value="1" id="<?php echo $id; ?>" name="<?php echo $id; ?>"<?php echo $s; ?>/>					
					
					<?php if ( $desc != "" ) { ?><div class="wip-desc"><?php echo $desc; ?></div><?php } ?>
					
				</div>
	
	<?php
	}
	
	
	
	
	
	function portfolio_sticky( $id, $label, $desc = "" ){
		global $post;
		
		$sticky = get_option('wip_featured_portfolio');
		$is_stick = false;
		$s = "";
		if( is_array($sticky) && in_array( $post->ID, $sticky ) ) $is_stick = true;
		
		if( $is_stick ){
			$s = ' checked="checked"';
		}
		?>
		
				<div class="wip-meta-form">
					
					<span class="wip-label"><?php echo $label; ?></span>
					
					<input type="checkbox" value="1" id="<?php echo $id; ?>" name="<?php echo $id; ?>"<?php echo $s; ?>/>					
					
					<?php if ( $desc != "" ) { ?><div class="wip-desc"><?php echo $desc; ?></div><?php } ?>
					
				</div>
		
		<?php
	}
	
	
	
	
	
	
	
	function select_input( $id, $label, $std, $desc = "", $select ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
	?>
	
			<div class="wip-meta-form">
				
				<span class="wip-label"><?php echo $label; ?></span>
			
					<select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
						
						<?php foreach ( $select as $opt ) { ?>
						
						<option<?php if ( $value == $opt) { echo ' selected="selected"'; } elseif ( ( $value == "" ) && ( $std == $opt ) ) { echo ' selected="selected"'; } ?>><?php echo $opt; ?></option>
						
						<?php } ?>
							
					</select>
					
				<?php if( $desc != "" ) { ?><div class="wip-desc"><?php echo stripslashes( $desc ); ?></div><?php } ?>
			
			</div>
	
	<?php
	}
	
	
	
	
	
	
	
	
	function select_layout( $id, $label, $std, $desc = "" ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
	?>
	
			<div class="wip-meta-form image-radio-option">
				
				<span class="wip-label"><?php echo $label; ?></span>
			
					<div class="layout">
						<label class="description">
							
									<span>
										<img src="<?php echo get_template_directory_uri(); ?>/framework/images/sidebar-content.png" width="136" height="122" alt="" />
									</span>
								<input type="radio" name="<?php echo $id; ?>" value="sidebar-content"<?php if( $value == 'sidebar-content' ) { echo ' checked="checked"'; } elseif( $value == '' && $std == 'sidebar-content' ) {  echo ' checked="checked"'; } ?> />
						</label>
					</div>
					
					<div class="layout">
						<label class="description">
							
									<span>
										<img src="<?php echo get_template_directory_uri(); ?>/framework/images/content-sidebar.png" width="136" height="122" alt="" />
									</span>
								<input type="radio" name="<?php echo $id; ?>" value="content-sidebar"<?php if( $value == 'content-sidebar' ) { echo ' checked="checked"'; } elseif( $value == '' && $std == 'content-sidebar' ) {  echo ' checked="checked"'; } ?> />
						</label>
					</div>
					
					<div class="clear"></div>
					
				<?php if( $desc != "" && $post->post_type == 'page' ) { ?><div class="wip-desc"><?php echo stripslashes( $desc ); ?></div><?php } ?>
			
			</div>
	
	<?php
	}
	
	
	
	
	
	
	
	function upload_thumbnail( $id, $label, $desc = "" ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
		$imgURL = "";
		
		$thumbnails = get_option('bd_portfolio_thumbnail');
		
		if( !empty($thumbnails) ){
			
			if( isset( $thumbnails[$value] ) ){
			
				foreach($thumbnails as $unique => $thumb ){
				
					if( $unique == $value ) $imgURL = $thumb['thumbnail']; 
				
				}
			
			}
		
		
		}
	?>
	
				<div class="wip-meta-form">
					
					<span class="wip-label"><?php echo $label; ?></span>
					
					<div class="t-preview">

						<?php if( $value != "" ) { echo '<img src="' . $imgURL . '" alt="" />'; } ?>

					</div>
					
					<span id="<?php echo $id; ?>"  class="upload_button upload_thumbnail_button" rel="<?php echo $id; ?>"><?php print __('Upload', 'wip'); ?></span>
					<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="thumb_id" type="hidden" value="<?php if( $value != "" ) { echo stripslashes( $value ); } else { echo ""; } ?>" />
					<input name="thispostid" class="thispostid" type="hidden" value="<?php echo $post->ID; ?>" />
					
					<?php if ( $desc != "" ) { ?><div class="wip-desc"><?php echo $desc; ?></div><?php } ?>
					
				</div>
	
	<?php
	}
	
	
	
	
	
	
	function upload_portfolio( $id, $label, $desc = "" ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
		$isThere = false;
		$imgURL = "";
		$video = "";
		
		$portfolios = get_option('bd_portfolio_data');
		
		if( !empty($portfolios) ){
			
			if( isset( $portfolios[$value] ) ){
			
				foreach($portfolios as $unique => $port ){
				
					if( $unique == $value ) {
						
						
						if( $port['type'] == 'image' ){
							
							if( isset($port['image']) && is_array($port['image']) ){
								$isThere = true;
								
								$uploadPath = wp_upload_dir();
								$imageDir = $uploadPath['basedir'] . $port['image']['subdir'] . '/' . $port['image']['image'];
								$imageUrl = $uploadPath['baseurl'] . $port['image']['subdir'] . '/'. $port['image']['image'];	
								
								$theThumb = wip_resize( $imageDir, $imageUrl, 215, 99999, false );
								$imgURL = $theThumb['url'];
							}
						
						} elseif( $port['type'] == 'video' ) {
							
							if( $port['video'] != "" ){
								$isThere = true;
								
								$video = $port['video'];
								$vidType = typeOflink( $video );
							}
						
						}
					
					
					} 
				
				}
			
			}
		
		
		}
	?>

				<div class="wip-meta-form" id="portfolio_o">
					
					<span class="wip-label"><?php echo $label; ?></span>
					
					<div class="p-preview"<?php if( $isThere ) : echo ' style="display:block;"'; else : echo ' style="display:none;"'; endif; ?>>

						<?php if( $imgURL != "" ) { echo '<img src="' . $imgURL . '" alt="" /><a id="delete_portfolio" href="#" title="delete"></a>'; } ?>
						
						<?php if( $video != "" ) echo WIPobjectPrint($video, $vidType, '215', '161', 'false' ) . '<a id="delete_portfolio" href="#" title="delete"></a>'; ?>

					</div>
					
					<?php if ( $desc != "" ) { ?><div class="wip-desc"<?php if( $isThere ) : echo ' style="display:none;"'; else : echo ' style="display:block;"'; endif; ?>><?php echo $desc; ?></div><?php } ?>
					
					<div id="portfolio-bt-handle"<?php if( $isThere ) : echo ' style="display:none;"'; else : echo ' style="display:block;"'; endif; ?>>
						<div id="pp-wip-pp">
						<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="uploadify_upload_portfolio" type="file" />
						</div>
						
						<span class="or">- OR -</span>
						<input type="text" name="portfolio-video" id="portfolio-video" value="Enter video URL" onfocus="if (this.value == 'Enter video URL') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter video URL';}" />
						<span class="upload_button insert_video">Insert Video</span>
						
						<div class="clear"></div>
					</div>
					
					<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="portfolio_id" type="hidden" value="<?php if( $value != "" ) { echo stripslashes( $value ); } else { echo ""; } ?>" />
					<input name="thispostid" class="thispostid" type="hidden" value="<?php echo $post->ID; ?>" />
					
					
					
				</div>
	
	<?php
	}

}