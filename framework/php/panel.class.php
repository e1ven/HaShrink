<?php
/**
 *  Class for theme options
 * 
 *  @package WIPanel
 *  @since 1.0
 */
 
Class WIPanel {

	function __construct() {
		
		$this->themeOptions = WIP_get_options();
		
		#build header
		$this->WIPanel_create_header();
		
		#build body (options sections)
		$this->WIPanel_create_content();
		
		#build footer
		$this->WIPanel_create_footer();
		
	}


	function WIPanel_create_header(){
		
		?>
		
<!-- .wip_wraper -->
<div class="wip_wraper">
				
	<!-- #wip_header_container -->
	<div id="wip_header_container">
							
		<h1 id="wip-title-panel"><?php print __('Theme Settings', 'wip'); ?></h1>
		
		<span class="wip-theme-name">
			<h3>The Builder</h3>
			<span class="wip-theme-version">version <?php echo get_option('theBuilder_db_version'); ?></span>
		</span>
	</div>
	<!-- end #wip_header_container -->
			
		<?php
		
	}

	
	function WIPanel_create_content(){
	
		?>
			
	<div id="wip-main">
				
				
		<div id="wip-tabs">
			<ul>
			
			<?php 
			
			foreach($this->themeOptions as $menu => $m ):
			
			?>
			
			<li>
			<a href="#<?php echo $menu; ?>">
			<img src="<?php echo $m['icon']; ?>" alt="" /><?php echo ucwords( str_replace('_',' ',$menu) );?>
			</a>
			<?php
			if( isset( $m['child'] ) ){
				echo '<ul class="child_left">' . "\n";
					foreach( $m['child'] as $o => $r ){
						
						if( $o == 'first' ){
							echo '<li><a href="#' . $menu . '">&rarr; '.$r['title'].'</a></li>' . "\n";
						} else {
							echo '<li><a href="#' . $o . '">&rarr; '. ucwords( str_replace('_',' ',$o) ) .'</a></li>' . "\n";
						}
					
					}
				echo '</ul>' . "\n";
			}
			?>
			</li>
			
			<?php 
			
			endforeach; 
			
			
			?>
			
			</ul>
		</div>
					
					
		<div id="wip-content">
		
		<?php foreach($this->themeOptions as $menu => $m ):?>
		
			<div class="wip-area" id="<?php echo $menu; ?>">
				
				<?php foreach( $m['options'] as $a => $b ):?>
						
						<?php $this->WIP_break_options($b); ?>
						
				<?php endforeach; ?>
				
			</div>
			
				<?php
					if( isset( $m['child'] ) ){
						foreach( $m['child'] as $o => $r ):					
							if( $o != 'first' ){
							?>
			<div class="wip-area" id="<?php echo $o; ?>">
				<?php
					foreach( $r as $t => $u ){	
						$this->WIP_break_options($u);
					}
				?>
			</div>			
							<?php
							}
						endforeach;
					}
				?>
		
		<?php endforeach; ?>
					
		</div>
					
	<div class="wip-clear"></div>
	</div>
			
		<?php
		
	}

	function WIPanel_create_footer(){
	
		?>
			
</div>
<!-- end .wip_wraper -->

	
		<?php
		
	}
	
	function WIP_break_options( $optPart ){
	
		switch ( $optPart['type'] ){
		
			case 'form':
				$this->WIP_open_form( $optPart['ajax'] );
				break;
		
			case 'text':
				$this->WIP_text_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'] );
				break;
				
			case 'text-withinfo':
				$this->WIP_textinfo_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'], $optPart['info'] );
				break;
				
			case 'color':
				$this->WIP_color_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'] );
				break;
				
			case 'textarea':
				$this->WIP_textarea_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'] );
				break;
				
			case 'textareasmall':
				$this->WIP_textarea_small_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'] );
				break;
				
			case 'textareascript':
				$this->WIP_textareascript_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'] );
				break;
				
			case 'upload_image':
				$this->WIP_uploadimage_input( $optPart['id'], $optPart['label'], $optPart['desc'] );
				break;
			
			case 'upload_script':
				$this->WIP_uploadscript_input( $optPart['id'], $optPart['label'] );
				break;
				
			case 'onecheck':
				$this->WIP_onecheck_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'] );
				break;
				
			case 'radio':
				$this->WIP_radio_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'], $optPart['option'], $optPart['choosen'] );
				break;
				
			case 'select':
				$this->WIP_select_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'], $optPart['option'] );
				break;
				
			case 'select_label':
				$this->WIP_select_input_label( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'], $optPart['option'] );
				break;
				
			case 'selectid':
				$this->WIP_selectid_input( $optPart['id'], $optPart['label'], $optPart['std'], $optPart['desc'], $optPart['option'], $optPart['choosen'] );
				break;
				
			case 'label':
				$this->WIP_section_label( $optPart['label'], $optPart['first-row'] );
				break;
			
			case 'labelonOff':
				$this->WIP_section_labelonOff( $optPart['label'] );
				break;
				
			case 'CloselabelonOff':
				$this->WIP_close_section_labelonOff();
				break;
			
			case 'close_form':
				$this->WIP_close_form( $optPart['part'], $optPart['reset'] );
				break;
				
				
			case 'upload_icons':
				$this->WIP_icons_frameform( $optPart['shortname'] );
				break;
				
			case 'slider':
				$this->WIP_slider_frameform( $optPart['shortname'] );
				break;
				
			case 'add_sidebar':
				$this->WIP_sidebar_frameform( $optPart['shortname'] );
				break;
				
				
			case 'wraper':
				$this->WIP_wraper( $optPart['label'], $optPart['area'] );
				break;
				
			case 'wraper_close':
				$this->WIP_wraper_close();
				break;
				
			case 'upload_background':
				$this->WIP_uploadbackground_input( $optPart['id'], $optPart['label'], $optPart['desc'] );
				break;
				
			case 'clear_float':
				$this->WIP_clear_float();
				break;
					
				
		}
		
	}
	
	
	
	function WIP_wraper( $label, $id ){
	
	$moreStyle = "";
	if( $id == 'form_for_bd_allbackgroundcolor' ){
		$ly = get_option('bd_skinlayout');
		if( $ly == "" || $ly == 'box' ){
			$moreStyle = ' style="display:block;"';
		} else {
			$moreStyle = ' style="display:none;"';
		}
	}
	?>
		
		<div class="wraper_skin" id="<?php echo $id; ?>"<?php echo $moreStyle; ?>>
			<h4 class="wraper_skin_title"><?php echo $label; ?></h4>
	
	<?php
	}
	
	
	function WIP_wraper_close(){
		echo '<div class="clear"></div></div>' . "\n";
	}
	
	
	function WIP_uploadbackground_input( $id, $name, $desc = '' ){
	?>
	
				<div class="wip-form upload_bg">
					
					<span class="wip-label"><?php echo $name; ?></span>

					
					<input style="float:left; margin-right: 5px;" name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="text" value="<?php if( get_option($id) != "" ) { echo stripslashes( esc_attr(get_option($id) ) ); } else { echo $std; } ?>" />
					
					<input name="uploader_<?php echo $id; ?>" id="uploader_<?php echo $id; ?>" class="uploadify_upload_bg" type="file" />
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
					<div class="wip-clear"></div>
					
				</div>
	
	<?php
	}
	
	
	function WIP_color_input( $id, $name, $std, $desc = "" ){	
	?>
	
				<div class="wip-form colorish">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<span class="imitation_form_color"><?php if( get_option($id) != "" ) { echo '#'.stripslashes( get_option($id) ); } else { echo '#'.$std; } ?></span>
					<label class="color_label" for="<?php echo $id; ?>" style="background-color: #<?php if( get_option($id) != "" ) { echo stripslashes( get_option($id) ); } else { echo $std; } ?>;">
					<input style="width: 0px;height: 0px;padding: 0px;" name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="color_scheme_input" type="text" value="<?php if( get_option($id) != "" ) { echo stripslashes( get_option($id) ); } else { echo $std; } ?>" />
					</label>
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	
	function WIP_clear_float(){
		echo '<div class="clear"></div>' . "\n";
	}
	
	
	function WIP_open_form($ajax){
		
		if( $ajax ){
		
			echo '<form method="post" action="" enctype="multipart/form-data" class="uajax">';
		
		} else {
		
			echo '<form method="post" action="" enctype="multipart/form-data">';
		}
		
	}
	
	function WIP_text_input( $id, $name, $std, $desc = "" ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="text" value="<?php if( get_option($id) != "" ) { echo stripslashes( esc_attr(get_option($id) ) ); } else { echo $std; } ?>" />
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>

				</div>
	
	<?php
	}
	
	function WIP_textinfo_input( $id, $name, $std, $desc = "", $info = "" ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="text" value="<?php if( get_option($id) != "" ) { echo stripslashes(get_option($id)); } else { echo $std; } ?>" />
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
						
					<?php if ( $info != "" ) { ?><div class="wip-add-info"><?php echo stripslashes($info); ?></div><?php } ?>
					

				</div>
	
	<?php
	}
	
	
	function WIP_textarea_input( $id, $name, $std, $desc = "" ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" rows="5" cols="30"><?php if( get_option($id) != "" ) { echo stripslashes( esc_textarea(get_option($id) ) ); } else { echo stripslashes( $std ); } ?></textarea>
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	function WIP_textarea_small_input( $id, $name, $std, $desc = "" ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" rows="5" cols="30" class="small"><?php if( get_option($id) != "" ) { echo stripslashes( esc_textarea(get_option($id) ) ); } else { echo stripslashes( $std ); } ?></textarea>
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	
	function WIP_textareascript_input( $id, $name, $std, $desc = "" ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
<pre style="font-size: 11px; color: #aaa; border-top: 1px solid #dadada;">&lt;script type='text/javascript'&gt;
/* &lt;![CDATA[ */
</pre>
					<br/>
					<textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" rows="5" cols="30"><?php if( get_option($id) != "" ) { echo stripslashes( esc_textarea(get_option($id) ) ); } else { echo stripslashes( $std ); } ?></textarea>
					<br/>
<pre style="font-size: 11px; color: #aaa; border-bottom: 1px solid #dadada; margin-top: 10px;">
/* ]]> */
&lt;/script&gt;
</pre>

					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	function WIP_select_input( $id, $name, $std, $desc = "", $select ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
						<select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
						
						<?php foreach ( $select as $opt ) { ?>
						
						<option<?php if ( get_option( $id ) == $opt) { echo ' selected="selected"'; } elseif ( ( get_option( $id ) == "" ) && ( $std == $opt ) ) { echo ' selected="selected"'; } ?>><?php echo $opt; ?></option>
						
						<?php } ?>
							
						</select>
						
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	function WIP_select_input_label( $id, $name, $std, $desc = "", $select ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
						<select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
						
						<?php foreach ( $select as $label => $opts ) { ?>
							
							<optgroup label="<?php echo $opts['label']; ?>">
								
								<?php 
								if( isset($opts['font']) && is_array($opts['font']) ){	
									foreach( $opts['font'] as $opt){ 
								?>
									<option<?php if ( get_option( $id ) == $opt) { echo ' selected="selected"'; } elseif ( ( get_option( $id ) == "" ) && ( $std == $opt ) ) { echo ' selected="selected"'; } ?>><?php echo $opt; ?></option>
								<?php 
									}
								}
								?>
								
							</optgroup>
							
						<?php } ?>
							
						</select>
						
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	function WIP_selectid_input( $id, $name, $std, $desc = "", $select, $selectid ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
						<select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
						
							<?php for ($i = 0; $i < count($select); $i++ ) { ?>
								
								<?php if(get_option( $id ) != ""  ){ ?>
									<option value="<?php echo $selectid[$i]; ?>" <?php if ( get_option( $id ) == $selectid[$i]) { echo ' selected="selected"'; }?>><?php echo $select[$i]; ?></option>
								<?php } else { ?>	
									<option value="<?php echo $selectid[$i]; ?>"<?php if ( $selectid[$i] == $std) { echo ' selected="selected"'; } ?>><?php echo $select[$i]; ?></option>
								<?php } ?>
								
							<?php } ?>
							
						</select>
						
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	function WIP_radio_input( $id, $name, $std, $desc = "", $select, $selectid ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
						
						<div style="width: 360px; margin: 0px;">
						<?php 
						$i = 0;
						foreach ($select as $opt) { 
						?>
						<span style="display: block; margin: 0px; padding: 3px 0px; border-bottom: 1px dotted #666;">
							<label style="display: inline-block;vertical-align:middle; font-size: 11px;padding-top: 2px;">
							<input type="radio" name="<?php echo $id; ?>" id="<?php echo $id . '-' . $i; ?>" value="<?php echo $selectid[$i]; ?>"<?php if ( get_option( $id ) == $selectid[$i] ) { echo ' checked="checked"'; } elseif ( ( get_option( $id ) == "" ) && ( $std == $selectid[$i] ) ) { echo ' checked="checked"'; } ?>>
							<?php echo $opt; ?></label>
						</span>
						<?php 
						$i++; } 
						?>
						
						</div>
						
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
				

		<?php if( $id == "bd_skinlayout" ){ ?>			
<script type="text/javascript">
/* <![CDATA[ */
(function($){
	$(document).ready(function(){
		$('input[name="bd_skinlayout"]').bind('change', function(){
			var t = $(this),
				vl = t.val();
			
			if( vl == 'box' ){
				$('#form_for_bd_allbackgroundcolor').slideDown();
			} else {
				$('#form_for_bd_allbackgroundcolor').slideUp();
			}
			
		});
	});
})(jQuery);
/* ]]> */
</script>	
		<?php } ?>				
				</div>
	
	<?php
	}
	
	function WIP_section_label( $name, $first = false ){
	
		echo '<div class="wip_section_label';
		if($first) echo ' first-row';
		echo '">';
		
			echo '<h4>' . stripslashes($name) . '</h4>';
		
		echo '</div>' . "\n";
	}
	
	
	function WIP_section_labelonOff( $name ){
	
		echo '<div class="wip_section_labelonOff">';
		
			echo '<h2><span>[ + ]</span> ' . stripslashes($name) . '</h2>';
		
		echo '<div class="wip_labelonOff_jq" style="display:none;">';
		
	}
	
	function WIP_close_section_labelonOff(){
	
		echo '<div class="wip-close-form"><input name="save" class="WIPanel-submit-section" type="submit" value="' . __('Save changes', 'wip') . '" /></div>';
	
		echo '</div>';
		
		echo '</div>';

	}
	
	
	function WIP_onecheck_input( $id, $name, $std, $desc = "" ){
	
	if( get_option( $id ) != "" ){
		
		if( get_option( $id ) == "1" ){
			$s = ' checked="checked"';
		} elseif( get_option( $id ) == "0" ) {
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
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<input type="checkbox" value="1" id="<?php echo $id; ?>" name="<?php echo $id; ?>"<?php echo $s; ?>/>					
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
				</div>
	
	<?php
	}
	
	function WIP_uploadimage_input( $id, $name, $desc = '' ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label on-line"><?php echo $name; ?></span>
					
					<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="uploadify_upload_image" type="file" />

					<input type="hidden" class="ajax_action_url" name="wp_ajax_action_url" value="<?php echo admin_url("admin-ajax.php"); ?>" />
					
					<br/>
					
					<span class="wip-image-preview<?php if( wip_get_uploaded_image_url($id) ) { ?> preview-img<?php } ?>">
					
					<img class="image_preview" id="image_<?php echo $id; ?>" src="<?php  echo wip_get_uploaded_image_url($id); ?>" alt="" /><a href="#" class="delete_image" rel="<?php echo $id; ?>" title="<?php print __('Delete image', 'wip'); ?>"></a>
					
					</span>
					
					<?php if ( $desc != "" ) { ?><span class="wip-desc"><?php echo $desc; ?></span><?php } ?>
					
					<div class="wip-clear"></div>
					
				</div>
	
	<?php
	}
	
	function WIP_uploadscript_input( $id, $name ){
	?>
	
				<div class="wip-form">
					
					<span class="wip-label"><?php echo $name; ?></span>
					
					<input name="<?php echo $id; ?>" class="uploaded_script" type="text" value="<?php if( get_option($id) != "" ) { echo get_option($id); } ?>" />
					
					<span id="<?php echo $id; ?>"  class="upload_button upload_script_button" rel="<?php echo $id; ?>"><?php print __('Upload', 'wip'); ?></span>
					<input type="hidden" class="ajax_action_url" name="wp_ajax_action_url" value="<?php echo admin_url("admin-ajax.php"); ?>" />
					
					<br/>
					<span class="wip-desc"><?php print __('You can change the default cufon font by uploading your cufon font script here', 'wip'); ?></span>
					
				</div>
	
	<?php
	}
	
	
	function WIP_close_form( $part, $reset ){
	?>
	
				<div class="wip-close-form">
				
						<input name="save" class="WIPanel-submit-section" type="submit" value="<?php print __('Save changes', 'wip'); ?>" /> 
						<input type="hidden" name="part" value="<?php echo $part; ?>" />
						<input type="hidden" name="action" class="wipaction" value="save" />
						
					</form>
					
				<?php if( $reset ): ?>
					<form method="post" action="" enctype="multipart/form-data" class="uajax_reset">
						<input name="reset" class="WIPanel-reset-section" type="submit" value="<?php print __('Reset', 'wip'); ?>" /> 
						<input type="hidden" class="ajax_action_url" name="wp_ajax_action_url" value="<?php echo admin_url("admin-ajax.php"); ?>" />
						<input type="hidden" name="part" class="parto" value="<?php echo $part; ?>" />
						<input type="hidden" name="action" class="wipaction" value="reset" />
					</form>
				<?php endif; ?>
					
				</div>
	
	<?php
	}
	
	
	function WIP_icons_frameform( $s ){
	
		#build form for uploader
		?>
		<form method="post" action="" enctype="multipart/form-data" class="iconajax">
		
			<div class="wip-form">
			
					<span class="icon-preview">
					
					</span>
			
					<input name="icon_image" id="icon_image" class="uploadify_upload_icon" type="file" />
					<input type="hidden" name="wip_icon_image" class="main_form_icon" value="" />
					
					<div class="wip-clear"></div>
					
					<span class="wip-desc"><?php print __('Please use the same icon size.<br/> Recomended icon size is 20 pixels (width and height)', 'wip'); ?></span>
					
			</div>
			<div class="wip-form">
			
					<span class="wip-label"><?php print __('Link URL', 'wip'); ?></span>
					
					<input name="wip_icon_url" id="wip_icon_url" type="text" value="" />
					
			
			</div>
			<div class="wip-form">
			
					<span class="wip-label"><?php print __('Link title (optional)', 'wip'); ?></span>
					
					<input name="wip_icon_title" id="wip_icon_title" type="text" value="" />
					
			
			</div>
			<br/>
			<center>
			<input name="save" class="WIPanel-submit-section add_more_icons" type="submit" value="<?php print __('+ Add Icon', 'wip'); ?>" />
			<input type="hidden" name="shortname" value="<?php echo $s; ?>" />
			</center>
			<br/>
		</form>
		
		<?php #icon lists ?>
		<table cellspacing="0" cellpadding="0" border="0" class="widefat fixed" id="iconicon_lists">
			<thead>
				<tr>
					<th scope="col" class="manage-column column-name" width="100%" align="center"><?php print __('Below are icons you have submited', 'wip'); ?></th>
				</tr>
			</thead>
			
			<?php
				$get_icons = get_option($s.'_fan_icons');
				
			if( !empty($get_icons) ) {
				foreach( $get_icons as $i => $icons):
					$path_info = wp_upload_dir();
					$iconImg = $icons['icon'];
					
					$ic =  $path_info['baseurl'] . $iconImg['subdir'] . '/' . $iconImg['file'];
			?>
				
			<tr class="iconicon-data">

				<td colspan="2" style="padding-top: 10px; padding-bottom: 10px; height: 50px; line-height: 30px;">
					
					<span style="display: inline-block;width: 50px; float: left;">
						<a href="<?php echo $icons['link']; ?>" target="_blank" style="text-shadow: none;" title="<?php echo $icons['text']; ?>">
						<img src="<?php echo $ic; ?>" alt="" class="alignleft" style="margin: 0px; display: block;"/>
						</a>
					</span>
					
					<a class="delete_icon_lists delete_delete" href="#" rel="<?php echo 'data='.$i.'&shortname='.$s; ?>" style="text-shadow: none;" title="<?php print __('Delete', 'wip'); ?>"></a> 
				</td>

			</tr>
				
			<?php
				endforeach;
				
			} else {
			?>
				
			<tr class="icon-no-data">
				<td style="padding-top: 10px; padding-bottom: 10px; text-shadow: none; color: #333;"><?php print __('No icons Found!', 'wip'); ?></td>
			</tr>
				
			<?php
			} 
			?> 

		</table>
		
		
		<?php
	
	}

	
	function WIP_sidebar_frameform( $s ){

		?>
		<form method="post" action="" enctype="multipart/form-data" class="sgajax">
		
			<div class="wip-form">
			
					<span class="wip-label"><?php print __('Sidebar name', 'wip'); ?></span>
					
					<input name="wip_sidebar_name" id="wip_sidebar_name" type="text" value="" />
					
			</div>

			<br/>
			<center>
			<input name="save" class="WIPanel-submit-section add_more_sidebar" type="submit" value="<?php print __('+ Add New Sidebar', 'wip'); ?>" />
			<input type="hidden" name="shortname" value="<?php echo $s; ?>" />
			</center>
			<br/>
		</form>
		
		<?php #sidebar lists ?>
		<table cellspacing="0" cellpadding="0" border="0" class="widefat fixed" id="wip-sidebarsidebar-lists">
			<thead>
				<tr>
					<th scope="col" class="manage-column column-name" width="100%" align="center"><?php print __('Below are custom sidebar(s) you have submited', 'wip'); ?></th>
				</tr>
			</thead>
			
			<?php
				$sidebars = get_option($s.'_sidebar_gen');
				
			if( !empty($sidebars) ) {
				foreach( $sidebars as $sidebar):
			?>
				
			<tr class="wip-sidebar-data">

				<td colspan="2" style="padding-top: 10px; padding-bottom: 10px; height: 50px; line-height: 30px;" class="sidebar-lists">
					
					<span style="text-shadow: none; color: #555; margin-right: 20px;">
						<strong><?php echo $sidebar; ?></strong>
					</span>
					
					<a class="delete_sidebar_lists delete_delete" href="#" rel="<?php echo 'data='.$sidebar.'&shortname='.$s; ?>" style="text-shadow: none;" title="<?php print __('Delete', 'wip'); ?>"></a> 
				</td>

			</tr>
				
			<?php
				endforeach;
				
			} else {
			?>
				
			<tr class="wip-no-sidebar">
				<td style="padding-top: 10px; padding-bottom: 10px; text-shadow: none; color: #333;"><?php print __('No custom sidebars found!', 'wip'); ?></td>
			</tr>
				
			<?php
			} 
			?> 

		</table>
		
		
		<?php
	
	}
	
	function WIP_slider_frameform( $s ){
	
	$transt = array('easeInOutQuad','easeInOutCubic','easeInOutQuart','easeInOutQuint','easeInOutSine','easeInOutExpo','easeInOutCirc','easeInOutElastic','easeInOutBack','easeInOutBounce')
	?>
	
	<div id="main-slider-form">
		<form method="post" action="" enctype="multipart/form-data" class="sliderajax">
		
			<div class="wip-form" id="sliderslider">
			
					<span class="slider-preview">
					
					</span>
			
					<input name="<?php echo $s; ?>_slider_image" id="<?php echo $s; ?>_slider_image" class="uploadify_upload_slider" type="file" />
					<input type="hidden" name="wip_slider_image" class="main_form_slider" value="" />
					<input type="hidden" name="wip_slider_image_name" class="main_form_slider_image_name" value="" />
					<input type="hidden" name="wip_slider_image_path" class="main_form_slider_path" value="" />
					<input type="hidden" name="wip_slider_image_sub_path" class="main_form_slider_sub_path" value="" />
					<input type="hidden" class="ajax_action_url" name="wp_ajax_action_url" value="<?php echo admin_url("admin-ajax.php"); ?>" />
					
					<div class="wip-clear"></div>
					
					<span class="wip-desc"><?php print __('fix size, 940px by the height of slider container (see Slider Settings tab)', 'wip'); ?></span>
					
			</div>
			
			<div class="wip_section_labelonOff">
		
				<h2><span>[ + ]</span><?php print __('Piecemaker 2 Options'); ?></h2>
		
				<div class="wip_labelonOff_jq" style="display:none;">
		
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('.SWF OR video file URL (optional)', 'wip'); ?></span>
						
						<input name="wip_slider_swf" id="wip_slider_swf" type="text" value="" />
						
						<br/>
						<span class="wip-desc"><?php print __('Please enter full URL, include the "http://"', 'wip'); ?></span>
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Title (required)', 'wip'); ?></span>
						
						<input name="wip_slider_title" id="wip_slider_title" type="text" value="" />
						
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Pieces', 'wip'); ?></span>
						
						<input name="wip_slider_pc_pieces" id="wip_slider_pc_pieces" type="text" value="9" />
						<br/>
						<span class="wip-desc"><?php print __('Number of pieces to which the image is sliced', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Time', 'wip'); ?></span>
						
						<input name="wip_slider_pc_time" id="wip_slider_pc_time" type="text" value="1.2" />
						<br/>
						<span class="wip-desc"><?php print __('Time for one cube to turn, in second', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Transition', 'wip'); ?></span>
						
						<select name="wip_slider_pc_transition" id="wip_slider_pc_transition">
							<?php foreach( $transt as $t ){ ?>
							<option value="<?php echo $t; ?>"><?php echo $t; ?></option>
							<?php } ?>
						</select>
						<br/>
						<span class="wip-desc"><?php print __('Transition type', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Delay', 'wip'); ?></span>
						
						<input name="wip_slider_pc_delay" id="wip_slider_pc_delay" type="text" value="0.1" />
						<br/>
						<span class="wip-desc"><?php print __('Delay between the start of one cube to the start of the next cube', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Depth Offset', 'wip'); ?></span>
						
						<input name="wip_slider_pc_depthoffset" id="wip_slider_pc_depthoffset" type="text" value="300" />
						<br/>
						<span class="wip-desc"><?php print __('The offset during transition on the z-axis. Value between 100 and 1000', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Cube Distance', 'wip'); ?></span>
						
						<input name="wip_slider_pc_cubedistance" id="wip_slider_pc_cubedistance" type="text" value="20" />
						<br/>
						<span class="wip-desc"><?php print __('The distance between the cubes during transition. Values between 5 and 50', 'wip'); ?></span>
				
				</div>
			

			</div>
			</div>
			
		
			<div class="wip-form">
			
					<span class="wip-label"><?php print __('Link URL (optional)', 'wip'); ?></span>
					
					<input name="wip_slider_url" id="wip_slider_url" type="text" value="" />
					
			
			</div>

			<div class="wip-form">
			
					<span class="wip-label"><?php print __('Description (optional)', 'wip'); ?></span>
					
					<textarea name="wip_slider_desc" id="wip_slider_desc" rows="5" cols="30"></textarea>
					
			
			</div>
			<br/>
			<center>
			<input name="save" class="WIPanel-submit-section add_more_slider" type="submit" value="<?php print __('+ Add Slider Object', 'wip'); ?>" />
			<input type="hidden" name="shortname" value="<?php echo $s; ?>" />
			</center>
			<br/>
		</form>
	
	
		<div class="wip_section_label"><h4><?php print __('Below are slider images you have submited<br/>You can drag and drop the list below to re-order the slider object', 'wip'); ?></h4></div>
		<br/>
		
		<div id="slider-lists-con">
			
			<ul id="slider-lists">
			
			<?php
				$get_slider_id = get_option($s . '_slider_id');
				$get_slider_det = get_option($s . '_slider_det');
				
			if( !empty($get_slider_id) ) {

				foreach( $get_slider_id as $i => $ids):
					$th = "";
					$idk = "";
					
					if( array_key_exists( $ids , $get_slider_det ) ){
						$idk = $ids;
						$detforthis = $get_slider_det[$ids];
						$uploadPath = wp_upload_dir();
						if( isset( $detforthis['image'] ) ){
							$img_path = $uploadPath['basedir'] .  $detforthis['image']['subdir'] . '/'. $detforthis['image']['file_name'];
							$img_url = $uploadPath['baseurl'] .  $detforthis['image']['subdir'] . '/'. $detforthis['image']['file_name'];
							if( file_exists($img_path) ){
								$newThumb = wip_resize( $img_path, $img_url, 50, 50, true );
								$th = $newThumb['url'];
							}
						}
					}
					
			?>	
			
			<li class="slider-data">
				<span class="slider-data-in">
				
					<span class="img-slid"><img src="<?php echo $th; ?>" alt="" /></span>
					
					<a href="#" class="slider-delete" title="delete"></a>
					
					<a href="#" class="slider-edit" title="edit"></a>
					
					<input type="hidden" name="_wip_slider_data[]" value="<?php echo $idk; ?>" />
				
				</span> 
			</li>
			<?php
				endforeach;
				
			} else {
			
			?>
				<li class="no-slider">
					<?php print __('No slider image', 'wip'); ?>
				</li>
				
			<?php
			}
			?>
			</ul>
		
		</div>
		
	</div>	
	
	<div id="slider-edit-form">
		
		<form method="post" action="" enctype="multipart/form-data" class="sliderajaxedit">
		
			<div class="wip-form" id="slideredit">
				<span class="slider-preview-edit"><img class="slider_up_preview" src="" alt="" /></span>
					
					<input name="<?php echo $s; ?>_slider_image_edit" id="<?php echo $s; ?>_slider_image_edit" class="uploadify_upload_slider_edit" type="file" />
					
					<div class="wip-clear"></div>
					
					<span class="wip-desc"><?php print __('fix size, 940px by the height of slider container (see Slider Settings tab)<br/>note: once you have upload another image the current image will be deleted', 'wip'); ?></span>			

			</div>
			
			<div class="wip_section_labelonOff">
		
				<h2><span>[ + ]</span><?php print __('Piecemaker 2 Options'); ?></h2>
		
				<div class="wip_labelonOff_jq" style="display:none;">
		
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('.SWF OR video file URL (optional)', 'wip'); ?></span>
						
						<input name="wip_slider_swf_edit" id="wip_slider_swf_edit" type="text" value="" />
						
						<br/>
						<span class="wip-desc"><?php print __('Please enter full URL, include the "http://"', 'wip'); ?></span>
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Title (required)', 'wip'); ?></span>
						
						<input name="wip_slider_title_edit" id="wip_slider_title_edit" type="text" value="" />
						
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Pieces', 'wip'); ?></span>
						
						<input name="wip_slider_pc_pieces_edit" id="wip_slider_pc_pieces_edit" type="text" value="" />
						<br/>
						<span class="wip-desc"><?php print __('Number of pieces to which the image is sliced', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Time', 'wip'); ?></span>
						
						<input name="wip_slider_pc_time_edit" id="wip_slider_pc_time_edit" type="text" value="" />
						<br/>
						<span class="wip-desc"><?php print __('Time for one cube to turn, in second', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Transition', 'wip'); ?></span>
						
						<select name="wip_slider_pc_transition_edit" id="wip_slider_pc_transition_edit">
							<?php foreach( $transt as $t ){ ?>
							<option value="<?php echo $t; ?>"><?php echo $t; ?></option>
							<?php } ?>
						</select>
						<br/>
						<span class="wip-desc"><?php print __('Transition type', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Delay', 'wip'); ?></span>
						
						<input name="wip_slider_pc_delay_edit" id="wip_slider_pc_delay_edit" type="text" value="" />
						<br/>
						<span class="wip-desc"><?php print __('Delay between the start of one cube to the start of the next cube', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Depth Offset', 'wip'); ?></span>
						
						<input name="wip_slider_pc_depthoffset_edit" id="wip_slider_pc_depthoffset_edit" type="text" value="" />
						<br/>
						<span class="wip-desc"><?php print __('The offset during transition on the z-axis. Value between 100 and 1000', 'wip'); ?></span>
				
				</div>
				<div class="wip-form">
				
						<span class="wip-label"><?php print __('Cube Distance', 'wip'); ?></span>
						
						<input name="wip_slider_pc_cubedistance_edit" id="wip_slider_pc_cubedistance_edit" type="text" value="" />
						<br/>
						<span class="wip-desc"><?php print __('The distance between the cubes during transition. Values between 5 and 50', 'wip'); ?></span>
				
				</div>
			

			</div>
			</div>
		
			
			<div class="wip-form">
				<span class="wip-label"><?php print __('Link URL (optional)', 'wip'); ?></span>
				<input name="wip_slider_url_edit" id="wip_slider_url_edit" type="text" value="" />
			</div>
			
			<div class="wip-form">
				<span class="wip-label"><?php print __('Description (optional)', 'wip'); ?></span>
				<textarea name="wip_slider_desc_edit" id="wip_slider_desc_edit" rows="5" cols="30"></textarea>
			</div><br/>
			
			<center>
				<input name="save" class="WIPanel-submit-section edit_the_slider" type="submit" value="Update" />
				<input name="cancel" id="cancel_slider-edit" class="WIPanel-submit-section" type="reset" value="cancel" />
				<input type="hidden" name="editid" id="editid" value="" />
			</center>
				
		</form>
		<p>&nbsp;</p>	
	</div>
	
	<?php
	}

}

?>