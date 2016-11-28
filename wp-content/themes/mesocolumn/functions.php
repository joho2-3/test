<?php
////////////////////////////////////////////////////////////////////////////////
// Global Define
////////////////////////////////////////////////////////////////////////////////
// do not change this, its for translation and options string
define('TEMPLATE_DOMAIN', 'mesocolumn');
// added option name
if( !defined('MESO_OPTION') ) { define('MESO_OPTION', 'meso'); }
if( !defined('SUPER_STYLE') ) { define('SUPER_STYLE', 'yes'); }
////////////////////////////////////////////////////////////////////////////////
// Additional Theme Support
////////////////////////////////////////////////////////////////////////////////

function mesocolumn_init_setup() {
if ( !isset( $content_width ) ) { $content_width = 550; }
////////////////////////////////////////////////////////////////////////////////
// Add Language Support
////////////////////////////////////////////////////////////////////////////////
load_theme_textdomain( 'mesocolumn', get_template_directory() . '/languages' );
add_theme_support( 'post-thumbnails' );
if( class_exists('woocommerce') ) { add_theme_support( 'woocommerce' ); }
add_theme_support('title-tag');
add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );
add_image_size( 'featured-slider-img', 640, 480, true );
add_image_size( 'featured-post-img', 480, 320, true );
// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );
add_editor_style();
add_theme_support( 'menus' );

register_nav_menus( array(
'top' => __( 'Top Menu', 'mesocolumn' ),
'primary' => __( 'Primary Menu', 'mesocolumn' ),
'footer' => __( 'Footer Menu', 'mesocolumn' ),
'mobile' => __( 'Mobile Menu', 'mesocolumn' ),
));

$custom_background_support = array(
	'default-color'          => '',
	'default-image'          => '',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $custom_background_support );

// Add support for custom headers.
$custom_header_support = array(
// The default header text color.
		'default-text-color' => '',
        'default-image' => '',
        'header-text'  => true,
		// The height and width of our custom header.
		'width' => 1440,
		'height' => 300,
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
	   'random-default'	=> false,
		// Callback for styling the header.
		'wp-head-callback' => '',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => '',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $custom_header_support );
}
add_action( 'after_setup_theme', 'mesocolumn_init_setup' );

// add default callback for wp_pages
function mesocolumn_revert_wp_menu_page($args) {
global $bp, $bp_active;
$pages_args = array('depth' => 0,'echo' => false,'exclude' => '','title_li' => '');
$menu = wp_page_menu( $pages_args );
$menu = str_replace( array( '<div class="menu"><ul>', '</ul></div>' ), array( '<ul class="sf-menu">', '</ul>' ), $menu );
echo $menu;
if($bp_active=='true'):
do_action( 'bp_nav_items' );
endif; ?>
<?php }

// add default callback for wp_list_categories
function mesocolumn_revert_wp_menu_cat() {
global $bp;
$menu = wp_list_categories('orderby=name&show_count=0&title_li=');
return $menu;
 ?>
<?php }

// add home link in custom menus
function mesocolumn_dtheme_page_menu_args( $args ) {
$args['show_home'] = __('Home', 'mesocolumn');
return $args; }
add_filter( 'wp_page_menu_args', 'mesocolumn_dtheme_page_menu_args' );


///////////////////////////////////////////////////////////////////////////////
// Load Theme Styles and Javascripts
///////////////////////////////////////////////////////////////////////////////
/*---------------------------load google webfont style--------------------------------------*/
function mesocolumn_theme_load_gwf_styles() {
if( get_theme_mod('body_font') == 'Choose a font' || get_theme_mod('body_font') == '') {
wp_register_style('default_gwf', '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,300,300italic');
wp_enqueue_style( 'default_gwf');
}
}
add_action('wp_enqueue_scripts', 'mesocolumn_theme_load_gwf_styles');

/*---------------------------load styles--------------------------------------*/
function mesocolumn_theme_load_styles() {
global $theme_version,$is_IE,$bp_active;
$responsive_mode = get_theme_mod('responsive_mode');
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), $theme_version );

if ( $responsive_mode == 'enable' ) {
wp_enqueue_style( 'style-responsive', get_template_directory_uri() . '/responsive.css', array(), $theme_version );
}

if ( function_exists('is_rtl') && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
wp_enqueue_style( 'style-rtl', get_template_directory_uri() . '/rtl.css', array(), $theme_version );
}

wp_enqueue_style( 'superfish', get_template_directory_uri(). '/lib/scripts/superfish-menu/css/superfish.css', array(), $theme_version );

if ( is_active_sidebar( 'tabbed-sidebar' ) ) {
wp_enqueue_style( 'tabber', get_template_directory_uri() . '/lib/scripts/tabber/tabber.css', array(), $theme_version );
}

if ( ( is_home() || is_front_page() || is_page_template('page-templates/template-blog.php') ) && get_theme_mod('slider_on') == 'enable'  ) {
wp_enqueue_style( 'jd-gallery-css', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.css', array(), $theme_version );
}

/*load font awesome */
wp_enqueue_style( 'font-awesome-cdn', get_template_directory_uri(). '/lib/scripts/font-awesome/css/font-awesome.css', array(), $theme_version );

?>

<?php
}
add_action( 'wp_enqueue_scripts', 'mesocolumn_theme_load_styles' );


/*---------------------------load js scripts--------------------------------------*/
function mesocolumn_theme_load_scripts() {
global $wp_customize,$theme_version, $is_IE;
wp_enqueue_script("jquery");
wp_enqueue_script('hoverIntent');

if ( isset($wp_customize) && $wp_customize->is_preview() && !is_admin() ) {
wp_enqueue_script('theme-customizer-js', get_template_directory_uri() . '/lib/functions/theme-customizer/theme-customizer.js', false, $theme_version, true );
}

wp_enqueue_script('modernizr', get_template_directory_uri() . '/lib/scripts/modernizr/modernizr.js', false, $theme_version, true );

if($is_IE) {
wp_enqueue_script('html5shim', get_template_directory_uri() . '/lib/scripts/html5shiv.js', false,$theme_version, false );
}

if ( is_active_sidebar( 'tabbed-sidebar' ) ) {
wp_enqueue_script( 'tabber', get_template_directory_uri() . '/lib/scripts/tabber/tabber.js', false, $theme_version, true );
}

wp_enqueue_script('superfish-js', get_template_directory_uri() . '/lib/scripts/superfish-menu/js/superfish.js', false, $theme_version, true );
wp_enqueue_script('supersub-js', get_template_directory_uri() . '/lib/scripts/superfish-menu/js/supersubs.js', false, $theme_version, true );

if ( ( is_home() || is_front_page() || is_page_template('page-templates/template-blog.php') ) && get_theme_mod('slider_on') == 'enable' ) {
wp_enqueue_script('mootools-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/mootools.v1.11.js', false, $theme_version, true );
wp_enqueue_script('jd-gallery2-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.v2.js', false, $theme_version, true );
wp_enqueue_script('jd-gallery-set-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.set.js', false, $theme_version, true );
wp_enqueue_script('jd-gallery-transitions-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.transitions.js', false, $theme_version, true );
}
wp_enqueue_script('custom-js', get_template_directory_uri() . '/lib/scripts/custom.js', false,$theme_version, true );
if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php }
add_action( 'wp_enqueue_scripts', 'mesocolumn_theme_load_scripts' );

////////////////////////////////////////////////////////////////////////////////
// Add Theme Functions for parent and child theme compability
////////////////////////////////////////////////////////////////////////////////
/* check parent and child theme for theme-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/theme-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/functions/theme-functions.php' );
} else {
include( get_template_directory() . '/lib/functions/theme-functions.php' );
}

/* including customizer functions */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/customizer-functions.php' ) ) {
include_once( get_stylesheet_directory() . '/lib/functions/customizer-functions.php');
} else {
if ( file_exists( get_template_directory() . '/lib/functions/customizer-functions.php' ) ) {
include_once( get_template_directory() . '/lib/functions/customizer-functions.php');
}
}

/* including color functions */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/color-functions.php' ) ) {
include_once( get_stylesheet_directory() . '/lib/functions/color-functions.php');
} else {
if ( file_exists( get_template_directory() . '/lib/functions/color-functions.php' ) ) {
include_once( get_template_directory() . '/lib/functions/color-functions.php');
}
}

/* load sanitization-callbacks.php */
if ( file_exists( get_template_directory() . '/lib/functions/theme-customizer/sanitization-callbacks.php' ) ) {
include( get_template_directory() . '/lib/functions/theme-customizer/sanitization-callbacks.php' );
}


/* check parent and child theme for widget-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/widget-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/functions/widget-functions.php' );
} else {
include( get_template_directory() . '/lib/functions/widget-functions.php' );
}

/* check parent and child theme for bp-widgets-functions.php */
if( class_exists('buddypress') ) {
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/buddypress/bp-theme-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/buddypress/bp-theme-functions.php' );
} else {
if( file_exists( get_template_directory() . '/lib/buddypress/bp-theme-functions.php' ) ) {
include( get_template_directory() . '/lib/buddypress/bp-theme-functions.php' );
}
}
}

/* check parent and child theme for bb-theme-functions.php */
if ( class_exists('bbPress') ) {
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/bbpress/bb-theme-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/bbpress/bb-theme-functions.php' );
} else {
if( file_exists( get_template_directory() . '/lib/bbpress/bb-theme-functions.php' ) ) {
include( get_template_directory() . '/lib/bbpress/bb-theme-functions.php' );
}
}
}


/* check parent and child theme for woo-theme-functions.php */
if ( class_exists('woocommerce') ) {
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/woocommerce/woo-theme-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/woocommerce/woo-theme-functions.php' );
} else {
if ( file_exists( get_template_directory() . '/lib/woocommerce/woo-theme-functions.php' ) ) {
include( get_template_directory() . '/lib/woocommerce/woo-theme-functions.php' );
}
}
}


/* check parent and child theme for jigoshop-theme-functions.php */
if ( class_exists('jigoshop') ) {
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' );
} else {
if ( file_exists( get_template_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' ) ) {
include( get_template_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' );
}
}
}


/* check parent and child theme for hooks-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/hooks-functions.php' ) ) {
include( get_stylesheet_directory() . '/lib/functions/hooks-functions.php' );
} else {
if ( file_exists( get_template_directory() . '/lib/functions/hooks-functions.php' ) ) {
include( get_template_directory() . '/lib/functions/hooks-functions.php' );
}
}


/* including fonts functions */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/fonts-functions.php' ) ) {
include_once( get_stylesheet_directory() . '/lib/functions/fonts-functions.php');
} else {
if ( file_exists( get_template_directory() . '/lib/functions/fonts-functions.php' ) ) {
include_once( get_template_directory() . '/lib/functions/fonts-functions.php');
}
}


/* including option css functions */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/options-functions.php' ) ) {
include_once( get_stylesheet_directory() . '/lib/functions/options-functions.php');
} else {
if ( file_exists( get_template_directory() . '/lib/functions/options-functions.php' ) ) {
include_once( get_template_directory() . '/lib/functions/options-functions.php');
}
}


/* check if custom function file is active */
if( file_exists( WP_CONTENT_DIR . '/meso-custom-functions.php' ) ) {
include_once( WP_CONTENT_DIR . '/meso-custom-functions.php' );
}

function jisakukansuu(){
	$post = array(
    'post_author' => 'test',
    'post_content' => '',
    'post_status' => "publish",
    'post_title' => 'testest',
    'post_parent' => '',
    'post_type' => "product",
);

//Create post
$post_id = wp_insert_post( $post, $wp_error );
if($post_id){
    $attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
    add_post_meta($post_id, '_thumbnail_id', $attach_id);
}

wp_set_object_terms( $post_id, 'Races', 'product_cat' );
wp_set_object_terms($post_id, 'simple', 'product_type');

update_post_meta( $post_id, '_visibility', 'visible' );
update_post_meta( $post_id, '_stock_status', 'instock');
update_post_meta( $post_id, 'total_sales', '0');
update_post_meta( $post_id, '_downloadable', 'yes');
update_post_meta( $post_id, '_virtual', 'yes');
update_post_meta( $post_id, '_regular_price', "1" );
update_post_meta( $post_id, '_sale_price', "1" );
update_post_meta( $post_id, '_purchase_note', "" );
update_post_meta( $post_id, '_featured', "no" );
update_post_meta( $post_id, '_weight', "" );
update_post_meta( $post_id, '_length', "" );
update_post_meta( $post_id, '_width', "" );
update_post_meta( $post_id, '_height', "" );
update_post_meta($post_id, '_sku', "");
update_post_meta( $post_id, '_product_attributes', array());
update_post_meta( $post_id, '_sale_price_dates_from', "" );
update_post_meta( $post_id, '_sale_price_dates_to', "" );
update_post_meta( $post_id, '_price', "1" );
update_post_meta( $post_id, '_sold_individually', "" );
update_post_meta( $post_id, '_manage_stock', "no" );
update_post_meta( $post_id, '_backorders', "no" );
update_post_meta( $post_id, '_stock', "" );

// // file paths will be stored in an array keyed off md5(file path)
// $downdloadArray =array('name'=>"Test", 'file' => $uploadDIR['baseurl']."/video/".$video);

// $file_path =md5($uploadDIR['baseurl']."/video/".$video);


// $_file_paths[  $file_path  ] = $downdloadArray;
// // grant permission to any newly added files on any existing orders for this product
// // do_action( 'woocommerce_process_product_file_download_paths', $post_id, 0, $downdloadArray );
// update_post_meta( $post_id, '_downloadable_files', $_file_paths);
// update_post_meta( $post_id, '_download_limit', '');
// update_post_meta( $post_id, '_download_expiry', '');
// update_post_meta( $post_id, '_download_type', '');
// update_post_meta( $post_id, '_product_image_gallery', '');
}
add_shortcode('jisaku', 'jisakukansuu');
?>