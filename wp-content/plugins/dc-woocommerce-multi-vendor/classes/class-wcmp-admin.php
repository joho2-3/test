<?php

/**
 * WCMp Admin Class
 *
 * @version		2.2.0
 * @package		WCMp
 * @author 		DualCube
 */
class WCMp_Admin {

    public $settings;

    public function __construct() {
        $general_singleproductmultisellersettings = get_option('wcmp_general_singleproductmultiseller_settings_name');
        // Admin script and style
        add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_script'), 30);
        add_action('dualcube_admin_footer', array(&$this, 'dualcube_admin_footer_for_wcmp'));
        add_action('admin_bar_menu', array(&$this, 'add_toolbar_items'), 100);
        add_action('admin_head', array(&$this, 'admin_header'));
        add_action('current_screen', array($this, 'conditonal_includes'));
        add_action('delete_post', array($this, 'remove_commission_from_sales_report'), 10);
        add_action('trashed_post', array($this, 'remove_commission_from_sales_report'), 10);
        add_action('untrashed_post', array($this, 'restore_commission_from_sales_report'), 10);
        add_action('woocommerce_order_status_changed', array($this, 'change_commission_status'), 20, 3);
        if (isset($general_singleproductmultisellersettings['is_singleproductmultiseller'])) {
            add_action('admin_enqueue_scripts', array($this, 'wcmp_kill_auto_save'));
        }
        $this->load_class('settings');
        $this->settings = new WCMp_Settings();
        add_filter('woocommerce_hidden_order_itemmeta', array(&$this, 'add_hidden_order_items'));

        add_filter('manage_wcmp_vendorrequest_posts_columns', array(&$this, 'wcmp_vendorrequest_columns'));
        add_action('manage_wcmp_vendorrequest_posts_custom_column', array(&$this, 'custom_wcmp_vendorrequest_column'), 10, 2);
        add_filter('post_row_actions', array(&$this, 'modify_wcmp_vendorrequest_row_actions'), 10, 2);
        add_filter('bulk_actions-edit-wcmp_vendorrequest', array(&$this, 'wcmp_vendorrequest_bulk_actions'));
        add_action('admin_menu', array(&$this, 'remove_wcmp_vendorrequest_meta_boxes'));
        add_action('add_meta_boxes', array(&$this, 'adding_vendor_application_meta_boxes'), 10, 2);
    }

    function adding_vendor_application_meta_boxes($post_type, $post) {
        global $WCMp;
        add_meta_box(
                'vendor-form-data', __('Vendor Form Data', $WCMp->text_domain), array(&$this,'render_vendor_meta_box'), 'wcmp_vendorrequest', 'normal', 'default'
        );
    }

    function render_vendor_meta_box($post, $metabox) {
        $post_id = $post->ID;
        $form_data = get_post_meta($post_id, 'wcmp_vendor_fields', true);
        if (!empty($form_data) && is_array($form_data)) {
            foreach ($form_data as $key => $value) {
                echo '<div class="wcmp-form-field">';
                echo '<label>' . html_entity_decode($value['label']) . ':</label>';
                if ($value['type'] == 'file') {
                    foreach ($value['value'] as $attacment_id) {
                        echo '<span> <a href="' . wp_get_attachment_url($attacment_id) . '" download>' . get_the_title($attacment_id) . '</a> </span>';
                    }
                } else {
                    if(is_array($value['value'])){
                        echo '<span> ' . implode(', ', $value['value']) . '</span>';
                    } else{
                        echo '<span> ' . $value['value'] . '</span>';
                    }
                }
                echo '</div>';
            }
        }
    }

    function remove_wcmp_vendorrequest_meta_boxes() {
        if (current_user_can('manage_options')) {
            remove_meta_box('submitdiv', 'wcmp_vendorrequest', 'side');
        }
    }

    function wcmp_vendorrequest_bulk_actions($actions) {
        unset($actions['edit']);
        return $actions;
    }

    function modify_wcmp_vendorrequest_row_actions($actions, $post) {
        global $WCMp;
        if ($post->post_type == "wcmp_vendorrequest") {
            unset($actions['view']);
            unset($actions['edit']);
            unset($actions['inline hide-if-no-js']);
            unset($actions['trash']);
            $user_id = get_post_meta($post->ID, 'user_id', true);
            $user = new WP_User($user_id);
            $user_data = get_userdata($user_id);
            $actions['view'] = '<a href="' . get_edit_post_link($post->ID) . '" title="" rel="permalink">' . __('View', $WCMp->text_domain) . '</a>';
            if (!in_array('dc_vendor', $user->roles) && !in_array('dc_rejected_vendor', $user->roles) && $user_data != false) {
                $actions['aprove'] = '<a class="activate_vendor" href="#" data-id="' . $user_id . '" title="" rel="permalink">' . __('Approve', $WCMp->text_domain) . '</a>';
                $actions['reject'] = '<a class="reject_vendor" href="#" data-id="' . $user_id . '" title="" rel="permalink">' . __('Reject', $WCMp->text_domain) . '</a>';
            }
        }
        return $actions;
    }

    function wcmp_vendorrequest_columns($columns) {
        global $WCMp;
        unset($columns['title'], $columns['date']);
        $new_columns = array(
            'userid' => __('Username', $WCMp->text_domain),
            'email' => __('Email', $WCMp->text_domain),
            'date' => __('Date', $WCMp->text_domain)
        );
        return array_merge($columns, $new_columns);
    }

    function custom_wcmp_vendorrequest_column($column, $post_id) {
        switch ($column) {
            case 'userid' :
                echo get_post_meta($post_id, 'username', true);
                break;
            case 'email' :
                echo get_post_meta($post_id, 'email', true);
                break;
        }
    }

    function add_hidden_order_items($order_items) {
        $order_items[] = '_give_tax_to_vendor';
        $order_items[] = '_give_shipping_to_vendor';
        // and so on...
        return $order_items;
    }

    public function change_commission_status($order_id, $old_status, $new_status) {
        global $WCMp, $wpdb;
        $myorder = get_post($order_id);
        $post_type = $myorder->post_type;
        if ($old_status == 'on-hold' || $old_status == 'pending' || $old_status == 'cancelled' || $old_status == 'refunded' || $old_status == 'failed') {
            if ($new_status == 'processing' || $new_status == 'completed') {
                if ($post_type == 'shop_order') {
                    $args = array(
                        'posts_per_page' => -1,
                        'offset' => 0,
                        'meta_key' => '_commission_order_id',
                        'meta_value' => $order_id,
                        'post_type' => 'dc_commission',
                        'post_status' => 'trash',
                        'suppress_filters' => true
                    );
                    $commission_array = get_posts($args);
                    foreach ($commission_array as $commission) {
                        $to_be_restore_commission = array();
                        $to_be_restore_commission['ID'] = $commission->ID;
                        $to_be_restore_commission['post_status'] = 'private';
                        wp_update_post($to_be_restore_commission);
                    }
                    $order_query = "update " . $wpdb->prefix . "wcmp_vendor_orders set 	is_trashed = '' where `order_id` = " . $order_id;
                    $wpdb->query($order_query);
                }
            }
        } elseif ($old_status == 'processing' || $old_status == 'completed') {
            if ($new_status == 'on-hold' || $new_status == 'pending' || $new_status == 'cancelled' || $new_status == 'refunded' || $new_status == 'failed') {
                if ($post_type == 'shop_order') {
                    $args = array(
                        'posts_per_page' => -1,
                        'offset' => 0,
                        'meta_key' => '_commission_order_id',
                        'meta_value' => $order_id,
                        'post_type' => 'dc_commission',
                        'post_status' => array('publish', 'private'),
                        'suppress_filters' => true
                    );
                    $commission_array = get_posts($args);
                    foreach ($commission_array as $commission) {
                        $to_be_deleted_commission = array();
                        $to_be_deleted_commission['ID'] = $commission->ID;
                        $to_be_deleted_commission['post_status'] = 'trash';
                        wp_update_post($to_be_deleted_commission);
                    }
                    $order_query = "update " . $wpdb->prefix . "wcmp_vendor_orders set 	is_trashed = '1' where `order_id` = " . $order_id;
                    $wpdb->query($order_query);
                }
            }
        }
    }

    public function remove_commission_from_sales_report($order_id) {
        global $WCMp, $wpdb;
        $myorder = get_post($order_id);
        $post_type = $myorder->post_type;
        if ($post_type == 'shop_order') {
            $args = array(
                'posts_per_page' => -1,
                'offset' => 0,
                'meta_key' => '_commission_order_id',
                'meta_value' => $order_id,
                'post_type' => 'dc_commission',
                'post_status' => array('publish', 'private'),
                'suppress_filters' => true
            );
            $commission_array = get_posts($args);
            foreach ($commission_array as $commission) {
                $to_be_deleted_commission = array();
                $to_be_deleted_commission['ID'] = $commission->ID;
                $to_be_deleted_commission['post_status'] = 'trash';
                wp_update_post($to_be_deleted_commission);
            }
            $order_query = "update " . $wpdb->prefix . "wcmp_vendor_orders set 	is_trashed = '1' where `order_id` = " . $order_id;
            $wpdb->query($order_query);
        }
    }

    public function restore_commission_from_sales_report($order_id) {
        global $WCMp, $wpdb;
        $myorder = get_post($order_id);
        $post_type = $myorder->post_type;
        if ($post_type == 'shop_order') {
            $args = array(
                'posts_per_page' => -1,
                'offset' => 0,
                'meta_key' => '_commission_order_id',
                'meta_value' => $order_id,
                'post_type' => 'dc_commission',
                'post_status' => 'trash',
                'suppress_filters' => true
            );
            $commission_array = get_posts($args);
            foreach ($commission_array as $commission) {
                $to_be_restore_commission = array();
                $to_be_restore_commission['ID'] = $commission->ID;
                $to_be_restore_commission['post_status'] = 'private';
                wp_update_post($to_be_restore_commission);
            }
            $order_query = "update " . $wpdb->prefix . "wcmp_vendor_orders set 	is_trashed = '' where `order_id` = " . $order_id;
            $wpdb->query($order_query);
        }
    }

    function conditonal_includes() {
        $screen = get_current_screen();

        if (in_array($screen->id, array('options-permalink'))) {
            $this->permalink_settings_init();
            $this->permalink_settings_save();
        }
    }

    function permalink_settings_init() {
        global $WCMp;
        // Add our settings
        add_settings_field(
                'dc_product_vendor_taxonomy_slug', // id
                __('Vendor Shop Base', $WCMp->text_domain), // setting title
                array(&$this, 'wcmp_taxonomy_slug_input'), // display callback
                'permalink', // settings page
                'optional'                                      // settings section
        );
    }

    function wcmp_taxonomy_slug_input() {
        global $WCMp;
        $permalinks = get_option('dc_vendors_permalinks');
        ?>
        <input name="dc_product_vendor_taxonomy_slug" type="text" class="regular-text code" value="<?php if (isset($permalinks['vendor_shop_base'])) echo esc_attr($permalinks['vendor_shop_base']); ?>" placeholder="<?php echo _x('vendor', 'slug', $WCMp->text_domain) ?>" />
        <?php
    }

    function permalink_settings_save() {
        if (!is_admin()) {
            return;
        }
        // We need to save the options ourselves; settings api does not trigger save for the permalinks page
        if (isset($_POST['permalink_structure']) || isset($_POST['dc_product_vendor_taxonomy_slug'])) {

            // Cat and tag bases
            $dc_product_vendor_taxonomy_slug = wc_clean($_POST['dc_product_vendor_taxonomy_slug']);
            $permalinks = get_option('dc_vendors_permalinks');

            if (!$permalinks) {
                $permalinks = array();
            }

            $permalinks['vendor_shop_base'] = untrailingslashit($dc_product_vendor_taxonomy_slug);
            update_option('dc_vendors_permalinks', $permalinks);
        }
    }

    /**
     * Add Toolbar for vendor user 
     *
     * @access public
     * @param admin bar
     * @return void
     */
    function add_toolbar_items($admin_bar) {
        global $WCMp;

        $plugin_pages = get_option('wcmp_pages_settings_name');
        $user = wp_get_current_user();
        if (is_user_wcmp_vendor($user)) {
            $admin_bar->add_menu(
                    array(
                        'id' => 'vendor_dashboard',
                        'title' => __('Frontend  Dashboard', $WCMp->text_domain),
                        'href' => get_permalink($plugin_pages['vendor_dashboard']),
                        'meta' => array(
                            'title' => __('Frontend Dashboard', $WCMp->text_domain),
                            'target' => '_blank',
                            'class' => 'shop-settings'
                        ),
                    )
            );
            $admin_bar->add_menu(
                    array(
                        'id' => 'shop_settings',
                        'title' => __('Shop Settings', $WCMp->text_domain),
                        'href' => get_permalink($plugin_pages['shop_settings']),
                        'meta' => array(
                            'title' => __('Shop Settings', $WCMp->text_domain),
                            'target' => '_blank',
                            'class' => 'shop-settings'
                        ),
                    )
            );
        }
    }

    function load_class($class_name = '') {
        global $WCMp;
        if ('' != $class_name) {
            require_once ($WCMp->plugin_path . '/admin/class-' . esc_attr($WCMp->token) . '-' . esc_attr($class_name) . '.php');
        } // End If Statement
    }

// End load_class()

    /**
     * Add dualcube footer text on plugin settings page
     *
     * @access public
     * @param admin bar
     * @return void
     */
    function dualcube_admin_footer_for_wcmp() {
        global $WCMp;
        ?>
        <div style="clear: both"></div>
        <div id="dc_admin_footer">
        <?php _e('Powered by', $WCMp->text_domain); ?> <a href="http://dualcube.com" target="_blank"><img src="<?php echo $WCMp->plugin_url . 'assets/images/dualcube.png'; ?>"></a><?php _e('Dualcube', $WCMp->text_domain); ?> &copy; <?php echo date('Y'); ?>
        </div>
        <?php
    }

    /**
     * Add css on admin header
     *
     * @access public
     * @return void
     */
    function admin_header() {
        global $WCMp;
        $screen = get_current_screen();
        if (is_user_logged_in()) {

            if (in_array($screen->id, array('edit-dc_commission', 'edit-wcmp_university', 'edit-wcmp_vendor_notice'))) {
                ?>
                <script>
                    jQuery(document).ready(function ($) {
                        var target_ele = $(".wrap>h1");
                        var targethtml = target_ele.html();
                        targethtml = targethtml + '<a href="<?php echo trailingslashit(get_admin_url()) . 'admin.php?page=wcmp-setting-admin'; ?>" class="page-title-action">Back To WCMp Settings</a>';
                        target_ele.html(targethtml);
                <?php if (in_array($screen->id, array('edit-wcmp_university'))) { ?>
                            target_ele.append('<p><b><?php echo __('"University" section is visible only to vendors through the vendor dashboard. You may use this section to onboard your vendors. Share tutorials, best practices, "how to" guides or whatever you feel is appropriate with your vendors.', $WCMp->text_domain); ?></b></p>');
                <?php } ?>
                <?php if (in_array($screen->id, array('edit-wcmp_vendor_notice'))) { ?>
                            target_ele.append('<p><b><?php echo __('Announcements are visible only to vendors through the vendor dashboard(message section). You may use this section to broadcast your announcements.', $WCMp->text_domain); ?></b></p>');
                <?php } ?>
                    });

                </script>
                <?php
            }
            $user_id = get_current_user_id();
            $user = new WP_User($user_id);
            if (!empty($user->roles) && is_array($user->roles) && in_array('dc_vendor', $user->roles)) {
                echo '<style type="text/css">';
                echo '#menu-posts-dc_commission { display : none;}';
                echo '</style>';
                $vendor_submit_coupon = get_user_meta($user_id, '_vendor_submit_coupon', true);
                if ($WCMp->vendor_caps->vendor_capabilities_settings('is_submit_coupon') && $vendor_submit_coupon) {
                    echo '<style type="text/css">';
                    echo '#toplevel_page_woocommerce ul li, #menu-posts, #menu-posts-dc_commission, #menu-tools, #menu-comments, #menu-appearance{ 
									display : none;
								}';
                    echo '#toplevel_page_woocommerce ul li.wp-first-item {
									display : block;
								}';
                    echo '</style>';
                } else {
                    echo '<style type="text/css">';
                    echo '#menu-tools, #menu-comments, #menu-appearance, #menu-posts{ 
										display : none;
									}';
                    echo '</style>';
                    echo '<style type="text/css">';
                    echo '#toplevel_page_woocommerce { 
										display : none;
									}';
                    echo '</style>';
                }
            }
        }
    }

    /**
     * Admin Scripts
     */
    public function enqueue_admin_script() {
        global $WCMp, $woocommerce;
        $screen = get_current_screen();
        $suffix = defined('WCMP_SCRIPT_DEBUG') && WCMP_SCRIPT_DEBUG ? '' : '.min';
        $general_singleproductmultisellersettings = get_option('wcmp_general_singleproductmultiseller_settings_name');
        //echo $screen->id;
        // Enqueue admin script and stylesheet from here
        if (in_array($screen->id, array('woocommerce_page_wcmp-setting-admin'))) :
            $WCMp->library->load_qtip_lib();
            $WCMp->library->load_upload_lib();
            $WCMp->library->load_colorpicker_lib();
            $WCMp->library->load_datepicker_lib();
            wp_enqueue_script('wcmp_admin_js', $WCMp->plugin_url . 'assets/admin/js/admin' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_style('wcmp_admin_css', $WCMp->plugin_url . 'assets/admin/css/admin' . $suffix . '.css', array(), $WCMp->version);
        endif;

        if (in_array($screen->id, array('dc_commission'))) :
            $WCMp->library->load_qtip_lib();
            wp_enqueue_script('wcmp_admin_js', $WCMp->plugin_url . 'assets/admin/js/admin' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_style('wcmp_admin_css', $WCMp->plugin_url . 'assets/admin/css/admin' . $suffix . '.css', array(), $WCMp->version);
            if (!wp_style_is('woocommerce_chosen_styles', 'queue')) {
                // wp_enqueue_style( 'woocommerce_chosen_styles', $woocommerce->plugin_url() . '/assets/css/chosen.css' );
                wp_enqueue_style('woocommerce_chosen_styles', $WCMp->plugin_url . '/assets/admin/css/chosen' . $suffix . '.css');
            }
            // Load Chosen JS
            // wp_enqueue_script( 'ajax-chosen' );
            // wp_enqueue_script( 'chosen' );
            wp_enqueue_script('WCMp_chosen', $WCMp->plugin_url . 'assets/admin/js/chosen.jquery' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_script('WCMp_ajax-chosen', $WCMp->plugin_url . 'assets/admin/js/ajax-chosen.jquery' . $suffix . '.js', array('jquery', 'WCMp_chosen'), $WCMp->version, true);
            wp_enqueue_script('commission_js', $WCMp->plugin_url . 'assets/admin/js/commission' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_localize_script('commission_js', 'dc_vendor_object', array('security' => wp_create_nonce("search-products")));
        endif;



        if (in_array($screen->id, array('product', 'edit-product'))) :
            $WCMp->library->load_qtip_lib();
            wp_enqueue_script('wcmp_admin_js', $WCMp->plugin_url . 'assets/admin/js/admin' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_style('wcmp_admin_css', $WCMp->plugin_url . 'assets/admin/css/admin' . $suffix . '.css', array(), $WCMp->version);
            if (!wp_style_is('woocommerce_chosen_styles', 'queue')) {
                wp_enqueue_style('woocommerce_chosen_styles', $WCMp->plugin_url . '/assets/admin/css/chosen' . $suffix . '.css');
            }
            // Load Chosen JS
            // wp_enqueue_script( 'ajax-chosen' );
            // wp_enqueue_script( 'chosen' );

            wp_enqueue_script('WCMp_chosen', $WCMp->plugin_url . 'assets/admin/js/chosen.jquery' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_script('WCMp_ajax-chosen', $WCMp->plugin_url . 'assets/admin/js/ajax-chosen.jquery' . $suffix . '.js', array('jquery', 'WCMp_chosen'), $WCMp->version, true);
            wp_enqueue_script('commission_js', $WCMp->plugin_url . 'assets/admin/js/product' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_localize_script('commission_js', 'dc_vendor_object', array('security' => wp_create_nonce("search-products")));
            if (isset($general_singleproductmultisellersettings['is_singleproductmultiseller'])) {
                wp_enqueue_script('wcmp_admin_product_auto_search_js', $WCMp->plugin_url . 'assets/admin/js/admin-product-auto-search' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            }
        endif;

        if (in_array($screen->id, array('user-edit', 'profile'))) :
            $WCMp->library->load_qtip_lib();
            $WCMp->library->load_upload_lib();
            wp_enqueue_script('wcmp_admin_js', $WCMp->plugin_url . 'assets/admin/js/admin' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_style('admin_user', $WCMp->plugin_url . 'assets/admin/css/admin-user' . $suffix . '.css', array(), $WCMp->version);
            wp_enqueue_script('edit_user_js', $WCMp->plugin_url . 'assets/admin/js/edit_user' . $suffix . '.js', array('jquery'), $WCMp->version, true);
        endif;

        if (in_array($screen->id, array('users'))) :
            wp_enqueue_script('dc_users_js', $WCMp->plugin_url . 'assets/admin/js/to_do_list' . $suffix . '.js', array('jquery'), $WCMp->version, true);
        endif;

        if (in_array($screen->id, array('woocommerce_page_wc-reports', 'toplevel_page_wc-reports'))) :
            // wp_enqueue_script( 'ajax-chosen' );
            // wp_enqueue_script( 'chosen' );
            wp_enqueue_script('WCMp_chosen', $WCMp->plugin_url . 'assets/admin/js/chosen.jquery' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_script('WCMp_ajax-chosen', $WCMp->plugin_url . 'assets/admin/js/ajax-chosen.jquery' . $suffix . '.js', array('jquery', 'WCMp_chosen'), $WCMp->version, true);
            wp_enqueue_script('product_js', $WCMp->plugin_url . 'assets/admin/js/product' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_localize_script('product_js', 'dc_vendor_object', array('security' => wp_create_nonce("search-products")));
        endif;
        if (in_array($screen->id, array('woocommerce_page_wcmp-setting-admin', 'edit-wcmp_vendorrequest'))) :
            wp_enqueue_script('dc_to_do_list_js', $WCMp->plugin_url . 'assets/admin/js/to_do_list' . $suffix . '.js', array('jquery'), $WCMp->version, true);
        endif;
        if (in_array($screen->id, array('wcmp_vendorrequest'))) :
            wp_enqueue_style('admin-vendor_registration-css', $WCMp->plugin_url . 'assets/admin/css/admin-vendor_registration' . $suffix . '.css', array(), $WCMp->version);
        endif;

        if (in_array($screen->id, array('woocommerce_page_wc-reports', 'toplevel_page_wc-reports'))) :
            wp_enqueue_script('wcmp_report_js', $WCMp->plugin_url . 'assets/admin/js/report' . $suffix . '.js', array('jquery'), $WCMp->version, true);
            wp_enqueue_style('wcmp_report_css', $WCMp->plugin_url . 'assets/admin/css/report' . $suffix . '.css', array(), $WCMp->version);
            $WCMp->library->font_awesome_lib();
        endif;
    }

    function wcmp_kill_auto_save() {
        if ('product' == get_post_type()) {
            wp_dequeue_script('autosave');
        }
    }

}
