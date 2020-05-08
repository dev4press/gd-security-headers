<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_component_feature_policy {
    public $fep = null;

    public function __construct() {
        $this->fep = new gdsih_core_feature_policy();

        if (!D4P_CRON && !gdsih_settings()->get('htaccess')) {
            $header = $this->fep->build();

            if (!empty($header)) {
                header($header);
            }
        }

        add_filter('gdsih_htaccess_build_list', array($this, 'htaccess'));
    }

    public function htaccess($htaccess = array()) {
        $header = $this->fep->build(true);

        if (!empty($header)) {
            $htaccess[] = D4P_TAB.'# add header: feature-policy';
            $htaccess[] = D4P_TAB.'Header set '.$header;
        }

        return $htaccess;
    }
}
