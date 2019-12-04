<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_component_feature_policy {
    public $fep = null;

    public function __construct() {
        $this->fep = new gdsih_core_feature_policy();

        if (!D4P_CRON && !gdsih_settings()->get('htaccess')) {
            header($this->fep->build());
        }

        add_filter('gdsih_htaccess_build_list', array($this, 'htaccess'));
    }

    public function htaccess($htaccess = array()) {
        $htaccess[] = D4P_TAB.'# add header: feature-policy';
        $htaccess[] = D4P_TAB.'Header set '.$this->fep->build(true);

        return $htaccess;
    }
}
