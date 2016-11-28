<?php
////////////////////////////////////////////////////////////////////////////////
// Sidebar Widget
////////////////////////////////////////////////////////////////////////////////
function mesocolumn_theme_widgets_init() {

   register_sidebar(array(
    'name'=>__('Tabbed Sidebar', 'mesocolumn'),
   	'id' => 'tabbed-sidebar',
	'description' => __( 'Sidebar Tabbed widget area', 'mesocolumn' ),
	'before_widget' => '<div class="tabbertab"><aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside></div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
	));


    register_sidebar(array(
    'name'=>__('Right Sidebar', 'mesocolumn'),
    'id' => 'right-sidebar',
	'description' => __( 'Right sidebar widget area', 'mesocolumn' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name'=>__('First Footer Widget Area', 'mesocolumn'),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'mesocolumn' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar( array(
		'name' => __('Second Footer Widget Area', 'mesocolumn'),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'mesocolumn' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __('Third Footer Widget Area', 'mesocolumn'),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'mesocolumn' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

   	register_sidebar( array(
		'name' => __('Fourth Footer Widget Area', 'mesocolumn'),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'mesocolumn' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'mesocolumn_theme_widgets_init' );



///////////////////////////////////////////////////////////////////////////////////
////custom most commented post widget
///////////////////////////////////////////////////////////////////////////////////
class MESO_Most_Commented_Widget extends WP_Widget {
function __construct()  {
//Constructor
parent::__construct(false, $name = __('Most Comments', 'mesocolumn'), array(
'description' => __('Display your most commented posts.', 'mesocolumn')
));
}

function widget($args, $instance) {
// outputs the content of the widget
extract($args); // Make before_widget, etc available.
$mc_name = empty($instance['title']) ? __('Most Comments', 'mesocolumn') : apply_filters('widget_title', $instance['title']);

$mc_number = isset($instance['number']) ? $instance['number'] : "";
$mc_comment_count = isset($instance['commentcount']) ? $instance['commentcount'] : "";

$unique_id = $args['widget_id'];

global $wpdb, $post;
$mostcommenteds = $wpdb->get_results("SELECT $wpdb->posts.ID, post_title, post_name, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_total' FROM $wpdb->posts LEFT JOIN $wpdb->comments ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_date_gmt < '" . gmdate("Y-m-d H:i:s") . "' AND post_status = 'publish' AND post_password = '' GROUP BY $wpdb->comments.comment_post_ID ORDER  BY comment_total DESC LIMIT $mc_number");
  echo $before_widget;
  echo $before_title . $mc_name . $after_title;
  echo "<ul class='most-commented'> ";
  foreach ($mostcommenteds as $post) {
    $post_title = htmlspecialchars(stripslashes($post->post_title));
    $comment_total = (int) $post->comment_total;
    echo "<li><a href=\"" . get_permalink() . "\">$post_title</a>";
    if($mc_comment_count == 'yes') {
    echo "<span class='total-com'>&nbsp;($comment_total)</span>";
    }
    echo "</li>";
  }
  echo "</ul> ";
  echo $after_widget;
}
function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$mc_name = isset($instance['title']) ? $instance['title'] : "";
$mc_number = isset($instance['number']) ? $instance['number'] : "";
$mc_comment_count = isset($instance['commentcount']) ? $instance['commentcount'] : "";
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Name for most comment(optional):', 'mesocolumn');?>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" class="widefat" value="<?php echo $mc_name;?>" /></label></p>

<p>
<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Total to show: ', 'mesocolumn');?>
<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" class="widefat" value="<?php echo $mc_number;?>" /></label>
</p>

<p>
<label for="<?php echo $this->get_field_id('commentcount'); ?>"><?php _e('Show comments count:', 'mesocolumn'); ?></label>
<select id="<?php echo $this->get_field_id('commentcount'); ?>" name="<?php echo $this->get_field_name('commentcount'); ?>">
<option<?php if($mc_comment_count == 'yes') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('commentcount'); ?>" value="yes"><?php _e('yes', 'mesocolumn'); ?></option>
<option<?php if($mc_comment_count == 'no') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('commentcount'); ?>" value="no"><?php _e('no', 'mesocolumn'); ?></option>
</select>
</p>

<?php
}
}



///////////////////////////////////////////////////////////////////////////////////
////wordpress and buddypress recent comment widget
///////////////////////////////////////////////////////////////////////////////////
class MESO_Recent_Comments_Widget extends WP_Widget {
function __construct() {
//Constructor
parent::__construct(false, $name = __('Recent Gravatar Comments', 'mesocolumn'), array(
'description' => __('Display your recent comments with user avatar.', 'mesocolumn')
));
}
function widget($args, $instance) {
// outputs the content of the widget
extract($args); // Make before_widget, etc available.
$rc_name = empty($instance['title']) ? __('Recent Gravatar Comments', 'mesocolumn') : apply_filters('widget_title', $instance['title']);

$rc_number = isset($instance['number']) ? $instance['number'] : "";
$rc_avatar = isset($instance['avatar_on']) ? $instance['avatar_on'] : "";

$unique_id = $args['widget_id'];

global $wpdb;

$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
comment_type,comment_author_url,
SUBSTRING(comment_content,1,50) AS com_excerpt
FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID)
WHERE post_type IN ('post','page') AND comment_approved = '1' AND comment_type = '' AND
post_password = ''
ORDER BY comment_date_gmt DESC LIMIT $rc_number";

$comments = $wpdb->get_results($sql);
$pre_HTML = '';
$output = $pre_HTML;
echo $before_widget;
echo $before_title . $rc_name . $after_title;
echo "<ul class='gravatar_recent_comment'>";
foreach ($comments as $comment) {
$grav_email = $comment->comment_author_email;
$grav_name = $comment->comment_author;
$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($grav_email). "&amp;size=32";
$comtext = strip_tags($comment->com_excerpt);
?>
<li>
<?php if($rc_avatar == 'yes') {  ?><?php echo get_avatar( $grav_email, '32'); ?><?php } ?>
<?php if($rc_avatar == 'yes') { ?><div class="gravatar-comment-meta"><?php } ?>
<span class="author"><span class="aname"><?php echo strip_tags($comment->comment_author); ?></span> - </span>
<span class="comment"><a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php _e('Comment on', 'mesocolumn'); ?> <?php echo strip_tags($comment->post_title); ?>"><?php echo $comtext; ?>...</a></span>
<?php if($rc_avatar == 'yes') { ?></div><?php } ?>
</li>
<?php
}
echo "</ul> ";
echo $after_widget;
?>
<?php }

function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$rc_name = isset($instance['title']) ? $instance['title'] : "";
$rc_number = isset($instance['number']) ? $instance['number'] : "";
$rc_avatar = isset($instance['avatar_on']) ? $instance['avatar_on'] : "";
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Name for recent comment(optional):', 'mesocolumn'); ?>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" class="widefat" value="<?php echo $rc_name; ?>" /></label></p>

<p>
<label for="<?php echo $this->get_field_id('avatar_on'); ?>"><?php _e('Enable avatar?:', 'mesocolumn'); ?></label>
<select id="<?php echo $this->get_field_id('avatar_on'); ?>" name="<?php echo $this->get_field_name('avatar_on'); ?>">
<option<?php if($rc_avatar == 'yes') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('avatar_on'); ?>" value="yes"><?php _e('yes', 'mesocolumn'); ?></option>
<option<?php if($rc_avatar == 'no') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('avatar_on'); ?>" value="no"><?php _e('no', 'mesocolumn'); ?></option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Total to show:', 'mesocolumn'); ?>
<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" class="widefat" value="<?php echo $rc_number; ?>" /></label></p>

<?php
}
}



//////////////////////////////////////////////////////////////////////////
// Multi Category Featured Posts Widget
///////////////////////////////////////////////////////////////////////////
class MESO_Featured_Multi_Category_Widget extends WP_Widget {
function __construct() {
//Constructor
parent::__construct(false, $name = __('Featured Categories', 'mesocolumn'), array(
'description' => __('Display your featured category listing.', 'mesocolumn')
));
}
function widget($args, $instance) {
global $bp_existed, $post;
// outputs the content of the widget
extract($args); // Make before_widget, etc available.

$feat_title = empty($instance['title']) ? __('Featured Categories', 'mesocolumn') : apply_filters('widget_title', $instance['title']);

$feat_name = isset($instance['featcatname']) ? $instance['featcatname'] : "";
$feat_thumb = isset($instance['featthumb']) ? $instance['featthumb'] : "";

if($feat_thumb == 'yes') {
$feat_thumb_size = isset($instance['featthumbsize']) ? $instance['featthumbsize'] : "";
} else {
$feat_thumb_size = 'thumb_off';
}

$feat_data = isset($instance['featdata']) ? $instance['featdata'] : "";
$feat_total = isset($instance['feattotal']) ? $instance['feattotal'] : "";

$unique_id = $args['widget_id'];

echo $before_widget;

echo $before_title . $feat_title . $after_title;

echo "<ul class='featured-cat-posts'>";
$my_query = new WP_Query('cat='. $feat_name . '&' . 'showposts=' . $feat_total);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
$the_post_ids = get_the_ID();
$thepostlink = '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
?>

<li class="<?php echo dez_get_has_thumb_check(); ?> <?php echo 'the-sidefeat-'.$feat_thumb_size; ?>">
<?php if($feat_thumb == 'yes') { ?>
<?php if($feat_thumb_size == '' || $feat_thumb_size == 'thumbnail'): ?>
<?php echo dez_get_featured_post_image($thepostlink,'</a>',50,50,'featpost alignleft','thumbnail',dez_get_image_alt_text(), the_title_attribute('echo=0'), false); ?>
<?php else: ?>
<?php echo dez_get_featured_post_image(''.$thepostlink,'</a>',480,320,'featpost alignleft','medium', dez_get_image_alt_text(), the_title_attribute('echo=0'), false); ?>
<?php endif; ?>
<?php } ?>
<div class="feat-post-meta">
<h5 class="feat-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
<?php if($feat_data != 'disable') { ?>
<div class="feat-meta"><small><?php echo the_time( get_option( 'date_format' ) ); ?><?php if ( comments_open() ) { ?><span class="widget-feat-comment"> - <?php comments_popup_link(__('No Comment','mesocolumn'), __('1 Comment','mesocolumn'), __('% Comments','mesocolumn') ); ?></span><?php } ?></small></div>
<?php } ?>
</div>
</li>
<?php endwhile; wp_reset_query(); ?>
<?php
echo "</ul>";
echo $after_widget;
// end echo result
}


function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$feat_title = isset($instance['title']) ? $instance['title'] : "";
$feat_name = isset($instance['featcatname']) ? $instance['featcatname'] : "";
$feat_thumb_size = isset($instance['featthumbsize']) ? $instance['featthumbsize'] : "";
$feat_thumb = isset($instance['featthumb']) ? $instance['featthumb'] : "";
$feat_total = isset($instance['feattotal']) ? $instance['feattotal'] : "";
$feat_data = isset($instance['featdata']) ? $instance['featdata'] : "";
?>


<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title:",'mesocolumn'); ?> <em><?php _e("*required",'mesocolumn'); ?></em></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $feat_title; ?>" />
</p>

<p><label for="<?php echo $this->get_field_id('featcatname'); ?>"><?php _e("Category ID:",'mesocolumn'); ?><br /><em><?php _e("*separate by commas [,]",'mesocolumn'); ?></em> </label>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('featcatname'); ?>" name="<?php echo $this->get_field_name('featcatname'); ?>" value="<?php echo $feat_name; ?>" />
</p>

<p><label for="<?php echo $this->get_field_id('featthumb'); ?>"><?php _e('Enable Thumbnails?:<br /><em>*post featured images</em>', 'mesocolumn'); ?></label>
<select class="widefat" id="<?php echo $this->get_field_id('featthumb'); ?>" name="<?php echo $this->get_field_name('featthumb'); ?>">
<option<?php if($feat_thumb == 'yes') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('featthumb'); ?>" value="yes"><?php _e('yes', 'mesocolumn'); ?></option>
<option<?php if($feat_thumb== 'no') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('featthumb'); ?>" value="no"><?php _e('no', 'mesocolumn'); ?></option>
</select>
</p>

<p><label for="<?php echo $this->get_field_id('featthumbsize'); ?>"><?php _e('Thumbnails Size?:', 'mesocolumn'); ?>    </label>
<select class="widefat" id="<?php echo $this->get_field_id('featthumbsize'); ?>" name="<?php echo $this->get_field_name('featthumbsize'); ?>">
<option<?php if($feat_thumb_size == 'thumbnail') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('featthumbsize'); ?>" value="thumbnail"><?php _e('thumbnail', 'mesocolumn'); ?></option>
<option<?php if($feat_thumb_size == 'medium') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('featthumbsize'); ?>" value="medium"><?php _e('medium', 'mesocolumn'); ?></option>
</select>
</p>


<p><label for="<?php echo $this->get_field_id('featdata'); ?>"><?php _e('Enable Post Meta?:<br /><em>*post date and post comments count</em>', 'mesocolumn'); ?></label>
<select class="widefat" id="<?php echo $this->get_field_id('featdata'); ?>" name="<?php echo $this->get_field_name('featdata'); ?>">
<option<?php if($feat_data == 'enable') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('featdata'); ?>" value="enable"><?php _e('Enable', 'mesocolumn'); ?></option>
<option<?php if($feat_data == 'disable') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('featdata'); ?>" value="disable"><?php _e('Disable', 'mesocolumn'); ?></option>
</select>
</p>

<p><label for="<?php echo $this->get_field_id('feattotal'); ?>"><?php _e("Total:",'mesocolumn'); ?></label> <br />
<input class="widefat" id="<?php echo $this->get_field_id('feattotal'); ?>" name="<?php echo $this->get_field_name('feattotal'); ?>" type="text" value="<?php echo $feat_total; ?>" />
</p>
<?php
}
}

/*--------------------------------------------
Multi Custom Post Type Featured Posts Widget
---------------------------------------------*/
class MESO_Featured_Multi_CPT_Widget extends WP_Widget {
function __construct() {
//Constructor
parent::__construct(false, $name = __('Custom Post Type', 'mesocolumn'), array(
'description' => __('Display your custom post type listing.', 'mesocolumn')
));
}
function widget($args, $instance) {
global $bp_existed, $post;
// outputs the content of the widget
extract($args);
// Make before_widget, etc available.
$cpt_title = empty($instance['title']) ? __('Custom Posts', 'mesocolumn') : apply_filters('widget_title', $instance['title']);
$cpt_name = isset($instance['cptname']) ? $instance['cptname'] : "";
$cpt_thumb = isset($instance['cptthumb']) ? $instance['cptthumb'] : "";

if($cpt_thumb == 'yes') {
$cpt_thumb_size = isset($instance['cptthumbsize']) ? $instance['cptthumbsize'] : "";
} else {
$cpt_thumb_size = 'thumb_off';
}

$cpt_data = isset($instance['cptdata']) ? $instance['cptdata'] : "";
$cpt_total = isset($instance['cpttotal']) ? $instance['cpttotal'] : "";
$unique_id = $args['widget_id'];
echo $before_widget;
echo $before_title . $cpt_title . $after_title;
echo "<ul class='featured-cat-posts'>";
$my_query = new WP_Query('post_type='. $cpt_name . '&' . 'showposts=' . $cpt_total);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
$the_post_ids = get_the_ID();
$thepostlink = '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
?>
<li class="<?php echo dez_get_has_thumb_check(); ?> <?php echo 'the-sidefeat-'.$cpt_thumb_size; ?>">
<?php if($cpt_thumb == 'yes') { ?>
<?php if($cpt_thumb_size == '' || $cpt_thumb_size == 'thumbnail'): ?>
<?php echo dez_get_featured_post_image($thepostlink,'</a>',50,50,'featpost alignleft','thumbnail',dez_get_image_alt_text(), the_title_attribute('echo=0'), false); ?>
<?php else: ?>
<?php echo dez_get_featured_post_image(''.$thepostlink,'</a>',480,320,'featpost alignleft','medium', dez_get_image_alt_text(), the_title_attribute('echo=0'), false); ?>
<?php endif; ?>
<?php } ?>
<div class="feat-post-meta">
<h5 class="feat-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
<?php if($cpt_data != 'disable') { ?>
<div class="feat-meta"><small><?php echo the_time( get_option( 'date_format' ) ); ?><?php if ( comments_open() ) { ?><span class="widget-feat-comment"> - <?php comments_popup_link(__('No Comment','mesocolumn'), __('1 Comment','mesocolumn'), __('% Comments','mesocolumn') ); ?></span><?php } ?></small></div>
<?php } ?>
</div>
</li>
<?php endwhile; wp_reset_postdata(); ?>
<?php
echo "</ul>";
echo $after_widget;
// end echo result
}


function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$cpt_title = isset($instance['title']) ? $instance['title'] : "";
$cpt_name = isset($instance['cptname']) ? $instance['cptname'] : "";
$cpt_thumb = isset($instance['cptthumb']) ? $instance['cptthumb'] : "";
$cpt_thumb_size = isset($instance['cptthumbsize']) ? $instance['cptthumbsize'] : "";
$cpt_data = isset($instance['cptdata']) ? $instance['cptdata'] : "";
$cpt_total = isset($instance['cpttotal']) ? $instance['cpttotal'] : "";
?>


<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title:",'mesocolumn'); ?> <em><?php _e("*required",'mesocolumn'); ?></em></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $cpt_title; ?>" />
</p>
<p><label for="<?php echo $this->get_field_id('cptname'); ?>"><?php _e("Select Custom Post Type:",'mesocolumn'); ?></label>
<select class="widefat" id="<?php echo $this->get_field_id('cptname'); ?>" name="<?php echo $this->get_field_name('cptname'); ?>">
<?php
$all_cpt = dez_get_all_posttype();
if($all_cpt) {
foreach($all_cpt as $cpts) {
if($cpt_name == $cpts) { $is_selected = ' selected="selected" '; } else { $is_selected = ""; }
$cptlist = '<option '. $is_selected . 'name="'.$this->get_field_name('cptname').'" value="'.$cpts.'">'. $cpts. '</option>';
echo $cptlist;
}
}
?>
</select>
</p>

<p><label for="<?php echo $this->get_field_id('cptthumb'); ?>"><?php _e('Enable Thumbnails?:<br /><em>*post featured images</em>', 'mesocolumn'); ?></label>
<select class="widefat" id="<?php echo $this->get_field_id('cptthumb'); ?>" name="<?php echo $this->get_field_name('cptthumb'); ?>">
<option<?php if($cpt_thumb == 'yes') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('cptthumb'); ?>" value="yes"><?php _e('yes', 'mesocolumn'); ?></option>
<option<?php if($cpt_thumb== 'no') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('cptthumb'); ?>" value="no"><?php _e('no', 'mesocolumn'); ?></option>
</select>
</p>

<p><label for="<?php echo $this->get_field_id('cptthumbsize'); ?>"><?php _e('Thumbnails Size?:', 'mesocolumn'); ?>    </label>
<select class="widefat" id="<?php echo $this->get_field_id('cptthumbsize'); ?>" name="<?php echo $this->get_field_name('cptthumbsize'); ?>">
<option<?php if($cpt_thumb_size == 'thumbnail') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('cptthumbsize'); ?>" value="thumbnail"><?php _e('thumbnail', 'mesocolumn'); ?></option>
<option<?php if($cpt_thumb_size == 'medium') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('cptthumbsize'); ?>" value="medium"><?php _e('medium', 'mesocolumn'); ?></option>
</select>
</p>

<p><label for="<?php echo $this->get_field_id('cptdata'); ?>"><?php _e('Enable Post Meta?:<br /><em>*post date and post comments count</em>', 'mesocolumn'); ?></label>
<select class="widefat" id="<?php echo $this->get_field_id('cptdata'); ?>" name="<?php echo $this->get_field_name('cptdata'); ?>">
<option<?php if($cpt_data == 'enable') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('cptdata'); ?>" value="enable"><?php _e('Enable', 'mesocolumn'); ?></option>
<option<?php if($cpt_data == 'disable') { echo " selected='selected'"; } ?> name="<?php echo $this->get_field_name('cptdata'); ?>" value="disable"><?php _e('Disable', 'mesocolumn'); ?></option>
</select>
</p>

<p><label for="<?php echo $this->get_field_id('cpttotal'); ?>"><?php _e("Total:",'mesocolumn'); ?></label> <br />
<input class="widefat" id="<?php echo $this->get_field_id('cpttotal'); ?>" name="<?php echo $this->get_field_name('cpttotal'); ?>" type="text" value="<?php echo $cpt_total; ?>" />
</p>
<?php
}
}

/*--------------------------------------------
Description: add tabber widget
---------------------------------------------*/
function meso_theme_widget_tabber() { get_template_part('lib/templates/tabber-widget'); }
wp_register_sidebar_widget( 'mesocolumn_tabbed','Tabber', 'meso_theme_widget_tabber','' );

/*--------------------------------------------
Description: add right sidebar ad widget
---------------------------------------------*/
function meso_theme_widget_right_sidebar_ads() {
$get_ads_right_sidebar = get_theme_mod('ads_right_sidebar'); if($get_ads_right_sidebar)  { ?>
<aside id="ctr-ad" class="widget">
<div class="textwidget adswidget"><?php echo stripcslashes(do_shortcode($get_ads_right_sidebar)); ?></div>
</aside>
<?php }
}
wp_register_sidebar_widget( 'mesocolumn_ads_right', 'Ads Right', 'meso_theme_widget_right_sidebar_ads','' );

/*--------------------------------------------
Description: register custom widget
---------------------------------------------*/
function meso_register_custom_widget() {
register_widget('MESO_Most_Commented_Widget');
register_widget('MESO_Recent_Comments_Widget');
register_widget('MESO_Featured_Multi_CPT_Widget');
register_widget('MESO_Featured_Multi_Category_Widget');
}
add_action('widgets_init','meso_register_custom_widget' );

?>