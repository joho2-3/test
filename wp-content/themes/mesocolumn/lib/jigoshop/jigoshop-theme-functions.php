<?php

// conditional to check if jigoshop related page showed
if( !function_exists('is_in_jigoshop_page')):
function is_in_jigoshop_page() {
return ( is_shop() || is_product_list() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account() ) ? true : false;
}
endif;

//wrap content for jigoshop products
function meso_open_jigoshop_content_wrappers() {
echo '<div id="jigo-wrapper"><div class="content" id="jigo-content">';
if( is_product() ){ echo '<div id="jigo-single-product">'; }
}
function meso_close_jigoshop_content_wrappers() {
if( is_product() ){ echo '</div>'; }
echo '</div></div>';
}
function meso_prepare_jigoshop_wrappers() {
remove_action( 'jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10 );
remove_action( 'jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10);
add_action( 'jigoshop_before_main_content', 'meso_open_jigoshop_content_wrappers', 10 );
add_action( 'jigoshop_after_main_content', 'meso_close_jigoshop_content_wrappers', 10 );
}
add_action( 'wp_head', 'meso_prepare_jigoshop_wrappers' );


// customization start here

function meso_jigo_add_post_right_div_start() {
global $post, $_product;
 $postright = '';
 $postright .= '<div class="post-product-right">';
 $postright .= '<h1 class="product-post post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
 echo $postright;
}

function meso_jigo_add_post_right_div_content() {
global $post, $_product;
$the_postexcerpt = dez_get_custom_the_excerpt(40);
 $postright = '';
 $postright .= '<div class="post-content">';
 if ($post->post_excerpt) {
 $postright .= do_shortcode(wpautop( wptexturize($post->post_excerpt)) );
 } else {
 if( strlen($the_postexcerpt) > 5 ):
 $postright .= wpautop( wptexturize( dez_get_custom_the_excerpt(40) ) );
 endif;
 }
 $postright .= '</div>';
 echo $postright;
}


function meso_jigo_add_post_right_div_end() {
 echo '</div>';
}

function meso_jigo_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
global $post, $_product;
$small_thumbnail_size = jigoshop_get_image_size( 'shop_thumbnail' );
$large_thumbnail_size = jigoshop_get_image_size( 'shop_large' );

$output = '<div class="product-thumb">';
if ( has_post_thumbnail() ) {
$output .= get_the_post_thumbnail( $post->ID, 'shop_catalog' );
} else {
$output .= '';
}
$output .= '</div>';
return $output;
}

function meso_jigo_template_loop_product_thumbnail() {
echo meso_jigo_get_product_thumbnail();
}

function meso_jigo_default_style() {
print "<style type='text/css' media='all'>"; ?>
.jigoshop_price_filter form {clear:both;}
.price_slider {margin:1em 0 2em 0;float:left;width:100%;}
.price_slider_amount .button {margin:-2px 10px 0 0;}
.widget.jigoshop_cart .total {border-top: 3px double #ddd;padding: 4px 0 4px;margin: 0!important;clear:both;}
#tab-reviews ol.commentlist li {background: transparent !important;}
.products li {margin: 0 30px 30px 0;}
div.product div.images {width: auto;}
div.product div.summary {float: left;width: 300px;margin:0 0 0 20px;}
a.checkout-button {color:#fff !important;text-decoration:none !important;}
.cart-collaterals .cart_totals h2 {font-size:15px;text-align: left;margin: 0 0 10px 10px;}
a.shipping-calculator-button {font-size:15px;}
#jigo-content h1.page-title {font-size:18px;margin:0 0 1em;}
#custom .product-with-desc ul.products li .post-product-right span.price, .js_widget_product_price,#jigo-single-product p.price {background: transparent none !important;}
<?php print "</style>";
}
add_action('wp_head','meso_jigo_default_style');


function meso_jigoshop_run_custom_shop_check() {
// add hooks if custom shop enabled
if( get_theme_mod('custom_shop') == 'enable' ) {
remove_action( 'jigoshop_after_shop_loop_item_title' , 'jigoshop_template_loop_price', 10);
remove_action( 'jigoshop_after_shop_loop_item', 'jigoshop_template_loop_add_to_cart', 10);
add_action('jigoshop_after_shop_loop_item','meso_jigo_add_post_right_div_start',10,2);
add_action('jigoshop_after_shop_loop_item','jigoshop_template_loop_price',11,2);
add_action('jigoshop_after_shop_loop_item','meso_jigo_add_post_right_div_content',12,2);
add_action('jigoshop_after_shop_loop_item','jigoshop_template_loop_add_to_cart', 13,2);
add_action('jigoshop_after_shop_loop_item','meso_jigo_add_post_right_div_end',99,2);
remove_action( 'jigoshop_before_shop_loop_item_title', 'jigoshop_template_loop_product_thumbnail', 10);
add_action( 'jigoshop_before_shop_loop_item_title', 'meso_jigo_template_loop_product_thumbnail', 10);
}
}
add_action('wp_head','meso_jigoshop_run_custom_shop_check');


function meso_jigoshop_run_style_check() {
// add hooks if custom shop enabled
if( get_theme_mod('custom_shop') == 'enable' ) {
remove_action( 'wp_head', 'meso_jigo_default_style', 10);
}
}
add_action('init','meso_jigoshop_run_style_check');



///////////////////////////////////////////////////////////////////////////////
// Load Theme Styles and Javascripts
///////////////////////////////////////////////////////////////////////////////
/*---------------------------load styles--------------------------------------*/
function meso_theme_load_jigo_styles() {
global $theme_version;
if ( get_theme_mod('custom_shop') == 'enable' ) {
wp_enqueue_style( 'custom-jigoshop-css', get_template_directory_uri() . '/lib/jigoshop/jigoshop-theme-css.css', array(), $theme_version );
}
}
add_action( 'wp_enqueue_scripts', 'meso_theme_load_jigo_styles' );


///////////////////////////////////////////////////////////////////////////////
// Load Woocommerce Widgets
///////////////////////////////////////////////////////////////////////////////
function meso_jigo_theme_widgets_init() {
     register_sidebar(array(
    'name'=>__('Shop Sidebar', 'mesocolumn'),
    'id' => 'shop-sidebar',
	'description' => __( 'Widget area for Jigo Shop Pages', 'mesocolumn' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'meso_jigo_theme_widgets_init', 20 );

?>