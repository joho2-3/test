<?php do_action('bp_before_sidebars');
global $in_bbpress, $bp_active;
if( $bp_active == 'true' && function_exists('bp_is_blog_page') && !bp_is_blog_page() ) {
$dynamic_sidebar = apply_filters('meso_buddypress_sidebar_widget_name','buddypress-sidebar');
$wpsidebar = 'false';
} elseif( function_exists('is_in_woocommerce_page') && is_in_woocommerce_page() ) {
$dynamic_sidebar = apply_filters('meso_shop_sidebar_widget_name','shop-sidebar');
$wpsidebar = 'false';
} elseif( function_exists('is_in_jigoshop_page') && is_in_jigoshop_page() ) {
$dynamic_sidebar = apply_filters('meso_shop_sidebar_widget_name','shop-sidebar');
$wpsidebar = 'false';
} elseif( $in_bbpress == 'true' ) {
$dynamic_sidebar = apply_filters('meso_forum_sidebar_widget_name','forum-sidebar');
$wpsidebar = 'false';
} else {
$dynamic_sidebar = apply_filters('meso_right_sidebar_widget_name','right-sidebar');
$wpsidebar = 'true';
}
?>

<div id="right-sidebar" class="sidebar <?php echo $dynamic_sidebar; ?>"<?php do_action('bp_section_sidebar'); ?>>
<div class="sidebar-inner">
<div class="widget-area the-icons">
<?php do_action('bp_before_right_sidebar'); ?>
<?php if ( is_active_sidebar( $dynamic_sidebar ) ) : ?>
<?php dynamic_sidebar( $dynamic_sidebar ); ?>
<?php else: ?>
<?php if($wpsidebar == 'true'): ?>
<?php get_template_part('lib/templates/default-widget'); ?>
<?php endif; ?>
<?php endif; ?>
<?php do_action('bp_after_right_sidebar'); ?>
</div>
</div><!-- SIDEBAR-INNER END -->
</div><!-- RIGHT SIDEBAR END -->

<?php do_action('bp_after_sidebars'); ?>