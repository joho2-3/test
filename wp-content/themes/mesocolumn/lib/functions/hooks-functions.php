<?php
/*--------------------------------------------
Description: add top header ads
---------------------------------------------*/
function meso_add_topheader_ads() {
$header_banner = get_theme_mod('header_embed');
if($header_banner) {
echo '<div id="topbanner">' . stripcslashes(do_shortcode($header_banner)) . '</div>';
}
}
add_action('bp_inside_header','meso_add_topheader_ads');

/*--------------------------------------------
Description: add code before </head> code
---------------------------------------------*/
function meso_add_before_head_code() {
$header_code = get_theme_mod('header_code');
if( !empty($header_code) ) { echo stripcslashes(do_shortcode($header_code)); }
}
add_action('wp_head','meso_add_before_head_code',89);

/*--------------------------------------------
Description: add codebefore </body> code
---------------------------------------------*/
function meso_add_before_footer_code() {
$footer_code = get_theme_mod('footer_code');
if( !empty($footer_code) ) { echo stripcslashes(do_shortcode($footer_code)); }
}
add_action('wp_footer','meso_add_before_footer_code',99);


/*--------------------------------------------
Description: add theme header
---------------------------------------------*/
function meso_add_theme_header() {
$header_overlay = get_theme_mod('custom_header_overlay');
do_action( 'bp_before_header' );
?>
<!-- HEADER START -->
<header class="iegradient <?php echo strtolower($header_overlay).'_head'; ?>" id="header"<?php do_action('bp_section_header'); ?>>
<div class="header-inner">
<div class="innerwrap">
<div id="siteinfo">
<?php do_action( 'bp_before_site_title' ); ?>
<?php
$get_header_logo =  get_theme_mod('header_logo');
if( $get_header_logo  ) { ?>
<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $get_header_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a>
<span class="header-seo-span">
<<?php if( !is_singular() || is_page_template('page-templates/template-blog.php') ){ echo 'h1 '; } else { echo 'div '; } ?>><a href="<?php echo home_url( '/' ); ?>" title="<?php echo bloginfo('name'); ?>" rel="home"><?php bloginfo( 'name' ); ?></a><<?php if( !is_singular() || is_page_template('page-templates/template-blog.php') ){ echo '/h1 '; } else { echo '/div '; } ?>><p id="site-description"><?php echo bloginfo('description'); ?></p>
</span>
<?php } else { ?>
<<?php if( !is_singular() || is_page_template('page-templates/template-blog.php') ){ echo 'h1 '; } else { echo 'div '; } ?>><a href="<?php echo home_url( '/' ); ?>" title="<?php echo bloginfo('name'); ?>" rel="home"><?php bloginfo( 'name' ); ?></a><<?php if( !is_singular() || is_page_template('page-templates/template-blog.php') ){ echo '/h1 '; } else { echo '/div '; } ?>><p id="site-description"><?php echo bloginfo('description'); ?></p>
<?php } ?>
<?php do_action( 'bp_after_site_title' ); ?>
</div>
<!-- SITEINFO END -->
<?php do_action( 'bp_inside_header' ); ?>
</div>
</div>
</header>
<!-- HEADER END -->
<?php do_action( 'bp_after_header' );
}
add_action('bp_before_container_wrap','meso_add_theme_header');


/*--------------------------------------------
Description: add schema breadcrumbs
---------------------------------------------*/
function meso_add_custom_breadcrumbs() {
$breadcrumb_on = get_theme_mod('breadcrumbs_on'); if($breadcrumb_on == 'enable') {
if( (function_exists('is_in_woocommerce_page') && is_in_woocommerce_page()) || (function_exists('is_in_jigoshop_page') && is_in_jigoshop_page())  ){
} else {
if(get_post_type() == 'post' || get_post_type() == 'page' ) {
echo meso_schema_breadcrumbs();
}
}
}
}
add_action('bp_inside_container_wrap','meso_add_custom_breadcrumbs',20);

/*--------------------------------------------
Description: add top navigation
---------------------------------------------*/
function meso_add_top_nav() { ?>
<?php do_action( 'bp_before_top_nav' ); ?>
<nav class="top-nav iegradient effect-1" id="top-navigation"<?php do_action('bp_section_nav'); ?>>
<div class="innerwrap">
<?php wp_nav_menu( array( 'theme_location' => 'top', 'container' => false, 'menu_class' => 'sf-menu', 'fallback_cb' => 'mesocolumn_revert_wp_menu_page','walker' => new Custom_Description_Walker )); ?>
<?php do_action( 'bp_inside_top_nav' ); ?>
</div>
</nav>
<?php do_action( 'bp_after_top_nav' ); ?>
<?php }
add_action('bp_before_header', 'meso_add_top_nav');


/*--------------------------------------------
Description: add primary navigation
---------------------------------------------*/
function meso_add_primary_nav() { ?>
<?php do_action( 'bp_before_main_nav' ); ?>
<!-- NAVIGATION START -->
<nav class="main-nav iegradient" id="main-navigation"<?php do_action('bp_section_nav'); ?>>
<?php if( has_nav_menu('primary') ):
wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'sf-menu', 'fallback_cb' => '','walker' => new Custom_Description_Walker ));
else:
echo '<ul class="sf-menu">';
echo wp_list_categories('orderby=name&show_count=0&title_li=');
echo '</ul>';
endif;
?>
<?php do_action( 'bp_inside_main_nav' ); ?>
</nav>
<!-- NAVIGATION END -->
<?php do_action( 'bp_after_main_nav' ); ?>
<?php }
add_action('bp_inside_container_wrap', 'meso_add_primary_nav');


/*--------------------------------------------
Description: add theme footer
---------------------------------------------*/
function meso_add_footer_top_widget() {
do_action( 'bp_before_footer_top' );

if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>

<footer class="footer-top"><div class="innerwrap"><div class="ftop"><div class="footer-container-wrap">

<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
<div class="fbox footer-one"><div class="widget-area the-icons">
<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
</div></div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
<div class="fbox wider-cat footer-two"><div class="widget-area the-icons">
<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
</div></div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
<div class="fbox footer-three"><div class="widget-area the-icons">
<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
</div></div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
<div class="fbox footer-four"><div class="widget-area the-icons">
<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
</div></div>
<?php endif; ?>

</div></div></div></footer>

<?php endif; do_action( 'bp_after_footer_top' );
}
add_action('bp_before_footer_bottom','meso_add_footer_top_widget');

/*--------------------------------------------
Description: add custom image header location
---------------------------------------------*/
function meso_cih_loc() {
$header_overlay = get_theme_mod('custom_header_overlay');
if( get_header_image() && $header_overlay == 'no' ) {
echo '<div id="custom-img-header"><img src="'. get_header_image() . '" alt="' . get_bloginfo('name') . '" /></div>';
}
}
add_action('bp_after_main_nav','meso_cih_loc');

function meso_cih_overlay() {
$header_overlay = get_theme_mod('custom_header_overlay');
if( get_header_image() && $header_overlay == 'yes' ) {
echo '<div id="custom-img-header"><img src="'. get_header_image() . '" alt="' . get_bloginfo('name') . '" /></div>';
}
}
add_action('bp_inside_header','meso_cih_overlay');


/*--------------------------------------------
Description: add mobile menu in navigation
---------------------------------------------*/
function meso_add_mobile_menu_nav() {
if ( has_nav_menu( 'mobile' ) ) {
dez_get_mobile_navigation('mobile');
} }
add_action('bp_inside_top_nav','meso_add_mobile_menu_nav');

/*--------------------------------------------
Description: add sub category in paren category
---------------------------------------------*/
function meso_add_subcat() {
if( get_theme_mod('allow_subcat') == 'enable' && is_category() ) {
$in_category = get_category( get_query_var( 'cat' ) );
$cat_id = $in_category->cat_ID;
$this_category = wp_list_categories('show_option_none=&orderby=id&depth=5&show_count=0&title_li=&use_desc_for_title=1&child_of='.$cat_id."&echo=0");
if($this_category) {
echo '<ul class="subcat sub_tn_cat_color_'. $cat_id . '">'. $this_category . '</ul>';
}
}
}
add_action('bp_after_main_nav','meso_add_subcat');


/*--------------------------------------------
Description: add featured slider
---------------------------------------------*/
remove_action('bp_before_blog_home','dez_add_slider_frontpage');
function meso_add_featured_slider() {
if('page' == get_option( 'show_on_front' )) {
$paged = get_query_var( 'page' );
} else {
$paged = get_query_var( 'paged' );
}
if( ( is_home() || is_front_page() || is_page_template('page-templates/template-blog.php')) && get_theme_mod('slider_on') == 'enable') {
if ( !$paged ) {
get_template_part( 'lib/sliders/jd-gallery-slider' );
}
}
}
add_action('bp_before_blog_entry','meso_add_featured_slider');

/*--------------------------------------------
Description: add archive header
---------------------------------------------*/
function meso_add_archive_header() {
$archive_headline = get_theme_mod('archive_headline');
if( ( is_archive() || is_search() ) && $archive_headline != 'disable') {
get_template_part( 'lib/templates/headline' );
}
}
add_action('bp_before_blog_entry','meso_add_archive_header');


/*--------------------------------------------
Description: add fav icon
---------------------------------------------*/
function meso_add_fav_icon() {
$mfavicon = get_theme_mod('fav_icon');
$getsiteicon = get_site_icon_url();
if($getsiteicon) {
echo '<link rel="icon" href="'. stripcslashes( $getsiteicon ) . '" type="images/x-icon" />';
} else if( $mfavicon ) {
echo '<link rel="icon" href="'. stripcslashes( $mfavicon ) . '" type="images/x-icon" />';
}
}
add_action('wp_head','meso_add_fav_icon');
add_action('admin_head','meso_add_fav_icon');
add_action('login_head', 'meso_add_fav_icon');

/*--------------------------------------------
Description: add ads in post loop
---------------------------------------------*/
function meso_add_ads_post_loop() {
global $postcount;
$get_ads_code_one = get_theme_mod('ads_code_one');
$get_ads_code_two = get_theme_mod('ads_code_two');
if( !is_single() ) {
if( $get_ads_code_one == '' && $get_ads_code_two == '') {
} else {
if( 2 == $postcount ){
echo '<div class="adsense-post">';
echo stripcslashes(do_shortcode($get_ads_code_one));
echo '</div>';
} elseif( 4 == $postcount ){
echo '<div class="adsense-post">';
echo stripcslashes(do_shortcode($get_ads_code_two));
echo '</div>';
}
}
}
}
add_action('bp_after_blog_post','meso_add_ads_post_loop');


/*--------------------------------------------
Description: add ads in home feat block one
---------------------------------------------*/
function meso_add_ads_home_feat() {
$get_ads_code_one = get_theme_mod('ads_code_one');
if( $get_ads_code_one != '') {
echo '<div class="adsense-post adsense-home">';
echo stripcslashes(do_shortcode($get_ads_code_one));
echo '</div>';
echo '<br />';
}
}
add_action('bp_home_feat_block_one','meso_add_ads_home_feat');


/*--------------------------------------------
Description: add ads in home feat block two
---------------------------------------------*/
function meso_add_ads_home_feat_two() {
$get_ads_code_two = get_theme_mod('ads_code_two');
if( $get_ads_code_two != '') {
echo '<div class="adsense-post adsense-home">';
echo stripcslashes(do_shortcode($get_ads_code_two));
echo '</div>';
echo '<br />';
}
}
add_action('bp_home_feat_block_two','meso_add_ads_home_feat_two');


/*--------------------------------------------
Description: Add footer left item
---------------------------------------------*/
function meso_add_footer_left_item() {
echo __('Copyright &copy;', 'mesocolumn') . gmdate(__('Y', 'mesocolumn')) . '. ' . get_bloginfo('name');
}
add_action('bp_footer_left','meso_add_footer_left_item');

/*--------------------------------------------
Description: Add footer bottom nav
---------------------------------------------*/
function meso_add_footer_bottom_nav() {
wp_nav_menu( array('theme_location' => 'footer','container' => false,'depth' => 1,'fallback_cb' => 'none'));
if( has_nav_menu('footer') ) { echo '<br />'; }
}
add_action('bp_footer_right','meso_add_footer_bottom_nav');

/*--------------------------------------------
Description: Author Footer Credits
---------------------------------------------*/
function meso_author_footer_credit() {
if( get_theme_mod('footer_credit') != 'disable') {
$paged = get_query_var( 'paged' );
if( (is_home() || is_front_page()) && !$paged ){
$author_link = '<a rel="nofollow" target="_blank" href="http://www.dezzain.com/wordpress-themes/mesocolumn/">Mesocolumn</a>';
printf( __( '%s Theme by Dezzain', 'mesocolumn' ), $author_link );
} else {
$author_link = 'Mesocolumn';
printf( __( '%s Theme by Dezzain', 'mesocolumn' ), $author_link );
}
} else {
echo '<!-- Mesocolumn Theme by Dezzain, download and info at https://wordpress.org/themes/mesocolumn -->';
}
}
add_action('bp_footer_right','meso_author_footer_credit');


/*--------------------------------------------
Description: layout load filter
---------------------------------------------*/
function meso_feat_set_thumbnail() {
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>',120, 120, 'alignleft','thumbnail',dez_get_singular_cat('false'),the_title_attribute('echo=0'), false);
return $feat_thumb;
}

function meso_feat_set_fpostimg() {
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>',480, 200, 'alignleft','medium',dez_get_singular_cat('false'),the_title_attribute('echo=0'), false);
return $feat_thumb;
}

function meso_feat_set_full() {
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>','', '', 'alignleft','large',dez_get_singular_cat('false'),the_title_attribute('echo=0'), false);
return $feat_thumb;
}

function meso_layout_load() {
$get_feat_layout = get_theme_mod('feat_layout');
if($get_feat_layout == 'all thumbnail') {
add_filter('meso_top_feat_thumb','meso_feat_set_thumbnail');
} elseif($get_feat_layout == 'all medium') {
add_filter('meso_bottom_feat_thumb','meso_feat_set_fpostimg');
}
}
add_action('wp_head','meso_layout_load');


/*--------------------------------------------
Description: add schema custom excerpt
---------------------------------------------*/
if( !function_exists('meso_out_custom_excerpt') ) {
function meso_out_custom_excerpt($text,$limit) {
global $post;
$output = strip_tags($text);
$output = strip_shortcodes($output);
$output = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );
$output = str_replace( '"', "'", $output);
$output = explode(' ', $output, $limit);
if (count($output)>=$limit) {
array_pop($output);
$output = implode(" ",$output).'...';
} else {
$output = implode(" ",$output);
}
return trim($output);
}
}

/*--------------------------------------------
Description: add schema user role
---------------------------------------------*/
if(!function_exists('meso_get_user_role')) {
function meso_get_user_role($id) {
$user = new WP_User( $id );
if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
foreach ( $user->roles as $role )
return ucfirst($role);
} else {
return 'User';
}
}
}

/*--------------------------------------------
Description: add filter comment textarea
---------------------------------------------*/
function meso_alter_comment_form_default($default){
$default['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
return $default;
}
add_filter('comment_form_defaults','meso_alter_comment_form_default');

/*--------------------------------------------
Description: add filter searchform
---------------------------------------------*/
function meso_custom_search_form( $form ) {
$form = '<form method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '"><label><span class="screen-reader-text">' . __( 'Search for:', 'mesocolumn' ) . '</span><input type="search" class="search-field" placeholder="' . __( 'Search &hellip;', 'mesocolumn' ) . '" value="' . get_search_query() . '" name="s" title="' . __( 'Search for:', 'mesocolumn' ) . '" /></label> <input type="submit" class="search-submit" value="'. __( 'Search', 'mesocolumn' ) .'" /></form>';
return $form;
}
add_filter( 'get_search_form', 'meso_custom_search_form' );


/*--------------------------------------------
Description: add schema breadcrumbs
---------------------------------------------*/
function meso_schema_breadcrumbs() {
global $post;
$schema_on = '';
$schema_link = '';
$schema_prop_url = '';
$schema_prop_title = '';
$showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
$delimiter = ' &raquo; '; // delimiter between crumbs
$home = __('Home', 'mesocolumn'); // text for the 'Home' link
$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
$before = '<span class="current">'; // tag before the current crumb
$after = '</span>'; // tag after the current crumb
$schema_breadcrumb_on = get_theme_mod('schema_breadcrumb_on');
if ( $schema_breadcrumb_on == 'enable' ) {
$schema_link = ' itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
$schema_prop_url = ' itemprop="url"';
$schema_prop_title = ' itemprop="title"';
}
$homeLink = home_url();
if ( is_home() || is_front_page()) {
if ( $showOnHome == 1 ) {
echo '<div id="breadcrumbs"><div class="innerwrap">';
echo __('You are here: ', 'mesocolumn');
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $homeLink . '">' . '<span' . $schema_prop_title . '>' . $home . '</span>' . '</a></span>';
echo '</div></div>';
}
}
else {
echo '<div id="breadcrumbs"><div class="innerwrap">';
if ( !is_single()) {
echo __('You are here: ', 'mesocolumn');
}
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $homeLink . '">' . '<span' . $schema_prop_title . '>' . $home . '</span>' . '</a></span>' . $delimiter . ' ';
if ( is_category()) {
$thisCat = get_category(get_query_var('cat'), false);
if ( $thisCat->parent != 0 ) {
$category_link = get_category_link($thisCat->parent);
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $category_link . '">' . '<span' . $schema_prop_title . '>' . get_cat_name($thisCat->parent) . '</span>' . '</a></span>' . $delimiter . ' ';
}
$category_id = get_cat_ID(single_cat_title('', false));
$category_link = get_category_link($category_id);
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $category_link . '">' . '<span' . $schema_prop_title . '>' . single_cat_title('', false) . '</span>' . '</a></span>';
}
elseif ( is_search()) {
echo __('Search results for', 'mesocolumn') . ' "' . get_search_query() . '"';
}
elseif ( is_day()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_year_link(get_the_time('Y')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('Y') . '</span>' . '</a></span>' . $delimiter . ' ';
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('F') . '</span>' . '</a></span>' . $delimiter . ' ';
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('d') . '</span>' . '</a></span>';
}
elseif ( is_month()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_year_link(get_the_time('Y')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('Y') . '</span>' . '</a></span>' . $delimiter . ' ';
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('F') . '</span>' . '</a></span>';
}
elseif ( is_year()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_year_link(get_the_time('Y')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('Y') . '</span>' . '</a></span>';
}
elseif ( is_single() && !is_attachment()) {
if ( get_post_type() != 'post' ) {
$post_type = get_post_type_object(get_post_type());
$slug = $post_type->rewrite;
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $homeLink . '/' . $slug['slug'] . '">' . '<span' . $schema_prop_title . '>' . $post_type->labels->singular_name . '</span>' . '</a></span>';
// get post type by post
$post_type = $post->post_type;
// get post type taxonomies
$taxonomies = get_object_taxonomies($post_type, 'objects');
if ( $taxonomies ) {
foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
// get the terms related to post
$terms = get_the_terms($post->ID, $taxonomy_slug);
if ( !empty ( $terms )) {
foreach ( $terms as $term ) {
$taxlist .= ' ' . $delimiter . ' ' . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_term_link($term->slug, $taxonomy_slug) . '">' . '<span' . $schema_prop_title . '>' . ucfirst($term->name) . '</span>' . '</a></span>';
}
}
}
if ( $taxlist ) {
echo $taxlist;
}
}
echo ' ' . $delimiter . ' ' . __('You are reading &raquo;', 'mesocolumn');
}
else {
$category = get_the_category();
if ( $category ) {
foreach ( $category as $cat ) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_category_link($cat->term_id) . '">' . '<span' . $schema_prop_title . '>' . $cat->name . '</span>' . '</a></span>' . $delimiter . ' ';
}
}
echo __('You are reading &raquo;', 'mesocolumn');
}
}
elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
$post_type = get_post_type_object(get_post_type());
echo $before . $post_type->labels->singular_name . $after;
}
elseif ( is_attachment()) {
$parent = get_post($post->post_parent);
$cat = get_the_category($parent->ID);
$cat = $cat[0];
if ( $cat ) {
echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
}
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink($parent) . '">' . '<span' . $schema_prop_title . '>' . $parent->post_title . '</span>' . '</a></span>';
if ( $showCurrent == 1 )
echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
}
elseif ( is_page() && !$post->post_parent ) {
if ( class_exists('buddypress')) {
global $bp;
if ( bp_is_groups_component()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('groups') . '">' . '<span' . $schema_prop_title . '>' . bp_get_root_slug('groups') . '</span>' . '</a></span>';
if ( !bp_is_directory()) {
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('groups') . '/' . bp_current_item() . '">' . '<span' . $schema_prop_title . '>' . bp_current_item() . '</span>' . '</a></span>';
if ( bp_current_action()) {
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('groups') . '/' . bp_current_item() . '/' . bp_current_action() . '">' . '<span' . $schema_prop_title . '>' . bp_current_action() . '</span>' . '</a></span>';
}
}
}
else
if ( bp_is_members_directory()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('members') . '">' . '<span' . $schema_prop_title . '>' . bp_get_root_slug('members') . '</span>' . '</a></span>';
}
else
if ( bp_is_user()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('members') . '">' . '<span' . $schema_prop_title . '>' . bp_get_root_slug('members') . '</span>' . '</a></span>';
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . bp_core_get_user_domain($bp->displayed_user->id) . '">' . '<span' . $schema_prop_title . '>' . bp_get_displayed_user_username() . '</span>' . '</a></span>';
if ( bp_current_action()) {
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . bp_core_get_user_domain($bp->displayed_user->id) . bp_current_component() . '">' . '<span' . $schema_prop_title . '>' . bp_current_component() . '</span>' . '</a></span>';
}
}
else {
if ( bp_is_directory()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . bp_current_component() . '</span>' . '</a></span>';
}
else {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
}
}
}
else {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
}
}
elseif ( is_page() && $post->post_parent ) {
$parent_id = $post->post_parent;
$breadcrumbs = array( );
while ( $parent_id ) {
$page = get_page($parent_id);
$breadcrumbs[] = '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink($page->ID) . '">' . '<span' . $schema_prop_title . '>' . get_the_title($page->ID) . '</span>' . '</a></span>';
$parent_id = $page->post_parent;
}
$breadcrumbs = array_reverse($breadcrumbs);
for ( $i = 0; $i < count($breadcrumbs); $i++ ) {
echo $breadcrumbs[$i];
if ( $i != count($breadcrumbs) - 1 )
echo ' ' . $delimiter . ' ';
}
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
}
elseif ( is_tag()) {
$tag_id = get_term_by('name', single_cat_title('', false), 'post_tag');
if ( $tag_id ) {
$tag_link = get_tag_link($tag_id->term_id);
}
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $tag_link . '">' . '<span' . $schema_prop_title . '>' . single_cat_title('', false) . '</span>' . '</a></span>';
}
elseif ( is_author()) {
global $author;
$userdata = get_userdata($author);
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_author_posts_url($userdata->ID) . '">' . '<span' . $schema_prop_title . '>' . $userdata->display_name . '</span>' . '</a></span>';
}
elseif ( is_404()) {
echo ' ' . $delimiter . ' ' . __('Error 404', 'mesocolumn');
}
if ( get_query_var('paged')) {
if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
echo ' (';
echo ' ' . $delimiter . ' ' . __('Page', 'mesocolumn') . ' ' . get_query_var('paged');
if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
echo ')';
}
echo '</div></div>';
}
}

/*--------------------------------------------
Description: add schema for post
---------------------------------------------*/
function meso_add_itemtype_header() { echo ' itemscope itemtype="http://schema.org/WPHeader"'; }
function meso_add_itemtype_nav() { echo ' itemscope itemtype="http://schema.org/SiteNavigationElement"'; }
function meso_add_itemtype_sidebar() { echo ' itemscope itemtype="http://schema.org/WPSideBar"'; }
function meso_add_itemtype_footer() { echo ' itemscope itemtype="http://schema.org/WPFooter"'; }
function meso_add_itemtype_article() { echo ' itemscope="" itemtype="http://schema.org/Article"'; }
function meso_add_itemtype_post_title() { echo ' itemprop="name headline"'; }
function meso_add_itemtype_post_content() { echo ' itemprop="articleBody"'; }

function meso_add_custom_schema($content) {
global $post,$aioseop_options;
if( is_single() ) {
$post_aioseo_title = get_post_meta($post->ID, '_aioseop_title', true);
$author_id = get_the_author_meta('ID');
$author_email = get_the_author_meta('user_email');
$author_displayname = get_the_author_meta('display_name');
$author_nickname = get_the_author_meta('nickname');
$author_firstname = get_the_author_meta('first_name');
$author_lastname = get_the_author_meta('last_name');
$author_url = get_the_author_meta('user_url');
$author_status = get_the_author_meta('user_level');
$author_description = get_the_author_meta('user_description');
$author_role = meso_get_user_role($author_id);
$getsiteicon = get_site_icon_url();
if($getsiteicon) {
$favicon = $getsiteicon;
} else {
$favicon = get_theme_mod('fav_icon');
}
// get user google+ profile
$author_googleplus_profile = get_the_author_meta('wp_user_googleplus');
$author_facebook_profile = get_the_author_meta('wp_user_facebook');
$author_twitter_profile = get_the_author_meta('wp_user_twitter');

// get post thumbnail
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail" );
$large_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );
$schema = '';
?>
<?php
$schema .=  '<!-- start data:schema --><span class="post-schema"><meta content="article" itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="' . get_permalink() . '"/>';
$schema .= '<a itemprop="url" href="'. get_permalink() . '" rel="bookmark" title="' . the_title_attribute('echo=0') . ' ">' . get_permalink() . '</a>';

if($post_aioseo_title):
$schema .= '<span itemprop="alternativeHeadline">' . $post_aioseo_title . '</span>';
endif;

if($large_src):
$schema .= '<span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">' . $large_src[0] . '<meta itemprop="url" content="' . $large_src[0] . '"><meta itemprop="width" content="' . $large_src[1] . '"><meta itemprop="height" content="' . $large_src[2] . '"></span>';
endif;

if($thumbnail_src):
$schema .= '<span itemprop="thumbnailUrl">' . $thumbnail_src[0] . '</span>';
endif;
$getmodtime = get_the_modified_time();
if( $getmodtime > get_the_time() ) {
$modtime = get_the_modified_time('c');
} else {
$modtime = get_the_time('c');
}
$schema .= '<time datetime="'.get_the_time('Y-m-d') . '" itemprop="datePublished"><span class="date updated">'. $modtime . '</span></time><meta itemprop="dateModified" content="'. $modtime . '"/><span class="vcard author"><span class="fn">'.get_the_author().'</span></span>';
$categories = get_the_category();
$separator = ', ';
$output = '';
if($categories){
foreach($categories as $category) {
$schema .= '<span itemprop="articleSection">' . $category->cat_name . '</span>';
}
}
$posttags = get_the_tags();
$post_tags_list = '';
if ($posttags) {
$schema .= '<span itemprop="keywords">';
foreach($posttags as $tag) {
$post_tags_list .= $tag->name . ',';
}
$schema .= substr( $post_tags_list,0,-1 );
$schema .= '</span>';
}
$schema .= '<span itemprop="description">'. meso_out_custom_excerpt(get_the_content(),50) .'</span>';
$schema .= '<span itemprop="author" itemscope="" itemtype="http://schema.org/Person">';

$schema .= '<span itemprop="name">'.$author_displayname.'</span><a href="'. $author_googleplus_profile. '?rel=author" itemprop="url">'. $author_googleplus_profile . '</a>';

$schema .= '<span itemprop="givenName">'.$author_firstname.'</span>
<span itemprop="familyName">'.$author_lastname.'</span><span itemprop="email">'.$author_email . '</span><span itemprop="jobTitle">'. $author_role . '</span>';
if($author_description):
$schema .= '<span itemprop="knows">'.stripcslashes($author_description).'</span>';
endif;
$schema .= '<span itemprop="brand">'. get_bloginfo('name').'</span>';
$schema .= '</span>';

$schema .= '<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization"><span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject"><img alt="' . get_bloginfo('description') . '" src="' . $favicon . '"/><meta itemprop="url" content="'.$favicon.'"><meta itemprop="width" content="80"><meta itemprop="height" content="80"></span><meta itemprop="name" content="'. get_bloginfo('name') . '"></span>';

$schema .= '</span><!-- end data:schema -->';
return $content . $schema;
} else {
return $content;
}
}

/*--------------------------------------------
Description: init schema for post
---------------------------------------------*/
function meso_init_schema_features() {
/* check if schema is on */
$schema_on = '';
$schema_on = get_theme_mod('schema_on');
/* if another plugin schema is active */
if( function_exists('sj_add_google_author_schema') && get_option('sj_gplus_schema') == 'Enable' ) {
} else {
if( $schema_on == 'enable' ) {
add_filter('the_content', 'meso_add_custom_schema');
add_action('bp_article_start','meso_add_itemtype_article');
add_action('bp_article_post_title','meso_add_itemtype_post_title');
add_action('bp_article_post_content','meso_add_itemtype_post_content');
add_action('bp_section_header','meso_add_itemtype_header');
add_action('bp_section_nav','meso_add_itemtype_nav');
add_action('bp_section_sidebar','meso_add_itemtype_sidebar');
add_action('bp_section_footer','meso_add_itemtype_footer');
}
}
}
add_action('wp_head','meso_init_schema_features');


?>