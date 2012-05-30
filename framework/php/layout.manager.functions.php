<?php
function wip_lcs_builder(){
	
	$cols = array();
	
	$cols['fullwidth'] = array(
		'title' => __('Full Width', 'wip'),
	);
	
	$cols['sidebar_content'] = array(
		'title' => __('Sidebar - Content', 'wip'),
	);
	
	$cols['content_sidebar'] = array(
		'title' => __('Content - Sidebar', 'wip'),
	);
	
	
	return $cols;

}



/**
 * get the layout for theme panel
 * layout framework
 * @param $type = type of layout that will inserted into layout structure
 * @param $id = unique id, for layout indetifier
 *
 * @return html structure
 */
function wipfr_get_layout_for_setting( $type = "fullwidth", $id, $parentID = 0, $forPage = false ){


	switch ( $type ){
	
		case 'fullwidth':
		
			return wipfr_fullwidth_module( $id, '', $forPage );
			
			break;
			
		case 'sidebar_content':
		
			return wipfr_sidebarcontent_module( 'sidebar_content', $id, '', $forPage );
		
			break;
			
		case 'content_sidebar':
		
			return wipfr_sidebarcontent_module( 'content_sidebar', $id, '', $forPage );
		
			break;
			
		case '4col':
		
			return wipfr_columns_module( 4, $id, $parentID, '4col' );
		
			break;
			
		case '3col':
		
			return wipfr_columns_module( 3, $id, $parentID, '3col' );
		
			break;
			
		case '2col':
		
			return wipfr_columns_module( 2, $id, $parentID, '2col' );
		
			break;
			
		case '1_2_3col':
			
			$colConcept = array('1/3','2/3');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '1_2_3col' );
		
			break;
			
		case '2_1_3col':
			
			$colConcept = array('2/3','1/3');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '2_1_3col' );
		
			break;
			
		case '1_1_2_4col':
			
			$colConcept = array('1/4','1/4','2/4');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '1_1_2_4col' );
		
			break;
			
		case '1_2_1_4col':
			
			$colConcept = array('1/4','2/4','1/4');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '1_2_1_4col' );
		
			break;
			
		case '2_1_1_4col':
			
			$colConcept = array('2/4','1/4','1/4');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '2_1_1_4col' );
		
			break;
			
		case '1_3_4col':
			
			$colConcept = array('1/4','3/4');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '1_3_4col' );
		
			break;
			
		case '3_1_4col':
			
			$colConcept = array('3/4','1/4');
			return wipfr_mix_columns_module( $colConcept, $id, $parentID, '3_1_4col' );
		
			break;
			
			
		case 'divider1':
		case 'divider2':
			
			return wipfr_divider_layout( $id, $parentID, $type );
		
			break;
			
		case 'paragraph-text':
			
			return wipfr_full_paragraph_layout( $id, $parentID );
		
			break;
			
		case 'tagline':
			
			return wipfr_full_tagline_layout( $id, $parentID );
		
			break;
			
		case 'taglinebutton':
			
			return wipfr_full_taglinebutton_layout( $id, $parentID );
		
			break;
			
		case 'single-page':
			
			return wipfr_get_singlepage_layout( $id, $parentID );
		
			break;
			
		case 'single-page-content':
			
			return wipfr_get_singlepagecontent_layout( $id, $parentID );
		
			break;
			
		case 'blog-lists':
			
			return wipfr_get_bloglists_layout( $id, $parentID );
		
			break;


		case 'product-lists':

			return wipfr_get_product_layout( $id, $parentID );

			break;
			
		case 'portfolio-lists':

			return wipfr_get_portfolio_layout( $id, $parentID );

			break;
	
	
	};


}



function wipfr_layout_parent_modules($id){

	$mod = '											
	<span class="span-module column-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Columns', 'wip') .'</span>' . "\n" .'
		<select name="mod-col['.$id.']" id="mod-col-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a column', 'wip') .'</option>' . "\n" .'
			<option value="2col">'. __('2 Columns', 'wip') .'</option>' . "\n" .'
			<option value="3col">'. __('3 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_2_3col">'. __('1/3 - 2/3 Columns', 'wip') .'</option>' . "\n" .'
			<option value="2_1_3col">'. __('2/3 - 1/3 Columns', 'wip') .'</option>' . "\n" .'
			<option value="4col">'. __('4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_1_2_4col">'. __('1/4 - 1/4 - 2/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_2_1_4col">'. __('1/4 - 2/4 - 1/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="2_1_1_4col">'. __('2/4 - 1/4 - 1/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_3_4col">'. __('1/4 - 3/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="3_1_4col">'. __('3/4 - 1/4 Columns', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n" .'
	
	<span class="span-module divider-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Dividers', 'wip') .'</span>' . "\n" .'
		<select name="mod-divider['.$id.']" id="mod-divider-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a divider', 'wip') .'</option>' . "\n" .'
			<option value="divider1">'. __('Divider style 1', 'wip') .'</option>' . "\n" .'
			<option value="divider2">'. __('Divider style 2', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n" .'
	
	<span class="span-module post-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Post', 'wip') .'</span>' . "\n" .'
		<select name="mod-post['.$id.']" id="mod-post-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a post type', 'wip') .'</option>' . "\n" .'
			<option value="single-page">'. __('Single Page', 'wip') .'</option>' . "\n" .'
			<option value="blog-lists">'. __('Blog Lists', 'wip') .'</option>' . "\n" .'
			<option value="portfolio-lists">'. __('Portfolio Lists', 'wip') .'</option>' . "\n" .'
			<option value="product-lists">'. __('Product Lists', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n" .'
	
	<span class="span-module tagline-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Tagline/Textarea', 'wip') .'</span>' . "\n" .'
		<select name="mod-tagline['.$id.']" id="mod-tagline-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a style', 'wip') .'</option>' . "\n" .'
			<option value="paragraph-text">'. __('Paragraph Text', 'wip') .'</option>' . "\n" .'
			<option value="tagline">'. __('Tagline', 'wip') .'</option>' . "\n" .'
			<option value="taglinebutton">'. __('Tagline with button', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n";
	
	
	return $mod;

}



function wipfr_page_layout_parent_modules($id){

	$mod = '											
	<span class="span-module column-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Columns', 'wip') .'</span>' . "\n" .'
		<select name="mod-col['.$id.']" id="mod-col-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a column', 'wip') .'</option>' . "\n" .'
			<option value="2col">'. __('2 Columns', 'wip') .'</option>' . "\n" .'
			<option value="3col">'. __('3 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_2_3col">'. __('1/3 - 2/3 Columns', 'wip') .'</option>' . "\n" .'
			<option value="2_1_3col">'. __('2/3 - 1/3 Columns', 'wip') .'</option>' . "\n" .'
			<option value="4col">'. __('4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_1_2_4col">'. __('1/4 - 1/4 - 2/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_2_1_4col">'. __('1/4 - 2/4 - 1/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="2_1_1_4col">'. __('2/4 - 1/4 - 1/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="1_3_4col">'. __('1/4 - 3/4 Columns', 'wip') .'</option>' . "\n" .'
			<option value="3_1_4col">'. __('3/4 - 1/4 Columns', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n" .'
	
	<span class="span-module divider-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Dividers', 'wip') .'</span>' . "\n" .'
		<select name="mod-divider['.$id.']" id="mod-divider-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a divider', 'wip') .'</option>' . "\n" .'
			<option value="divider1">'. __('Divider style 1', 'wip') .'</option>' . "\n" .'
			<option value="divider2">'. __('Divider style 2', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n" .'
	
	<span class="span-module post-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Post', 'wip') .'</span>' . "\n" .'
		<select name="mod-post['.$id.']" id="mod-post-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a post type', 'wip') .'</option>' . "\n" .'
			<option value="single-page-content">'. __('Page Content', 'wip') .'</option>' . "\n" .'
			<option value="blog-lists">'. __('Blog Lists', 'wip') .'</option>' . "\n" .'
			<option value="portfolio-lists">'. __('Portfolio Lists', 'wip') .'</option>' . "\n" .'
			<option value="product-lists">'. __('Product Lists', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n" .'
	
	<span class="span-module tagline-module-lists">' . "\n" .'
		<span class="modules-tit-top">'. __('Tagline/Textarea', 'wip') .'</span>' . "\n" .'
		<select name="mod-tagline['.$id.']" id="mod-tagline-'.$id.'">' . "\n" .'
			<option value="0">'. __('Select a style', 'wip') .'</option>' . "\n" .'
			<option value="paragraph-text">'. __('Paragraph Text', 'wip') .'</option>' . "\n" .'
			<option value="tagline">'. __('Tagline', 'wip') .'</option>' . "\n" .'
			<option value="taglinebutton">'. __('Tagline with button', 'wip') .'</option>' . "\n" .'
		</select>' . "\n" .'
	</span>' . "\n";
	
	
	return $mod;

}




function wipfr_get_portfolio_layout( $id, $parentID, $fields = ""){
	
	$portfoliocats = wip_get_tax_lists('portfolio-category');
	$portfoliocat_select = "";
	if( ! empty($portfoliocats) && is_array($portfoliocats) ){
		
		foreach( $portfoliocats as $pcatID => $pvalue ){
			$pselected = '';
			if( (fields != '') && 
				(is_array($fields)) && 
				(isset($fields[2])) && 
				($fields[2] == $pcatID)
			) $pselected = ' selected="selected"';
			
			$portfoliocat_select .= '<option value="'.$pcatID.'"'.$pselected.'>'. ( ( isset($pvalue['name']) ) ? $pvalue['name'] : '' ) .'</option>';
		}
	}
	
	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Portfolio Lists', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-portfoliolists-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";

		
	$col .= '<div class="wip-layout-item-settings" id="wip-portfoliolists-item-settings-'.$id.'">' . "\n" .'
	
			<p>
			<label class="wip-label-onrow" for="portfolio-lists-title-'.$id.'">'.__('Title (optional)','wip').'</label>
			<input type="text" style="width:200px;" name="portfolio-lists-title['.$id.']" id="portfolio-lists-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[5])) ) ? stripslashes(esc_attr($fields[5])) : '' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="portfolio-lists-column-'.$id.'">'.__('How many columns','wip').'</label>
				<select name="portfolio-lists-column['.$id.']" id="portfolio-lists-column-'.$id.'">
					<option value="2"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && $fields[0] == "2") ) ? ' selected="selected"' : '' ) .'>'.__('2 Columns', 'wip').'</option>
					<option value="3"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && $fields[0] == "3") ) ? ' selected="selected"' : '' ) .'>'.__('3 Columns', 'wip').'</option>
					<option value="4"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && ( $fields[0] == "4" || $fields[0] == "" ) ) ) ? ' selected="selected"' : '' ) .'>'. __('4 Columns', 'wip') .'</option>
				</select>
			</p>

			<p>
			<label class="wip-label-onrow" for="portfolio-lists-cat-'.$id.'">'.__('portfolio Category','wip').'</label>
				<select name="portfolio-lists-cat['.$id.']" id="portfolio-lists-cat-'.$id.'">
				<option value="all"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) && ($fields[3]=='all' || $fields[3]=='') ) ? ' selected="selected"' : '' ) .'>'.__('All', 'wip').'</option>' . "\n" . '
				'.$portfoliocat_select.'
				</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="portfolio-lists-number-'.$id.'">'.__('How many post','wip').'</label>
			<input type="text" style="width:200px;" name="portfolio-lists-number['.$id.']" id="portfolio-lists-number-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '4' ) .'" />
			</p>

			<p>
			<label class="wip-label-onrow">'.__('Featured portfolio','wip').'</label>
			<input type="checkbox" name="portfolio-lists-featured['.$id.']" id="portfolio-lists-featured-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4])) ) ? ( ($fields[4] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="portfolio-lists-featured-'.$id.'">'.__('Show Featured portfolio','wip').'</label>
			<br/><label class="wip-label-onrow"></label><small>'.__('if this is checked, the portfolio category value will ignored!','wip').'</small>
			</p>
			
			<p>
			<label class="wip-label-onrow">' . __('Pagination', 'wip') . '</label>
			<input type="checkbox" name="portfolio-lists-pagination['.$id.']" id="portfolio-lists-pagination-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? ( ($fields[2] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="portfolio-lists-pagination-'.$id.'">'.__('Show the pagination?','wip').'</label>
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="portfolio-lists" />';

	$col .= '</li>' . "\n";


	
	return $col;

}





function wipfr_get_product_layout( $id, $parentID, $fields = ""){

	$productcats = wip_get_tax_lists('product_cat');
	$productcat_select = "";
	if( ! empty($productcats) && is_array($productcats) ){
		
		foreach( $productcats as $catID => $value ){
			$selected = '';
			if( ($fields != '') && 
				(is_array($fields)) && 
				(isset($fields[3])) && 
				($fields[3] == $catID) 
			) $selected = ' selected="selected"';
			
			$productcat_select .= '<option value="'.$catID.'"'.$selected.'>'. ( ( isset($value['name']) ) ? $value['name'] : '' ) .'</option>';
		
		}
	
	}


	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Product Lists', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-productlists-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";

		
	$col .= '<div class="wip-layout-item-settings" id="wip-productlists-item-settings-'.$id.'">' . "\n" .'
	
			<p>
			<label class="wip-label-onrow" for="product-lists-title-'.$id.'">'.__('Title (optional)','wip').'</label>
			<input type="text" style="width:200px;" name="product-lists-title['.$id.']" id="product-lists-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[5])) ) ? stripslashes(esc_attr($fields[5])) : '' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="product-lists-column-'.$id.'">'.__('How many columns','wip').'</label>
				<select name="product-lists-column['.$id.']" id="product-lists-column-'.$id.'">
					<option value="2"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && $fields[0] == "2") ) ? ' selected="selected"' : '' ) .'>'.__('2 Columns', 'wip').'</option>
					<option value="3"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && $fields[0] == "3") ) ? ' selected="selected"' : '' ) .'>'.__('3 Columns', 'wip').'</option>
					<option value="4"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && ( $fields[0] == "4" || $fields[0] == "" ) ) ) ? ' selected="selected"' : '' ) .'>'. __('4 Columns', 'wip') .'</option>
					<option value="5"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0]) && $fields[0] == "5") ) ? ' selected="selected"' : '' ) .'>'.__('5 Columns', 'wip').'</option>
				</select>
			</p>

			<p>
			<label class="wip-label-onrow" for="product-lists-cat-'.$id.'">'.__('Product Category','wip').'</label>
				<select name="product-lists-cat['.$id.']" id="product-lists-cat-'.$id.'">
				<option value="all"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) && ($fields[3]=='all' || $fields[3]=='') ) ? ' selected="selected"' : '' ) .'>'.__('All', 'wip').'</option>' . "\n" . '
				'.$productcat_select.'
				</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="product-lists-number-'.$id.'">'.__('How many post','wip').'</label>
			<input type="text" style="width:200px;" name="product-lists-number['.$id.']" id="product-lists-number-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '4' ) .'" />
			</p>

			<p>
			<label class="wip-label-onrow">'.__('Featured products','wip').'</label>
			<input type="checkbox" name="product-lists-featured['.$id.']" id="product-lists-featured-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4])) ) ? ( ($fields[4] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="product-lists-featured-'.$id.'">'.__('Show Featured products','wip').'</label>
			<br/><label class="wip-label-onrow"></label><small>'.__('if this is checked, the product category value will ignored!','wip').'</small>
			</p>
			
			<p>
			<label class="wip-label-onrow">' . __('Pagination', 'wip') . '</label>
			<input type="checkbox" name="product-lists-pagination['.$id.']" id="product-lists-pagination-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? ( ($fields[2] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="product-lists-pagination-'.$id.'">'.__('Show the pagination?','wip').'</label>
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="product-lists" />';

	$col .= '</li>' . "\n";


	
	return $col;

}




function wipfr_get_bloglists_layout( $id, $parentID, $fields = "" ){

	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Blog Lists', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-bloglists-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";

$default = 'default';
$oImg = get_template_directory_uri(). '/framework/images/blog-style-2.jpg';
if( _wipfr_check_parentlayout_type($parentID) == 'fullwidth' ) {
	$default = 'default-fullwidth';
	$oImg = get_template_directory_uri(). '/framework/images/blog-style-1.jpg';
}
		
	$col .= '<div class="wip-layout-item-settings" id="wip-bloglists-item-settings-'.$id.'">' . "\n" .'
			
			<p>
			<label class="wip-label-onrow" for="blog-lists-title-'.$id.'">'.__('Title (optional)','wip').'</label>
			<input type="text" style="width:200px;" name="blog-lists-title['.$id.']" id="blog-lists-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[5])) ) ? stripslashes(esc_attr($fields[5])) : '' ) .'" />
			</p>

			<p><label class="wip-label-onrow" for="blog-lists-layout-'.$id.'">'.__('Select a layout','wip').'</label></p>
			<div class="image-radio-option">
				<label class="description">
					
							<span>
								<img src="' . $oImg .'" alt="" />
							</span>
						<input type="radio" name="blog-lists-layout['.$id.']" value="'.$default.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? ( ($fields[0] == $default || $fields[0] == '') ? ' checked="checked"' : '' ) : '' ) .'/><br/>
						<center>'.__('Default', 'wip').'</center>
				</label>
			</div>
			
			<div class="image-radio-option">
				<label class="description">
					
							<span>
								<img src="' . get_template_directory_uri(). '/framework/images/blog-style-column.jpg" alt="" />
							</span>
						<input type="radio" name="blog-lists-layout['.$id.']" value="column"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? ( ($fields[0] == 'column') ? ' checked="checked"' : '' ) : '' ) .'/><br/>
						<center>'.__('Columns', 'wip').'</center>
				</label>
			</div>
					
			<div class="clear"></div>

			<p id="jq-blog-lists-content-'.$id.'" style="display:'. ( ( isset($fields[0]) ) ? ( ($fields[0] == 'default') ? 'block' : 'none' ) : 'none' ) .';">
			<label class="wip-label-onrow" for="blog-lists-content-'.$id.'">'.__('Content','wip').'</label>
				<label class="description"><input type="radio" name="blog-lists-content['.$id.']" value="excerpt"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4])) ) ? ( ($fields[4] == 'excerpt') ? ' checked="checked"' : '' ) : '' ) .'>'. __('Show Excerpt', 'wip') .'</label>
				<label class="description"><input type="radio" name="blog-lists-content['.$id.']" value="full"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4])) ) ? ( ($fields[4] == 'full') ? ' checked="checked"' : '' ) : '' ) .'>'. __('Show Full Content', 'wip') .'</label>

			</p>
			
			<p id="jq-blog-lists-column-'.$id.'" style="display:'. ( ( isset($fields[0]) ) ? ( ($fields[0] == 'column') ? 'block' : 'none' ) : 'none' ) .';">
			<label class="wip-label-onrow" for="blog-lists-column-'.$id.'">'.__('How many columns','wip').'</label>
				<select name="blog-lists-column['.$id.']" id="blog-lists-column-'.$id.'">
					<option value="2"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3]) && $fields[3] == "2") ) ? ' selected="selected"' : '' ) .'>'.__('2 Columns', 'wip').'</option>
					<option value="3"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3]) && $fields[3] == "3") ) ? ' selected="selected"' : '' ) .'>'.__('3 Columns', 'wip').'</option>
					<option value="4"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3]) && ( $fields[3] == "4" || $fields[3] == "" ) ) ) ? ' selected="selected"' : '' ) .'>'. __('4 Columns', 'wip') .'</option>
				</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="blog-lists-number-'.$id.'">'.__('How many post','wip').'</label>
			<input type="text" style="width:200px;" name="blog-lists-number['.$id.']" id="blog-lists-number-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '4' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow">' . __('Pagination', 'wip') . '</label>
			<input type="checkbox" name="blog-lists-pagination['.$id.']" id="blog-lists-pagination-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? ( ($fields[2] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="blog-lists-pagination-'.$id.'">'.__('Show the pagination?','wip').'</label>
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="blog-lists" />';
$detect = '<script type="text/javascript">
/* <![CDATA[ */
(function($){
	$(document).ready(function(){
		$(\'input[name="blog-lists-layout['.$id.']"]\').bind(\'change\', function(e){
			if ( e.target ){
				var tv = e.target.value;
				if( tv == "column" ){
					$("#jq-blog-lists-column-'.$id.'").slideDown();
					$("#jq-blog-lists-content-'.$id.'").slideUp();
				} else if( tv == "default"){
					$("#jq-blog-lists-column-'.$id.'").slideUp();
					$("#jq-blog-lists-content-'.$id.'").slideDown();
				} else {
					$("#jq-blog-lists-column-'.$id.'").slideUp();
					$("#jq-blog-lists-content-'.$id.'").slideUp();
				}
			}
		});
	});
})(jQuery);
/* ]]> */
</script>';

	$col .= wptexturize( $detect );
	$col .= '</li>' . "\n";


	
	return $col;

}



function wipfr_get_singlepage_layout( $id, $parentID, $fields = "" ){

	$pages = retrieve_page_data( false, false);
	$page_select = "";
	if( ! empty($pages) && is_array($pages) ){
		
		foreach( $pages as $pageID => $pagename ){
			$selected = '';
			if( ($fields != '') && 
				(is_array($fields)) && 
				(isset($fields[0])) && 
				($fields[0] == $pageID)
			) $selected = ' selected="selected"';
			
			$page_select .= '<option value="'.$pageID.'"'.$selected.'>'. $pagename .'</option>';
		
		}
	
	}

	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Page', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-page-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
	
	$col .= '<div class="wip-layout-item-settings" id="wip-page-item-settings-'.$id.'">' . "\n" .'
			
			<p>
			<label class="wip-label-onrow" for="single-pageid-'.$id.'">'.__('Select a page:','wip').'</label>
			<select name="single-pageid['.$id.']" id="single-pageid-'.$id.'">
				'.$page_select.'
			</select>
			</p>
			
			<p>
			<input type="checkbox" name="show-pagetitle['.$id.']" id="showtop-pagetitle-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? ( ($fields[1] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="showtop-pagetitle-'.$id.'">'.__('Show Page Title?','wip').'</label>
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="single-page" />';
	$col .= '</li>' . "\n";
	
	return $col;

}



function wipfr_get_singlepagecontent_layout( $id, $parentID ){

	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Page Content', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-page-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
	
	$col .= '<div class="wip-layout-item-settings" id="wip-page-item-settings-'.$id.'">' . "\n" .'
			
			<p>
			'. __('No options for this section. This is will display your page content!', 'wip') .'
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="single-page-content" />';
	$col .= '</li>' . "\n";
	
	return $col;

}


function wipfr_full_tagline_layout( $id, $parentID, $fields = "" ){

	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Tagline', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-tagline-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
	
	$col .= '<div class="wip-layout-item-settings" id="wip-tagline-item-settings-'.$id.'">' . "\n" .'
			<p>
			<label class="wip-label-onrow" for="custom-taglines-text-'.$id.'">'.__('Tagline Text','wip').'</label>
			<textarea name="custom-taglines-text['.$id.']" id="custom-taglines-text-'.$id.'"  cols="20" rows="6" class="widefat">'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes( esc_textarea($fields[0]) ) : '' ) .'</textarea>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-taglines-color-'.$id.'">'.__('Font Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="custom-taglines-color['.$id.']" id="custom-taglines-color-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '555555' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-taglines-fontstyle-'.$id.'">'.__('Font Style','wip').'</label>
			<select name="custom-taglines-fontstyle['.$id.']" id="custom-taglines-fontstyle-'.$id.'">
				<option value="normal"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2]) && ( $fields[2] == "normal" || $fields[2] == "" ) ) ) ? ' selected="selected"' : '' ) .'>Normal</option>
				<option value="italic"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2]) && $fields[2] == "italic") ) ? ' selected="selected"' : '' ) .'>Italic</option>
			</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-taglines-fontweight-'.$id.'">'.__('Font Weight','wip').'</label>
			<select name="custom-taglines-fontweight['.$id.']" id="custom-taglines-fontweight-'.$id.'">
				<option value="normal"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3]) && ( $fields[3] == "normal" || $fields[3] == "" ) ) ) ? ' selected="selected"' : '' ) .'>Normal</option>
				<option value="bold"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3]) && $fields[3] == "bold") ) ? ' selected="selected"' : '' ) .'>Bold</option>
			</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-taglines-texttransform-'.$id.'">'.__('Text Transform','wip').'</label>
			<select name="custom-taglines-texttransform['.$id.']" id="custom-taglines-texttransform-'.$id.'">
				<option value="none"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4]) && ( $fields[4] == "none" || $fields[4] == "" ) ) ) ? ' selected="selected"' : '' ) .'>None</option>
				<option value="capitalize"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4]) && $fields[4] == "capitalize") ) ? ' selected="selected"' : '' ) .'>Capitalize</option>
				<option value="uppercase"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4]) && $fields[4] == "uppercase") ) ? ' selected="selected"' : '' ) .'>Uppercase</option>
				<option value="lowercase"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4]) && $fields[4] == "lowercase") ) ? ' selected="selected"' : '' ) .'>Lowercase</option>
			</select>
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="tagline" />';
	$col .= '</li>' . "\n";
	
	return $col;
}


function wipfr_full_taglinebutton_layout( $id, $parentID, $fields = "" ){

	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Tagline with button', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-tagline-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
	
	$col .= '<div class="wip-layout-item-settings" id="wip-tagline-item-settings-'.$id.'">' . "\n" .'
			<p>
			<label class="wip-label-onrow" for="custom-tagline-text-'.$id.'">'.__('Tagline Text','wip').'</label>
			<textarea name="custom-tagline-text['.$id.']" id="custom-tagline-text-'.$id.'"  cols="20" rows="6" class="widefat">'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes( esc_textarea($fields[0]) ) : '' ) .'</textarea>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-buttonurl-'.$id.'">'.__('Button URL','wip').'</label>
			<input type="text" style="width:200px;" name="custom-tagline-buttonurl['.$id.']" id="custom-tagline-buttonurl-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-buttontext-'.$id.'">'.__('Button Text','wip').'</label>
			<input type="text"  style="width:200px;" name="custom-tagline-buttontext['.$id.']" id="custom-tagline-buttontext-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? stripslashes(esc_attr($fields[2])) : '' ) .'" />
			</p>
			<br/><br/>
			
			<em>&rarr; '.__('Button settings', 'wip').'</em>
			<p>
			<label class="wip-label-onrow" for="custom-tagline-buttonbg-'.$id.'">'.__('Button Background Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="custom-tagline-buttonbg['.$id.']" id="custom-tagline-buttonbg-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) ) ? stripslashes(esc_attr($fields[3])) : '777777' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-buttonborder-'.$id.'">'.__('Button Border Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="custom-tagline-buttonborder['.$id.']" id="custom-tagline-buttonborder-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[4])) ) ? stripslashes(esc_attr($fields[4])) : '414141' ) .'" />
			<small>'.__('Tip: Use darker color than button background color and the tagline background color', 'wip').'</small>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-buttoncolor-'.$id.'">'.__('Button Font Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="custom-tagline-buttoncolor['.$id.']" id="custom-tagline-buttoncolor-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[5])) ) ? stripslashes(esc_attr($fields[5])) : 'FFFFFF' ) .'" />
			</p>
			<br/><br/>
			
			<em>&rarr; '.__('Tagline settings', 'wip').'</em>
			<p>
			<label class="wip-label-onrow" for="custom-tagline-bgcolor-'.$id.'">'.__('Tagline Background Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="custom-tagline-bgcolor['.$id.']" id="custom-tagline-bgcolor-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[6])) ) ? stripslashes(esc_attr($fields[6])) : '555555' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-color-'.$id.'">'.__('Font Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="custom-tagline-color['.$id.']" id="custom-tagline-color-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[7])) ) ? stripslashes(esc_attr($fields[7])) : 'FFFFFF' ) .'" />
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-fontstyle-'.$id.'">'.__('Font Style','wip').'</label>
			<select name="custom-tagline-fontstyle['.$id.']" id="custom-tagline-fontstyle-'.$id.'">
				<option value="normal"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[8]) && ( $fields[8] == "normal" || $fields[8] == "" ) ) ) ? ' selected="selected"' : '' ) .'>Normal</option>
				<option value="italic"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[8]) && $fields[8] == "italic") ) ? ' selected="selected"' : '' ) .'>Italic</option>
			</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-fontweight-'.$id.'">'.__('Font Weight','wip').'</label>
			<select name="custom-tagline-fontweight['.$id.']" id="custom-tagline-fontweight-'.$id.'">
				<option value="normal"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[9]) && ( $fields[9] == "normal" || $fields[9] == "" ) ) ) ? ' selected="selected"' : '' ) .'>Normal</option>
				<option value="bold"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[9]) && $fields[9] == "bold") ) ? ' selected="selected"' : '' ) .'>Bold</option>
			</select>
			</p>
			
			<p>
			<label class="wip-label-onrow" for="custom-tagline-texttransform-'.$id.'">'.__('Text Transform','wip').'</label>
			<select name="custom-tagline-texttransform['.$id.']" id="custom-tagline-texttransform-'.$id.'">
				<option value="none"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[10]) && ( $fields[10] == "none" || $fields[10] == "" ) ) ) ? ' selected="selected"' : '' ) .'>None</option>
				<option value="capitalize"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[10]) && $fields[10] == "capitalize") ) ? ' selected="selected"' : '' ) .'>Capitalize</option>
				<option value="uppercase"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[10]) && $fields[10] == "uppercase") ) ? ' selected="selected"' : '' ) .'>Uppercase</option>
				<option value="lowercase"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[10]) && $fields[10] == "lowercase") ) ? ' selected="selected"' : '' ) .'>Lowercase</option>
			</select>
			</p>
			
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="taglinebutton" />';
	$col .= '</li>' . "\n";
	
	return $col;
}


function wipfr_full_paragraph_layout( $id, $parentID, $fields = "" ){
	
	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Paragraph Text', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-paragraph-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
	
	$col .= '<div class="wip-layout-item-settings" id="wip-paragraph-item-settings-'.$id.'">' . "\n" .'
			<p>
			<label class="wip-label-onrow" for="custom-paragraph-title-'.$id.'">'.__('Title','wip').'</label>
			<input type="text" class="widefat" name="custom-paragraph-title['.$id.']" id="custom-paragraph-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" />
			</p>
			<p>
			<textarea name="custom-paragraph-text['.$id.']" id="custom-paragraph-text-'.$id.'"  cols="20" rows="16" class="widefat">'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes( esc_textarea($fields[1]) ) : '' ) .'</textarea>
			</p>
			<p>
			<input type="checkbox" name="custom-paragraph-autop['.$id.']" id="custom-paragraph-autop-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? ( ($fields[2] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="custom-paragraph-autop-'.$id.'">'.__('Automatically add paragraphs','wip').'</label>
			</p>
			<p>
			' . __('You can put any shortcode here, however shortcode only works if automatically add paragraphs is checked!') . '
			</p>
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="paragraph-text" />';
	$col .= '</li>' . "\n";
	
	return $col;

}




function wipfr_divider_layout( $id, $parentID, $typelayout, $fields = "" ){
	
	$title = ($typelayout == 'divider1') ? __('Divider 1', 'wip') : __('Divider 2', 'wip');
	
	$col = '<li class="layout-placer-item wip-layout-edit-inactive" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$col .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. $title .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-divider-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
	
	$col .= '<div class="wip-layout-item-settings" id="wip-divider-item-settings-'.$id.'">' . "\n" .'
			<p>
			<label class="wip-label-onrow" for="custom-divider-title-'.$id.'">'.__('Custom Title','wip').'</label>
			&nbsp;&nbsp;<input type="text" name="custom-divider-title['.$id.']" id="custom-divider-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" />
			</p>
			<p>
			<label class="wip-label-onrow" for="fontcolor-divider-title-'.$id.'">'.__('Title Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="fontcolor-divider-title['.$id.']" id="fontcolor-divider-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : 'E1E1E1' ) .'" />
			</p>
			<p>
			<label class="wip-label-onrow" for="fontbgcolor-divider-title-'.$id.'">'.__('Title Background Color','wip').'</label>
			<small>#</small><input type="text" class="color_scheme_input_on_layout" name="fontbgcolor-divider-title['.$id.']" id="fontbgcolor-divider-title-'.$id.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? stripslashes(esc_attr($fields[2])) : '888888' ) .'" />
			</p>
			<p>
			<input type="checkbox" name="showtop-link['.$id.']" id="showtop-link-'.$id.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) ) ? ( ($fields[3] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
			<label for="showtop-link-'.$id.'">'.__('Show top link?','wip').'</label>
			</p>
			</div>' . "\n";
	
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="'.$typelayout.'" />';
	$col .= '</li>' . "\n";
	
	return $col;

}


function wipfr_mix_columns_module( $args, $id, $parentID, $columnID, $content = "" ){

	$col = '<li class="layout-placer-item no-border" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$a = 0;
	foreach( $args as $c ){
	$a++;
		$class = "";
		
		if( substr($columnID, -4) == '3col' ){
			
			$class = ( $c == '1/3' ) ? 'one_third' : 'two_third';
		
		} else if( substr($columnID, -4) == '4col' ){
			
			switch ( $c ){
				case '1/4':
					$class = 'one_fourth';
					break;
				case '2/4':
					$class = 'two_fourth';
					break;
				case '3/4':
					$class = 'three_fourth';
					break;
			}
			
		}
		
		$none = "";
		if( $content != "" && is_array( $content ) ){
			if( isset( $content[$a-1] ) && ($content[$a-1] != "") ){
				$none = ' style="display:none;"';
			}
		}
		
		$post_options = '<option value="latest-post">'. __('Latest Blog Post Lists', 'wip') .'</option>' . "\n" .'
							<option value="latest-portfolio-thumbnail">'. __('Latest Portfolio Lists(thumbnail only)', 'wip') .'</option>' . "\n" .'
							<option value="latest-product">'. __('Latest Product Lists', 'wip') .'</option>' . "\n";
		
		if( $class == 'three_fourth' ){
		$post_options = '<option value="latest-post-column">'. __('Latest Blog Post (3 column view)', 'wip') .'</option>' . "\n" .'
							<option value="latest-portfolio-column">'. __('Latest Portfolio (3 column view)', 'wip') .'</option>' . "\n" .'
							<option value="latest-product-column">'. __('Latest Product (3 column view)', 'wip') .'</option>' . "\n";
		}
		
		$col .= '
		<div class="placer-columns '.$class.' left wip-layout-edit-inactive">' . "\n" .'
			<dl class="wip-layout-item-bar">' . "\n" .'
				<dt class="wip-layout-item-handle">' . "\n" .'
					<span class="layout-title">Column '.$a.'</span>' . "\n" .'
					<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-placercolumn-'.$a.'-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
				</dt>' . "\n" .'
			</dl>' . "\n" .'
			<div class="wip-layout-item-settings" id="wip-placercolumn-'.$a.'-'.$id.'">' . "\n" .'
				<div class="wip-layout-modules"'.$none.'>' . "\n" .'
					<span class="span-module box-module-lists module-for-column">' . "\n" .'
						<select name="mod-box['.$a.']['.$id.']" id="mod-box-'.$a.'-'.$id.'">' . "\n" .'
							<option value="0">'. __('Select a content', 'wip') .'</option>' . "\n" .'
							<option value="paragraph-text">'. __('Paragraph Text', 'wip') .'</option>' . "\n" .'
							'.$post_options.'
							<option value="latest-tweet">'. __('Latest Twitter', 'wip') .'</option>' . "\n" .'
							<option value="flickr-photo">'. __('Flickr Photo', 'wip') .'</option>' . "\n" .'
							<option value="box-testimonial">'. __('a Testimonial', 'wip') .'</option>' . "\n" .'
						</select>' . "\n" .'
					</span>' . "\n" .'
				</div>' . "\n" .'
				
				<div class="wip-column-content-placer" id="wip-column-content-placer-'.$a.'-'.$id.'">';
				
		if( $content != "" && is_array( $content ) ){
			if( isset( $content[$a-1] ) ){
				$col .= $content[$a-1];
			}
		}
				
		$col .= '</div>' . "\n" . '
				
			</div>' . "\n" .'
		</div>
		' . "\n";
		
	}

	$col .= '<div class="clear"></div>' . "\n";
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="'.$columnID.'" />';
	$col .= '</li>' . "\n";
	
	return $col;
}



function wipfr_fullwidth_module( $id, $content = '', $forPage = false ){
	
	$tem = '<li id="wip-layout-item-'.$id.'" class="wip-layout-item wip-layout-edit-inactive">' . "\n";
	$tem .= '<a class="delete_layout_item" href="#wip-layout-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$tem .= '<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Full Width', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-layout-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
			</dl>' . "\n";
			
	$tem .= '<div class="wip-layout-item-settings" id="wip-layout-item-settings-'.$id.'">' . "\n" .'
			<div class="wip-layout-modules" id="wip-layout-modules-'.$id.'">' . "\n";
	
	if( $forPage ){
		$tem .= wipfr_page_layout_parent_modules($id);
	} else {
		$tem .= wipfr_layout_parent_modules($id);
	}
	
	$tem .= '</div>' . "\n";
	
	$tem .= '<div class="layout-placer" id="layout-placer-'.$id.'">' . "\n";
	
	if( $content != '' ) {
		$tem .= $content;
	}  else {
		$tem .= '<ul class="layout-placer-lists"></ul>';
	}
	
	$tem .= '</div>' . "\n";
	$tem .= '</div>' . "\n";
	if( $forPage ){
	$tem .= '<input type="hidden" name="wip_page_parent_id['.$id.']" value="'.$id.'" />';
	} else {
	$tem .= '<input type="hidden" name="parent_id['.$id.']" value="'.$id.'" />';
	}
	$tem .= '<input type="hidden" name="layout_parent['.$id.']" value="fullwidth" />';
	$tem .= '</li>' . "\n";
	
	
	return $tem;
}



function wipfr_sidebarcontent_module( $struc = 'sidebar_content', $id, $content = '', $forPage = false ){
	
	$sidebarSelections = get_custom_sidebar_array();
	$sidebarSel = '';
	if( $forPage ){
		global $post;
		
		foreach( $sidebarSelections as $sb ){
			$sidebarSel .= '<option value="'.$sb.'"'.( (get_option('wip_sidebarid_'.$id.'_'.$post->ID) == $sb) ? ' selected="selected"' : '' ).'>'.$sb.'</option>' . "\n";
		}
	} else {
		foreach( $sidebarSelections as $sb ){
			$sidebarSel .= '<option value="'.$sb.'"'.( (get_option('wip_sidebarid_'.$id) == $sb) ? ' selected="selected"' : '' ).'>'.$sb.'</option>' . "\n";
		}
	}
	
	$tem = '<li id="wip-layout-item-'.$id.'" class="wip-layout-item no-border">' . "\n";
	$tem .= '<a class="delete_layout_item" href="#wip-layout-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$tem .= '
	<div class="part-sidebar '. ( ($struc != 'sidebar_content') ? 'right' : 'left' ) .' wip-layout-edit-inactive">' . "\n" .'
	<dl class="wip-layout-item-bar">' . "\n" .'
		<dt class="wip-layout-item-handle">' . "\n" .'
			<span class="layout-title">'. __('Sidebar', 'wip') . '</span>' . "\n" .'
			<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-sidebar-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
		</dt>' . "\n" .'
	</dl>' . "\n" .'
	<div class="wip-layout-item-settings" id="wip-sidebar-item-settings-'.$id.'">' . "\n" .'
	<label for="wip_sidebarid_'.$id.'">
		<select name="wip_sidebarid_'.$id.'" id="wip_sidebarid_'.$id.'" class="widefat">
		'.$sidebarSel.'
		</select>
	</label>	
	</div>' . "\n" .'
	</div>' . "\n";
	
	$tem .='
	<div class="part-content '. ( ($struc != 'sidebar_content') ? 'left' : 'right' ) .' wip-layout-edit-inactive">' . "\n" .'
		<dl class="wip-layout-item-bar">' . "\n" .'
			<dt class="wip-layout-item-handle">' . "\n" .'
				<span class="layout-title">'. __('Content', 'wip') .'</span>' . "\n" .'
				<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-layout-item-settings-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
			</dt>' . "\n" .'
		</dl>' . "\n";
		
		
	$tem .= '<div class="wip-layout-item-settings" id="wip-layout-item-settings-'.$id.'">' . "\n" .'
			<div class="wip-layout-modules" id="wip-layout-modules-'.$id.'">' . "\n";
	
	if( $forPage ){
		$tem .= wipfr_page_layout_parent_modules($id);
	} else {
		$tem .= wipfr_layout_parent_modules($id);
	}
	
	$tem .= '</div>' . "\n";
	
	$tem .= '<div class="layout-placer" id="layout-placer-'.$id.'">' . "\n";
	
	if( $content != '' ) {
		$tem .= $content;
	}  else {
		$tem .= '<ul class="layout-placer-lists"></ul>';
	}
	
	$tem .= '</div>' . "\n";
	$tem .= '</div>' . "\n";
	$tem .= '</div>' . "\n";
	$tem .= '<div class="clear"></div>' . "\n";
	
	if( $forPage ){
	$tem .= '<input type="hidden" name="wip_page_parent_id['.$id.']" value="'.$id.'" />';
	} else {
	$tem .= '<input type="hidden" name="parent_id['.$id.']" value="'.$id.'" />';
	}
	
	$tem .= '<input type="hidden" name="layout_parent['.$id.']" value="'.$struc.'" />';
	$tem .= '</li>' . "\n";
	
	return $tem;
}


function wipfr_columns_module( $count = 4, $id, $parentID, $columnID, $content = "" ){

	$col = '<li class="layout-placer-item no-border" id="layout-placer-item-'.$id.'">' . "\n";
	$col .= '<a class="delete_layout_item" href="#layout-placer-item-'.$id.'" title="'.__('Remove', 'wip').'">x</a>';
	$a = 0;
	for( $a = 1; $a <= $count; $a++ ){
		
		$none = "";
		if( !empty($content) && is_array( $content ) ){
			if( isset( $content[$a-1] ) && ( $content[$a-1] != "" ) ){
				$none = ' style="display:none;"';
			}
		}
	
		$col .= '
		<div class="placer-columns column-'.$count.' left wip-layout-edit-inactive">' . "\n" .'
			<dl class="wip-layout-item-bar">' . "\n" .'
				<dt class="wip-layout-item-handle">' . "\n" .'
					<span class="layout-title">Column '.$a.'</span>' . "\n" .'
					<a class="wip-edit-layout-item" title="'. __('Edit', 'wip') .'" href="#wip-placercolumn-'.$a.'-'.$id.'">'. __('Edit', 'wip') .'</a>' . "\n" .'
				</dt>' . "\n" .'
			</dl>' . "\n" .'
			<div class="wip-layout-item-settings" id="wip-placercolumn-'.$a.'-'.$id.'">' . "\n" .'
				<div class="wip-layout-modules"'.$none.'>' . "\n" .'
					<span class="span-module box-module-lists module-for-column">' . "\n" .'
						<select name="mod-box['.$a.']['.$id.']" id="mod-box-'.$a.'-'.$id.'">' . "\n" .'
							<option value="0">'. __('Select a content', 'wip') .'</option>' . "\n" .'
							<option value="paragraph-text">'. __('Paragraph Text', 'wip') .'</option>' . "\n" .'
							<option value="latest-post">'. __('Latest Blog Post Lists', 'wip') .'</option>' . "\n" .'
							<option value="latest-portfolio-thumbnail">'. __('Latest Portfolio Lists(thumbnail only)', 'wip') .'</option>' . "\n" .'
							<option value="latest-product">'. __('Latest Product Lists', 'wip') .'</option>' . "\n" .'
							<option value="latest-tweet">'. __('Latest Twitter', 'wip') .'</option>' . "\n" .'
							<option value="flickr-photo">'. __('Flickr Photo', 'wip') .'</option>' . "\n" .'
							<option value="box-testimonial">'. __('a Testimonial', 'wip') .'</option>' . "\n" .'
						</select>' . "\n" .'
					</span>' . "\n" .'
				</div>' . "\n" .'
				
				<div class="wip-column-content-placer" id="wip-column-content-placer-'.$a.'-'.$id.'">';
		
		if( $content != "" && is_array( $content ) ){
			if( isset( $content[$a-1] ) ){
				$col .= $content[$a-1];
			}
		}

		
		$col .= '</div>' . "\n" . '
				
			</div>' . "\n" .'
		</div>
		' . "\n";
		
	}

	$col .= '<div class="clear"></div>' . "\n";
	$col .= '<input type="hidden" name="id['.$parentID.']['.$id.']" value="'.$id.'" />';
	$col .= '<input type="hidden" name="type['.$id.']" value="'.$columnID.'" />';
	$col .= '</li>' . "\n";
	
	return $col;
}


function wipfr_content_for_column( $type, $colNumber, $parentID, $fields = '' ){
	
	
	$productcats = wip_get_tax_lists('product_cat');
	$productcat_select = "";
	if( ! empty($productcats) && is_array($productcats) ){
		
		foreach( $productcats as $catID => $value ){
			$selected = '';
			if( ( $type == 'latest-product' || $type == 'latest-product-column' ) && 
				( 
				($fields != '') && (is_array($fields)) && (isset($fields[2])) && ($fields[2] == $catID) 
				)
			) $selected = ' selected="selected"';
			
			$productcat_select .= '<option value="'.$catID.'"'.$selected.'>'. ( ( isset($value['name']) ) ? $value['name'] : '' ) .'</option>';
		
		}
	
	}
	
	$portfoliocats = wip_get_tax_lists('portfolio-category');
	$portfoliocat_select = "";
	if( ! empty($portfoliocats) && is_array($portfoliocats) ){
		
		foreach( $portfoliocats as $pcatID => $pvalue ){
			$pselected = '';
			if( ( $type == 'latest-portfolio' || $type == 'latest-portfolio-column' ) && 
				( 
				($fields != '') && (is_array($fields)) && (isset($fields[2])) && ($fields[2] == $pcatID) 
				)
			) $pselected = ' selected="selected"';
			
			$portfoliocat_select .= '<option value="'.$pcatID.'"'.$pselected.'>'. ( ( isset($pvalue['name']) ) ? $pvalue['name'] : '' ) .'</option>';
		
		}
	
	}
	
	switch ( $type ){
		
		case 'paragraph-text':

			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Paragraph', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<textarea name="text-column['.$colNumber.']['.$parentID.']" id="text-column-'.$colNumber.'-'.$parentID.'"  cols="20" rows="16" class="widefat">'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes( esc_textarea($fields[1]) ) : '' ) .'</textarea>
					</p>
					<p>
					<input type="checkbox" name="useautop-column['.$colNumber.']['.$parentID.']" id="useautop-column-'.$colNumber.'-'.$parentID.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? ( ($fields[2] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
					<label for="useautop-column-'.$colNumber.'-'.$parentID.'">'.__('Automatically add paragraphs','wip').'</label>
					</p>
					<p><small>
					' . __('You can put any shortcode here, however shortcode only works if automatically add paragraphs is checked!') . '
					</small></p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';

			break;
			
			
		case 'latest-post':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Post', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="blogcount-column-'.$colNumber.'-'.$parentID.'">'.__('How many posts to show','wip').'<br/>
					<input type="text" name="blogcount-column['.$colNumber.']['.$parentID.']" id="blogcount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<input type="checkbox" name="showthumbnail-column['.$colNumber.']['.$parentID.']" id="showthumbnail-column-'.$colNumber.'-'.$parentID.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? ( ($fields[2] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
					<label for="showthumbnail-column-'.$colNumber.'-'.$parentID.'">'.__('Show thumbnail?','wip').'</label>
					</p>
					<p>
					<input type="checkbox" name="showexcerpt-column['.$colNumber.']['.$parentID.']" id="showexcerpt-column-'.$colNumber.'-'.$parentID.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) ) ? ( ($fields[3] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
					<label for="showexcerpt-column-'.$colNumber.'-'.$parentID.'">'.__('Show the Excerpt?','wip').'</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
			
		case 'latest-post-column':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Post (3 Column View)', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="blogcount-column-'.$colNumber.'-'.$parentID.'">'.__('How many posts to show','wip').'<br/>
					<input type="text" name="blogcount-column['.$colNumber.']['.$parentID.']" id="blogcount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '3' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
		case 'latest-portfolio-thumbnail':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Portfolio', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="portfoliocount-column-'.$colNumber.'-'.$parentID.'">'.__('How many posts to show','wip').'<br/>
					<input type="text" name="portfoliocount-column['.$colNumber.']['.$parentID.']" id="portfoliocount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="portfoliocat-column-'.$colNumber.'-'.$parentID.'">'.__('Pull from specific category?','wip').'<br/>
					<select name="portfoliocat-column['.$colNumber.']['.$parentID.']" id="portfoliocat-column-'.$colNumber.'-'.$parentID.'" class="widefat">
						<option value="all"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) && ($fields[2]=='all' || $fields[2]=='') ) ? ' selected="selected"' : '' ) .'>'.__('All', 'wip').'</option>' . "\n" . '
						'.$portfoliocat_select.'
					</select>
					</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
		case 'latest-portfolio-column':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Portfolio (3 Column View)', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="portfoliocount-column-'.$colNumber.'-'.$parentID.'">'.__('How many posts to show','wip').'<br/>
					<input type="text" name="portfoliocount-column['.$colNumber.']['.$parentID.']" id="portfoliocount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '3' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="portfoliocat-column-'.$colNumber.'-'.$parentID.'">'.__('Pull from specific category?','wip').'<br/>
					<select name="portfoliocat-column['.$colNumber.']['.$parentID.']" id="portfoliocat-column-'.$colNumber.'-'.$parentID.'" class="widefat">
						<option value="all"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) && ($fields[2]=='all' || $fields[2]=='') ) ? ' selected="selected"' : '' ) .'>'.__('All', 'wip').'</option>' . "\n" . '
						'.$portfoliocat_select.'
					</select>
					</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
		case 'latest-product':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Product', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="productcount-column-'.$colNumber.'-'.$parentID.'">'.__('How many posts to show','wip').'<br/>
					<input type="text" name="productcount-column['.$colNumber.']['.$parentID.']" id="productcount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="productcat-column-'.$colNumber.'-'.$parentID.'">'.__('Product Category','wip').'<br/>
					<select name="productcat-column['.$colNumber.']['.$parentID.']" id="productcat-column-'.$colNumber.'-'.$parentID.'" class="widefat">
						<option value="all"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) && ($fields[2]=='all' || $fields[2]=='') ) ? ' selected="selected"' : '' ) .'>'.__('All', 'wip').'</option>' . "\n" . '
						'.$productcat_select.'
					</select>
					</label>
					</p>
					<p>
					<input type="checkbox" name="showfeatured-column['.$colNumber.']['.$parentID.']" id="showfeatured-column-'.$colNumber.'-'.$parentID.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) ) ? ( ($fields[3] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
					<label for="showfeatured-column-'.$colNumber.'-'.$parentID.'">'.__('Show Featured products','wip').'</label>
					<br/><small>'.__('if this is checked, the product category value will ignored!','wip').'</small>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
			
		case 'latest-product-column':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Product (3 Column View)', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="productcount-column-'.$colNumber.'-'.$parentID.'">'.__('How many posts to show','wip').'<br/>
					<input type="text" name="productcount-column['.$colNumber.']['.$parentID.']" id="productcount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="productcat-column-'.$colNumber.'-'.$parentID.'">'.__('Product Category','wip').'<br/>
					<select name="productcat-column['.$colNumber.']['.$parentID.']" id="productcat-column-'.$colNumber.'-'.$parentID.'" class="widefat">
						<option value="all"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) && ($fields[2]=='all' || $fields[2]=='') ) ? ' selected="selected"' : '' ) .'>'.__('All', 'wip').'</option>' . "\n" . '
						'.$productcat_select.'
					</select>
					</label>
					</p>
					<p>
					<input type="checkbox" name="showfeatured-column['.$colNumber.']['.$parentID.']" id="showfeatured-column-'.$colNumber.'-'.$parentID.'"'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[3])) ) ? ( ($fields[3] !== '') ? ' checked="checked"' : '' ) : '' ) .'/>
					<label for="showfeatured-column-'.$colNumber.'-'.$parentID.'">'.__('Show Featured products','wip').'</label>
					<br/><small>'.__('if this is checked, the product category value will ignored!','wip').'</small>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
		case 'latest-tweet':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Latest Tweet', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="tweetid-column-'.$colNumber.'-'.$parentID.'">'.__('Twitter Username','wip').'<br/>
					<input type="text" name="tweetid-column['.$colNumber.']['.$parentID.']" id="tweetid-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="tweetcount-column-'.$colNumber.'-'.$parentID.'">'.__('How many tweet to show','wip').'<br/>
					<input type="text" name="tweetcount-column['.$colNumber.']['.$parentID.']" id="tweetcount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? stripslashes(esc_attr($fields[2])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
		case 'flickr-photo':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Flickr Photo', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="flickrid-column-'.$colNumber.'-'.$parentID.'">'.__('Flickr ID','wip').'<br/>
					<input type="text" name="flickrid-column['.$colNumber.']['.$parentID.']" id="flickrid-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes(esc_attr($fields[1])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="flickrcount-column-'.$colNumber.'-'.$parentID.'">'.__('How many photo to show','wip').'<br/>
					<input type="text" name="flickrcount-column['.$colNumber.']['.$parentID.']" id="flickrcount-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? stripslashes(esc_attr($fields[2])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
		case 'box-testimonial':
			
			$cont = '
			<div class="hider-content-column-block inactive" id="hider-content-column-block-'.$colNumber.'-'.$parentID.'">
				<a class="opener-content-column-block" href="#wrap-content-column-block-'.$colNumber.'-'.$parentID.'">[+] '.__('Testimonial', 'wip').'</a>' . "\n" . '
				<div id="wrap-content-column-block-'.$colNumber.'-'.$parentID.'" class="wrap-content-column-block">
					<p>
					<label for="title-column-'.$colNumber.'-'.$parentID.'">'.__('Title','wip').'<br/>
					<input type="text" name="title-column['.$colNumber.']['.$parentID.']" id="title-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[0])) ) ? stripslashes(esc_attr($fields[0])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<label for="testitext-column-'.$colNumber.'-'.$parentID.'">'.__('Testimonial Text','wip').'<br/>
					<textarea name="testitext-column['.$colNumber.']['.$parentID.']" id="testitext-column-'.$colNumber.'-'.$parentID.'"  cols="20" rows="16" class="widefat">'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[1])) ) ? stripslashes( esc_textarea($fields[1]) ) : '' ) .'</textarea>
					</label>
					</p>
					<p>
					<label for="testiauthor-column-'.$colNumber.'-'.$parentID.'">'.__('Testimonial Source/Author','wip').'<br/>
					<input type="text" name="testiauthor-column['.$colNumber.']['.$parentID.']" id="testiauthor-column-'.$colNumber.'-'.$parentID.'" value="'. ( ( ($fields != '') && (is_array($fields)) && (isset($fields[2])) ) ? stripslashes(esc_attr($fields[2])) : '' ) .'" class="widefat" />
					</label>
					</p>
					<p>
					<a href="#" class="delete-box-content-column-block" rel="#hider-content-column-block-'.$colNumber.'-'.$parentID.'">'.__('remove', 'wip').'</a>
					</p>
				</div>
				<input type="hidden" name="content-column['.$colNumber.']['.$parentID.']" value="'.$type.'" />
			</div>
			';
		
			break;
			
			
		case '':
		
			$cont = '' . "\n";
		
			break;
	
	
	}
		
	return $cont;
}



function wipfr_get_numberOf_column( $type ){
	
	$colCount = 4;
	
	switch( $type ){
	
		case '4col':
		
			$colCount = 4;
		
			break;
			
		case '3col':
		case '1_1_2_4col':
		case '1_2_1_4col':
		case '2_1_1_4col':
		
			$colCount = 3;
		
			break;
			
		case '2col':
		case '1_2_3col':
		case '2_1_3col':
		case '1_3_4col':
		case '3_1_4col':
		
			$colCount = 2;
		
			break;
	}
	
	return $colCount;
	
}


?>