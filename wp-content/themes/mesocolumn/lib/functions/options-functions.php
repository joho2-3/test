<?php
/*--------------------------------------------
Description: add container style in options-css.php
---------------------------------------------*/
function meso_add_container_style() {
$bg_image = get_background_image();
$bg_color = get_background_color();
$header_image = get_header_image();
if( $bg_image || $bg_color) { ?>
.container-wrap, footer .ftop {float: left;margin: 0;padding: 2% 2% 0 2%;width: 96%;background-color:white;}
#header {background:white;}footer.footer-bottom {background:transparent none !important;}.fbottom {background-color: #52C0D4;color:#fff !important;width: 96%;margin: 0;padding: 0.6em 2% !important;}#siteinfo {margin:0 0 0 1.6em;}@media only screen and (min-width:300px) and (max-width:770px){.container-wrap, #custom footer .ftop {float: left;margin: 0;padding: 2% !important;width: 96% !important;background-color:white;}#custom-img-header {margin:0 0 2em;}}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_container_style');


/*--------------------------------------------
Description: add body font style
---------------------------------------------*/
function meso_add_body_font_style() {
$bodyfont = get_theme_mod('body_font');
$bodyfontweight = get_theme_mod('body_font_weight');
if( $bodyfont == 'Choose a font' || $bodyfont == '') { ?>
body {font-family: 'Open Sans', sans-serif;font-weight: 400;}
<?php } else { ?>
body {font-family:<?php echo $bodyfont; ?>;font-weight:<?php echo $bodyfontweight; ?>;}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_body_font_style');


/*--------------------------------------------
Description: add headline font style
---------------------------------------------*/
function meso_add_headline_font_style() {
$headlinefont = get_theme_mod('headline_font');
$headlinefontweight = get_theme_mod('headline_font_weight');
if( $headlinefont == 'Choose a font' || $headlinefont == '') { ?>
#siteinfo div,h1,h2,h3,h4,h5,h6,.header-title,#main-navigation, #featured #featured-title, #cf .tinput, #wp-calendar caption,.flex-caption h1,#portfolio-filter li,.nivo-caption a.read-more,.form-submit #submit,.fbottom,ol.commentlist li div.comment-post-meta, .home-post span.post-category a,ul.tabbernav li a {font-family: 'Open Sans', sans-serif;font-weight:600;}
<?php } else { ?>
#siteinfo div,h1,h2,h3,h4,h5,h6,.header-title,#main-navigation, #featured #featured-title, #cf .tinput, #wp-calendar caption,.flex-caption h1,#portfolio-filter li,.nivo-caption a.read-more,.form-submit #submit,.fbottom,ol.commentlist li div.comment-post-meta, .home-post span.post-category a,ul.tabbernav li a {font-family:  <?php echo $headlinefont; ?>; font-weight: <?php echo $headlinefontweight; ?>; }
<?php
}
}
add_action('wpmeso_custom_css','meso_add_headline_font_style');

/*--------------------------------------------
Description: add navigation font style
---------------------------------------------*/
function meso_add_navigation_font_style() {
$navfont = get_theme_mod('navigation_font');
$navfontweight = get_theme_mod('navigation_font_weight');
if( $navfont == 'Choose a font' || $navfont == '') { ?>
#main-navigation, .sf-menu li a {font-family: 'Open Sans', sans-serif;font-weight: 600;}
<?php } else { ?>
#main-navigation, .sf-menu li a {font-family: <?php echo $navfont; ?>; font-weight:<?php echo $navfontweight; ?>; }
<?php
}
}
add_action('wpmeso_custom_css','meso_add_navigation_font_style');


/*--------------------------------------------
Description: add slider height option
---------------------------------------------*/
function meso_add_slider_height_style() {
$sliderheight = get_theme_mod('slider_height');
if( $sliderheight ) { ?>
#Gallerybox,#myGallery,#myGallerySet,#flickrGallery {height:<?php echo $sliderheight; ?>px;}
<?php }
}
add_action('wpmeso_custom_css','meso_add_slider_height_style');

/*--------------------------------------------
Description: add top nav color option
---------------------------------------------*/
function meso_add_topnav_style() {
$topnav_color = get_theme_mod('topnav_color');
if( $topnav_color ) {
$topnav = '';
$topnav .= '#top-navigation {background-color: '. $topnav_color . ';}#top-navigation .sf-menu li a:hover,#top-navigation .sf-menu li:hover,#top-navigation .sf-menu ul {background-color: '. dehex($topnav_color, -10) . ';}#top-navigation .sf-menu ul li a:hover {background-color: '. dehex($topnav_color, -20) . ';background-image: none;}#mobile-nav .mobile-open a {background: ' . $topnav_color . ' none;}#mobile-nav ul li a {background: ' . dehex($topnav_color, -10) . ' none;}#mobile-nav ul li a:hover {background:' . dehex($topnav_color, -20) . ' none;}';
echo $topnav;
}
}
add_action('wpmeso_custom_css','meso_add_topnav_style');


/*--------------------------------------------
Description: add main color scheme option
---------------------------------------------*/
function meso_add_main_color_style() {
$main_color = get_theme_mod('main_color');
if($main_color) { ?>
#custom #right-sidebar ul.tabbernav { background: <?php echo $main_color; ?> !important; }
h2.header-title { background: <?php echo $main_color; ?>; }
#right-sidebar ul.tabbernav li.tabberactive a,#right-sidebar ul.tabbernav li.tabberactive a:hover { color:#fff !important; background-color: <?php echo dehex($main_color, -20); ?> !important; }
#right-sidebar ul.tabbernav li a:hover, #custom h2.inblog {color: #FFF !important;background-color: <?php echo dehex($main_color, -10); ?> !important;}
#breadcrumbs a {color:<?php echo $main_color; ?>;}
#breadcrumbs a:hover {color:<?php echo dehex($main_color,-20); ?>;}
#content .item-title a,h2.post-title a, h1.post-title a, article.post .post-meta a:hover, #custom .product-with-desc ul.products li h1.post-title a:hover, #custom .twitterbox span a, #custom h3.widget-title a, #custom .ftop div.textwidget a, #custom .ftop a:hover, #custom .ftop .widget_my_theme_twitter_widget a, #content .activity-header a, #content .activity-inner a, #content .item-list-tabs a {
color: <?php echo $main_color; ?> !important;}
#custom #post-entry h1.post-title a:hover,#custom #post-entry h2.post-title a:hover {color: #222;}
#woo-container p.price,.wp-pagenavi a, #woo-container span.price, #custom ul.product_list_widget li span.amount,span.pricebox, #custom .product-with-desc ul.products li .post-product-right span.price, .js_widget_product_price,#jigo-single-product p.price   {background-color: <?php echo dehex($main_color, 18); ?>; color:#fff;}
.wp-pagenavi .current, .wp-pagenavi a:hover{background: none repeat scroll 0 0 <?php echo dehex($main_color, -10); ?>;}
#post-navigator .wp-pagenavi a,#post-navigator .wp-pagenavi a:hover {background: none repeat scroll 0 0 <?php echo dehex($main_color, -30); ?>;}
#post-navigator .wp-pagenavi .current {background: none repeat scroll 0 0 <?php echo dehex($main_color, -50); ?>;}
#content a.activity-time-since {color: #888 !important;}
#content .item-list-tabs span  {background-color: <?php echo dehex($main_color, 10); ?> !important;}
#custom .widget a:hover, #custom h3.widget-title a:hover, #custom .ftop div.textwidget a:hover, #custom .ftop a:hover, #custom .ftop .widget_my_theme_twitter_widget a:hover {color: <?php echo dehex($main_color, -20); ?> !important;}
#custom h3.widget-title {border-bottom: 5px solid <?php echo $main_color; ?>;}
#right-sidebar .search-form .search-submit,#searchform input[type="submit"], #searchform input[type="button"],#custom .bp-searchform #search-submit {background-color: <?php echo $main_color; ?>;border:1px solid <?php echo $main_color; ?>;}
#post-entry .post-content a, #author-bio a, #post-related a, #commentpost .fn a, ol.pinglist a, #post-navigator-single a,#commentpost #rssfeed a, #commentpost .comment_text a, #commentpost p a, .product_meta a, a.show_review_form, #custom .twitterbox li a  {color: <?php echo $main_color; ?>;}
.pagination-links a.page-numbers, #custom #woo-container nav.woocommerce-pagination a.page-numbers {background-color: <?php echo $main_color; ?>;color:#fff !important;}
.pagination-links .page-numbers, #custom #woo-container nav.woocommerce-pagination span.page-numbers.current {background-color: <?php echo dehex($main_color, -20); ?>;color:#fff !important;}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_main_color_style');


/*--------------------------------------------
Description: add footer bottom color option
---------------------------------------------*/
function meso_add_footer_bottom_style() {
$footer_bottom_color = get_theme_mod('footer_bottom_color');
if($footer_bottom_color) { ?>
#custom footer.footer-bottom, #custom footer.footer-bottom .fbottom {background-color:<?php echo $footer_bottom_color; ?>;color:#fff !important;}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_footer_bottom_style');


/*----------------------------------------------------
Description: add homepage featured category rss option
----------------------------------------------------*/
function meso_add_home_feat_rss_style() {
$rss_feed_on = get_theme_mod('rss_feed_on');
if( $rss_feed_on == 'disable' ) { echo 'img.home-feat-rss {display:none;}'; }
}
add_action('wpmeso_custom_css','meso_add_home_feat_rss_style');

/*----------------------------------------------------
Description: add homepage featured category rss option
----------------------------------------------------*/
function meso_add_blogpost_style() {
$blogpost_style = get_theme_mod('blogpost_style');
$post_custom_excerpt = get_theme_mod('post_custom_excerpt');
if($blogpost_style == 'magazine') { ?>
@media only screen and (min-width:768px) {
#post-entry article.post-style-magazine {width:48%;float:left;height:<?php echo $post_custom_excerpt + 450; ?>px;}
#post-entry article.feat-thumbnail.post-style-magazine {height:<?php echo ($post_custom_excerpt * 5) + 200 ; ?>px;}
#post-entry article.post-style-magazine.alt-post {margin-right:4%;}
#post-entry article.post-style-magazine .post-right {margin:0;}
#post-entry article.post-style-magazine .post-right h2,
#post-entry article.post-style-magazine .post-right .post-meta,
#post-entry article.post-style-magazine .post-right .post-content {float:none;width:auto;}
#post-entry article.post-style-magazine.feat-thumbnail div.post-thumb {margin: 0 15px 8px 0;}
#post-entry article.post-style-magazine:last-of-type {border-bottom:1px solid #ddd;}
#post-entry article.post-style-magazine.feat-medium div.post-thumb,#post-entry article.post-style-magazine.feat-large div.post-thumb {width:100%;max-height:200px;float:left;margin:0 0 12px;}
#post-entry article.post-style-magazine.feat-medium div.post-thumb img,#post-entry article.post-style-magazine.feat-large div.post-thumb img {width:100%;height:auto;}
}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_blogpost_style');


/*----------------------------------------------------
Description: add theme header text style
----------------------------------------------------*/
function meso_add_header_textcolor() {
$header_textcolor = get_theme_mod('header_textcolor');
if( $header_textcolor == 'blank') { ?>
#custom #siteinfo h1,#custom #siteinfo div, #custom #siteinfo p {display:none;}
<?php } else { ?>
#custom #siteinfo a {color: #<?php echo $header_textcolor; ?> !important;text-decoration: none;}
#custom #siteinfo p#site-description {color: #<?php echo $header_textcolor; ?> !important;text-decoration: none;}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_header_textcolor');


/*----------------------------------------------------
Description: add theme header overlay
----------------------------------------------------*/
function meso_add_header_overlay() {
$header_overlay = get_theme_mod('custom_header_overlay');
if( get_header_image() && $header_overlay == 'yes' ) { ?>
#siteinfo {position:absolute;top:15%;left:2em;}
#topbanner {position:absolute;top:15%;right:2em;}
#custom #custom-img-header {margin:0;}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_header_overlay');

/*----------------------------------------------------
Description: add theme layout style
----------------------------------------------------*/
function meso_add_theme_layout_style() {
$feat_size = get_theme_mod('feat_img_size');
if($feat_size == ''){ $feat_size = 'thumbnail'; }
$thumb_w = get_option($feat_size.'_size_w');
$thumb_h = get_option($feat_size.'_size_h');
$get_feat_layout = get_theme_mod('feat_layout');
if($feat_size != 'large'){ ?>
#post-entry div.post-thumb.size-<?php echo $feat_size; ?> {float:left;width:<?php echo $thumb_w; ?>px;}
#post-entry article .post-right {margin:0 0 0 <?php echo $thumb_w + 20; ?>px;}
<?php } else { ?>
#post-entry div.post-thumb {margin:0 0 1em;width:100%;}
#post-entry article .post-right {width:100%;float:left;margin:0;}
<?php }
if( $get_feat_layout == 'all thumbnail' ) { ?>
#post-entry aside.home-feat-cat .fpost {padding:0;}
#post-entry aside.home-feat-cat .fpost .feat-right {margin: 0em 0em 0em 140px;}
#post-entry aside.home-feat-cat .fpost .feat-thumb {width: 125px;}
#post-entry aside.home-feat-cat .fpost .entry-content {font-size:1.1em;line-height: 1.5em !important;}
#post-entry aside.home-feat-cat .fpost .feat-title {font-size:1.35em;margin:0;}
#post-entry aside.home-feat-cat .fpost .feat_comment {display:none;}
<?php } elseif($get_feat_layout == 'all medium') { ?>
#post-entry aside.home-feat-cat .apost .feat-right {margin: 0;}
#post-entry aside.home-feat-cat .apost .feat-thumb {width: 100%;}
#post-entry aside.home-feat-cat .apost .entry-content {font-size:1.25em;}
#post-entry aside.home-feat-cat .apost .feat-title {font-size:1.65em;margin:12px 0 8px !important;}
#custom #post-entry aside.home-feat-cat .apost {padding:0 0 2em !important;margin:0 0 2em !important;}
@media only screen and (min-width:300px) and (max-width:770px){
#post-entry aside.home-feat-cat .apost .feat-thumb {height:auto;max-height:1000px;} }
<?php
}
}
add_action('wpmeso_custom_css','meso_add_theme_layout_style');

/*----------------------------------------------------
Description: add ie filter compatible
----------------------------------------------------*/
function meso_add_ie_compat() {
global $is_IE;
if($is_IE) { ?>
#main-navigation,.post-meta,a.button,input[type='button'], input[type='submit'],h1.post-title,.wp-pagenavi a,#sidebar .item-options,.iegradient,h3.widget-title,.footer-bottom,.sf-menu .current_page_item a, .sf-menu .current_menu_item a, .sf-menu .current-menu-item a,.sf-menu .current_page_item a:hover, .sf-menu .current_menu_item a:hover, .sf-menu .current-menu-item a:hover {filter: none !important;} #buddypress .activity-list .activity-avatar {float: none !important;}
<?php
}
}
add_action('wpmeso_custom_css','meso_add_ie_compat');

/*----------------------------------------------------
Description: add theme custom css
----------------------------------------------------*/
function meso_add_theme_custom_css() {
$customcss = get_theme_mod('custom_css');
if( $customcss ) { echo $customcss; }
}
add_action('wpmeso_custom_css','meso_add_theme_custom_css');


/*----------------------------------------------------
Description: let's finalize all it wp_head
----------------------------------------------------*/
function meso_init_theme_custom_style() {
print '<style type="text/css" media="all">' . "\n";
do_action( 'wpmeso_custom_css' );
print '</style>' . "\n";
}
add_action('wp_head','meso_init_theme_custom_style',99);

?>