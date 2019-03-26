<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_component_headers {
    public function __construct() {
        if (gdsih_settings()->get('htaccess')) {
            add_filter('gdsih_htaccess_build_list', array($this, 'htaccess'));
        } else {
            $this->_headers();
        }
    }

    public function htaccess($htaccess = array()) {
        if (gdsih_settings()->get('x_content_type_nosniff', 'headers')) {
            $htaccess = array_merge($htaccess, $this->_x_content_type_nosniff());
            $htaccess[] = '';
        }

        if (gdsih_settings()->get('x_frame_options_sameorigin', 'headers')) {
            $htaccess = array_merge($htaccess, $this->_x_frame_options_sameorigin());
            $htaccess[] = '';
        }

        if (gdsih_settings()->get('strict_transport_security', 'headers')) {
            $htaccess = array_merge($htaccess, $this->_strict_transport_security());
            $htaccess[] = '';
        }

        if (gdsih_settings()->get('referrer_policy', 'headers')) {
            $htaccess = array_merge($htaccess, $this->_referrer_policy());
            $htaccess[] = '';
        }

        return $htaccess;
    }

    private function _headers() {
        if (gdsih_settings()->get('x_content_type_nosniff', 'headers')) {
            header("X-Content-Type-Options: nosniff");
        }

        if (gdsih_settings()->get('x_frame_options_sameorigin', 'headers')) {
            $args = array(
                'value' => gdsih_settings()->get('x_frame_options_sameorigin_value', 'headers'),
                'domains' => gdsih_settings()->get('x_frame_options_sameorigin_domains', 'headers')
            );

            $values = array_keys(gdsih_x_frame_options_list());

            if (!in_array($args['value'], $values)) {
                $args['value'] = 'SAMEORIGIN';
            }

            $parm = $args['value'];

            if ($parm == 'ALLOW-FROM') {
                $parm.= ' '.$args['domains'];
            }

            header("X-Frame-Options: \"".$parm."\"");
        }

        if (gdsih_settings()->get('strict_transport_security', 'headers')) {
            $args = array(
                'max_age' => gdsih_settings()->get('strict_transport_security_max_age', 'headers'),
                'extra' => gdsih_settings()->get('strict_transport_security_extra', 'headers'));

            $parm = $args['max_age'];

            if ($args['extra'] == 'includeSubDomains') {
                $parm.= '; includeSubDomains';
            }

            header("Strict-Transport-Security: \"".$parm."\"");
        }

        if (gdsih_settings()->get('referrer_policy', 'headers')) {
            $args = array(
                'policy' => gdsih_settings()->get('referrer_policy_value', 'headers'));

            $policies = array_keys(gdsih_referrer_policies_list());

            if (!in_array($args['policy'], $policies)) {
                $args['policy'] = 'no-referrer-when-downgrade';
            }

            header("Referrer-Policy: ".$args['policy']);
        }
    }

    private function _x_content_type_nosniff() {
        return array(
            '# add header: x-content-type-options',
            '<IfModule mod_headers.c>',
            D4P_TAB.'Header always set X-Content-Type-Options "nosniff"',
            '</IfModule>'
        );
    }

    private function _x_frame_options_sameorigin() {
        $value = gdsih_settings()->get('x_frame_options_sameorigin_value', 'headers');

        $values = array_keys(gdsih_x_frame_options_list());

        if (!in_array($value, $values)) {
            $value = 'ALLOW-FROM';
        }

        if ($value == 'ALLOW-FROM') {
            $value.= ' '.gdsih_settings()->get('x_frame_options_sameorigin_domains', 'headers');
        }

        return array(
            '# add header: x-frame-options',
            '<IfModule mod_headers.c>',
            D4P_TAB.'Header always set X-Frame-Options "'.$value.'"',
            '</IfModule>'
        );
    }

    private function _strict_transport_security() {
        $max_age = gdsih_settings()->get('strict_transport_security_max_age', 'headers');

        if (gdsih_settings()->get('strict_transport_security_extra', 'headers') == 'includeSubDomains') {
            $max_age.= '; includeSubDomains';
        }

        return array(
            '# add header: strict-transport-security',
            '<IfModule mod_headers.c>',
            D4P_TAB.'Header always set Strict-Transport-Security "max-age='.$max_age.'"',
            '</IfModule>'
        );
    }

    private function _referrer_policy() {
        $policy = gdsih_settings()->get('referrer_policy_value', 'headers');

        $policies = array_keys(gdsih_referrer_policies_list());

        if (!in_array($policy, $policies)) {
            $policy = 'no-referrer-when-downgrade';
        }

        return array(
            '# add header: referrer-policy',
            '<IfModule mod_headers.c>',
            D4P_TAB.'Header always set Referrer-Policy "'.$policy.'"',
            '</IfModule>'
        );
    }
}
