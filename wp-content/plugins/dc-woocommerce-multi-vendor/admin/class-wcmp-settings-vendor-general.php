<?php

class WCMp_Settings_Vendor_General {

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $tab;
    private $subsection;

    /**
     * Start up
     */
    public function __construct($tab, $subsection) {
        $this->tab = $tab;
        $this->subsection = $subsection;
        $this->options = get_option("wcmp_{$this->tab}_{$this->subsection}_settings_name");
        $this->settings_page_init();
    }

    /**
     * Register and add settings
     */
    public function settings_page_init() {
        global $WCMp;

        $settings_tab_options = array("tab" => "{$this->tab}",
            "ref" => &$this,
            "subsection" => "{$this->subsection}",
            "sections" => array(
                "wcmp_vendor_general_settings_section" => array("title" => '', // Section one
                    "fields" => array(
                        "woo_reg_section_label" => array('title' => __('Woocommerce Section Label', $WCMp->text_domain), 'type' => 'text', 'id' => 'woo_reg_section_label', 'label_for' => 'woo_reg_section_label', 'name' => 'woo_reg_section_label','hints' => __('Woocommerce registration section form heading.', $WCMp->text_domain)), // Checkbox
                    ),
                )
            ),
        );

        $WCMp->admin->settings->settings_field_withsubtab_init(apply_filters("settings_{$this->tab}_{$this->subsection}_tab_options", $settings_tab_options));
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function wcmp_vendor_general_settings_sanitize($input) {
        global $WCMp;
        $new_input = array();

        $hasError = false;

        if (isset($input['woo_reg_section_label'])){
            $new_input['woo_reg_section_label'] = sanitize_text_field($input['woo_reg_section_label']);
        }
        if (!$hasError) {
            add_settings_error(
                    "wcmp_{$this->tab}_{$this->subsection}_settings_name", esc_attr("wcmp_{$this->tab}_{$this->subsection}_settings_admin_updated"), __('Vendor Settings Updated', $WCMp->text_domain), 'updated'
            );
        }
        return apply_filters("settings_{$this->tab}_{$this->subsection}_tab_new_input", $new_input, $input);
    }

    /**
     * Print the Section text
     */
    public function wcmp_vendor_general_settings_section_info() {
        global $WCMp;
        printf(__('Setup vendor registration field from <a href="'.  admin_url('admin.php').'?page=wcmp-setting-admin&tab=vendor&tab_section=registration">here</a>.', $WCMp->text_domain));
    }

}
