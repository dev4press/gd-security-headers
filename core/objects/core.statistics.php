<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_core_statistics {
    public function __construct() { }

    public static function instance($ip = '') {
        static $_gdsih_statistics = null;

        if (is_null($_gdsih_statistics)) {
            $_gdsih_statistics = new gdsih_core_statistics();
        }

        return $_gdsih_statistics;
    }

    public function headers() {
        $list = array(
            array(
                'icon' => 'tag',
                'label' => __("Content Security Policy", "gd-security-headers"),
                'status' => gdsih_settings()->get('mode', 'csp') != 'disable',
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=csp'),
                'recommended' => true,
                'csp' => true,
                'live' => gdsih_settings()->get('mode', 'csp') == 'live',
                'report' => gdsih_settings()->get('mode', 'csp') == 'report'
            ),
            array(
                'icon' => 'tag',
                'label' => __("XSS Protection", "gd-security-headers"),
                'status' => gdsih_settings()->get('x_xss_protection', 'xxp'),
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=xxp'),
                'recommended' => true
            ),
            array(
                'icon' => 'tag',
                'label' => __("Feature Policy", "gd-security-headers"),
                'status' => gdsih_settings()->get('protection', 'feature'),
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=feature'),
                'recommended' => true
            ),
            array(
                'icon' => 'tag',
                'label' => __("Referrer Policy", "gd-security-headers"),
                'status' => gdsih_settings()->get('referrer_policy', 'headers'),
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=headers'),
                'recommended' => true
            ),
            array(
                'icon' => 'tag',
                'label' => __("Content Type", "gd-security-headers"),
                'status' => gdsih_settings()->get('x_content_type_nosniff', 'headers'),
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=headers'),
                'recommended' => true
            ),
            array(
                'icon' => 'tag',
                'label' => __("Strict Transport Security", "gd-security-headers"),
                'status' => gdsih_settings()->get('strict_transport_security', 'headers'),
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=headers'),
                'recommended' => is_ssl(),
                'ssl' => !is_ssl()
            ),
            array(
                'icon' => 'tag',
                'label' => __("Frame Options", "gd-security-headers"),
                'status' => gdsih_settings()->get('x_frame_options_sameorigin', 'headers'),
                'url' => network_admin_url('admin.php?page=gd-security-headers-settings&panel=headers'),
                'recommended' => gdsih_settings()->get('mode', 'csp') == 'disable'
            )
        );

        return $list;
    }

    public function get_reports_overview_week() {
        $csp = "SELECT COUNT(*) FROM ".gdsih_db()->csp_reports." WHERE `reported` > DATE(NOW()) - INTERVAL 7 DAY";
        $xxp = "SELECT COUNT(*) FROM ".gdsih_db()->xxp_reports." WHERE `reported` > DATE(NOW()) - INTERVAL 7 DAY";

        return array(
            'csp' => array(
                'label' => 'CSP',
                'active' => gdsih_settings()->get('mode', 'csp') != 'disable',
                'reports' => gdsih_db()->get_var($csp)),
            'xxp' => array(
                'label' => 'XXP',
                'active' => gdsih_settings()->get('x_xss_protection', 'xxp'),
                'reports' => gdsih_db()->get_var($xxp))
        );
    }

    public function get_csp_urls_week() {
        $sql = "SELECT `document_uri` AS url, COUNT(*) AS `reports` FROM ".gdsih_db()->csp_reports." WHERE `reported` > DATE(NOW()) - INTERVAL 7 DAY GROUP BY `document_uri` ORDER BY `reports` DESC LIMIT 0, 10;";

        return gdsih_db()->get_results($sql);
    }

    public function get_xxp_urls_week() {
        $sql = "SELECT `request_url` AS url, COUNT(*) AS `reports` FROM ".gdsih_db()->xxp_reports." WHERE `reported` > DATE(NOW()) - INTERVAL 7 DAY GROUP BY `request_url` ORDER BY `reports` DESC LIMIT 0, 10;";

        return gdsih_db()->get_results($sql);
    }
}

function gdsih_statistics() {
    return gdsih_core_statistics::instance();
}
