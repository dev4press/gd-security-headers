<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_csp_extra_google_analytics {
    public $basic = array('img', 'script');

    public $list = array(
        'www.google-analytics.com'
    );

    public function __construct() {
        add_filter('gdsih_csp_build_basic_rule', array($this, 'basic'), 10, 2);

        add_filter('gdsih_csp_build_custom_rules_for_script', array($this, 'add_items'));
        add_filter('gdsih_csp_build_custom_rules_for_img', array($this, 'add_items'));
    }

    public function basic($basic, $name) {
        if (in_array($name, $this->basic)) {
            $basic = 'self';
        }

        return $basic;
    }

    public function add_items($custom) {
        return array_merge($custom, $this->list);
    }
}

new gdsih_csp_extra_google_analytics();
