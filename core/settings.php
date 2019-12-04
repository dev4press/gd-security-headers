<?php

if (!defined('ABSPATH')) exit;

class gdsih_core_scope extends d4p_core_scope {
    public static function instance() {
        static $instance = null;

        if (null === $instance) {
            $instance = new gdsih_core_scope();
        }

        return $instance;
    }
}

class gdsih_core_settings extends d4p_plugin_settings_core {
    public $base = 'gdsih';
    public $scope = 'network';

    public $features = array();

    public $settings = array(
        'core' => array(
            'activated' => 0,
            'htaccess_added' => false,
            'htaccess_available' => false
        ),
        'settings' => array(
            'htaccess' => false,
        ),
        'feature' => array(
            'protection' => false
        ),
        'csp' => array(
            'mode' => 'report',
            'log' => true,
            'log_original_policy' => false,
            'log_force_ssl' => false,

            'extra_google_adsense' => false,
            'extra_google_analytics' => false,
            'extra_google_fonts' => false,
            'extra_google_maps' => false,
            'extra_google_translate' => false,
            'extra_google_youtube' => false,
            'extra_google_tag_manager' => false,
            'extra_gravatar' => true,
            'extra_vimeo' => false,
            'extra_gleam' => false,

            'auto_inline_rule' => true,
            'auto_eval_rule' => true,
            'auto_data_rule' => true,
            'auto_blob_rule' => true,
            'auto_mediastream_rule' => true,
            'auto_filesystem_rule' => true,

            'upgrade_insecure_requests' => false,
            'block_all_mixed_content' => false,
            'disown_opener' => false,

            'default_basic' => 'self',
            'default_custom' => array(),
            'script_basic' => 'no',
            'script_custom' => array(),
            'style_basic' => 'no',
            'style_custom' => array(),
            'img_basic' => 'no',
            'img_custom' => array(),
            'connect_basic' => 'no',
            'connect_custom' => array(),
            'font_basic' => 'no',
            'font_custom' => array(),
            'object_basic' => 'no',
            'object_custom' => array(),
            'media_basic' => 'no',
            'media_custom' => array(),
            'child_basic' => 'no',
            'child_custom' => array(),
            'manifest_basic' => 'no',
            'manifest_custom' => array(),
            'form-action_basic' => 'no',
            'form-action_custom' => array(),
            'frame-ancestors_basic' => 'no',
            'frame-ancestors_custom' => array(),
            'worker_basic' => 'no',
            'worker_custom' => array(),
            'frame_basic' => 'no',
            'frame_custom' => array()
        ),
        'xxp' => array(
            'x_xss_protection' => true,
            'log' => true,
            'log_force_ssl' => false
        ),
        'headers' => array(
            'x_content_type_nosniff' => true,
            'x_frame_options_sameorigin' => false,
            'strict_transport_security' => false,
            'referrer_policy' => false,

            'referrer_policy_value' => 'no-referrer-when-downgrade',
            'strict_transport_security_max_age' => 31536000,
            'strict_transport_security_extra' => 'includeSubDomains',
            'x_frame_options_sameorigin_value' => 'SAMEORIGIN',
            'x_frame_options_sameorigin_domains' => ''
        )
    );

    protected function constructor() {
        $this->info = new gdsih_core_info();

        $this->features = array(
            'accelerometer' => __("Accelerometer", "gd-security-headers"),
            'autoplay' => __("Autoplay", "gd-security-headers"),
            'battery' => __("Battery", "gd-security-headers"),
            'camera' => __("Camera", "gd-security-headers"),
            'fullscreen' => __("Full Screen", "gd-security-headers"),
            'geolocation' => __("GEO Location", "gd-security-headers"),
            'gyroscope' => __("Gyroscope", "gd-security-headers"),
            'magnetometer' => __("Magentometer", "gd-security-headers"),
            'microphone' => __("Microphone", "gd-security-headers"),
            'midi' => __("MIDI", "gd-security-headers"),
            'notifications' => __("Notifications", "gd-security-headers"),
            'payment' => __("Payment", "gd-security-headers"),
            'picture-in-picture' => __("Picture In Picture", "gd-security-headers"),
            'push' => __("Push", "gd-security-headers"),
            'speaker' => __("Speaker", "gd-security-headers"),
            'sync-xhr' => __("Sync XHR", "gd-security-headers"),
            'usb' => __("USB", "gd-security-headers"),
            'vibrate' => __("Vibrate", "gd-security-headers")
        );

        foreach (array_keys($this->features) as $feature) {
            $this->settings['feature'][$feature.'_basic'] = 'no';
            $this->settings['feature'][$feature.'_custom'] = array();
        }

        add_action('gdsih_load_settings', array($this, 'init'));
    }

    protected function _db() {
        require_once(GDSIH_PATH.'core/admin/install.php');

        gdsih_install_database();
    }

    protected function _name($name) {
        return 'dev4press_'.$this->info->code.'_'.$name;
    }
}

/** @return gdsih_core_scope */
function gdsih_scope() {
    return gdsih_core_scope::instance();
}
