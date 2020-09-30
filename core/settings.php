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

class gdsih_core_settings extends d4p_plugin_settings_corex {
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
            'variant' => 'feature-policy',
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
            'extra_gleam' => false,
            'extra_vimeo' => false,
            'extra_wordpress' => false,

            'cdn' => array(),

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
            'prefetch_basic' => 'no',
            'prefetch_custom' => array(),
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
            'accelerometer' => _x("Accelerometer", "Feature/Permissions Policy", "gd-security-headers"),
            'ambient-light-sensor' => _x("Ambient Light Sensor", "Feature/Permissions Policy", "gd-security-headers"),
            'autoplay' => _x("Autoplay", "Feature/Permissions Policy", "gd-security-headers"),
            'camera' => _x("Camera", "Feature/Permissions Policy", "gd-security-headers"),
            'document-domain' => _x("Document Domain", "Feature/Permissions Policy", "gd-security-headers"),
            'encrypted-media' => _x("Encrypted Media", "Feature/Permissions Policy", "gd-security-headers"),
            'fullscreen' => _x("Full Screen", "Feature/Permissions Policy", "gd-security-headers"),
            'geolocation' => _x("GEO Location", "Feature/Permissions Policy", "gd-security-headers"),
            'gyroscope' => _x("Gyroscope", "Feature/Permissions Policy", "gd-security-headers"),
            'legacy-image-formats' => _x("Legacy Image Formats", "Feature/Permissions Policy", "gd-security-headers"),
            'magnetometer' => _x("Magentometer", "Feature/Permissions Policy", "gd-security-headers"),
            'microphone' => _x("Microphone", "Feature/Permissions Policy", "gd-security-headers"),
            'midi' => _x("MIDI", "Feature/Permissions Policy", "gd-security-headers"),
            'notifications' => _x("Notifications", "Feature/Permissions Policy", "gd-security-headers"),
            'oversized-images' => _x("Oversized Images", "Feature/Permissions Policy", "gd-security-headers"),
            'payment' => _x("Payment", "Feature/Permissions Policy", "gd-security-headers"),
            'publickey-credentials-get' => _x("Publickey Credentials Get", "Feature/Permissions Policy", "gd-security-headers"),
            'speaker' => _x("Speaker", "Feature/Permissions Policy", "gd-security-headers"),
            'sync-xhr' => _x("Sync XHR", "Feature/Permissions Policy", "gd-security-headers"),
            'unoptimized-images' => _x("Unoptimized Images", "Feature/Permissions Policy", "gd-security-headers"),
            'unsized-media' => _x("Unsized Media", "Feature/Permissions Policy", "gd-security-headers"),
            'usb' => _x("USB", "Feature/Permissions Policy", "gd-security-headers"),
            'battery' => _x("Battery", "Feature/Permissions Policy", "gd-security-headers").' ('.__("Not widely supported!", "gd-security-headers").')',
            'display-capture' => _x("Display Capture", "Feature/Permissions Policy", "gd-security-headers").' ('.__("Not widely supported!", "gd-security-headers").')',
            'layout-animations' => _x("Layout Animations", "Feature/Permissions Policy", "gd-security-headers").' ('.__("Not widely supported!", "gd-security-headers").')',
            'picture-in-picture' => _x("Picture In Picture", "Feature/Permissions Policy", "gd-security-headers").' ('.__("Not widely supported!", "gd-security-headers").')',
            'vibrate' => _x("Vibrate", "Feature/Permissions Policy", "gd-security-headers").' ('.__("Not widely supported!", "gd-security-headers").')',
            'vr' => _x("VR", "Feature/Permissions Policy", "gd-security-headers").' ('.__("Not widely supported!", "gd-security-headers").')'
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
