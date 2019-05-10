<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_csp_extra_google_analytics {
    public $basic = array('img', 'script');

    public $scripts = array(
        'www.google-analytics.com'
    );

    public $images = array(
        'www.google-analytics.com',
        'stats.g.doubleclick.net'
    );

    public function __construct() {
        add_filter('gdsih_csp_build_basic_rule', array($this, 'basic'), 10, 2);

        add_filter('gdsih_csp_build_custom_rules_for_script', array($this, 'add_scripts'));
        add_filter('gdsih_csp_build_custom_rules_for_img', array($this, 'add_imagess'));
    }

    public function basic($basic, $name) {
        if (in_array($name, $this->basic)) {
            $basic = 'self';
        }

        return $basic;
    }



    public function add_scripts($custom) {
        return array_merge($custom, $this->scripts);
    }

    public function add_imagess($custom) {
        return array_merge($custom, $this->images);
    }
}

new gdsih_csp_extra_google_analytics();
