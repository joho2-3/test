<?php
/*****************************************************************************************
Add Color Option to Category
*****************************************************************************************/

function meso_extra_category_fields( $term ) {
$t_id = $term->term_id;
$term_meta = get_theme_mod('cat_color_'.$t_id); ?>
<tr class="form-field">
<th scope="row" valign="top"><label for="meta-color"><?php _e('Color', 'mesocolumn'); ?></label></th>
<td>
<div id="colorpicker">
<input type="text" name="cat_color_meta" class="colorpicker" size="10" style="width:50%;" value="<?php echo (isset($term_meta)) ? $term_meta : ''; ?>" />
</div>
<br />
<span class="description"></span>
<br />
</td>
</tr>
<?php
}


/** Save Category Meta **/
function meso_save_extra_category_fileds( $term_id ) {
if ( isset( $_POST['cat_color_meta'] ) ) {
$t_id = $term_id;
$value_meta = $_POST['cat_color_meta'];
//save the option array
set_theme_mod( 'cat_color_'.$t_id, $value_meta );
//delete_transient('cat_color_option_cache');
}
}


/** Enqueue Color Picker **/
function meso_colorpicker_enqueue() {
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-colorpicker-js', get_template_directory_uri() . '/lib/admin/js/wp-colorpicker.js', array( 'wp-color-picker' ) );
}
add_action ('admin_enqueue_scripts', 'meso_colorpicker_enqueue' );




function meso_add_all_tax_control() {
$allptype = dez_get_all_posttype();
foreach( $allptype as $type) {
$customPostTaxonomies = get_object_taxonomies($type);
foreach($customPostTaxonomies as $taxo) {
add_action ($taxo.'_add_form_fields', 'meso_extra_category_fields',10,2);
add_action ($taxo.'_edit_form_fields','meso_extra_category_fields',10,2);
add_action ('edited_'.$taxo, 'meso_save_extra_category_fileds',10,2);
}
}
}
add_action('admin_init','meso_add_all_tax_control');


function meso_get_all_tax_cat() {
$allptype = dez_get_all_taxonomy();
$taxonomies = $allptype;
$args = array('orderby'=>'name','order'=>'ASC');
$tax_terms = get_terms($taxonomies, $args);
foreach ($tax_terms as $tax_term) {
echo $tax_term->term_id . '=>' . $tax_term->name . '<br />';
}
}
//add_action('bp_before_container','meso_get_all_tax_cat');



function meso_custom_category_style_init() {

print '<style type="text/css" media="all">' . "\n";

$cat_color_cache = '';

$taxonomies = dez_get_all_taxonomy();

$args = array('orderby'=>'name','order'=>'ASC');

$tax_terms = get_terms($taxonomies, $args);

foreach ($tax_terms as $tax_term) {

$cat_id =  $tax_term->term_id;
$cat_value_option = 'tn_cat_color_' . $cat_id;
$cat_color_option = get_theme_mod('cat_color_'.$cat_id);
if( $cat_color_option ) {
$cat_color_cache .= '#main-navigation li.'. $cat_value_option . ' a {border-bottom: 5px solid '. $cat_color_option . ';}#main-navigation ul.sf-menu li.'.$cat_value_option. ':hover {background-color: '.$cat_color_option. ';}#main-navigation li.'.$cat_value_option.'.current-menu-item a {background-color: '.$cat_color_option.';color:white;}#main-navigation li.'.$cat_value_option.'.current-menu-item a span.menu-decsription {color:white;}ul.sub_'.$cat_value_option.' li a {color: '.$cat_color_option.';}#main-navigation .sf-menu li a:hover {color: #fff !important;}#custom #main-navigation .sf-menu li.'.$cat_value_option.' a:hover {color: #fff !important;background-color: '.$cat_color_option.';}aside.home-feat-cat h4.homefeattitle.feat_'.$cat_value_option.' {border-bottom: 5px solid '.$cat_color_option.';}h2.header-title.feat_'.$cat_value_option.' {background-color: '.$cat_color_option.';padding: 1% 2%;width:95%;color: white;}#custom .archive_'.$cat_value_option.' h1.post-title a,#custom .archive_'.$cat_value_option.' h2.post-title a {color: '.$cat_color_option.' !important;}aside.home-feat-cat.post_'.$cat_value_option.' .widget a, aside.home-feat-cat.post_'.$cat_value_option.' article a {color: '.$cat_color_option.';}#custom #post-entry.archive_'.$cat_value_option.' article .post-meta a:hover {color: '.$cat_color_option.' !important;}#main-navigation .sf-menu li.'.$cat_value_option.' ul  {background-color: '.$cat_color_option.';background-image: none;}#main-navigation .sf-menu li.'.$cat_value_option.' ul li a:hover  {background-color:'.dehex( $cat_color_option, -20 ).';background-image: none;}';
}
}
echo $cat_color_cache;
print '</style>' . "\n";
}
add_action('wp_head','meso_custom_category_style_init',10);





/*****************************************************************************************
Add Color Option to Pages
*****************************************************************************************/
function meso_add_pagecolor_box() {
add_meta_box('meso_page_color_option', __( 'Choose Page Color:', 'mesocolumn' ),'meso_pagecolor_box_setting','page','side','high');
}
add_action( 'add_meta_boxes', 'meso_add_pagecolor_box' );


function meso_pagecolor_box_setting() {
global $post;
// Noncename needed to verify where the data originated
echo '<input type="hidden" name="pagecolor_noncename" id="pagecolor_noncename" value="' . wp_create_nonce( 'sf-nonce' ) . '" />';
$t_id = $post->ID;
$thispagecolor = get_theme_mod('page_color_'.$t_id); ?>
<p>
<label for="meta-color"><?php _e('Add page color for custom menu', 'mesocolumn' ); ?></label>
<div id="colorpicker">
<input type="text" name="page_color" class="colorpicker" size="10" style="width:50%;" value="<?php echo (isset($thispagecolor)) ? $thispagecolor : ''; ?>" />
</div>
</p>
<?php }




// Save the Metabox Data
function meso_pagecolor_box_save($post_id, $post) {
if ( isset($_POST['pagecolor_noncename']) && !wp_verify_nonce( $_POST['pagecolor_noncename'], 'sf-nonce' )) { return $post->ID; }
if ( !current_user_can( 'edit_post', $post->ID ))
return $post->ID;

$t_id = $post->ID;
$thispagecolor = get_theme_mod('page_color_'.$t_id);
$value = $_POST['page_color'];

if( $post->post_type == 'revision' ) return; // Don't store custom data twice

	if( isset($_POST['page_color']) ) {
    set_theme_mod( 'page_color_'.$t_id, $value );
	}

    }
// save the custom fields
add_action('save_post', 'meso_pagecolor_box_save', 1, 2);



/*****************************************************************************************
Add Page Color Options
*****************************************************************************************/
$all_pages = get_pages('post_status=publish&post_type=page&hierarchical=1');
$wp_pages = array();
foreach ($all_pages as $page_list ) {
$wp_pages[$page_list->ID] = $page_list->ID;
}

function meso_custom_page_style_init() {
global $wp_pages;
print '<style type="text/css" media="all">' . "\n";
$page_color_cache = '';

if( is_array($wp_pages) ) {

foreach ($wp_pages as $page_value) {
$page_id = $page_value;

$page_value_option = 'tn_page_color_' . $page_id;
$page_color_option = get_theme_mod('page_color_'.$page_id);

if( $page_color_option != '' ) {
$page_color_cache .= '#main-navigation li.menu-item-object-page.'. $page_value_option.' a {border-bottom: 5px solid '.$page_color_option.';}#main-navigation ul.sf-menu li.menu-item-object-page.'.$page_value_option.':hover {background-color: '.$page_color_option.';}#main-navigation .sf-menu li.menu-item-object-page.'.$page_value_option.' a:hover {color: #fff !important;background-color: '.$page_color_option.';}#main-navigation .sf-menu li.menu-item-object-page.'.$page_value_option.' ul  {background-color: '.$page_color_option.';background-image: none;}#main-navigation .sf-menu li.menu-item-object-page.'.$page_value_option.' ul li a:hover  {background-color: '.dehex( $page_color_option, -20 ).' !important;background-image: none;} ';
}
}
}

echo $page_color_cache;
print '</style>' . "\n";

}
add_action('wp_head','meso_custom_page_style_init',10);


?>