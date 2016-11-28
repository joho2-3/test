<?php
$theme_data = wp_get_theme();
$theme_version = $theme_data['Version'];
$theme_name = $theme_data['Name'];
$shortname = 'tn_'. TEMPLATE_DOMAIN;
$choose_count = array("Select a number","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");
$choose_weight = array("Select font weight",'light','lighter','normal','bold','100','200','300','400','500','600','700','800','900');

////////////////////////////////////////////////////////////////////////////////
// import old options into customizer options
////////////////////////////////////////////////////////////////////////////////
function meso_import_option_into_customizer() {
$check_import = get_option('meso_customizer_import');
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );
if( $check_import != 'complete') {
if( $options ) {
//print_r($options);
foreach( $options as $opt => $value ) {
//echo $opt . ' = ' . $value . '<br />';
$opt_filter = str_replace('tn_mesocolumn_','',$opt);
$opt_filter_tn = str_replace('tn_','',$opt_filter);
//lowercase the value option
if($value == 'Enable') { $value = 'enable'; }
if($value == 'Disable') { $value = 'disable'; }
if($value == 'Yes') { $value = 'yes'; }
if($value == 'No') { $value = 'no'; }
set_theme_mod($opt_filter_tn,$value);
}
update_option('meso_customizer_import','complete');
delete_option($option_name);
}
}
//watch out! this remove all the theme mod for this theme
//remove_theme_mods();
}
add_action('init','meso_import_option_into_customizer');


if ( ! isset( $wp_customize ) ) {
		return;
	}

function meso_add_customizer_custom_css() {
wp_enqueue_style('theme-customizer-css', get_template_directory_uri() . '/lib/functions/theme-customizer/theme-customizer.css', array(), $theme_version);
}
add_action( 'customize_controls_print_styles', 'meso_add_customizer_custom_css', 999 );

function meso_add_google_webfont_preview() { ?>
<link id="google_body" rel="stylesheet" href="">
<link id="google_headline" rel="stylesheet" href="">
<link id="google_nav" rel="stylesheet" href="">
<?php }
add_action('wp_head','meso_add_google_webfont_preview');


class Meso_Fonts_Family_Option_Control extends WP_Customize_Control {
public $type = 'select';

    public function render_content() {
       global $font_family_group;
        ?>
            <label>
  <span class="customize-control-title"><?php echo esc_html( $this->description ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<?php foreach($font_family_group as $font): ?>
<option<?php $fontsave = get_theme_mod($this->id); if( $fontsave == $font ) { ?> selected="selected"<?php } ?> value="<?php echo $font; ?>"><?php echo ucfirst($font); ?></option>
<?php endforeach; ?>
</select>
            </label>
        <?php
    }
}


class Meso_Fonts_Weight_Option_Control extends WP_Customize_Control {
public $type = 'select';

    public function render_content() {
       global $choose_weight;
        ?>
            <label>
  <span class="customize-control-title"><?php echo esc_html( $this->description ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<?php foreach($choose_weight as $weight): ?>
<option<?php $fontweightsave = get_theme_mod($this->id); if( $fontweightsave == $weight ) { ?> selected="selected"<?php } ?> value="<?php echo $weight; ?>"><?php echo ucfirst($weight); ?></option>
<?php endforeach; ?>
</select>
            </label>
        <?php
    }
}



class Meso_Choose_Count_Option_Control extends WP_Customize_Control {
public $type = 'select';

    public function render_content() {
       global $choose_count;
        ?>
            <label>
  <span class="customize-control-title"><?php echo esc_html( $this->description ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<?php foreach($choose_count as $count): ?>
<option<?php $choosecountsave = get_theme_mod($this->id); if( $choosecountsave == $count ) { ?> selected="selected"<?php } ?> value="<?php echo $count; ?>"><?php echo $count; ?></option>
<?php endforeach; ?>
</select>
            </label>
        <?php
    }
}



class Meso_Category_Dropdown_Control extends WP_Customize_Control {
public $type = 'select';
    private $cats = false;
    public function __construct($manager, $id, $args = array(), $options = array()) {
        $this->cats = get_categories($options);
        parent::__construct( $manager, $id, $args );
    }
    public function render_content() {
    if(!empty($this->cats)) { ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
   <select data-customize-setting-link="<?php echo $this->id; ?>">

    <option<?php $catsave = get_theme_mod($this->id); if( $catsave == '' && $catsave == 'Choose a category' ) { ?> selected="selected"<?php } ?> value="Choose a category"><?php _e('Choose a category', 'mesocolumn'); ?></option>

    <?php foreach ( $this->cats as $cat ) {
printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
}
?>
</select>
</label>
<?php
}
}
}




/* add mesocolumn sections for customizer */
add_action( 'customize_register', 'meso_customizer_add_panels' );
function meso_customizer_add_panels($wp_customize) {

$wp_customize->add_panel('meso_posts_option_panel', array(
'priority' 			=> 30,
'capability' 		=> 'edit_theme_options',
'theme_supports'	=> '',
'title' 			=> __( 'General', 'mesocolumn' ),
'description' 		=> __( 'Genaral settings', 'mesocolumn' ),
)
);

$wp_customize->add_panel('meso_homefeat_option_panel', array(
'priority' 			=> 50,
'capability' 		=> 'edit_theme_options',
'theme_supports'	=> '',
'title' 			=> __( 'Home Featured Category', 'mesocolumn' ),
'description' 		=> __( 'Home featured categories settings', 'mesocolumn' ),
)
);


$wp_customize->add_panel('meso_ads_option_panel', array(
'priority' 			=> 60,
'capability' 		=> 'edit_theme_options',
'theme_supports'	=> '',
'title' 			=> __( 'Advertisement', 'mesocolumn' ),
'description' 		=> __( 'Site advertisement settings', 'mesocolumn' ),
)
);

}




/* add mesocolumn sections for customizer */
add_action( 'customize_register', 'meso_customizer_add_sections' );
function meso_customizer_add_sections($wp_customize) {

// font sections
$wp_customize->add_section( 'custom_font_section', array (
'title'			=> __( 'Fonts', 'mesocolumn' ),
'description'	=> __( 'Save your site fonts settings', 'mesocolumn' ),
'priority'	=> 30
)
);


// post sections
$wp_customize->add_section( 'custom_post_section', array (
'title'			=> __( 'Posts', 'mesocolumn' ),
'description'	=> __( 'Save your posts settings', 'mesocolumn' ),
'priority'	=> 35,
'panel'	=> 'meso_posts_option_panel'
)
);

// post sections
$wp_customize->add_section( 'custom_slider_section', array (
'title'			=> __( 'Slider', 'mesocolumn' ),
'description'	=> __( 'Save your slider settings', 'mesocolumn' ),
'priority'	=> 40,
'panel'	=> 'meso_posts_option_panel'
)
);


// sections
$wp_customize->add_section( 'custom_featcat_section', array (
'title'			=> __( 'Choose Category:', 'mesocolumn' ),
'description'	=> __( 'Choose which category to featured', 'mesocolumn' ),
'priority'	=> 20,
'panel'	=> 'meso_homefeat_option_panel'
)
);

// sections
$wp_customize->add_section( 'custom_homefeat_section', array (
'title'			=> __( 'Layout & Style', 'mesocolumn' ),
'description'	=> __( 'Home featured category layout settings', 'mesocolumn' ),
'priority'	=> 30,
'panel'	=> 'meso_homefeat_option_panel'
)
);


// sections
$wp_customize->add_section( 'custom_ads_section', array (
'title'			=> __( 'Ad Location', 'mesocolumn' ),
'description'	=> __( 'Advertisement location settings', 'mesocolumn' ),
'priority'	=> 30,
'panel'	=> 'meso_ads_option_panel'
)
);

// sections
$wp_customize->add_section( 'custom_misc_section', array (
'title'			=> __( 'Miscellaneous', 'mesocolumn' ),
'description'	=> __( 'Miscellaneous settings', 'mesocolumn' ),
'priority'	=> 40,
'panel'	=> 'meso_posts_option_panel'
)
);

// sections
$wp_customize->add_section( 'custom_css_section', array (
'title'			=> __( 'Custom CSS', 'mesocolumn' ),
'description'	=> __( 'Custom css and style settings', 'mesocolumn' ),
'priority'	=> 50,
'panel'	=> 'meso_posts_option_panel'
)
);


}




/* add mesocolumn settings for customizer */
add_action( 'customize_register', 'meso_customizer_add_settings' );
function meso_customizer_add_settings($wp_customize) {

$wp_customize->add_setting('custom_header_overlay' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'sanitize_callback' => 'meso_sanitize_select'
)
);


$wp_customize->add_setting('header_logo' , array(
'default' => '',
'type' => 'theme_mod',
'sanitize_callback'	=> 'meso_sanitize_image',
'capability' => 'edit_theme_options'
)
);


$wp_customize->add_setting('fav_icon' , array(
'default' => '',
'type' => 'theme_mod',
'sanitize_callback'	=> 'meso_sanitize_image',
'capability' => 'edit_theme_options'
)
);


$wp_customize->add_setting('body_font' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'transport' => 'postMessage',
'sanitize_callback' => 'meso_sanitize_nohtml'
)
);

$wp_customize->add_setting('body_font_weight' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'transport' => 'postMessage',
'sanitize_callback' => 'meso_sanitize_nohtml'
)
);


$wp_customize->add_setting('headline_font' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'transport' => 'postMessage',
'sanitize_callback' => 'meso_sanitize_nohtml'
)
);

$wp_customize->add_setting('headline_font_weight' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'transport' => 'postMessage',
'sanitize_callback' => 'meso_sanitize_nohtml'
)
);

$wp_customize->add_setting('navigation_font' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'transport' => 'postMessage',
'sanitize_callback' => 'meso_sanitize_nohtml'
)
);

$wp_customize->add_setting('navigation_font_weight' , array(
'default' => '',
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'transport' => 'postMessage',
'sanitize_callback' => 'meso_sanitize_nohtml'
)
);

$wp_customize->add_setting(
    'main_color',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_css'
    )
);

$wp_customize->add_setting(
    'topnav_color',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_css'
    )
);

$wp_customize->add_setting(
    'footer_bottom_color',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_css'
    )
);



$wp_customize->add_setting(
    'feat_img_size',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'thumbnail',
         'sanitize_callback' => 'meso_sanitize_select'
    )
);


$wp_customize->add_setting(
    'blogpost_style',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'default',
        'sanitize_callback' => 'meso_sanitize_select'
    )
);

$wp_customize->add_setting(
    'first_feat_img',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'enable',
        'sanitize_callback' => 'meso_sanitize_select'
    )
);

$wp_customize->add_setting(
    'post_custom_excerpt',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 30,
        'sanitize_callback' => 'meso_sanitize_html'
    )
);


$wp_customize->add_setting(
    'post_excerpt_moretext',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'Continue Reading',
        'sanitize_callback' => 'meso_sanitize_html'
    )
);




$wp_customize->add_setting(
    'related_on',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'disable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);


$wp_customize->add_setting(
    'related_count',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 3,
        'sanitize_callback' => 'meso_sanitize_number_absint'
    )
);



$wp_customize->add_setting(
    'author_bio_on',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'disable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);

$wp_customize->add_setting(
    'breadcrumbs_on',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'disable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);


$wp_customize->add_setting(
    'archive_headline',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'enable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);


$wp_customize->add_setting(
    'comment_notice',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'enable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);

$wp_customize->add_setting(
    'comment_subscribe',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'enable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);


$wp_customize->add_setting(
    'allow_subcat',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'disable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);

$wp_customize->add_setting(
    'custom_shop',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'disable',
        'transport' => 'refresh',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);




$wp_customize->add_setting(
    'slider_on',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'disable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);


$wp_customize->add_setting(
    'slider_height',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 400,
        'sanitize_callback' => 'meso_sanitize_number_absint'
  )
);


$wp_customize->add_setting(
    'feat_cat',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_nohtml'
  )
);

$wp_customize->add_setting(
    'feat_cat_count',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_number_absint'
  )
);

$wp_customize->add_setting(
    'feat_post',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_nohtml'
  )
);



$wp_customize->add_setting(
    'feat_layout',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'default',
        'sanitize_callback' => 'meso_sanitize_nohtml'
  )
);


$wp_customize->add_setting(
    'rss_feed_on',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'enable',
        'sanitize_callback' => 'meso_sanitize_select'
  )
);


$wp_customize->add_setting(
    'feat_text_count',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '20',
        'sanitize_callback' => 'meso_sanitize_nohtml'
  )
);


$allhomefeat = array('1','2','3','4','5','6','7','8','9','10');
foreach ( $allhomefeat as $cfeat ) {
$wp_customize->add_setting(
    'side_feat_cat'. $cfeat,
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_nohtml'
  )
);

$wp_customize->add_setting(
    'side_feat_cat'. $cfeat . '_count',
    array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'meso_sanitize_nohtml'
  )
);
}



$wp_customize->add_setting( 'header_embed', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );

$wp_customize->add_setting( 'ads_code_one', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );

$wp_customize->add_setting( 'ads_code_two', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );

$wp_customize->add_setting( 'ads_single_top', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );

$wp_customize->add_setting( 'ads_single_bottom', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );

$wp_customize->add_setting( 'ads_right_sidebar', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );


$wp_customize->add_setting( 'header_code', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );

$wp_customize->add_setting( 'footer_code', array(
'type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => apply_filters('meso_textarea_settings_filter','meso_sanitize_textarea')
) );


$wp_customize->add_setting( 'footer_credit', array(
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => 'meso_sanitize_select'
) );

$wp_customize->add_setting( 'schema_on', array(
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'default' => 'disable',
'sanitize_callback' => 'meso_sanitize_select'
) );

$wp_customize->add_setting( 'schema_breadcrumb_on', array(
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'default' => 'disable',
'sanitize_callback' => 'meso_sanitize_select'
) );


$wp_customize->add_setting( 'responsive_mode', array(
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'default' => 'disable',
'sanitize_callback' => 'meso_sanitize_select'
) );

$wp_customize->add_setting( 'custom_css', array(
'type' => 'theme_mod',
'capability' => 'edit_theme_options',
'default' => '',
'sanitize_callback' => 'meso_sanitize_css'
) );


}



/* add mesocolumn control for customizer */
add_action( 'customize_register', 'meso_customizer_add_control' );
function meso_customizer_add_control($wp_customize) {

$wp_customize->add_control( 'custom_header_overlay', array(
'label'   => 'Header on top',
'section' => 'header_image',
'settings'   => 'custom_header_overlay',
'type'     => 'radio',
'choices'  => array(
'yes'  => 'Yes',
'no' => 'No',
),
)
);

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo', array(
   'label'   => 'Site Logo',
   'section' => 'title_tagline',
   'settings'   => 'header_logo'
  )
  )
  );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fav_icon', array(
   'label'   => 'Fav icon',
   'section' => 'title_tagline',
   'settings'   => 'fav_icon'
  )
  )
  );



$wp_customize->add_control(
     new Meso_Fonts_Family_Option_Control (
        $wp_customize,
        'body_font',
        array(
            'label'   => 'Body Font',

            'section' => 'custom_font_section',
            'description'	=> __( 'Body', 'mesocolumn' ),
            'settings' => 'body_font'
        )
    )
);

$wp_customize->add_control(
     new Meso_Fonts_Weight_Option_Control (
        $wp_customize,
        'body_font_weight',
        array(
            'label'   => 'Body Font Weight',
            'section' => 'custom_font_section',
            'description'	=> __( 'font weight', 'mesocolumn' ),
            'settings' => 'body_font_weight'
        )
    )
);


$wp_customize->add_control(
    new Meso_Fonts_Family_Option_Control (
        $wp_customize,
        'headline_font',
        array(
            'label'   => 'Headline Font',

            'section' => 'custom_font_section',
            'description'	=> __( 'Headline', 'mesocolumn' ),
            'settings' => 'headline_font'
        )
    )
);


$wp_customize->add_control(
     new Meso_Fonts_Weight_Option_Control (
        $wp_customize,
        'headline_font_weight',
        array(
            'label'   => 'Headline Font Weight',
            'section' => 'custom_font_section',
            'description'	=> __( 'font weight', 'mesocolumn' ),
            'settings' => 'headline_font_weight'
        )
    )
);


$wp_customize->add_control(
    new Meso_Fonts_Family_Option_Control (
        $wp_customize,
        'navigation_font',
        array(
            'label'   => 'Navigation Font',
            'section' => 'custom_font_section',
            'description'	=> __( 'Navigation', 'mesocolumn' ),
            'settings' => 'navigation_font'
        )
    )
);


$wp_customize->add_control(
     new Meso_Fonts_Weight_Option_Control (
        $wp_customize,
        'navigation_font_weight',
        array(
            'label'   => 'Navigation Font Weight',
            'section' => 'custom_font_section',
            'description'	=> __( 'font weight', 'mesocolumn' ),
            'settings' => 'navigation_font_weight'
        )
    )
);



$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'main_color',
        array(
            'label' => __("Color Scheme", 'mesocolumn'),
            'section' => 'colors',
            'settings' => 'main_color',
        )
    )
);


$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'topnav_color',
        array(
            'label' => __("Top Navigation Background Color", 'mesocolumn'),
            'section' => 'colors',
            'settings' => 'topnav_color',
        )
    )
);


$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'footer_bottom_color',
        array(
            'label' => __("Bottom Footer Background Color", 'mesocolumn'),
            'section' => 'colors',
            'settings' => 'footer_bottom_color',
        )
    )
);


$wp_customize->add_control( 'feat_img_size', array(
'label'   => __("Featured Image Size", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'feat_img_size',
'type'     => 'radio',
'choices'  => array(
'thumbnail'  => 'Thumbnail',
'medium' => 'Medium',
'large' => 'Large',
),
)
);


$wp_customize->add_control( 'blogpost_style', array(
'label'   => __("Blog Post Style", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'blogpost_style',
'type'     => 'radio',
'choices'  => array(
'default'  => 'Default',
'magazine' => 'Magazine',
),
)
);

$wp_customize->add_control( 'first_feat_img', array(
'label'   =>  __("Enable First Image Grab for Featured Thumbnails", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'first_feat_img',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'post_excerpt_moretext', array(
'label'   => __("Enter Post Excerpt More Text", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'post_excerpt_moretext',
'type'     => 'text'
)
);


$wp_customize->add_control( 'post_custom_excerpt', array(
'label'   => __("Enter Post Excerpt Count", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'post_custom_excerpt',
'type'     => 'text'
)
);



$wp_customize->add_control( 'related_on', array(
'label'   =>  __("Enable Related Posts", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'related_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control(
     new Meso_Choose_Count_Option_Control (
        $wp_customize,
        'related_count',
        array(
            'label'   => 'Related Count',
            'section' => 'custom_post_section',
            'description'	=> __( 'Choose related count', 'mesocolumn' ),
            'settings' => 'related_count'
        )
    )
);




$wp_customize->add_control( 'author_bio_on', array(
'label'   => __("Enable Author Bio", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'author_bio_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'breadcrumbs_on', array(
'label'   => __("Enable Breadcrumbs", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'breadcrumbs_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'archive_headline', array(
'label'   => __("Enable Archive Header", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'archive_headline',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);

$wp_customize->add_control( 'comment_notice', array(
'label'   => __("Enable Comments Close Notice", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'comment_notice',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);

$wp_customize->add_control( 'comment_subscribe', array(
'label'   => __("Enable Comments Subscribes", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'comment_subscribe',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'allow_subcat', array(
'label'   => __("Enable Auto Sub Category in Primary Menu", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'allow_subcat',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'custom_shop', array(
'label'   => __("Enable Custom Shop Style", 'mesocolumn'),
'section' => 'custom_post_section',
'settings'   => 'custom_shop',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);




$wp_customize->add_control( 'slider_on', array(
'label'   => __("Enable Featured Slider", 'mesocolumn'),
'section' => 'custom_slider_section',
'settings'   => 'slider_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);



$wp_customize->add_control( 'slider_height', array(
'label'   => __("Slider Height", 'mesocolumn'),
'section' => 'custom_slider_section',
'settings'   => 'slider_height',
'type'     => 'text'
)
);


$wp_customize->add_control( 'feat_cat', array(
'label' => __("Categories ID", 'mesocolumn'),
'description' => __("Add a list of category ids if you want to use category as featured. <em>*leave blank to use bottom post ids featured</em><br /><small>example: 3,4,68</small>", 'mesocolumn'),
'section' => 'custom_slider_section',
'settings'   => 'feat_cat',
'type'     => 'text'
)
);


$wp_customize->add_control(
     new Meso_Choose_Count_Option_Control (
        $wp_customize,
        'feat_cat_count',
        array(
            'label'   => __("Limit to how many posts", 'mesocolumn'),
            'section' => 'custom_slider_section',
            'description'	=> __("How many posts to show?", 'mesocolumn'),
            'settings' => 'feat_cat_count'
        )
    )
);


$wp_customize->add_control( 'feat_post', array(
'label' => __("Posts ID", 'mesocolumn'),
'description' => __("Add a list of post ids if you want to use posts as featured. <em>*leave blank to use above category ids featured</em><br /><strong style='font-size:13px;'>Post, Page and Custom Post Type Supported</strong><br /><small>example: 136,928,925,80,77,55,49</small>", 'mesocolumn'),
'section' => 'custom_slider_section',
'settings'   => 'feat_post',
'type'     => 'text'
)
);




$wp_customize->add_control( 'feat_layout', array(
'label'   => __("Featured Category Layout", 'mesocolumn'),
'section' => 'custom_homefeat_section',
'settings'   => 'feat_layout',
'type'     => 'radio',
'choices'  => array(
'default'  => 'Default',
'all thumbnail' => 'All Thumbnail',
'all medium' => 'All Medium',
),
)
);


$wp_customize->add_control( 'rss_feed_on', array(
'label'   => __("Enable Category RSS Feed Link", 'mesocolumn'),
'section' => 'custom_homefeat_section',
'settings'   => 'rss_feed_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'feat_text_count', array(
'label'   => __("How many text count for each post", 'mesocolumn'),
'section' => 'custom_homefeat_section',
'settings'   => 'feat_text_count',
'type'     => 'text',
)
);



$allhomefeat = array('1','2','3','4','5','6','7','8','9','10');
foreach ( $allhomefeat as $cfeat ) {
$wp_customize->add_control(
     new Meso_Category_Dropdown_Control (
        $wp_customize,
        'side_feat_cat'.$cfeat,
        array(
            'label'   => __( 'Category ', 'mesocolumn' ) . $cfeat,
            'section' => 'custom_featcat_section',
            'description'	=> __("Choose which category to featured.", 'mesocolumn'),
            'settings' => 'side_feat_cat'.$cfeat
        )
    )
);



$wp_customize->add_control(
     new Meso_Choose_Count_Option_Control (
        $wp_customize,
        'side_feat_cat'.$cfeat.'_count',
        array(
            'label'   => __("How many posts?", 'mesocolumn'),
            'section' => 'custom_featcat_section',
            'description'	=> __("How many?", 'mesocolumn'),
            'settings' => 'side_feat_cat'.$cfeat.'_count'
        )
    )
);


}



$wp_customize->add_control( 'header_embed', array(
'label' => __("Top Header", 'mesocolumn'),
'description' => __("468x60 or 728x90 Header Banner and Advertisment Embed Code", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'header_embed',
'type'     => 'textarea'
) );

$wp_customize->add_control( 'ads_code_one', array(
'label' => __("First Post Loop", 'mesocolumn'),
'description' => __("Add Embed Code or Image Banner Here<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'ads_code_one',
'type'     => 'textarea'
) );

$wp_customize->add_control( 'ads_code_two', array(
'label' => __("Second Post Loop", 'mesocolumn'),
'description' => __("Add Embed Code or Image Banner Here<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'ads_code_two',
'type'     => 'textarea'
) );

$wp_customize->add_control( 'ads_single_top', array(
'label' => __("Single Post Top", 'mesocolumn'),
'description' => __("Insert Ads code for the single post <strong>top</strong>. It will appeared before post content. <br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'ads_single_top',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'ads_single_bottom', array(
'label' => __("Single Post Bottom", 'mesocolumn'),
'description' => __("Insert Ads code for the single post <strong>bottom</strong>. It will appeared before post content. <br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'ads_single_bottom',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'ads_right_sidebar', array(
'label' => __("Right Sidebar", 'mesocolumn'),
'description' => __("Insert Ads code for the <strong>right</strong> sidebar.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'ads_right_sidebar',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'header_code', array(
'label' => __("Header Code", 'mesocolumn'),
'description' => __("Insert any code here. It will appeared after wp_head().<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'header_code',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'footer_code', array(
'label' => __("Footer Code", 'mesocolumn'),
'description' => __("Insert any code here. It will appeared after wp_footer().<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
'section' => 'custom_ads_section',
'settings'   => 'footer_code',
'type'     => 'textarea'
) );




$wp_customize->add_control( 'footer_credit', array(
'label'   => __("Theme Author Footer Credit", 'mesocolumn'),
'description' => __("Choose to disable or enable theme author footer credit links.<br /><em>*optional, but I would appreciate if you leave the footer credit link or consider a donation to <a target='_blank' href='http://www.dezzain.com/donation'>support the theme</a></em>", 'mesocolumn'),
'section' => 'custom_misc_section',
'settings'   => 'footer_credit',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));



$wp_customize->add_control( 'schema_on', array(
'label' => __("Schema.org Markup for Posts", 'mesocolumn'),
'description' => __("Choose to disable or enable schema markup for posts", 'mesocolumn'),
'section' => 'custom_misc_section',
'settings'   => 'schema_on',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));


$wp_customize->add_control( 'schema_breadcrumb_on', array(
'label' => __("Schema.org Markup for Breadcrumb", 'mesocolumn'),
'description' => __("Choose to disable or enable schema markup for site breadcrumb", 'mesocolumn'),
'section' => 'custom_misc_section',
'settings'   => 'schema_breadcrumb_on',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));


$wp_customize->add_control( 'responsive_mode', array(
'label' => __("Responsive Layout", 'mesocolumn'),
'description' => __("Choose to disable or enable theme responsive mode for smaller screen or mobile", 'mesocolumn'),
'section' => 'custom_misc_section',
'settings'   => 'responsive_mode',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));


$wp_customize->add_control( 'custom_css', array(
'label' => __("Custom CSS", 'mesocolumn'),
'description' => __("Insert your custom css here.", 'mesocolumn'),
'section' => 'custom_css_section',
'settings'   => 'custom_css',
'type'     => 'textarea'
) );

}


/* remove shop setting if woocommerce or jigoshop not installed */
add_action('customize_register', 'meso_remove_shop_setting');
function meso_remove_shop_setting($wp_customize) {
if( !class_exists('woocommerce') && !class_exists('jigoshop') ) {
$wp_customize->remove_setting('custom_shop');
$wp_customize->remove_control('custom_shop');
}
}


/* build a customizer reset core functions
Original Code from: http://wordpress.org/plugins/customizer-reset/
*/
if ( ! class_exists( 'MESO_Customizer_Reset' ) ) {
final class MESO_Customizer_Reset {
private static $instance = null;
private $wp_customize;
public static function get_instance() {
if ( null === self::$instance ) {
self::$instance = new self();
}
return self::$instance;
}
private function __construct() {
add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
add_action( 'customize_register', array( $this, 'customize_register' ) );
}

public function customize_controls_print_scripts() {
wp_enqueue_script( 'meso-customizer-reset', get_template_directory_uri() . '/lib/functions/theme-customizer/customizer-reset.js', array( 'jquery' ), $theme_version );
wp_localize_script( 'meso-customizer-reset', '_MesoCustomizerReset', array(
'reset'   => __( 'Reset', 'mesocolumn' ),
'confirm' => __( "Attention! This will remove all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'mesocolumn' ),
'nonce'   => array(
'reset' => wp_create_nonce( 'customizer-reset' ),
)
) );
}

/**
* Store a reference to `WP_Customize_Manager` instance
*
* @param $wp_customize
*/
public function customize_register( $wp_customize ) {
$this->wp_customize = $wp_customize;
}
public function ajax_customizer_reset() {
if ( ! $this->wp_customize->is_preview() ) {
wp_send_json_error( 'not_preview' );
}
if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
wp_send_json_error( 'invalid_nonce' );
}
$this->reset_customizer();
wp_send_json_success();
}
public function reset_customizer() {
$settings = $this->wp_customize->settings();
// remove theme_mod settings registered in customizer
foreach ( $settings as $setting ) {
if ( 'theme_mod' == $setting->type ) {
// only remove theme mod by customizer
if ($setting->id == 'active_theme' || $setting->id == 'nav_menu_locations[top]' || $setting->id == 'nav_menu_locations[primary]' || $setting->id == 'nav_menu_locations[footer]' || $setting->id == 'nav_menu_locations[mobile]'):
continue;
endif;
remove_theme_mod( $setting->id );
}
}
}
}
}
MESO_Customizer_Reset::get_instance();
?>