<?php
/**
 * Class for page manager
 * @author webinpixels
 * @since 2012
 */
 
Class wip_page_manager{
	
	var $_column_modules;
	
	function __construct() {
		
		#call function for column modules
		$this->_column_modules = wip_lcs_builder();
		
		#build header
		$this->_page_create_header();
		
		#build body (options sections)
		$this->_page_create_content();
		
		#build footer
		$this->_page_create_footer();
		
	}
	
	
	/**
	 * Create the header of layout
	 * @return the HTML markup
	 */
	function _page_create_header(){

		$markup .= '<div id="webinpixels_wraper">' . "\n";
		
		echo $markup;
	}
	
	
	
	function _page_create_content(){
		global $post;
	?>
		
		<div id="page-columns-lists">

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
		
		<div class="clear"></div>
		
		<div id="page_the_layout">
				<div id="wip-layout-placement">
					<span class="layout-tit-top"><?php _e('Page Content', 'wip'); ?></span>
					
					
					<div id="actual-layout">
					
						<?php 

						echo $this->_print_current_layout_db( $post->ID ); 
						
						?>
					
					</div>
				
				</div><!-- end #wip-layout-placement -->
		
		</div>

		
	<?php
	}
	
	
	function _print_current_layout_db( $id ){
		
		$parentStruct = get_post_meta( $id, '_wipfr_page_parent_layout', true);	
		$throw = "";
		
		if( ! empty( $parentStruct ) && is_array( $parentStruct ) ){
		
		$throw = '<ul id="wip-layout-item-lists" >' . "\n";
		
			foreach( $parentStruct as $pid => $key ){
				if( isset( $key['type'] ) ){
					
					$pL = $key['type'];
					switch( $pL ){
					
						case 'fullwidth':
							
							$throw .= wipfr_fullwidth_module( $pid, wip_page_manager::_get_current_content_db( $id, $pid ), true );
							
							break;
						
						case 'sidebar_content':
						
							$throw .= wipfr_sidebarcontent_module( 'sidebar_content', $pid, wip_page_manager::_get_current_content_db( $id, $pid ), true );
						
							break;
							
						case 'content_sidebar':
						
							$throw .= wipfr_sidebarcontent_module( 'content_sidebar', $pid, wip_page_manager::_get_current_content_db( $id, $pid ), true );
						
							break;
					
					}
				}
			}
			
		$throw .= '</ul>' . "\n";
		
		}
		
		return $throw;
	
	
	}
	
	
	function _get_current_content_db( $postid, $parentID ){
		
		$contentStruct = get_post_meta( $postid, '_wipfr_page_content_layout', true);	
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
									
								case 'single-page-content':

									$con .= wipfr_get_singlepagecontent_layout( $thisID, $parentID );
									
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
	
	
	function _process_layout_save( $post_id, $post ){
		global $wpdb;
		

	if ( !$_POST ) return $post_id;
	if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
	if( is_int( wp_is_post_autosave( $post_id ) ) ) return;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( !current_user_can( 'edit_post', $post_id )) return $post_id;
	
	if( ('page' == $_POST['post_type']) && ( isset($_POST['update']) || isset($_POST['save']) || isset($_POST['publish']) ) ){
	
		$parentIds = ( isset($_POST['wip_page_parent_id']) ) ? $_POST['wip_page_parent_id'] : '';
		
		if($parentIds != ""){
			
			$parrentStruct = array();
			$parentContent = array();
			
			foreach( (array)  $_POST['wip_page_parent_id'] as $pid ):		

					$parent_type = isset( $_POST['layout_parent'][$pid] ) ? esc_attr( $_POST['layout_parent'][$pid] ) : '';

					
					$parrentStruct[$pid] = array(
						'id' => $pid,
						'type' => $parent_type
					);
					
					if( $parent_type == 'sidebar_content' || $parent_type == 'content_sidebar' ){
						update_option('wip_sidebarid_'.$pid.'_'.$post_id , ( isset( $_POST['wip_sidebarid_'.$pid] ) ? esc_attr( $_POST['wip_sidebarid_'.$pid] ) : 'Default Sidebar' ) );
					} else {
						delete_option('wip_sidebarid_'.$pid.'_'.$post_id);
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
													
												case 'single-page-content':
												
													$fields = array(
														'content' => 1
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
			update_post_meta($post_id, '_wipfr_page_parent_layout', $parrentStruct);
			update_post_meta($post_id, '_wipfr_page_content_layout', $parentContent);
			
		
		} else {
		
			delete_post_meta($post_id, '_wipfr_page_parent_layout', get_post_meta($post_id, '_wipfr_page_parent_layout', true));
			delete_post_meta($post_id, '_wipfr_page_content_layout', get_post_meta($post_id, '_wipfr_page_content_layout', true));

		}
		
	}

	
	}
	
	
	
	/**
	 * Create the footer of layout
	 * @return the HTML markup
	 */
	function _page_create_footer(){
		
		$markup = '</div><!-- #webinpixels_wraper -->' . "\n";
		
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
			$uId = ( isset( $_POST['parentId'] ) ) ? intval($_POST['parentId']) : '';
			
			if( $layout != '' && $uId != '' ){

				$toEcho = wipfr_get_layout_for_setting( $layout, $uId, 0, true );
				echo $toEcho;
				
				die();
			
			}
			
		} else if( $save_type == 'addContentToLayout'){
			
			$uId = isset( $_POST['uId'] ) ? intval($_POST['uId']) : '';
			$contentValue = isset( $_POST['contentValue'] ) ? $_POST['contentValue'] : "";
			$possibleID = isset( $_POST['possibleID'] ) ? intval($_POST['possibleID']) : '';

			
			if( $uId != "" && $contentValue != "" && $possibleID != "" ){
				
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