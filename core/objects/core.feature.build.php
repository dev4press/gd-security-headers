<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_core_feature_policy {
    public function __construct() { }

    public function rule($items, $name) {
        $basic = gdsih_settings()->get($name.'_basic', 'feature');
        $custom = gdsih_settings()->get($name.'_custom', 'feature');

        $basic = apply_filters('gdsih_feature-policy_build_basic_rule', $basic, $name);
        $basic = apply_filters('gdsih_feature-policy_build_basic_rule_for_'.$name, $basic);

        if ($basic != 'no') {
            $item = $name.' ';

            if ($basic == 'none') {
                $item.= "'none'";
            } else if ($basic == 'all') {
                $item.= '*';
            } else if ($basic == 'self') {
                $item.= "'self'";
            } else if ($basic == 'custom' || $basic == 'custom_self') {
                $custom = apply_filters('gdsih_feature-policy_build_custom_rules_for_'.$name, $custom);

                $custom = array_unique($custom);
                $custom = array_filter($custom);

                if ($basic == 'custom_self') {
                    $item.= "'self'";
                }

                if (!empty($custom)) {
                    $item.= join(' ', $custom);
                }
            }

            $item = trim($item).';';

            $items[] = $item;
        }

        return $items;
    }

    public function build($htaccess = false) {
        $items = array();

        $header = 'Feature-Policy';

        foreach (array_keys(gdsih_settings()->features) as $key) {
            $items = $this->rule($items, $key);
        }

        if (empty($items)) {
            return '';
        }

        if ($htaccess) {
            return $header.' "'.join(' ', $items).'"';
        } else {
            return $header.': '.join(' ', $items);
        }
    }
}
