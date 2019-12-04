<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_csp_extra_google_tag_manager {
    public $basic = array('script', 'img');

    public $script = array(
        'www.googletagmanager.com'
    );

    public function __construct() {
        add_filter('gdsih_csp_build_basic_rule', array($this, 'basic'), 10, 2);

        add_filter('gdsih_csp_build_custom_rules_for_img', array($this, 'add_script'));
        add_filter('gdsih_csp_build_custom_rules_for_script', array($this, 'add_script'));
    }

    public function basic($basic, $name) {
        if (in_array($name, $this->basic)) {
            $basic = 'self';
        }

        return $basic;
    }

    public function add_script($custom) {
        return array_merge($custom, $this->script);
    }
}

new gdsih_csp_extra_google_tag_manager();
