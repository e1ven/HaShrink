<?php
/**
 * Class for homepage manager
 * @author webinpixels
 * @since 2012
 */
 
Class wip_home_manager{
	
	var $_column_modules;
	
	function __construct() {
		
		#call function for column modules
		$this->_column_modules = wip_lcs_builder();
		
		#build header
		$this->_create_header();
		
		#build body (options sections)
		$this->_create_content();
		
		#build footer
		$this->_create_footer();
		
	}
	
	
	/**
	 * Create the header of layout
	 * @return the HTML markup
	 */
	function _create_header(){
		
		$markup = '<div class="wrap">' . "\n";
		
		$markup .= '<div id="webinpixels_wraper">' . "\n";
		$markup .= '<div class="icon32" id="icon-options-general"><br/></div><h2>' . __('Homepage Manager', 'wip') . '</h2>' . "\n";
		
		if( isset($_GET['saved']) && ($_GET['saved'] == "true") ){
			$markup .= '<div id="message" class="updated below-h2"><p>'.__('Your content structure is saved!', 'wip').'</p></div>';
		}
		
		
		echo $markup;
	}
	
	
	
	function _create_content(){
	?>
		
		<div id="columns-lists">
			<h3><?php print __('Layouts', 'wip'); ?></h3>
			
			<ul>
				<?php
					foreach( $this->_column_modules as $x => $k ):
				?>
				<li>
					<span id="<?php echo $x; ?>" class="col_insert">
						<?php print $k['title']; ?>
						<img class="waiting" src="<?php echo admin_url('images/wpspin_light.gif'); ?>" alt="" />
						<a href="#" class="anchor_insert_cols" title="<?php print __('Insert', 'wip'); ?>">+</a>
					</span>
				</li>
				<?php
					endforeach;
				?>
			</ul>
			
		</div>
		
		
		<div id="the_layout">
		<form id="wip-form-layout"  action="" method="post" enctype="multipart/form-data">
			<div id="layout_info">
				<h3><?php _e('Current Homepage Content', 'wip'); ?></h3>
				<div class="topper">
					<input type="submit" name="save_wip_layout" class="wip-layout-sent" value="<?php _e('Save Changes', 'wip'); ?>"/>
				</div>
			</div>
		
			<div class="wip-layout-inner">
				
				<div id="wip-slider-placement" class="wip-layout-item wip-layout-edit-active">
					<dl class="wip-layout-item-bar">
						<dt class="wip-layout-item-handle">
							<span class="layout-title"><?php print __('Homepage Slider', 'wip'); ?></span>
							<a class="wip-edit-layout-item" title="<?php print __('Edit', 'wip'); ?>" href="#wip-layout-item-settings-0"><?php print __('Edit', 'wip'); ?></a>
						</dt>
					</dl>
					
					<div class="wip-layout-item-settings" id="wip-layout-item-settings-0">
						<p>
						<input type="checkbox" name="home-slider-off" id="home-slider-off"<?php if( _wipfr_homeslider_inactive() ) echo ' checked="checked"'; ?>/>
						<label for="home-slider-off"><?php print __('Turn off the homepage slider?','wip'); ?></label>
						</p>						
						<p><small><?php printf( __('You can manage the homepage slider settings and image on the <a href="%s">theme settings</a> page','wip'), admin_url('admin.php?page=wip-panel#slider_settings')); ?></small></p>
						<input type="hidden" name="parent_id[0]" value="0"/>
					</div>
				</div><!-- end #wip-slider-placement -->
				
				<div id="wip-layout-placement">
					<span class="layout-tit-top"><?php _e('Homepage Content', 'wip'); ?></span>
					
					
					<div id="actual-layout">
					
						<?php echo $this->_print_current_layout_db(); ?>
					
					</div>
				
				</div><!-- end #wip-layout-placement -->
				
				

			</div>
			
			<div id="wip-layout-form-executor">
				<input type="submit" name="save_wip_layout" class="wip-layout-sent" value="<?php _e('Save Changes', 'wip'); ?>"/>
				<input type="hidden" name="action" value="save_layout" />
				<input type="hidden" name="layoutID" value="wip_home_manager" />
			</div>
		</form>
		</div>
		
		
		<div class="clear"></div>
		
	<?php
	}
	
	
	function _print_current_layout_db(){
		
		$parentStruct = get_option( 'wipfr_parent_home_layout');	
		$throw = "";
		
		if( ! empty( $parentStruct ) && is_array( $parentStruct ) ){
		
		$throw = '<ul id="wip-layout-item-lists" >' . "\n";
		
			foreach( $parentStruct as $pid => $key ){
				if( isset( $key['type'] ) ){
					
					$pL = $key['type'];
					switch( $pL ){
					
						case 'fullwidth':
							
							$throw .= wipfr_fullwidth_module( $pid, wip_home_manager::_get_current_content_db($pid) );
							
							break;
						
						case 'sidebar_content':
						
							$throw .= wipfr_sidebarcontent_module( 'sidebar_content', $pid, wip_home_manager::_get_current_content_db($pid) );
						
							break;
							
						case 'content_sidebar':
						
							$throw .= wipfr_sidebarcontent_module( 'content_sidebar', $pid, wip_home_manager::_get_current_content_db($pid) );
						
							break;
					
					}
				}
			}
			
		$throw .= '</ul>' . "\n";
		
		}
		
		return $throw;
	
	
	}
	
	
	function _get_current_content_db( $parentID ){
		
		$contentStruct = get_option( 'wipfr_parent_home_content');
		$con='';
		
		if( ! empty( $contentStruct ) && is_array( $contentStruct ) ){
			$con = '<ul class="layout-placer-lists">' . "\n";
			
			foreach( $contentStruct as $id => $c ){
			
				if( isset($c['parent']) && ( $c['parent'] == $parentID ) ){
					$thisID = isset( $c['id'] ) ? $c['id'] : '';
					$type = isset( $c['type'] ) ? $c['type'] : '';
					if( $type != "" ){
						
						
						
						
						if( substr($type, -3) == 'col' ){
						
							switch( $type ){
								case '4col':
									
									$insidecol = array();
									foreach( $c['field'] as $z => $t ){
										
										$col_content_type = '';
										if(isset( $t['content'] )) $col_content_type = $t['content'];
										
										$fields = array();
										foreach( $t as $name => $value ){
											if( $name != 'content' ){
												$fields[] = $value;
											}
										}
										
										if( $col_content_type != '' ){
											$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
										} else {
											$insidecol[] = "";
										}
									}
									
									$con .= wipfr_columns_module( 4, $thisID, $parentID, '4col', $insidecol );
									
									break;
									
								case '3col':
									
									$insidecol = array();
									foreach( $c['field'] as $z => $t ){
										
										$col_content_type = '';
										if(isset( $t['content'] )) $col_content_type = $t['content'];
										
										$fields = array();
										foreach( $t as $name => $value ){
											if( $name != 'content' ){
												$fields[] = $value;
											}
										}
										
										if( $col_content_type != '' ){
											$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
										} else {
											$insidecol[] = "";
										}
										
									}
									
									$con .= wipfr_columns_module( 3, $thisID, $parentID, '3col', $insidecol );
									
									break;
									
								case '2col':
									
									$insidecol = array();
									foreach( $c['field'] as $z => $t ){
										
										$col_content_type = '';
										if(isset( $t['content'] )) $col_content_type = $t['content'];
										
										$fields = array();
										foreach( $t as $name => $value ){
											if( $name != 'content' ){
												$fields[] = $value;
											}
										}
										
										if( $col_content_type != '' ){
											$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
										} else {
											$insidecol[] = "";
										}
										
									}
									
									$con .= wipfr_columns_module( 2, $thisID, $parentID, '2col', $insidecol );
									
									break;
									
									case '1_2_3col':
										
										$colConcept = array('1/3','2/3');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '1_2_3col', $insidecol );
									
										break;
										
									case '2_1_3col':
										
										$colConcept = array('2/3','1/3');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '2_1_3col', $insidecol );
									
										break;
										
									case '1_1_2_4col':
										
										$colConcept = array('1/4','1/4','2/4');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '1_1_2_4col', $insidecol );
									
										break;
										
									case '1_2_1_4col':
										
										$colConcept = array('1/4','2/4','1/4');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '1_2_1_4col', $insidecol );
									
										break;
										
									case '2_1_1_4col':
										
										$colConcept = array('2/4','1/4','1/4');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '2_1_1_4col', $insidecol );
									
										break;
										
									case '1_3_4col':
										
										$colConcept = array('1/4','3/4');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '1_3_4col', $insidecol );
									
										break;
										
									case '3_1_4col':
										
										$colConcept = array('3/4','1/4');
										$insidecol = array();
										foreach( $c['field'] as $z => $t ){
											
											$col_content_type = '';
											if(isset( $t['content'] )) $col_content_type = $t['content'];
											
											$fields = array();
											foreach( $t as $name => $value ){
												if( $name != 'content' ){
													$fields[] = $value;
												}
											}
											
											if( $col_content_type != '' ){
												$insidecol[] = wipfr_content_for_column( $col_content_type, $z, $thisID, $fields);
											} else {
												$insidecol[] = "";
											}
											
										}
										
										$con .= wipfr_mix_columns_module( $colConcept, $thisID, $parentID, '3_1_4col', $insidecol );
									
										break;
							
							}
						
						} else {
						
							switch( $type ){
								case 'divider1':
								case 'divider2':
									
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_divider_layout( $thisID, $parentID, $type, $fields );
									
									break;
									
									
								case 'paragraph-text':
									
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_full_paragraph_layout( $thisID, $parentID, $fields );
									
									break;
									
									
								case 'tagline':
								
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_full_tagline_layout( $thisID, $parentID, $fields );
									
									break;
									
								case 'taglinebutton':
								
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_full_taglinebutton_layout( $thisID, $parentID, $fields );
									
									break;
									
								case 'single-page':
								
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_get_singlepage_layout( $thisID, $parentID, $fields );
									
									break;
									
								case 'blog-lists':
								
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_get_bloglists_layout( $thisID, $parentID, $fields );
									
									break;
									
								case 'portfolio-lists':
								
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_get_portfolio_layout( $thisID, $parentID, $fields );
									
									break;

								case 'product-lists':
								
									$fields = array();
									foreach( $c['field'] as $z => $t ){
										$fields[] = $t;
									}
									
									$con .= wipfr_get_product_layout( $thisID, $parentID, $fields );
									
									break;
							
							}
						
						}
						
						
						
						
					
					}
				}
			}
			
			$con .= '</ul>';
		}
		
		return $con;
	
	}
	
	
	function _process_layout_save(){
		
		if( isset( $_POST['action'] ) && $_POST['action'] == 'save_layout' ):
			
			if( isset($_POST['layoutID']) &&  $_POST['layoutID'] == 'wip_home_manager' ):

				$parentIds = ( isset($_POST['parent_id']) ) ? $_POST['parent_id'] : '';
				
				if($parentIds != ""){
					
					$parrentStruct = array();
					$parentContent = array();
					
					foreach( (array)  $_POST['parent_id'] as $pid ):
							
							$parent_type = "";
							if( $pid === '0' ){
								$parent_type = isset( $_POST['home-slider-off'] ) ? '1' : '';
							} else {
								$parent_type = isset( $_POST['layout_parent'][$pid] ) ? esc_attr( $_POST['layout_parent'][$pid] ) : '';
							}
							
							$parrentStruct[$pid] = array(
								'id' => $pid,
								'type' => $parent_type
							);
							
							if( $parent_type == 'sidebar_content' || $parent_type == 'content_sidebar' ){
								update_option('wip_sidebarid_'.$pid , ( isset( $_POST['wip_sidebarid_'.$pid] ) ? esc_attr( $_POST['wip_sidebarid_'.$pid] ) : 'Default Sidebar' ) );
							} else {
								delete_option('wip_sidebarid_'.$pid);
							}
							
							if( isset( $_POST['id'] ) ){
							
								foreach( (array) $_POST['id'] as $p => $thisids ):
									
									
									if( $p == $pid ){
										
										foreach( $thisids as $thisid ):
										
											$fields = array();
											if( isset( $_POST['type'][$thisid] ) ){
												
												$theContent = $_POST['type'][$thisid];
												
												if( substr($theContent, -3) == 'col' ){ #should be columns module
												
													$colCount = wipfr_get_numberOf_column( $theContent );
													
														$a = 0;
														for( $a = 1; $a <= $colCount; $a++ ){
															
															$col_content = isset( $_POST['content-column'][$a][$thisid] ) ? $_POST['content-column'][$a][$thisid] : '';
															
															if( $col_content != "" ){
															
																switch( $col_content ){
																	case 'paragraph-text':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'text-column' => isset( $_POST['text-column'][$a][$thisid] ) ? stripslashes( $_POST['text-column'][$a][$thisid] ) : '',
																			'useautop-column' => isset( $_POST['useautop-column'][$a][$thisid] ) ? '1' : ''
																		);
																		
																		break;
																	
																	
																	case 'latest-post':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'blogcount-column' => isset( $_POST['blogcount-column'][$a][$thisid] ) ? esc_attr($_POST['blogcount-column'][$a][$thisid]) : '',
																			'showthumbnail-column' => isset( $_POST['showthumbnail-column'][$a][$thisid] ) ? '1' : '',
																			'showexcerpt-column' => isset( $_POST['showexcerpt-column'][$a][$thisid] ) ? '1' : ''
																		);
																		
																		break;
																		
																		
																	case 'latest-post-column':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'blogcount-column' => isset( $_POST['blogcount-column'][$a][$thisid] ) ? esc_attr($_POST['blogcount-column'][$a][$thisid]) : ''
																		);
																		
																		break;
																		
																	case 'latest-portfolio-thumbnail':
																	case 'latest-portfolio-column':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'portfoliocount-column' => isset( $_POST['portfoliocount-column'][$a][$thisid] ) ? esc_attr($_POST['portfoliocount-column'][$a][$thisid]) : '',
																			'portfoliocat-column' => isset( $_POST['portfoliocat-column'][$a][$thisid] ) ? $_POST['portfoliocat-column'][$a][$thisid] : ''
																		);
																		
																		break;
																		
																	case 'latest-product':
																	case 'latest-product-column':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'productcount-column' => isset( $_POST['productcount-column'][$a][$thisid] ) ? esc_attr($_POST['productcount-column'][$a][$thisid]) : '',
																			'productcat-column' => isset( $_POST['productcat-column'][$a][$thisid] ) ? $_POST['productcat-column'][$a][$thisid] : '',
																			'showfeatured-column' => isset( $_POST['showfeatured-column'][$a][$thisid] ) ? '1' : ''
																		);
																		
																		break;
																		
																	case 'latest-tweet':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'tweetid-column' => isset( $_POST['tweetid-column'][$a][$thisid] ) ? stripslashes($_POST['tweetid-column'][$a][$thisid]) : '',
																			'tweetcount-column' => isset( $_POST['tweetcount-column'][$a][$thisid] ) ? $_POST['tweetcount-column'][$a][$thisid] : ''
																		);
																		
																		break;
																		
																	case 'flickr-photo':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'flickrid-column' => isset( $_POST['flickrid-column'][$a][$thisid] ) ? stripslashes($_POST['flickrid-column'][$a][$thisid]) : '',
																			'flickrcount-column' => isset( $_POST['flickrcount-column'][$a][$thisid] ) ? $_POST['flickrcount-column'][$a][$thisid] : ''
																		);
																		
																		break;
																		
																	case 'box-testimonial':
																		
																		$fields[$a] = array(
																			'content' => $col_content,
																			'title-column' => isset( $_POST['title-column'][$a][$thisid] ) ? stripslashes($_POST['title-column'][$a][$thisid]) : '',
																			'testitext-column' => isset( $_POST['testitext-column'][$a][$thisid] ) ? stripslashes($_POST['testitext-column'][$a][$thisid]) : '',
																			'testiauthor-column' => isset( $_POST['testiauthor-column'][$a][$thisid] ) ? esc_attr($_POST['testiauthor-column'][$a][$thisid]) : ''
																		);
																		
																		break;
																} #end switch
															} #end if $col_content != ""
															else {
																$fields[$a] = array(
																	'content' => $col_content
																);
															}
														} #end for $colCount;
													
												} #end if substr($theContent, -3) == 'col'
												else {
													
													switch( $theContent ){
														case 'divider1':
														case 'divider2':
															
															$fields = array(
																'custom-divider-title' => isset( $_POST['custom-divider-title'][$thisid] ) ? stripslashes($_POST['custom-divider-title'][$thisid]) : '',
																'fontcolor-divider-title' => isset( $_POST['fontcolor-divider-title'][$thisid] ) ? esc_attr($_POST['fontcolor-divider-title'][$thisid]) : '',
																'fontbgcolor-divider-title' => isset( $_POST['fontbgcolor-divider-title'][$thisid] ) ? esc_attr($_POST['fontbgcolor-divider-title'][$thisid]) : '',
																'showtop-link' => isset( $_POST['showtop-link'][$thisid] ) ? '1' : ''
															);
															
															break;
															
															
														case 'paragraph-text':
															
															$fields = array(
																'custom-paragraph-title' => isset( $_POST['custom-paragraph-title'][$thisid] ) ? stripslashes($_POST['custom-paragraph-title'][$thisid]) : '',
																'custom-paragraph-text' => isset( $_POST['custom-paragraph-text'][$thisid] ) ? stripslashes($_POST['custom-paragraph-text'][$thisid]) : '',
																'custom-paragraph-autop' => isset( $_POST['custom-paragraph-autop'][$thisid] ) ? '1' : ''
															);
															
															break;
															
														case 'tagline':
															
															$fields = array(
																'custom-taglines-text' => isset( $_POST['custom-taglines-text'][$thisid] ) ? stripslashes($_POST['custom-taglines-text'][$thisid]) : '',
																'custom-taglines-color' => isset( $_POST['custom-taglines-color'][$thisid] ) ? stripslashes($_POST['custom-taglines-color'][$thisid]) : '',
																'custom-taglines-fontstyle' => isset( $_POST['custom-taglines-fontstyle'][$thisid] ) ? stripslashes($_POST['custom-taglines-fontstyle'][$thisid]) : '',
																'custom-taglines-fontweight' => isset( $_POST['custom-taglines-fontweight'][$thisid] ) ? stripslashes($_POST['custom-taglines-fontweight'][$thisid]) : '',
																'custom-taglines-texttransform' => isset( $_POST['custom-taglines-texttransform'][$thisid] ) ? stripslashes($_POST['custom-taglines-texttransform'][$thisid]) : ''
															);
															
															break;
															
														case 'taglinebutton':
															
															$fields = array(
																'custom-tagline-text' => isset( $_POST['custom-tagline-text'][$thisid] ) ? stripslashes($_POST['custom-tagline-text'][$thisid]) : '',
																'custom-tagline-buttonurl' => isset( $_POST['custom-tagline-buttonurl'][$thisid] ) ? stripslashes($_POST['custom-tagline-buttonurl'][$thisid]) : '',
																'custom-tagline-buttontext' => isset( $_POST['custom-tagline-buttontext'][$thisid] ) ? stripslashes($_POST['custom-tagline-buttontext'][$thisid]) : '',
																'custom-tagline-buttonbg' => isset( $_POST['custom-tagline-buttonbg'][$thisid] ) ? stripslashes($_POST['custom-tagline-buttonbg'][$thisid]) : '',
																'custom-tagline-buttonborder' => isset( $_POST['custom-tagline-buttonborder'][$thisid] ) ? stripslashes($_POST['custom-tagline-buttonborder'][$thisid]) : '',
																'custom-tagline-buttoncolor' => isset( $_POST['custom-tagline-buttoncolor'][$thisid] ) ? stripslashes($_POST['custom-tagline-buttoncolor'][$thisid]) : '',
																'custom-tagline-bgcolor' => isset( $_POST['custom-tagline-bgcolor'][$thisid] ) ? stripslashes($_POST['custom-tagline-bgcolor'][$thisid]) : '',
																'custom-tagline-color' => isset( $_POST['custom-tagline-color'][$thisid] ) ? stripslashes($_POST['custom-tagline-color'][$thisid]) : '',
																'custom-tagline-fontstyle' => isset( $_POST['custom-tagline-fontstyle'][$thisid] ) ? stripslashes($_POST['custom-tagline-fontstyle'][$thisid]) : '',
																'custom-tagline-fontweight' => isset( $_POST['custom-tagline-fontweight'][$thisid] ) ? stripslashes($_POST['custom-tagline-fontweight'][$thisid]) : '',
																'custom-tagline-texttransform' => isset( $_POST['custom-tagline-texttransform'][$thisid] ) ? stripslashes($_POST['custom-tagline-texttransform'][$thisid]) : ''
															);
															
															break;
															
														case 'single-page':
														
															$fields = array(
																'single-pageid' => isset( $_POST['single-pageid'][$thisid] ) ? stripslashes($_POST['single-pageid'][$thisid]) : '0',
																'show-pagetitle' => isset( $_POST['show-pagetitle'][$thisid] ) ? '1' : ''
															);
														
															break;
															
														case 'blog-lists':
															
															$fields = array(
																'blog-lists-layout' => isset( $_POST['blog-lists-layout'][$thisid] ) ? stripslashes($_POST['blog-lists-layout'][$thisid]) : '',
																'blog-lists-number' => isset( $_POST['blog-lists-number'][$thisid] ) ? stripslashes($_POST['blog-lists-number'][$thisid]) : '4',
																'blog-lists-pagination' => isset( $_POST['blog-lists-pagination'][$thisid] ) ? '1' : '',
																'blog-lists-column' => isset( $_POST['blog-lists-column'][$thisid] ) ? stripslashes($_POST['blog-lists-column'][$thisid]) : '4',
																'blog-lists-content' => isset( $_POST['blog-lists-content'][$thisid] ) ? stripslashes($_POST['blog-lists-content'][$thisid]) : 'excerpt',
																'blog-lists-title' => isset( $_POST['blog-lists-title'][$thisid] ) ? stripslashes($_POST['blog-lists-title'][$thisid]) : ''
															);
													
														
															break;

														case 'product-lists':
															
															$fields = array(
																'product-lists-column' => isset( $_POST['product-lists-column'][$thisid] ) ? stripslashes($_POST['product-lists-column'][$thisid]) : '4',
																'product-lists-number' => isset( $_POST['product-lists-number'][$thisid] ) ? stripslashes($_POST['product-lists-number'][$thisid]) : '4',
																'product-lists-pagination' => isset( $_POST['product-lists-pagination'][$thisid] ) ? '1' : '',
																'product-lists-cat' => isset( $_POST['product-lists-cat'][$thisid] ) ? stripslashes($_POST['product-lists-cat'][$thisid]) : '',
																'product-lists-featured' => isset( $_POST['product-lists-featured'][$thisid] ) ? '1' : '',
																'product-lists-title' => isset( $_POST['product-lists-title'][$thisid] ) ? stripslashes($_POST['product-lists-title'][$thisid]) : ''
															);
														
															break;
															
															
														case 'portfolio-lists':
															
															$fields = array(
																'portfolio-lists-column' => isset( $_POST['portfolio-lists-column'][$thisid] ) ? stripslashes($_POST['portfolio-lists-column'][$thisid]) : '4',
																'portfolio-lists-number' => isset( $_POST['portfolio-lists-number'][$thisid] ) ? stripslashes($_POST['portfolio-lists-number'][$thisid]) : '4',
																'portfolio-lists-pagination' => isset( $_POST['portfolio-lists-pagination'][$thisid] ) ? '1' : '',
																'portfolio-lists-cat' => isset( $_POST['portfolio-lists-cat'][$thisid] ) ? stripslashes($_POST['portfolio-lists-cat'][$thisid]) : '',
																'portfolio-lists-featured' => isset( $_POST['portfolio-lists-featured'][$thisid] ) ? '1' : '',
																'portfolio-lists-title' => isset( $_POST['portfolio-lists-title'][$thisid] ) ? stripslashes($_POST['portfolio-lists-title'][$thisid]) : '',
															);
														
															break;
													
													}
												
												}
											
											} #end isset( $_POST['type'][$thisid] )
											
											
											$parentContent[$thisid] = array(
												'id' => $thisid,
												'parent' => $pid,
												'type' => isset( $_POST['type'][$thisid] ) ? esc_attr( $_POST['type'][$thisid] ) : '',
												'field' => $fields
											);
											
										endforeach; #end for each $thisids as $thisid
									
									} #end if $p == $pid
									
								endforeach; #end for each $_POST['id'] as $p => $thisids
							
							} #end isset( $_POST['id'] )
					
					endforeach;

					
					//save the layout
					update_option( 'wipfr_parent_home_layout', $parrentStruct );
					update_option( 'wipfr_parent_home_content', $parentContent );
					
					
					//delete the draft field
					delete_option( 'wipfr_parent_home_layout_draft');
					delete_option( 'wipfr_parent_home_content_draft');
					
					
					wp_safe_redirect(admin_url('admin.php?page=wip-home-manager&saved=true'));
					die();
				
				
				} else {
					//delete the layout
					delete_option( 'wipfr_parent_home_layout' );
					delete_option( 'wipfr_parent_home_content' );
					
					
					//delete the draft field
					delete_option( 'wipfr_parent_home_layout_draft');
					delete_option( 'wipfr_parent_home_content_draft');
					
					wp_safe_redirect(admin_url('admin.php?page=wip-home-manager&saved=true'));
					die();
				}
			
			
			endif;#if layoutID == wip_home_manager
		
		endif; #if action == save_layout
	
	}
	
	
	
	/**
	 * Create the footer of layout
	 * @return the HTML markup
	 */
	function _create_footer(){
		
		$markup = '</div><!-- #webinpixels_wraper -->' . "\n";
		$markup .= '</div><!-- .wrap -->' . "\n";
		
		echo $markup;
	}
	
	
	
	function ajaxProcessLayout(){
		global $wpdb;
	
		if( isset($_POST['type']) && $_POST['type']){
			$save_type = $_POST['type'];	
		} else {
			$save_type = null;	
		}
		
		if( $save_type == 'addItemToLayout' ){
		
			$layout = ( isset( $_POST['layout'] ) ) ? $_POST['layout'] : '';
			
			if( $layout != '' ){
				
				$currentParent = get_option('wipfr_parent_home_layout');
				$currentParentDraft = get_option('wipfr_parent_home_layout_draft');
				
				$insertID = array();
				$uId = 1;
				$toEcho = '';
				$parentdrafting = '';
				
				
				if( !empty($currentParent) && is_array($currentParent) ){

					$biggest = array();
					foreach( $currentParent as $x => $n ){
						$biggest[$x] = $x;
					}

					$bigNum = max( $biggest );
					$uId = intval($bigNum) + 1;//possible db id
					
					if( !empty($currentParentDraft) && is_array($currentParentDraft) ){
						
						$biggestDraft = array();
						foreach( $currentParentDraft as $xd => $nd ){
							$biggestDraft[$xd] = $xd;
						}
						
						if( array_key_exists( $uId, $biggestDraft ) ){
							$bigNumDraft = max( $biggestDraft );
							$uId = $bigNumDraft+1; //possible db id
						}
					
					} 

					
				} else {
				
					if( !empty($currentParentDraft) && is_array($currentParentDraft) ){
						
						$biggestDraft = array();
						foreach( $currentParentDraft as $xd => $nd ){
							$biggestDraft[$xd] = $xd;
						}
						
						if( array_key_exists( $uId, $biggestDraft ) ){
							$bigNumDraft = max( $biggestDraft );
							$uId = $bigNumDraft+1; //possible db id
						}
					
					}

				}
				
				$insertID[$uId] = array(
					"id" => $uId,
					"type" => $layout
				);
				
				if( !empty($currentParentDraft) && is_array($currentParentDraft) ){
					$parentdrafting = $currentParentDraft + $insertID;
				} else {
					$parentdrafting = $insertID;
				}
				
				update_option( 'wipfr_parent_home_layout_draft', $parentdrafting );
				
				$toEcho = wipfr_get_layout_for_setting( $layout, $uId );
				echo $toEcho;
				
				die();
			
			}
			
		} else if( $save_type == 'addContentToLayout'){
			
			$uId = isset( $_POST['uId'] ) ? $_POST['uId'] : 0;
			$contentValue = isset( $_POST['contentValue'] ) ? $_POST['contentValue'] : "";
			
			$currentContent = get_option('wipfr_parent_home_content');
			$currentContentDraft = get_option('wipfr_parent_home_content_draft');
			$possibleID = 1;
			$drafting = '';
			
			if( !empty($uId) && $contentValue != "" ){
				
				if( !empty($currentContent) && is_array($currentContent) ){
					
					$biggest = array();
					foreach( $currentContent as $x => $n ){
						$biggest[$x] = $x;
					}

					$bigNum = max( $biggest );
					$possibleID = $bigNum+1; //possible db id
					
					if( !empty($currentContentDraft) && is_array($currentContentDraft) ){
						
						$biggestDraft = array();
						foreach( $currentContentDraft as $xd => $nd ){
							$biggestDraft[$xd] = $xd;
						}
						
						if( array_key_exists( $possibleID, $biggestDraft ) ){
							$bigNumDraft = max( $biggestDraft );
							$possibleID = $bigNumDraft+1; //possible db id
						}
					
					} 
					
				} else {
					
					if( !empty($currentContentDraft) && is_array($currentContentDraft) ){
						
						$biggestDraft = array();
						foreach( $currentContentDraft as $xd => $nd ){
							$biggestDraft[$xd] = $xd;
						}
						
						if( array_key_exists( $possibleID, $biggestDraft ) ){
							$bigNumDraft = max( $biggestDraft );
							$possibleID = $bigNumDraft+1; //possible db id
						}
					
					}
					
				}
				
				$contentDraft[$possibleID] = array(
					'id' => $possibleID,
					'parent' => $uId,
					'type' => $contentValue
				);
				
				if( !empty($currentContentDraft) && is_array($currentContentDraft) ){
					$drafting = $currentContentDraft + $contentDraft;
				} else {
					$drafting = $contentDraft;
				}
				
				update_option( 'wipfr_parent_home_content_draft', $drafting );
				
				
				echo wipfr_get_layout_for_setting( $contentValue, $possibleID, $uId );
				die();
			}
		
		} else if( $save_type == 'addContentToBox' ){
		
			$formname = isset( $_POST['formname'] ) ? $_POST['formname'] : '';
			$formvalue = isset( $_POST['formvalue'] ) ? $_POST['formvalue'] : '';
			
			if( ($formname != "") && ($formvalue != "") ){
				
				$theID = str_replace('[', ',', $formname);
				$theID = str_replace(']', '', $theID);
				
				$findIt = explode(",", $theID);
				$html = wipfr_content_for_column( $formvalue, $findIt[1], $findIt[2] );
				
				$return = array(
					"col" => $findIt[1],
					"parID" => $findIt[2],
					"html" => $html
				);
				
				echo json_encode( $return );
				die();
			}
			
		}
		
		die();
	
	}


}

?>