<?php $get_ads_right_sidebar = get_theme_mod('ads_right_sidebar'); if($get_ads_right_sidebar) { ?>
<aside id="ctr-ad" class="widget">
<div class="textwidget"><?php echo stripcslashes(do_shortcode($get_ads_right_sidebar)); ?></div>
</aside>
<?php } ?>

<?php if ( is_active_sidebar( 'tabbed-sidebar' ) ) : ?>
<div id="tabber-widget"><div class="tabber">
<?php dynamic_sidebar( 'tabbed-sidebar' ); ?>
</div></div>
<?php endif; ?>

<aside class="widget">
<h3 class="widget-title"><?php _e('Search','mesocolumn'); ?></h3>
<?php get_search_form(); ?>
</aside>
<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Recent Posts', 'mesocolumn'); ?></h3>
<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
</aside>
<aside class="widget widget">
<h3 class="widget-title"><?php _e('Pages', 'mesocolumn'); ?></h3>
<ul><?php wp_list_pages('title_li='); ?></ul>
</aside>
<aside class="widget">
<h3 class="widget-title"><?php _e('Tags','mesocolumn'); ?></h3>
<div class="tagcloud"><ul><?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?></ul></div>
</aside>