<?php
///////////////////////////////////////////////////////////////////////////////
// Check if BuddyPress is installed
//////////////////////////////////////////////////////////////////////////////
if ( function_exists( 'bp_is_active' ) ) {
global $blog_id, $current_blog;
if ( is_multisite() ) {
//check if multiblog
if ( defined( 'BP_ENABLE_MULTIBLOG' ) && BP_ENABLE_MULTIBLOG ) {
$bp_active = 'true';
} else if ( defined( 'BP_ROOT_BLOG' ) && BP_ROOT_BLOG == $current_blog->blog_id ) {
$bp_active = 'true';
}
else if ( defined( 'BP_ROOT_BLOG' ) && ( $blog_id != 1 ) ) {
$bp_active = 'false';
}
} else {
$bp_active = 'true';
}
} else {
$bp_active = 'false';
}

///////////////////////////////////////////////////////////////////////
/// fetch random groups
///////////////////////////////////////////////////////////////////////
function meso_fetch_random_groups($limit='', $size='', $type='', $block_id='') {
global $wpdb, $bp;
$fetch_group = "SELECT * FROM " . $wpdb->base_prefix . "bp_groups WHERE status = 'public' ORDER BY rand() LIMIT $limit";
$sql_fetch_group = $wpdb->get_results($fetch_group); ?>
<ul class="random-groups item-list group-in-<?php echo $block_id; ?>">
<?php
$no_avatar = 'http://www.gravatar.com/avatar';
foreach($sql_fetch_group as $group_fe) {
$avatar_full = bp_core_fetch_avatar( 'item_id=' . $group_fe->id . '&class=avatar&object=group&type=' . $type . '&width=' . $size . '&height=' . $size );
$group_description = stripslashes($group_fe->description);
?>
<li>
<div class="item-avatar"><?php echo $avatar_full; ?></div>
<div class="item">
<div class="item-title">
<a title="<?php echo $group_fe->name . ' - ' . dez_get_short_text($group_description, 150); ?>" href="<?php echo home_url() . '/' . bp_get_root_slug( 'groups' ) . '/' . $group_fe->slug; ?>"><?php echo $group_fe->name; ?></a>
</div>
<div class="item-meta">
<span class="activity">
<?php echo groups_get_groupmeta( $group_fe->id, $meta_key = 'total_member_count'); ?> <?php echo bp_get_root_slug( 'members' ); ?>
</span>
</div>
</div>
</li>
<?php } ?>
</ul>
<?php }


///////////////////////////////////////////////////////////////////////////////////
//// BuddyPress Random Groups
///////////////////////////////////////////////////////////////////////////////////
class MESO_BP_Random_Groups_Widget extends WP_Widget {
function __construct() {
//Constructor
parent::__construct(false, $name = __('BuddyPress Random Groups', 'mesocolumn'), array(
'description' => __('Displays your BuddyPress Groups Randomly.', 'mesocolumn')
));
}
function widget($args, $instance) {
// outputs the content of the widget
extract($args); // Make before_widget, etc available.
$rg_name = empty($instance['title']) ? __('BuddyPress Random Groups', 'mesocolumn') : apply_filters('widget_title', $instance['title']);
$unique_id = $args['widget_id'];
echo $before_widget;
echo $before_title . $rg_name . $after_title;
echo meso_fetch_random_groups($limit=12, $size=50, $type='thumb',$block_id='');
echo $after_widget;
}
function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$rg_name = $instance['title'];
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Name','mesocolumn'); ?>:</label>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" class="widefat" value="<?php echo $rg_name; ?>" /></p>
<?php
}
}


function meso_register_bp_custom_widget() {
if ( bp_is_active( 'groups' ) ) {register_widget('MESO_BP_Random_Groups_Widget');}
}
add_action('widgets_init','meso_register_bp_custom_widget' );

///////////////////////////////////////////////////////////////////////////////
// Load Theme Styles and Javascripts
///////////////////////////////////////////////////////////////////////////////
/*---------------------------load styles--------------------------------------*/
function meso_theme_load_bp_styles() {
global $theme_version;
wp_enqueue_style( 'bp-custom-css', get_template_directory_uri(). '/lib/buddypress/bp-custom-css.css', array(), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'meso_theme_load_bp_styles' );


function meso_bp_theme_widgets_init() {
   register_sidebar(array(
    'name'=>__('BuddyPress Sidebar', 'mesocolumn'),
    'id' => 'buddypress-sidebar',
	'description' => __( 'Widget area for BuddyPress Pages', 'mesocolumn' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'meso_bp_theme_widgets_init', 20 );


?>