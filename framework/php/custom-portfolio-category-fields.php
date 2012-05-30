<?php
/**
 * Custom fields on portfolio category
 * @author Webinpixels
 * @2012
 */

/** new field at add new category */
add_action( 'portfolio-category_add_form_fields', '_wip_add_fields_on_portfolio_cat', 10, 2);
function _wip_add_fields_on_portfolio_cat($taxonomy){

	?>
<script type="text/javascript">
/* <![CDATA[ */
(function($){
	$('document').ready(function(){

		$('#cat_layout_type').bind('change', function(){
			var t = $(this);

			if( t.val() == 'fullwidth' ){
				$('#ff_cat_custom_sidebar').slideUp();
			} else {
				$('#ff_cat_custom_sidebar').slideDown();
			}
		});

	});
})(jQuery);
/* ]]> */
</script>

    <div class="form-field">

        <label for="cat_layout_type"><?php print __('Layout', 'wip'); ?></label>

            <select name="cat_layout_type" id="cat_layout_type" style="width: 50%;">
                <option value="content-sidebar" selected="selected"><?php print __('Content Sidebar', 'wip'); ?></option>
                <option value="sidebar-content"><?php print __('Sidebar Content', 'wip'); ?></option>
                <option value="fullwidth"><?php print __('FullWidth', 'wip'); ?></option>
            </select>

            <p class="description"><?php print __('Select the layout for this category', 'wip'); ?></p>

    </div>

    <div class="form-field">

        <label for="cat_column_number"><?php print __('Columns style', 'wip'); ?></label>

            <select name="cat_column_number" id="cat_column_number" style="width: 50%;">
                <option value="2"><?php print __('2 Columns', 'wip'); ?></option>
                <option value="3" selected="selected"><?php print __('3 Columns', 'wip'); ?></option>
                <option value="4"><?php print __('4 Columns', 'wip'); ?></option>
            </select>

            <p class="description"><?php print __('Select a column style', 'wip'); ?></p>

    </div>
	
    <div class="form-field" id="ff_cat_custom_sidebar">

        <label for="cat_custom_sidebar"><?php print __('Select a sidebar', 'wip'); ?></label>

            <select name="cat_custom_sidebar" id="cat_custom_sidebar" style="width: 50%;">
				<?php 
				$get_custom_sidebars = get_custom_sidebar_array();
				
				if($get_custom_sidebars != "") {
				
					foreach( $get_custom_sidebars as $sidebar){
					
				?>
					<option value="<?php echo $sidebar; ?>"><?php echo $sidebar; ?></option>
				<?php
				
					} 
					
				}
				?>

            </select>

            <p class="description"><?php print __('Select a sidebar for this category', 'wip'); ?></p>

    </div>
	
	<?php
}







/** new field at edit category */
add_action( 'portfolio-category_edit_form_fields', '_wip_edit_fields_portfolio_cat', 10, 2);
function _wip_edit_fields_portfolio_cat($tag, $taxonomy){

	$layout = get_metadata('portfoliocategory', $tag->term_id, 'cat_layout_type', true);
	$column_type = get_metadata('portfoliocategory', $tag->term_id, 'cat_column_number', true);
	$sidebar_cat = get_metadata('portfoliocategory', $tag->term_id, 'cat_custom_sidebar', true);
	?>

	
    <tr class="form-field">

        <th scope="row" valign="top"> <label for="cat_layout_type"><?php print __('Layout', 'wip'); ?></label></th>
		<td>
            <select name="cat_layout_type" id="cat_layout_type" class="postform">
                <option value="content-sidebar"<?php if( $layout == '' || $layout == 'content-sidebar') echo ' selected="selected"'; ?>><?php print __('Content Sidebar', 'wip'); ?></option>
                <option value="sidebar-content"<?php if( $layout == 'sidebar-content') echo ' selected="selected"'; ?>><?php print __('Sidebar Content', 'wip'); ?></option>
                <option value="fullwidth"<?php if( $layout == 'fullwidth') echo ' selected="selected"'; ?>><?php print __('FullWidth', 'wip'); ?></option>
            </select>
            <br/>
            <span class="description"><?php print __('Select the layout for this category', 'wip'); ?></span>
		</td>
    </tr>


    <tr class="form-field">

        <th scope="row" valign="top"><label for="cat_column_number"><?php print __('Columns type', 'wip'); ?></label></th>
		<td>

            <select name="cat_column_number" id="cat_column_number" class="postform">
                <option value="2"<?php if( $column_type == '2') echo ' selected="selected"'; ?>><?php print __('2 Columns', 'wip'); ?></option>
                <option value="3"<?php if( $column_type == '' || $column_type == '3') echo ' selected="selected"'; ?>><?php print __('3 Columns', 'wip'); ?></option>
                <option value="4"<?php if( $column_type == '4') echo ' selected="selected"'; ?>><?php print __('4 Columns', 'wip'); ?></option>
            </select>
            <br/>
            <span class="description"><?php print __('Select a column style', 'wip'); ?></span>
		</td>
    </tr>


    <tr class="form-field" id="ff_cat_custom_sidebar" style="display: <?php if ($layout == 'fullwidth') { echo 'none'; } else { echo 'table-row';  } ?>;">

        <th scope="row" valign="top"><label for="cat_custom_sidebar"><?php print __('Select a sidebar', 'wip'); ?></label></th>
		<td>
		
            <select name="cat_custom_sidebar" id="cat_custom_sidebar" class="postform">
				<?php 
				$get_custom_sidebars = get_custom_sidebar_array();
				
				if($get_custom_sidebars != "") {
				
					foreach( $get_custom_sidebars as $sidebar){
					
				?>
				
					<option value="<?php echo $sidebar; ?>"<?php if( $sidebar_cat == $sidebar ) echo ' selected="selected"'; ?>><?php echo $sidebar; ?></option>
					
				<?php
				
					} 
					
				}
				?>

            </select>
            <br/>
            <span class="description"><?php print __('Select a sidebar for this category', 'wip'); ?></span>
		</td>
    </tr>


<script type="text/javascript">
/* <![CDATA[ */
(function($){
	$('document').ready(function(){

		$('#cat_layout_type').bind('change', function(){
			var t = $(this);

			if( t.val() == 'fullwidth' ){
				$('#ff_cat_custom_sidebar').slideUp();
			} else {
				$('#ff_cat_custom_sidebar').slideDown();
			}
		});

	});
})(jQuery);
/* ]]> */
</script>

	<?php
}







/** saved process at edit category page */
add_action( 'edited_portfolio-category', '_wip_saving_portfolio_cat', 10, 2);
function _wip_saving_portfolio_cat()
{
	//die($_POST['cat_custom_sidebar']);
	
	if( isset( $_POST['cat_custom_sidebar']) ){
		if( !update_metadata( 'portfoliocategory' , $_POST['tag_ID'], 'cat_custom_sidebar', $_POST['cat_custom_sidebar']) )
			add_metadata( 'portfoliocategory' , $_POST['tag_ID'], 'cat_custom_sidebar', $_POST['cat_custom_sidebar'], true );
	}
	if( isset( $_POST['cat_layout_type']) ){
		if( !update_metadata( 'portfoliocategory' , $_POST['tag_ID'], 'cat_layout_type', $_POST['cat_layout_type']) )
			add_metadata( 'portfoliocategory' , $_POST['tag_ID'], 'cat_layout_type', $_POST['cat_layout_type'], true );
	}
	if( isset( $_POST['cat_column_number']) ){
		if( !update_metadata( 'portfoliocategory' , $_POST['tag_ID'], 'cat_column_number', $_POST['cat_column_number']) )
			add_metadata( 'portfoliocategory' , $_POST['tag_ID'], 'cat_column_number', $_POST['cat_column_number'], true );
	}
}







/** saved process at add category page */
add_action( 'create_portfolio-category', 'add_first_portfolio_category', 10, 2);
function add_first_portfolio_category($id)
{
	add_metadata( 'portfoliocategory' , $id, 'cat_custom_sidebar', ( isset($_POST['cat_custom_sidebar']) ? $_POST['cat_custom_sidebar'] : '' ), true );
	add_metadata( 'portfoliocategory' , $id, 'cat_layout_type', ( isset($_POST['cat_layout_type']) ? $_POST['cat_layout_type'] : '' ), true );
	add_metadata( 'portfoliocategory' , $id, 'cat_column_number', ( isset($_POST['cat_column_number']) ? $_POST['cat_column_number'] : '' ), true );
}