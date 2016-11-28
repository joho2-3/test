<?php
if ( ! function_exists( 'dez_mp_theme_wp_title' ) ) :
///////////////////////////////////////////////////////////////////////////////////////
// Custom WP TITLE - Credit to WordPress Team
///////////////////////////////////////////////////////////////////////////////////////
function dez_mp_theme_wp_title( $title, $sep ) {
global $paged, $page;
$site_title = get_bloginfo( 'name' );
$post_title = the_title_attribute('echo=0');
$site_description = get_bloginfo( 'description', 'display' );
$sep = '&raquo;';
if ( is_feed() ) {
$title = $site_title;
} elseif ( $site_description && ( is_home() || is_front_page() ) ) {
$title = "$site_title $sep $site_description";
} elseif ( $paged >= 2 || $page >= 2 ) {
$title = "$site_title $sep " . sprintf( __( 'Page %s', 'mesocolumn' ), max( $paged, $page ) );
} elseif ( is_category() || is_tag() ) {
$title = ucfirst(single_cat_title('',false)) . ' ' . $sep . ' ' . $site_title;
} elseif ( is_singular() ) {
$title = "$post_title $sep $site_title";
} else {
if ( is_day() ) {
$title = __('Archives for ', 'mesocolumn') . get_the_date() . ' ' . $sep . ' ' . $site_title;
} else if ( is_month() ) {
$title = __('Archives for ', 'mesocolumn') . get_the_date('F Y') . ' ' . $sep . ' ' . $site_title;
} else if ( is_year() ){
$title = __('Archives for ', 'mesocolumn') . get_the_date('Y') . ' ' . $sep . ' ' . $site_title;
}
}
return $title;
}
//disable if all-in-one-seo and yoast seo plugin installed
if ( function_exists('aioseop_load_modules') || function_exists('wpseo_admin_init') ) {
} else {
add_filter( 'wp_title', 'dez_mp_theme_wp_title', 10, 2 );
}
endif;



///////////////////////////////////////////////////////////////////////////////////////
// Custom WP Pagination original code ( kriesi_pagination() ) - Credit to kriesi code
// http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
///////////////////////////////////////////////////////////////////////////////////////
function dez_custom_kriesi_pagination($pages = '', $range = 2) {
$showitems = ($range * 2)+1;
global $paged;
if(empty($paged)) $paged = 1;
if($pages == '') {
global $wp_query;
$pages = $wp_query->max_num_pages;
if(!$pages) {
$pages = 1;
}
}

if(1 != $pages) {
echo "<div class='wp-pagenavi iegradient'>";
if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
for ($i=1; $i <= $pages; $i++) {
if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
}
}
if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
echo "</div>\n";
}
}


if( !class_exists('Custom_Description_Walker') ):
////////////////////////////////////////////////////////////////////
// add description to wp_nav
///////////////////////////////////////////////////////////////////
class Custom_Description_Walker extends Walker_Nav_Menu {
    /**
     * Start the element output.
     *
     * @param  string $output Passed by reference. Used to append additional content.
     * @param  object $item   Menu item data object.
     * @param  int $depth     Depth of menu item. May be used for padding.
     * @param  array $args    Additional strings.
     * @return void
     */
function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
$classes = empty ( $item->classes ) ? array () : (array) $item->classes;
$class_names = join(' ', apply_filters('nav_menu_css_class',array_filter( $classes ), $item));
$item_desc = (!empty ($item->description) && $depth == 0 ) ? "have_desc" : "no_desc";


$the_icon = $classes[0];

if($depth == 0 && defined('SUPER_ICON') && SUPER_ICON == 'yes' ):
$the_class_names = str_replace($the_icon,'',$class_names);
$call_icon = ( !empty($the_icon) ) ? "<i class='$the_icon'></i>" : "<i class='icon-file'></i>";
$have_icon = ( !empty($the_icon) )  ? 'have_icon': "";
else:
$the_class_names = $class_names;
$call_icon = '';
$have_icon = '';
endif;

$catname_val = '';
$pagename_val = '';
if($depth == 0 ):

$cat_id = get_post_meta( $item->ID, '_menu_item_object_id', true );

if( !$cat_id ) {
if( class_exists('woocommerce') || class_exists('jigoshop') ) {
$cat_name = get_term_by('name', $catname, 'product_cat');
if($cat_name) {
$cat_id = $cat_name->term_id;
}
}
}

if($cat_id) {
$cat_bg_color = get_theme_mod( 'cat_color_'.$cat_id );
$catname_val = ( !empty($cat_bg_color) ) ? "tn_cat_color_" . $cat_id : "";
}

$page_id = get_post_meta( $item->ID, '_menu_item_object_id', true );

if($page_id) {
$page_bg_color = get_theme_mod( 'page_color_'.$page_id );
$pagename_val = ( !empty($page_bg_color) ) ? "tn_page_color_" . $page_id : "";
}

endif;

$class_names = ' class="'. esc_attr( $the_class_names . ' ' . $item_desc . ' ' . $have_icon . ' ' . $catname_val . ' ' . $pagename_val ) . '"';

$output .= "<li id='menu-item-$item->ID' $class_names>";

$attributes  = '';
        ! empty( $item->attr_title )
            and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
        ! empty( $item->target )
            and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
        ! empty( $item->xfn )
            and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
        ! empty( $item->url )
            and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

// insert description for top level elements only
// you may change this
$description = ( ! empty ( $item->description ) and 0 == $depth )
? '<br /><span class="menu-decsription">' . esc_attr( $item->description ) . '</span>' : '';

$title = apply_filters( 'the_title', $item->title, $item->ID );
$item_output = $args->before
            . "<a $attributes>"
            . $args->link_before
            . $title
            . $description
            . '</a>'
            . $args->link_after
            . $args->after;

// Since $output is called by reference we don't need to return anything.
$output .= apply_filters(
            'walker_nav_menu_start_el'
        ,   $item_output
        ,   $item
        ,   $depth
        ,   $args
        );
    }
}
endif;


///////////////////////////////////////////////////////////////////////////////
// custom walker nav for mobile navigation
///////////////////////////////////////////////////////////////////////////////
class mobi_custom_walker extends Walker_Nav_Menu
{
function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '';



           $prepend = '';
           $append = '';
         //$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
           $description = $append = $prepend = "";
           }

            $item_output = $args->before;

            if($depth == 1):
            $item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;<i class='fa fa-minus'></i>" . $item->title . "</a></li>";
            elseif($depth == 2):
            $item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-angle-double-right'></i>" . $item->title . "</a></li>";
            elseif($depth == 3):
            $item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-angle-right'></i>" . $item->title . "</a></li>";
            elseif($depth == 4):
            $item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-angle-down'></i>" . $item->title . "</a></li>";
            else:
            $item_output .= "<li><a href='" . $item->url . "'>" . $item->title . "</a></li>";
            endif;

            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}



function dez_get_wp_custom_mobile_nav_menu($get_custom_location=''){
$options = array('walker' => new mobi_custom_walker(), 'theme_location' => "$get_custom_location", 'menu_id' => '', 'echo' => false, 'container' => false, 'container_id' => '', 'fallback_cb' => "");
$menu = wp_nav_menu($options);
$menu_list = preg_replace( '#^<ul[^>]*>#', '', $menu );
$menu_list2 = str_replace( array('<ul class="sub-menu">','<ul>','</ul>','</li>'), '', $menu_list );
return $menu_list2;
}


function dez_revert_wp_mobile_menu_page() {
  global $wpdb;
  $qpage = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "posts WHERE post_type='page' AND post_status='publish' ORDER by ID");
  foreach ($qpage as $ipage ) {
  echo "<option value='" . get_permalink( $ipage->ID ) . "'>" . $ipage->post_title . "</option>";
  }
}

function dez_get_mobile_navigation($nav_name='') {
echo '<div id="mobile-nav">';
echo '<div class="mobile-open"><a class="mobile-open-click" href="#"><i class="fa fa-bars"></i>'. __(
"Top Menu","mesocolumn") . '</a></div>';
echo '<ul id="mobile-menu-wrap">';
echo dez_get_wp_custom_mobile_nav_menu($nav_name);
echo '</ul>';
echo '</div>';
}

////////////////////////////////////////////////////////////////////
// Browser Detect
///////////////////////////////////////////////////////////////////
function dez_get_browser_body_class($classes) {
global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
$customshop = get_theme_mod('custom_shop');
if($is_lynx) $classes[] = 'lynx';
elseif($is_gecko) $classes[] = 'gecko';
elseif($is_opera) $classes[] = 'opera';
elseif($is_NS4) $classes[] = 'ns4';
elseif($is_safari) $classes[] = 'safari';
elseif($is_chrome) $classes[] = 'chrome';
elseif($is_IE) $classes[] = 'ie';
else $classes[] = 'unknown';
if($is_iphone) $classes[] = 'iphone';
if($customshop == 'enable') $classes[] = 'custom-shop-enable';
return $classes;
}
add_filter('body_class','dez_get_browser_body_class');

////////////////////////////////////////////////////////////////////
// Check body class name by pages
///////////////////////////////////////////////////////////////////
function dez_get_current_body_class($name) {
$boclass = get_body_class();
//print_r($boclass);
if (in_array($name, $boclass)) {
return 'true';
} else {
return 'false';
}
}

////////////////////////////////////////////////////////////////////////////////
// Get Recent Comments With Avatar
////////////////////////////////////////////////////////////////////////////////
function dez_get_avatar_recent_comment($limit) {
global $wpdb;
$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
comment_type,comment_author_url, SUBSTRING(comment_content,1,50) AS com_excerpt FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID) WHERE post_type IN ('post','page') AND comment_approved = '1' AND comment_type = '' AND
post_password = '' ORDER BY comment_date_gmt DESC LIMIT " . $limit;
echo '<ul class="gravatar_recent_comment">';
$comments = $wpdb->get_results($sql);
$pre_HTML = '';
$output = $pre_HTML;
$gravatar_status = 'on'; /* off if not using */
foreach ($comments as $comment) {
$grav_email = $comment->comment_author_email;
$grav_name = $comment->comment_author;
$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($grav_email). "&amp;size=32";
$comtext = strip_tags($comment->com_excerpt);
?>
<li>
<?php if($gravatar_status == 'on') { echo get_avatar( $grav_email, '120'); } ?>
<div class="gravatar-meta">
<span class="author"><span class="aname"><?php echo strip_tags($comment->comment_author); ?></span> - </span>
<span class="comment"><a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php _e('Comment on', 'mesocolumn'); ?> <?php echo strip_tags($comment->post_title); ?>"><?php echo $comtext; ?>...</a></span>
</div>
</li>
<?php
}
echo '</ul>';
}


////////////////////////////////////////////////////////////////////////////////
// Most Comments
////////////////////////////////////////////////////////////////////////////////
function dez_get_hot_topics($limit) {
global $wpdb, $post;
$mostcommenteds = $wpdb->get_results("SELECT  $wpdb->posts.ID, post_title, post_name, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_total' FROM $wpdb->posts LEFT JOIN $wpdb->comments ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' GROUP BY $wpdb->comments.comment_post_ID ORDER  BY comment_total DESC LIMIT " . $limit);
echo '<ul class="most-commented">';
foreach ($mostcommenteds as $post) {
$post_title = htmlspecialchars(stripslashes($post->post_title));
$comment_total = (int) $post->comment_total;
echo "<li><a href=\"".get_permalink()."\">$post_title</a><span class=\"total-com\">&nbsp;($comment_total)</span></li>";
}
echo '</ul>';
}




////////////////////////////////////////////////////////////////////////////////
// Get Short Featured Title
////////////////////////////////////////////////////////////////////////////////
function dez_get_short_feat_title($limit) {
 $title = get_the_title();
 $count = strlen($title);
 if ($count >= $limit) {
 $title = substr($title, 0, $limit);
 $title .= '...';
 }
 echo $title;
}


////////////////////////////////////////////////////////////////////////////////
// Get Short Excerpt
////////////////////////////////////////////////////////////////////////////////
function dez_get_short_text($text='', $wordcount='') {
$text_count = strlen( $text );
if ( $text_count <= $wordcount ) {
$text = $text;
} else {
$text = substr( $text, 0, $wordcount );
$text = $text . '...';
}
return $text;
}


////////////////////////////////////////////////////////////////////////////////
// excerpt the_content()
////////////////////////////////////////////////////////////////////////////////
function dez_get_custom_the_excerpt($limit='',$more='') {
global $post;
$thepostlink = '<a class="readmore" href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
$custom_text = get_post_meta($post->ID,'post_custom_text',true);
if($custom_text) {
if($more) {
    $excerpt = $custom_text . $thepostlink . $more . '</a>';
    } else {
    $excerpt = $custom_text;
    }
return $excerpt;

} else {

$content = wp_strip_all_tags(get_the_content() , true );
//remove caption tag
$content_filter = preg_replace('`\[[^\]]*\]`','',$content);
//remove email tag
$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
$replacement = "";
$content_filter = preg_replace($pattern, $replacement, $content_filter);
//remove link url tag
$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
$replacement = "";
$content_filter = preg_replace($pattern, $replacement, $content_filter);

if($more) {
    $excerpt = wp_trim_words($content_filter, $limit) . $thepostlink.$more.'</a>';
    } else {
    $excerpt = wp_trim_words($content_filter, $limit);
    }
return $excerpt;
}
}



function dez_get_custom_the_content($limit) {
global $id, $post;
$mycontent = get_the_content();
if($mycontent) {
  $content = explode(' ', $mycontent, $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  $content = strip_tags($content, '<p>');
  return $content;
  }
}


////////////////////////////////////////////////////////////////////////////////
// get first attachment image
////////////////////////////////////////////////////////////////////////////////
function dez_echo_first_image( $id='', $size='' ) {
$args = array(
		'numberposts' => 1,
		'order' => 'ASC',
		'post_mime_type' => 'image',
		'post_parent' => $id,
		'post_status' => null,
		'post_type' => 'attachment',
	);
	$attachments = get_children( $args );

	if ( $attachments ) {
	foreach ( $attachments as $attachment ) {
    $image_attributes = wp_get_attachment_image_src( $attachment->ID, $size );
    return $image_attributes[0];
		}
	}
}

////////////////////////////////////////////////////////////////////////////////
// remove http or https
////////////////////////////////////////////////////////////////////////////////
function dez_remove_http($url) {
$disallowed = array('http://', 'https://');
foreach($disallowed as $d) {
if(strpos($url, $d) === 0) {
return str_replace($d, '', $url);
}
}
return $url;
}

////////////////////////////////////////////////////////////////////////////////
// get image source link
////////////////////////////////////////////////////////////////////////////////
function dez_get_image_src($string){
$first_img = '';
ob_start();
ob_end_clean();
$first_image = preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $string, $matches );
$import_image = $matches[1][0];
$import_image = str_replace('-150x150','',$import_image);
$final_import_image = str_replace('-300x300','',$import_image);
return $final_import_image;
}



function dez_get_image_alt_text() {
global $wpdb, $post, $posts;
$image_id = get_post_thumbnail_id( get_the_ID() );
$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
if( $image_alt ) {
return $image_alt;
} else {
return the_title_attribute('echo=0');
}
}


////////////////////////////////////////////////////////////////////////////////
// get featured images
////////////////////////////////////////////////////////////////////////////////
if( !function_exists( 'dez_get_featured_post_image' )):
function dez_get_featured_post_image($before,$after,$width,$height,$class,$size,$alt,$title,$default) { //$size - full, large, medium, thumbnail
global $blog_id,$wpdb, $post, $posts;
$image_id = get_post_thumbnail_id();
$image_url = wp_get_attachment_image_src($image_id,$size);
$image_url = $image_url[0];
$current_theme = wp_get_theme();
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$smart_image = get_theme_mod('first_feat_img');

$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

if($output): $first_img = $matches[1][0]; endif;

if(!empty($swt_post_thumb)):

$import_img = dez_get_image_src($swt_post_thumb);

return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $import_img . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

else:

if( has_post_thumbnail( $post->ID ) ) {
return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $image_url . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {

/* check image attach or uploaded to post */
$images = dez_echo_first_image( $post->ID, $size );

if($images && $smart_image == 'enable') {

return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $images . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {

if($first_img && $smart_image == 'enable') {

return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $first_img . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

}  else  {

/* if true, default image is set */
if($default == 'true'):
return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . get_template_directory_uri() . '/images/post-default.png' . "' alt='" . $alt . "' title='" . $title . "' />" . $after;
endif;

}


}

}
endif;

}
endif;

////////////////////////////////////////////////////////////////////////////////
// get featured slider images
////////////////////////////////////////////////////////////////////////////////
if( !function_exists( 'dez_get_featured_slider_image' )):
function dez_get_featured_slider_image($before,$after,$width,$height,$class,$size,$alt,$title,$default) { //$size - full, large, medium, thumbnail
global $blog_id,$wpdb, $post, $posts;
$image_id = get_post_thumbnail_id();
$image_url = wp_get_attachment_image_src($image_id,$size);
$image_url = $image_url[0];
$current_theme = wp_get_theme();
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$smart_image = get_theme_mod('first_feat_img');

$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

if($output): $first_img = $matches[1][0]; endif;

if(!empty($swt_post_thumb)):

$import_img = dez_get_image_src($swt_post_thumb);

return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $import_img . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

else:

if( has_post_thumbnail( $post->ID ) ) {
return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $image_url . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {


/* check image attach or uploaded to post */
$images = dez_echo_first_image( $post->ID, $size );

if($images && $smart_image == 'enable') {

return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $images . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {

if($first_img && $smart_image == 'enable') {
return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $first_img . "' alt='" . $alt . "' title='" . $title . "' />" . $after;
} else {
if($default == 'true'):
return $before . "<img width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . get_template_directory_uri() . '/images/slider-default.png' . "' alt='" . $alt . "' title='" . $title . "' />" . $after;
endif;
}

}


}
endif;

}
endif;


////////////////////////////////////////////////////////////////////////////////
// Get Post Page ID Outside loop
////////////////////////////////////////////////////////////////////////////////
function dez_get_post_id_outside_loop() {
global $wp_query;
$thePostID = $wp_query->post->ID;
return $thePostID;
}


////////////////////////////////////////////////////////////////////////////////
// Check if post has thumbnail attached
////////////////////////////////////////////////////////////////////////////////
function dez_get_has_thumb_class($classes) {
global $post;
$smart_image = get_theme_mod('first_feat_img');
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
if($output && $smart_image == 'enable') {
$first_img = $matches[1][0];
} else {
$first_img = '';
}

/* check image attach or uploaded to post */
if( $smart_image == 'enable') {
$upload_images = dez_echo_first_image( $post->ID, 'thumbnail' );
} else {
$upload_images = '';
}

if( has_post_thumbnail($post->ID) || !empty($first_img) || !empty($swt_post_thumb) || !empty($upload_images) ) {
$classes[] = 'has_thumb';
} else {
$classes[] = 'has_no_thumb';
}
return $classes;
}
add_filter('post_class', 'dez_get_has_thumb_class');


////////////////////////////////////////////////////////////////////////////////
// Check if post has thumbnail check
////////////////////////////////////////////////////////////////////////////////
function dez_get_has_thumb_check() {
global $post;
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$smart_image = get_theme_mod('first_feat_img');
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
if($output && $smart_image == 'enable') {
$first_img = $matches[1][0];
} else {
$first_img = '';
}
/* check image attach or uploaded to post */
if( $smart_image == 'enable') {
$upload_images = dez_echo_first_image( $post->ID, 'thumbnail' );
} else {
$upload_images = '';
}

if( has_post_thumbnail($post->ID) || !empty($first_img) || !empty($swt_post_thumb) || !empty($upload_images) ) {
$output = 'has_thumb';
} else {
$output = 'has_no_thumb';
}
return $output;
}


////////////////////////////////////////////////////////////////////////////////
// wp_list_comment
////////////////////////////////////////////////////////////////////////////////
function dez_get_the_list_comments($comment, $args, $depth) {
global $bp_existed;
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
<div class="comment-body" id="div-comment-<?php comment_ID(); ?>">
<?php if($bp_existed == 'true') { // check if bp existed  ?>
<?php echo bp_core_fetch_avatar( array( 'item_id' => $comment->user_id, 'width' => 52, 'height' => 52, 'email' => $comment->comment_author_email ) ); ?>
<?php } else { ?>
<?php echo get_avatar( $comment, 52 ) ?>
<?php } ?>
<div class="comment-author vcard">
<div class="comment-post-meta">
<cite class="fn"><?php comment_author_link() ?></cite> <span class="says">-</span> <small><a href="#comment-<?php comment_ID() ?>"><?php comment_date(__('F jS, Y', 'mesocolumn')) ?> <?php _e("at",'mesocolumn'); ?> <?php comment_time() ?>
</a></small>
<span class="meta-no-display"><cite class="org"><?php _e('none', 'mesocolumn'); ?></cite><cite class="role">
<?php printf( __( 'Comment author #%1$s on %2$s by %3$s', 'mesocolumn' ), get_comment_ID(),the_title_attribute('echo=0'), get_bloginfo('name') ); ?></cite>
</span>
</div>
<div id="comment-text-<?php comment_ID(); ?>" class="comment_text">
<?php if ($comment->comment_approved == '0') : ?>
<em><?php _e('Your comment is awaiting moderation.', 'mesocolumn'); ?></em>
<?php endif; ?>
<?php comment_text() ?>
<div class="reply">
<?php comment_reply_link(array_merge( $args, array('add_below'=> 'comment-text', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
</div>
</div>
</div>
</div>
<?php
}

////////////////////////////////////////////////////////////////////////////////
// wp_list_pingback
////////////////////////////////////////////////////////////////////////////////
function dez_get_the_list_pings($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

////////////////////////////////////////////////////////////////////////////////
// search post only exclude pages
////////////////////////////////////////////////////////////////////////////////
function dez_remove_page_search_filter($query) {
if ( $query->is_search ) {
$query->set('post_type', 'post');
}
return $query;
}
//add_filter('pre_get_posts','dez_remove_page_search_filter');


if( !function_exists('dez_get_singular_cat') ) {
////////////////////////////////////////////////////////////////////////////////
// get/show single category only
////////////////////////////////////////////////////////////////////////////////
function dez_get_singular_cat($link = '') {
global $post;
$category_check = get_the_category();
$category = isset( $category_check ) ? $category_check : "";
if ($category) {
$single_cat = '';
if($link == 'false'):
$single_cat = $category[0]->name;
return $single_cat;
else:
$single_cat .= '<a rel="category tag" href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s", 'mesocolumn' ), $category[0]->name ) . '" ' . '>';
$single_cat .= $category[0]->name;
$single_cat .= '</a>';
return $single_cat;
endif;
} else {
return NULL;
}
}
}

if( !function_exists('dez_get_wp_post_view') ) :
////////////////////////////////////////////////////////////////////////////////
// get post view count
////////////////////////////////////////////////////////////////////////////////
function dez_get_wp_post_view($postID){
$count_key = 'post_views_count';
$count = get_post_meta($postID, $count_key, true);
if( $count == '' ) {
delete_post_meta($postID, $count_key);
add_post_meta($postID, $count_key, '0');
return "0";
}
return $count;
}
function dez_set_wp_post_view($postID) {
$count_key = 'post_views_count';
$count = get_post_meta($postID, $count_key, true);
if( $count == '' ){
$count = 0;
delete_post_meta($postID, $count_key);
add_post_meta($postID, $count_key, '0');
} else {
$count++;
update_post_meta($postID, $count_key, $count);
}
}
endif;



if( !function_exists('dez_get_wp_comment_count') ) :
////////////////////////////////////////////////////////////////////////////////
// get post view count
////////////////////////////////////////////////////////////////////////////////
function dez_get_wp_comment_count($type = ''){ //type = comments, pings,trackbacks, pingbacks
        if($type == 'comments'):
                $typeSql = 'comment_type = ""';
                $oneText = __('One comment', 'mesocolumn');
                $moreText = __('% comments', 'mesocolumn');
                $noneText = __('No Comments', 'mesocolumn');
        elseif($type == 'pings'):
                $typeSql = 'comment_type != ""';
                $oneText = __('One pingback/trackback', 'mesocolumn');
                $moreText = __('% pingbacks/trackbacks', 'mesocolumn');
                $noneText = __('No pinbacks/trackbacks', 'mesocolumn');
        elseif($type == 'trackbacks'):
                $typeSql = 'comment_type = "trackback"';
                $oneText = __('One trackback', 'mesocolumn');
                $moreText = __('% trackbacks', 'mesocolumn');
                $noneText = __('No trackbacks', 'mesocolumn');
        elseif($type == 'pingbacks'):
                $typeSql = 'comment_type = "pingback"';
                $oneText = __('One pingback', 'mesocolumn');
                $moreText = __('% pingbacks', 'mesocolumn');
                $noneText = __('No pingbacks', 'mesocolumn');
        endif;
global $wpdb;
$result = $wpdb->get_var('SELECT COUNT(comment_ID) FROM '. $wpdb->prefix . 'comments WHERE '. $typeSql . ' AND comment_approved="1" AND comment_post_ID= '.get_the_ID());
if($result == 0):
echo str_replace('%', $result, $noneText);
elseif($result == 1):
echo str_replace('%', $result, $oneText);
elseif($result > 1):
echo str_replace('%', $result, $moreText);
endif;
}
endif;


if( !function_exists( 'dez_get_cat_post_count' ) ):
//////////////////////////////////////////////////////////////////////////////
// get post count in category
/////////////////////////////////////////////////////////////////////////////
function dez_get_cat_post_count($cat_id) {
global $wpdb;
$querystr = "SELECT count FROM " . $wpdb->prefix . "term_taxonomy WHERE term_id = '". $cat_id . "'";
$result = $wpdb->get_var($querystr);
if($result) {
return $result;
} else {
return NULL;
}
}
endif;

if( !function_exists( 'dez_get_cat_slug' ) ):
//////////////////////////////////////////////////////////////////////////////
// get cat slug
/////////////////////////////////////////////////////////////////////////////
function dez_get_cat_slug($cat_id) {
	$category = get_category($cat_id);
	return $category->slug;
}
endif;

if( !function_exists( 'dez_get_strip_variable' ) ):
//////////////////////////////////////////////////////////////////////////////
// get post count in category
/////////////////////////////////////////////////////////////////////////////
function dez_get_strip_variable($var) {
$cat_value_strip = str_replace(' ','_',$var);
$cat_value_strip_sec = str_replace('-','_',$cat_value_strip);
$cat_value_option = strtolower($cat_value_strip_sec);
return $cat_value_option;
}
endif;

if( !function_exists( 'dez_posts_columns_id' ) ):
//////////////////////////////////////////////////////////////////////////////
// add ID column to posts in admins
/////////////////////////////////////////////////////////////////////////////
function dez_posts_columns_id($defaults){
$defaults['wps_post_id'] = __('ID', 'mesocolumn');
return $defaults;
}
function dez_posts_custom_id_columns($column_name, $id){
if($column_name === 'wps_post_id'){
echo $id;
}
}
add_filter('manage_posts_columns', 'dez_posts_columns_id', 5);
add_action('manage_posts_custom_column', 'dez_posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'dez_posts_columns_id', 5);
add_action('manage_pages_custom_column', 'dez_posts_custom_id_columns', 5, 2);
endif;

////////////////////////////////////////////////////////////////////////////////
// auto hex based on main color
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('dehex') ) {
function dehex($colour, $per) {
$colour = substr( $colour, 1 ); // Removes first character of hex string (#)
$rgb = ''; // Empty variable
$per = $per/100*255; // Creates a percentage to work with. Change the middle figure to control colour temperature

if  ($per < 0 ) // Check to see if the percentage is a negative number
{
// DARKER
$per =  abs($per); // Turns Neg Number to Pos Number
for ($x=0;$x<3;$x++)
{
$c = hexdec(substr($colour,(2*$x),2)) - $per;
$c = ($c < 0) ? 0 : dechex($c);
$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
}
} else {
// LIGHTER
for ($x=0;$x<3;$x++) {
$c = hexdec(substr($colour,(2*$x),2)) + $per;
$c = ($c > 255) ? 'ff' : dechex($c);
$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
}
}
return '#'.$rgb;
}
}

////////////////////////////////////////////////////////////////////////////////
// get all available custom post type name
////////////////////////////////////////////////////////////////////////////////
function dez_get_all_posttype() {
$post_types = get_post_types( '', 'names' );
$ptype = array();
foreach ( $post_types as $post_type ) {
$ptype[] = $post_type;
}
return $ptype;
}

////////////////////////////////////////////////////////////////////////////////
// get all available taxonomy
////////////////////////////////////////////////////////////////////////////////
function dez_get_all_taxonomy() {
$ptax = array();
$allptype = dez_get_all_posttype();
foreach( $allptype as $type) {
$post_taxo = get_object_taxonomies($type);
foreach($post_taxo  as $taxo) {
$ptax[] = $taxo;
}
}
return $ptax;
}

////////////////////////////////////////////////////////////////////////////////
// change the excerpt length limit
////////////////////////////////////////////////////////////////////////////////
function dez_custom_excerpt_length($length) {
$myexcerpt = get_theme_mod('post_custom_excerpt');
if(!empty($myexcerpt)) {
return $myexcerpt;
} else {
return 30;
}
}
add_filter('excerpt_length', 'dez_custom_excerpt_length');


if( !function_exists('dez_add_hatom_author_entry') ) {
////////////////////////////////////////////////////////////////////////////////
// add hatom data to post author
////////////////////////////////////////////////////////////////////////////////
function dez_add_hatom_author_entry( $link ) {
global $authordata;
// modify this as you like - so far exactly the same as in the original core function
// if you simply want to add something to the existing link, use ".=" instead of "=" for $link
    $link = sprintf(
        '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
        get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
        esc_attr( sprintf( __( 'Posts by %s', 'mesocolumn' ), get_the_author() ) ),
        get_the_author()
    );
return $link;
}
add_filter( 'the_author_posts_link', 'dez_add_hatom_author_entry' );
}


////////////////////////////////////////////////////////////////////////////////
// Add Theme Data
////////////////////////////////////////////////////////////////////////////////
function meso_get_theme_data($data) {
$theme_data = wp_get_theme();
if($data == 'ThemeURI' || $data == 'Author URI' || $data == 'TextDomain'){
$the_theme_data = $theme_data->get($data);
} else {
$the_theme_data = $theme_data->$data;
}
return $the_theme_data;
}

////////////////////////////////////////////////////////////////////////////////
// Add Child Path File Detect
////////////////////////////////////////////////////////////////////////////////
function meso_get_child_file($file_path) {
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . $file_path )) {
$realpath = get_stylesheet_directory_uri() . $file_path;
} elseif( file_exists( get_template_directory() . $file_path ) ) {
$realpath = get_template_directory_uri() . $file_path;
}
return $realpath;
}


?>