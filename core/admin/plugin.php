<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_admin_core extends d4p_admin_core {
    public $plugin = 'gd-security-headers';

    function __construct() {
        parent::__construct();

        $this->url = GDSIH_URL;

        add_action('gdsec_plugin_init', array($this, 'core'));
    }

    public function core() {
        parent::core();

        add_action('network_admin_menu', array($this, 'admin_menu'));

        add_filter('set-screen-option', array($this, 'screen_options_grid_rows_save'), 10, 3);

        $this->init_ready();

        if (gdsih_scope()->is_master_network_admin()) {
            if (gdsih_settings()->is_install()) {
                add_action('admin_notices', array($this, 'install_notice'));
            }

            if (gdsih_settings()->is_update()) {
                add_action('admin_notices', array($this, 'update_notice'));
            }
        }
    }

    public function screen_options_grid_rows_save($status, $option, $value) {
        if (in_array($option, array(
            'gdsec_rows_per_page_csp_reports',
            'gdsec_rows_per_page_xxp_reports'))) {
            return $value;
        }

        return $status;
    }

    public function screen_options_grid_rows_csp_reports() {
        $key = 'gdsec_rows_per_page_csp_reports';

        $args = array(
            'label' => __("Rows", "gd-security-headers"),
            'default' => 25, 'option' => $key
        );

        add_screen_option('per_page', $args);

        require_once(GDSIH_PATH.'core/grids/csp.php');

        new gdsec_csp_report_grid();
    }

    public function screen_options_grid_rows_xxp_reports() {
        $key = 'gdsec_rows_per_page_xxp_reports';

        $args = array(
            'label' => __("Rows", "gd-security-headers"),
            'default' => 25, 'option' => $key
        );

        add_screen_option('per_page', $args);

        require_once(GDSIH_PATH.'core/grids/xxp.php');

        new gdsec_xxp_report_grid();
    }

    public function install_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Security Headers is activated and it needs to finish installation.", "gd-security-headers");
            echo ' <a href="admin.php?page=gd-security-headers-front">'.__("Click Here", "gd-security-headers").'</a>.';
            echo '</p></div>';
        }
    }

    public function update_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Security Headers is updated and it needs to finish the update process.", "gd-security-headers");
            echo ' <a href="admin.php?page=gd-security-headers-front">'.__("Click Here", "gd-security-headers").'</a>.';
            echo '</p></div>';
        }
    }

    public function init_ready() {
        do_action('gdsec_admin_load_addons');

        $this->menu_items = array(
            'front' => array('title' => __("Overview", "gd-security-headers"), 'icon' => 'home'),
            'about' => array('title' => __("About", "gd-security-headers"), 'icon' => 'info-circle'),
            'csp-reports' => array('title' => __("CSP Reports", "gd-security-headers"), 'icon' => 'info-circle'),
            'xxp-reports' => array('title' => __("XXP Reports", "gd-security-headers"), 'icon' => 'info-circle'),
            'settings' => array('title' => __("Settings", "gd-security-headers"), 'icon' => 'cogs'),
            'tools' => array('title' => __("About", "gd-security-headers"), 'icon' => 'wrench')
        );
    }

    public function admin_init() {
        d4p_include('grid', 'admin', GDSIH_D4PLIB);

        do_action('gdsec_admin_init');
    }

    public function title() {
        return 'GD Security Headers';
    }

    public function admin_menu() {
        if (is_multisite() && is_blog_admin()) {
            return;
        }

        $parent = 'gd-security-headers-front';

        $this->page_ids[] = add_menu_page(
            'GD Security Headers',
            'Security Headers',
            gdsec()->cap,
            $parent,
            array($this, 'panel_general'),
            gdsec()->svg_icon);

        foreach($this->menu_items as $item => $data) {
            $this->page_ids[] = add_submenu_page($parent,
                'GD Security Headers: '.$data['title'],
                $data['title'],
                gdsec()->cap,
                'gd-security-headers-'.$item,
                array($this, 'panel_general'));
        }

        $this->admin_load_hooks();
    }

    public function enqueue_scripts($hook) {
        $load_admin_data = false;

        gdsec()->enqueue_global();

        if ($this->page !== false) {
            d4p_admin_enqueue_defaults();

            wp_enqueue_script('jquery-form');

            wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

            wp_enqueue_style('d4plib-font', $this->file('css', 'font', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-admin', $this->file('css', 'admin', true), array('d4plib-shared'), D4P_VERSION);

            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION, true);
            wp_enqueue_script('d4plib-admin', $this->file('js', 'admin', true), array('d4plib-shared'), D4P_VERSION, true);
            wp_enqueue_script('d4plib-moment', GDSIH_URL.'d4pjs/moment/moment.min.js', array(), D4P_VERSION);

            wp_enqueue_style('gdsih-plugin', $this->file('css', 'plugin'), array('d4plib-admin'), gdsih_settings()->file_version());
            wp_enqueue_script('gdsih-plugin', $this->file('js', 'plugin'), array('d4plib-admin', 'd4plib-moment'), gdsih_settings()->file_version(), true);

            if ($this->page == 'about') {
                wp_enqueue_style('d4plib-grid', $this->file('css', 'grid', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            }

            do_action('gdsec_admin_enqueue_scripts', $this->page);

            $_data = array(
                'nonce' => wp_create_nonce('gdsec-admin-internal'),
                'wp_version' => GDSIH_WPV,
                'page' => $this->page,
                'panel' => $this->panel,
                'button_icon_ok' => '<i class="fa fa-check fa-fw" aria-hidden="true"></i> ',
                'button_icon_cancel' => '<i class="fa fa-times fa-fw" aria-hidden="true"></i> ',
                'button_icon_delete' => '<i class="fa fa-trash fa-fw" aria-hidden="true"></i> ',
                'dialog_button_ok' => __("OK", "gd-security-headers"),
                'dialog_button_cancel' => __("Cancel", "gd-security-headers"),
                'dialog_button_delete' => __("Delete", "gd-security-headers"),
                'dialog_button_remove' => __("Remove", "gd-security-headers"),
                'dialog_button_clear' => __("Clear", "gd-security-headers"),
                'dialog_title_areyousure' => __("Are you sure you want to do this?", "gd-security-headers"),
                'dialog_content_pleasewait' => __("Please Wait...", "gd-security-headers")
            );

            wp_localize_script('gdsih-plugin', 'gdsih_data', $_data);

            $load_admin_data = true;
        }

        if ($load_admin_data) {
            wp_localize_script('d4plib-shared', 'd4plib_admin_data', array(
                'string_media_image_title' => __("Select Image", "gd-security-headers"),
                'string_media_image_button' => __("Use Selected Image", "gd-security-headers"),
                'string_are_you_sure' => __("Are you sure you want to do this?", "gd-security-headers"),
                'string_image_not_selected' => __("Image not selected.", "gd-security-headers")
            ));
        }

        wp_enqueue_style('gdsih-admin', $this->file('css', 'admin'), array(), gdsih_settings()->file_version());
    }

    public function admin_load_hooks() {
        foreach ($this->page_ids as $id) {
            add_action('load-'.$id, array($this, 'load_admin_page'));
        }

        add_action('load-security-toolbox_page_gd-security-toolbox-csp-reports', array($this, 'screen_options_grid_rows_csp_reports'));
        add_action('load-security-toolbox_page_gd-security-toolbox-xxp-reports', array($this, 'screen_options_grid_rows_xxp_reports'));
    }

    public function current_screen($screen) {
        if (isset($_GET['panel']) && $_GET['panel'] != '') {
            $this->panel = d4p_sanitize_slug($_GET['panel']);
        }

        $id = $screen->id;

        if (gdsec_scope()->is_network_admin()) {
            if ($id == 'toplevel_page_gd-security-headers-front-network') {
                $this->page = 'front';
            } else if (substr($id, 0, 42) == 'security-toolbox_page_gd-security-headers-') {
                $this->page = substr($id, 42, strlen($id) - 50);
            }
        } else {
            if ($id == 'toplevel_page_gd-security-headers-front') {
                $this->page = 'front';
            } else if (substr($id, 0, 42) == 'security-toolbox_page_gd-security-headers-') {
                $this->page = substr($id, 42);
            }
        }

        if (is_super_admin()) {
            if (isset($_POST['gdsih_handler']) && $_POST['gdsih_handler'] == 'postback') {
                require_once(GDSIH_PATH.'core/admin/postback.php');

                new gdsih_admin_postback();
            } else if (isset($_GET['gdsih_handler']) && $_GET['gdsih_handler'] == 'getback') {
                require_once(GDSIH_PATH.'core/admin/getback.php');

                new gdsih_admin_getback();
            }
        }
    }

    public function load_admin_page() {
        $this->help_tab_sidebar();

        do_action('gdsec_load_admin_page_'.$this->page);

        if ($this->panel !== false && $this->panel != '') {
            do_action('gdsec_load_admin_page_'.$this->page.'_'.$this->panel);
        }

        $this->help_tab_getting_help();
    }

    public function install_or_update() {
        if (gdsec_scope()->is_multisite() && gdsec_scope()->is_blog_admin()) {
            $install = gdsec_blog()->is_install();
            $update = gdsec_blog()->is_update();
        } else {
            $install = gdsih_settings()->is_install();
            $update = gdsih_settings()->is_update();
        }

        if ($install) {
            include(GDSIH_PATH.'forms/install.php');
        } else if ($update) {
            include(GDSIH_PATH.'forms/update.php');
        }

        return $install || $update;
    }

    public function panel_general() {
        if (!$this->install_or_update()) {
            $path = GDSIH_PATH.'forms/'.$this->page.'.php';

            $path = apply_filters('gdsih_admin_panel_'.$this->page, $path);

            include($path);
        }
    }

    public function current_url($with_panel = true) {
        $page = 'admin.php?page=gd-security-headers-';

        $page.= $this->page;

        if ($with_panel && $this->panel !== false && $this->panel != '') {
            $page.= '&panel='.$this->panel;
        }

        return self_admin_url($page);
    }
}

global $_gdsih_core_admin;
$_gdsih_core_admin = new gdsih_admin_core();

function gdsih_admin() {
    global $_gdsih_core_admin;
    return $_gdsih_core_admin;
}
