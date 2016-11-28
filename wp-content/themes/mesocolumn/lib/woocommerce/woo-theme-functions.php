<?php

///////////////////////////////////////////////////////////////////////////////
// woocommerce - conditional to check if woocommerce related page showed
///////////////////////////////////////////////////////////////////////////////
if( !function_exists('is_in_woocommerce_page')):
function is_in_woocommerce_page() {
return ( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) ? true : false;
}
endif;


///////////////////////////////////////////////////////////////////////////////
// woocommerce - add before and after container class
///////////////////////////////////////////////////////////////////////////////
if (!function_exists('woocommerce_theme_before_content')) {
function woocommerce_theme_before_content() { ?>
<!-- #content Starts -->
<div id="content">
<!-- .woo-content Starts -->
<div id="woo-container" class="woo-content">
<?php
}
}

if (!function_exists('woocommerce_theme_after_content')) {
function woocommerce_theme_after_content() { ?>
</div><!-- end .woo-content -->
</div><!-- end #content -->
<?php
}
}


///////////////////////////////////////////////////////////////////////////////
// woocommerce - show ads using theme options ads settings
///////////////////////////////////////////////////////////////////////////////
function woocommerce_show_custom_ads_top() {}
function woocommerce_show_custom_ads_bottom() {}
add_action( 'woocommerce_before_shop_loop', 'woocommerce_show_custom_ads_top', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_show_custom_ads_bottom', 20 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_show_custom_ads_bottom', 5 );



///////////////////////////////////////////////////////////////////////////////
// woocommerce - paging and search fucntion tweak
///////////////////////////////////////////////////////////////////////////////
function woocommerceframework_add_search_fragment ( $settings ) {
$settings['add_fragment'] = '&post_type=product';
return $settings;
}
function woocommerceframework_woo_pagination_defaults ( $settings ) {
$settings['use_search_permastruct'] = false;
return $settings;
}

///////////////////////////////////////////////////////////////////////////////
// woocommerce - add sharing box
///////////////////////////////////////////////////////////////////////////////
function dez_woo_sharebox() {}
add_action('woocommerce_share', 'dez_woo_sharebox', 20 );

///////////////////////////////////////////////////////////////////////////////
// woocommerce - allow shortcode in excerpt
///////////////////////////////////////////////////////////////////////////////
if (!function_exists('woocommerce_my_custom_excerpt')) {
function woocommerce_my_custom_excerpt( $post ) {
global $post;
echo '<div class="post-content woo-post-content">';
if ($post->post_excerpt) {
echo do_shortcode(wpautop(wptexturize($post->post_excerpt)));
} else {
echo wpautop( wptexturize( dez_get_custom_the_excerpt(30) ) );
}
echo '</div>';
}
}

///////////////////////////////////////////////////////////////////////////////
// woocommerce - allow thumbnail wrapper
///////////////////////////////////////////////////////////////////////////////

/**
 * WooCommerce Loop Product Thumbs
 **/

if ( !function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
function woocommerce_template_loop_product_thumbnail() {
echo woocommerce_get_product_thumbnail();
}
}

/**
 * WooCommerce Product Thumbnail
 **/
if ( !function_exists( 'woocommerce_get_product_thumbnail' ) ) {
function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
global $post, $woocommerce;

if ( ! $placeholder_width )
if ( function_exists('wc_get_image_size') ) {
$placeholder_width = wc_get_image_size( 'shop_catalog_image_width' );
} else {
$placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
}

if ( ! $placeholder_height )
if ( function_exists('wc_get_image_size') ) {
$placeholder_height = wc_get_image_size( 'shop_catalog_image_height' );
} else {
$placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
}

$output = '<div class="product-thumb">';
if ( has_post_thumbnail() ) {
$output .= get_the_post_thumbnail( $post->ID, $size );
} else {
$output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
}
$output .= '</div>';
return $output;
}
}


function add_post_right_div_start() {
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
if( $terms && count($terms) > 0 ) {
foreach ($terms as $term) { $product_cat_id = $term->term_id; break; } }
 echo '<div class="post-product-right product_'. $product_cat_id . '">';
 echo '<h1 class="product-post post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
 do_action('woocommerce_inside_product_right');
}
function add_post_right_div_end() {
 echo '</div>';
}

///////////////////////////////////////////////////////////////////////////////
// woocommerce - add head css
///////////////////////////////////////////////////////////////////////////////
function woo_wp_custom_css() {
if( function_exists('is_in_woocommerce_page') && is_in_woocommerce_page() ) { ?>
<?php print "<style type='text/css' media='all'>"; ?>
<?php if( is_cart() || is_checkout() ): ?>
div#woo-wrapper .content {width:95%;margin: 0;clear:both;}
div#woo-wrapper #post-entry article .post-content {float: none !important;padding:0;}
div#woo-wrapper article.page {border: 0 none !important;margin:0 !important;padding:0 !important;}
h3#order_review_heading { margin-top: 3em; }
.sidebar, footer.footer-top { display: none !important; }
<?php endif; ?>
#woo-container h2 {font-size:1.25em;margin: 1em 0; }
.woocommerce-page #content {float: left;width: 69%;padding: 0 !important;background: transparent none;border: 0 none;margin: 1em 0 2em !important;box-shadow: 0 0 0 0 transparent;-moz-box-shadow: 0 0 0 0 transparent;-webkit-box-shadow: 0 0 0 0 transparent;}
#custom .shop-sidebar {padding:3em 0 0;}
<?php if( get_theme_mod('custom_shop') == 'enable' ) {
} else { ?>
.woocommerce .related ul.products li.product, .woocommerce-page .related ul.products li.product, .woocommerce .upsells.products ul.products li.product, .woocommerce-page .upsells.products ul.products li.product, .woocommerce .related ul li.product, .woocommerce-page .related ul li.product, .woocommerce .upsells.products ul li.product, .woocommerce-page .upsells.products ul li.product { clear:none;width:20%;height:350px;float:left;margin:0 20px 20px 0; }
#woo-container span.price,#woo-container p.price,#custom ul.product_list_widget li span.amount {background-color:transparent;color:#333;}
#woo-container span.price,#woo-container p.price {font-size:1.2em;}
.woocommerce ul.products li.product h3,.woocommerce div.product .product_title {font-size: 1.3em;line-height:110%;}
<?php } ?>
<?php print "</style>"; ?>
<?php }
print "<style type='text/css' media='all'>"; ?>
#custom .post-content ul.products li.product a, #custom .post-content ul.products li.product a {text-decoration: none !important;}
a.buybutton {padding: 7px 20px;background: #e8e8e8;color: #666;border: 1px solid #ccc;float: left;font-weight: bold;text-shadow: 0 0 1px #fff;margin: 8px;}
a.buybutton.oncart {background: #FFFFFF;color: #5BB850;border: 1px solid #63DB9B;}
<?php print "</style>";
}
add_action('wp_head', 'woo_wp_custom_css', 20);

//remove default open and close wrapper for woocommerce
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
//add new open and close wrapper for woocommerce
add_action('woocommerce_before_main_content', 'woocommerce_theme_before_content', 10);
add_action('woocommerce_after_main_content', 'woocommerce_theme_after_content', 20);


function woocommerce_run_custom_shop_check() {
// add hooks if custom shop enabled
if( get_theme_mod('custom_shop') == 'enable' ) {
remove_action('wp_head', 'woo_wp_custom_css', 10);
// Remove add to cart button on archives
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
// Remove sale flash on archives
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
// remove and moved star rating near title
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action('woocommerce_inside_product_right', 'woocommerce_template_loop_rating',1);
add_action('woocommerce_inside_product_right', 'woocommerce_my_custom_excerpt');
// remove and moved product thumbnail position
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
// remove and moved product price position
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action( 'woocommerce_inside_product_right', 'woocommerce_template_loop_price', 10);
// add the post right for custom shop
add_action('woocommerce_after_shop_loop_item','add_post_right_div_start',0);
add_action('woocommerce_after_shop_loop_item','add_post_right_div_end',99);
}
}

add_action('wp_head','woocommerce_run_custom_shop_check');



///////////////////////////////////////////////////////////////////////////////
// Load Theme Styles and Javascripts
///////////////////////////////////////////////////////////////////////////////
/*---------------------------load styles--------------------------------------*/
function meso_theme_load_woo_styles() {
global $theme_version;
if ( get_theme_mod('custom_shop') == 'enable' ) {
wp_enqueue_style( 'custom-woo-css', get_template_directory_uri() . '/lib/woocommerce/woo-theme-css.css', array(), $theme_version );
}
}
add_action( 'wp_enqueue_scripts', 'meso_theme_load_woo_styles' );


///////////////////////////////////////////////////////////////////////////////
// Load Woocommerce Widgets
///////////////////////////////////////////////////////////////////////////////
function meso_woo_theme_widgets_init() {
     register_sidebar(array(
    'name'=>__('Shop Sidebar', 'mesocolumn'),
    'id' => 'shop-sidebar',
	'description' => __( 'Widget area for WooCommerce Shop Pages', 'mesocolumn' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'meso_woo_theme_widgets_init', 20 );
?>