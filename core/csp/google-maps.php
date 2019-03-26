<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_csp_extra_google_maps {
    public $basic = array('style', 'script');

    public $style = array(
        'maps.googleapis.com'
    );

    public $script = array(
        'ajax.googleapis.com',
        'maps.google.com',
        'maps.gstatic.com',
        'maps.googleapis.com'
    );

    public function __construct() {
        add_filter('gdsih_csp_build_basic_rule', array($this, 'basic'), 10, 2);

        add_filter('gdsih_csp_build_custom_rules_for_style', array($this, 'add_style'));
        add_filter('gdsih_csp_build_custom_rules_for_script', array($this, 'add_script'));
    }

    public function basic($basic, $name) {
        if (in_array($name, $this->basic)) {
            $basic = 'self';
        }

        return $basic;
    }

    public function add_style($custom) {
        return array_merge($custom, $this->style);
    }

    public function add_script($custom) {
        return array_merge($custom, $this->script);
    }
}

new gdsih_csp_extra_google_maps();
